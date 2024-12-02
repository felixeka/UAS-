<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  $user_id = $_SESSION['user_id'];

  $data = [
    'product_id' => $product_id,
    'user_id' => $user_id,
    'quantity' => $quantity
  ];

  if (addToCart($data)) {
    echo "
    <script>
        if (confirm('Product berhasil ditambahkan ke cart.\nProceed to cart?')) {
          window.location.href = 'cart.php';
        } else {
          window.location.href = 'cart.php';
        }
    </script>
    ";
  } else {
    echo "
    <script>
        alert('Product sudah ada di cart');
        window.location.href = '/';
    </script>
    ";
  }
}
?>
<h1 class="mb-4 text-center">Produk</h1>
<div class="row">
  <?php $i = 1;
  if ($products):
    foreach ($products as $row): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-lg rounded-4 transition-transform transform-hover">
          <div class="card-img-container overflow-hidden rounded-top">
            <img src="assets/<?= $row['image'] ?>" class="card-img-top img-1-1 transition-transform hover-scale" alt="Product Image 1"
              onerror="this.src='https://via.placeholder.com/150'">
          </div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title text-white font-weight-bold">
              <a href="/detail.php?id=<?= $row['id'] ?>" class="text-white"><?= $row['name'] ?></a>
            </h5>
            <p class="card-text text-white"><?= excerpt($row['description']) ?></p>
            <p class="card-text text-white"><strong>Rp. <?= number_format($row['price']) ?></strong></p>
            <div class="mt-auto d-flex flex-column gap-2">
              <!-- Form to add product to cart -->
              <form action="" method="post" class="d-flex flex-column gap-3">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <div class="d-flex gap-2 align-items-center">
                  <label for="quantity" class="font-weight-semibold text-white">Quantity:</label>
                  <?php if ($row['stock'] > 1): ?>
                    <input type="number" name="quantity" class="form-control w-25" id="quantity" value="1" min="0"
                      max="<?= $row['stock'] ?>">
                  <?php else: ?>
                    <input type="number" name="quantity" class="form-control w-25" id="quantity" value="0" min="0"
                      max="<?= $row['stock'] ?>" disabled>
                  <?php endif; ?>
                </div>
                <?php if (isset($_SESSION['login'])): ?>
                  <?php if ($row['stock'] > 1): ?>
                    <button type="submit" class="btn btn-primary hover-zoom mt-2">Buy Now</button>
                  <?php else: ?>
                    <button class="btn btn-danger disabled mt-2">Not Available</button>
                  <?php endif; ?>
                <?php endif; ?>
              </form>
              <span class="text-white fs-6">Stock: <?= $row['stock'] ?></span>
              <?php if (isAdmin()): ?>
                <div class="d-flex gap-2 mt-3">
                  <a class="btn btn-success" href="/product/edit.php?id=<?= $row['id'] ?>">Edit</a>
                  <a class="btn btn-danger" href="/product/remove.php?id=<?= $row['id'] ?>">Remove</a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?php $i++ ?>
    <?php endforeach;
  else: ?>
    <div class="container mt-5 text-center">
      <p class="text-white">Produk Kosong nihh!.</p>
      <a href="/" class="btn btn-secondary">Kembali ke halaman utama </a>
    </div>
  <?php endif; ?>
</div>

<!-- Add these CSS styles for smooth animations and visual effects -->
<style>
  /* Background Nebula Effect */
  body {
    background: url('assets/nebula_background.png') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Arial', sans-serif;
    color: #fff;
  }

  /* Smooth Hover Effects */
  .transition-transform {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .transition-transform:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  }

  /* Hover Scale Effect on Image */
  .hover-scale {
    transition: transform 0.3s ease;
  }

  .hover-scale:hover {
    transform: scale(1.1);
  }

  /* Zoom effect on the Buy Now button */
  .hover-zoom {
    transition: transform 0.3s ease;
  }

  .hover-zoom:hover {
    transform: scale(1.05);
  }

  /* Card styling with a transparent background */
  .card {
    border: 1px solid #ddd;
    border-radius: 15px;
    background-color: rgba(0, 0, 0, 0.6); /* Transparent dark background */
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .card:hover {
    transform: translateY(-5px); /* Smooth up movement */
  }

  /* Card Title Styling */
  .card-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #fff; /* White text for better contrast */
    transition: color 0.3s ease;
  }

  .card-title:hover {
    color: #8A2BE2; /* Change color on hover */
  }

  /* Card Description Styling with darker background for better readability */
  .card-description p {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9); /* Lighter text */
    background-color: rgba(0, 0, 0, 0.6); /* Dark background for readability */
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
  }

  .card-description p:hover {
    background-color: rgba(0, 0, 0, 0.8); /* Slightly darker on hover */
  }

  /* Button Styling */
  .btn-primary {
    background-color: #8A2BE2;
    border-color: #8A2BE2;
    border-radius: 8px;
    padding: 12px;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #6a1d9b;
    border-color: #6a1d9b;
  }

  .btn-danger.disabled {
    background-color: #e0e0e0;
    border-color: #d0d0d0;
  }

  .btn-success, .btn-danger {
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .card-img-container {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
  }

  .card-img-top {
    transition: transform 0.3s ease;
    object-fit: cover;
    height: 200px;
  }

  .footer {
    background-color: #343a40;
    color: #fff;
    font-size: 0.9rem;
    text-align: center;
  }

  .footer a {
    color: #ccc;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .footer a:hover {
    color: #8a2be2;
  }

  .footer .container {
    max-width: 1200px;
  }
</style>
