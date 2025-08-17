<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Tool</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php wp_head(); ?>
</head>
<body class="admin-tool">
  <div id="admin-shell">
    <aside class="sidebar">
      <div class="brand">Booking Admin</div>
      <nav>
        <a href="#/dashboard" class="nav-link">Dashboard</a>
        <a href="#/rooms" class="nav-link">Rooms</a>
        <a href="#/bookings" class="nav-link">Bookings</a>
        <a href="#/transactions" class="nav-link">Transactions</a>
      </nav>
      <div class="spacer"></div>
      <button id="logoutBtn" class="logout">Log out</button>
    </aside>
    <main class="content">
      <div id="view-root">
        <!-- JS renders views here without page reload -->
      </div>
    </main>
  </div>

  <!-- Login modal -->
  <div id="login-overlay" class="overlay hidden">
    <form id="login-form" class="login-card">
      <h2>Admin Login</h2>
      <label>Email <input type="email" name="email" required value="admin@example.com" /></label>
      <label>Password <input type="password" name="password" required value="supersecret" /></label>
      <button type="submit">Sign in</button>
      <p class="hint">Single-device lock is enforced.</p>
      <div class="error" id="login-error"></div>
    </form>
  </div>

  <?php wp_footer(); ?>
</body>
</html>