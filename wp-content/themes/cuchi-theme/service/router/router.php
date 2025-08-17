<?php

// service/router/router.php

// 1. Register /booking-callback rewrite URL
add_action('init', function () {
    add_rewrite_rule('^booking-callback$', 'index.php?booking_callback=1', 'top');
});

// 2. Allow 'booking_callback' as a query var
add_filter('query_vars', function ($vars) {
    $vars[] = 'booking_callback';
    return $vars;
});

// 3. Handle the callback when the URL matches
add_action('template_redirect', function () {
    if (get_query_var('booking_callback')) {
        require_once get_theme_file_path('service/db_config/db.php');
        require_once get_theme_file_path('service/room_service.php');

        $pdo = get_db_connection();
        $roomService = new RoomService($pdo);

        $roomService->handle_call_back($_GET);
        exit;
    }
});

function handle_booking_gateway() {
    if (!session_id()) session_start();

    require_once get_theme_file_path ('service/db_config/db.php');
    require_once get_theme_file_path ('service/room_service.php');

    $pdo = get_db_connection();
    $roomService = new RoomService($pdo);

    $action = $_POST['action_type'] ?? null;

    if ($action === 'check_availability') {
        $roomService->check_availability($_POST);
    } elseif ($action === 'submit_booking') {
        $roomService->book_room($_POST);
    } else {
        echo "Unknown action: " . esc_html($action);
    }

    exit;
}

// service/router/router.php

