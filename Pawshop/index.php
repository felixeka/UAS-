<?php
ob_start();
include 'header.php';

?>

<!-- Hero Section -->
<div class="container-fluid py-5 my-5" style="background: linear-gradient(135deg, #2e026d, #6a00ff, #ff008e); color: white;">
  <div class="d-flex align-items-center justify-content-center text-center">
    <div class="hero-content" style="position: relative; z-index: 2;">
      <h1 class="fw-bold display-4">Welcome to PawShop</h1>
      <p class="fs-5">Ayo Temukan Barang Kesukaanmu Sekarang!</p>
      <a href="#products" class="btn btn-light btn-lg">Beli Sekarang</a>
    </div>
  </div>
</div>

<!-- Main content area -->
<div class="container my-5" id="products">
  <?php include './template/_products.php'; ?>
</div>

<?php
include 'footer.php';
?>
