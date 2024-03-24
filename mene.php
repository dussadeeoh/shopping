<nav class="navbar justify-content-center py-3 sticky-top shadow-sm" style="background-color: #e3f2fd;" >
  <!-- Navbar content -->
  <ul class="nav">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="<?php echo $base_url; ?>/index.php">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="<?php echo $base_url; ?>/product-list.php">Product-list</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="<?php echo $base_url; ?>/cart.php"> Cart (<?php echo count($_SESSION['cart']) ?>) </a>
  </li>
</ul>
</nav>