// ————————————————————————————————————————
// Small helpers
// ————————————————————————————————————————
if (!function_exists('json_ok')) {
    function json_ok($data = []) { wp_send_json_success($data, 200); }
  }
  if (!function_exists('json_err')) {
    function json_err($msg = 'Error', $debug = null) {
      $payload = ['message' => $msg];
      if (defined('WP_DEBUG') && WP_DEBUG && $debug) $payload['debug'] = $debug;
      wp_send_json_error($payload, 200);
    }
  }
  
  // Ensure DB helper is loaded
  require_once get_theme_file_path('service/db_config/db.php');
  
  // ————————————————————————————————————————
  // ADMIN TOOL: auth = simply require logged-in capability
  // ————————————————————————————————————————
  function at_require_auth() {
    if (!is_user_logged_in() || !current_user_can('manage_options')) json_err('You must be logged in as admin.');
    check_ajax_referer('admin_tool_nonce', '_ajax_nonce'); // validate nonce coming from JS
  }
  
  // ————————————————————————————————————————
  // ROOMS / BOOKINGS / TRANSACTIONS
  // ————————————————————————————————————————
  add_action('wp_ajax_admin_tool_rooms_list', function () {
    at_require_auth();
    $pdo = get_db_connection();
    $rows = $pdo->query("SELECT * FROM rooms ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
  
    // enrich with image ids + urls
    foreach ($rows as &$r) {
      $ids = [];
      if (!empty($r['images_json'])) {
        $decoded = json_decode($r['images_json'], true);
        $ids = is_array($decoded) ? array_values(array_filter($decoded, 'is_numeric')) : [];
      }
      $r['image_ids']  = array_map('intval', $ids);
    }
    json_ok($rows);
  });
  
  add_action('wp_ajax_admin_tool_bookings_list', function () {
    at_require_auth();
    $pdo = get_db_connection();
    $sql = "SELECT b.*, r.room_name FROM bookings b JOIN rooms r ON r.id=b.room_id ORDER BY b.id DESC";
    json_ok($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC));
  });
  
  add_action('wp_ajax_admin_tool_booking_checkin', function () {
    at_require_auth();
    $id = intval($_POST['id'] ?? 0);
    if (!$id) json_err('Missing id');
    $pdo = get_db_connection();
    $st = $pdo->prepare("UPDATE bookings SET checked_in=1 WHERE id=?");
    $st->execute([$id]);
    json_ok(['updated' => (bool)$st->rowCount()]);
  });
  
  add_action('wp_ajax_admin_tool_transactions_list', function () {
    at_require_auth();
    $pdo = get_db_connection();
    $sql = "SELECT t.*, r.room_name FROM `transaction` t JOIN rooms r ON r.id=t.room_id ORDER BY t.is_success DESC, t.check_in DESC";
    json_ok($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC));
  });
  
  add_action('wp_ajax_admin_tool_transaction_update', function () {
    at_require_auth();
    $id = sanitize_text_field($_POST['id'] ?? '');
    $ok = isset($_POST['is_success']) ? (intval($_POST['is_success']) ? 1 : 0) : null;
    if ($id === '' || $ok === null) json_err('Missing data');
    $pdo = get_db_connection();
    $st = $pdo->prepare("UPDATE `transaction` SET is_success=? WHERE id=?");
    $st->execute([$ok, $id]);
    json_ok(['updated' => (bool)$st->rowCount()]);
  });
  
  // ————————————————————————————————————————
  // MEDIA HELPERS
  // ————————————————————————————————————————
  function at_media_item($id) {
    $id = intval($id);
    if (!$id) return null;
  
    // Prefer wp_get_attachment_image_src (reliable for generated sizes)
    $src = wp_get_attachment_image_src($id, 'large');
    $url = $src && !empty($src[0]) ? $src[0] : wp_get_attachment_url($id);
  
    // Validate file existence (best-effort)
    $ok = false;
    if ($url) {
      $uploads = wp_get_upload_dir();
      if (strpos($url, $uploads['baseurl']) === 0) {
        $path = $uploads['basedir'] . '/' . ltrim(str_replace($uploads['baseurl'], '', $url), '/');
        $ok = file_exists($path);
      } else {
        // external/filtered URLs – we cannot check filesystem; assume ok
        $ok = true;
      }
    }
  
    return $url ? ['id' => $id, 'url' => $url, 'ok' => (bool)$ok] : null;
  }
  
  // Resolve array of ids → urls (+ existence flag)
  add_action('wp_ajax_admin_tool_media_urls', function () {
    at_require_auth();
    $raw = $_POST['ids'] ?? '';
    $ids = is_array($raw) ? $raw : preg_split('/\s*,\s*/', (string)$raw, -1, PREG_SPLIT_NO_EMPTY);
    $ids = array_slice(array_values(array_unique(array_map('intval', $ids))), 0, 4);
  
    $items = [];
    foreach ($ids as $id) {
      $it = at_media_item($id);
      if ($it) $items[] = $it;
    }
    json_ok(['items' => $items]);
  });
  
  // ————————————————————————————————————————
  // ROOM create + update images
  // ————————————————————————————————————————
  add_action('wp_ajax_admin_tool_room_create', function () {
    at_require_auth();
    $name = sanitize_text_field($_POST['room_name'] ?? '');
    $slot = intval($_POST['slot'] ?? 0);
    $price = floatval($_POST['price'] ?? 0);
    $total = intval($_POST['total_rooms'] ?? 0);
    $type = sanitize_text_field($_POST['room_type'] ?? '');
    $ids  = $_POST['image_ids'] ?? '';
    $ids = preg_split('/\s*,\s*/', (string)$ids, -1, PREG_SPLIT_NO_EMPTY);
    $ids = array_slice(array_values(array_unique(array_map('intval', $ids))), 0, 4);
  
    if (!$name || !$slot || !$total) json_err('Missing required fields');
  
    $pdo = get_db_connection();
    $st = $pdo->prepare("INSERT INTO rooms (room_name, slot, price, total_rooms, room_type, images_json) VALUES (?,?,?,?,?,?)");
    $st->execute([$name, $slot, $price, $total, $type, json_encode($ids)]);
    json_ok(['id' => intval($pdo->lastInsertId())]);
  });
  
  add_action('wp_ajax_admin_tool_room_update_images', function () {
    at_require_auth();
    $id  = intval($_POST['id'] ?? 0);
    $ids = $_POST['image_ids'] ?? '';
    $ids = preg_split('/\s*,\s*/', (string)$ids, -1, PREG_SPLIT_NO_EMPTY);
    $ids = array_slice(array_values(array_unique(array_map('intval', $ids))), 0, 4);
    if (!$id) json_err('Missing room id');
  
    $pdo = get_db_connection();
    $st = $pdo->prepare("UPDATE rooms SET images_json=? WHERE id=?");
    $st->execute([json_encode($ids), $id]);
    json_ok(['updated' => (bool)$st->rowCount()]);
  });
