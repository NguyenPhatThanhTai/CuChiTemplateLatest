<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Tool</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body class="admin-tool">
  <div id="admin-shell">
    <aside class="sidebar">
    <div class="header-side-bar"><p>Admin</p></div>
      <nav>
        <a href="#/dashboard" class="nav-link"><p>Dashboard</p></a>
        <a href="#/rooms" class="nav-link"><p>Rooms</p></a>
        <a href="#/bookings" class="nav-link"><p>Bookings</p></a>
        <a href="#/transactions" class="nav-link"><p>Transactions</p></a>
      </nav>
      <div class="spacer"></div>
    </aside>
    <main class="content">
      <div id="view-root">
        <!-- JS renders views here without page reload -->
      </div>
    </main>
  </div>
</body>
</html>