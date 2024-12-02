<div class="container mt-5">
  <h2>Your Orders</h2>
  <hr>
  <?php if (empty($orders)): ?>
    <hr>
    <div class="alert alert-warning" role="alert">
      You have no orders.
    </div>
  <?php else: ?>
    <div class="accordion" id="ordersAccordion">
      <?php foreach ($orders as $index => $order): ?>
        <div class="card mb-3" style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
          <div class="card-header" id="heading<?= $index ?>" style="border-radius: 15px 15px 0 0;">
            <h2 class="mb-0">
              <button class="btn btn-outline-info w-100 text-left" type="button" data-toggle="collapse" data-target="#collapse<?= $index ?>"
                aria-expanded="true" aria-controls="collapse<?= $index ?>" style="border-radius: 15px;">
                Order ID: <?= $order['trans_id'] ?> - Total: <?= 'Rp. ' . number_format($order['total_price']) ?> - Created
                At: <?= $order['created_at'] ?>
              </button>
            </h2>
          </div>

          <div id="collapse<?= $index ?>" class="collapse" aria-labelledby="heading<?= $index ?>" data-parent="#ordersAccordion">
            <div class="card-body" style="border-radius: 0 0 15px 15px;">
              <h5>Items</h5>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($order['items'] as $item_index => $item): ?>
                      <tr>
                        <td><?= $item_index + 1 ?></td>
                        <td>
                          <a href="<?= $item['product_id'] ?>" class="text-white">
                            <?= $item['product_name'] ?>
                          </a>
                        </td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= 'Rp. ' . number_format($item['item_price']) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
