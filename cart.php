<!-- แสดงรายละเอียดสินค้าเป็นตาราง  สามารถ copy file : product-list มาเพื่อแก้ไขได้ -->
<?php
session_start();
include 'config.php';

//สร้างตัวแปร product เก็บเป็น id ของสินค้านั้น// วน loop cart id จำนวนอยู่ใน cartQty// ยกตัวอย่าง id=6 , quantity = 1  ถ้าหยิบใส่ตระกร้าอีก id=1, quantity = 2 
$productIds = [];  
foreach(($_SESSION['cart'] ?? []) as $cartId => $cartQty) {  
    $productIds[] = $cartId; 
}

$ids = 0;
if(count($productIds) > 0) { //ในตระกร้ามากกว่า 0 หรือไม่
    $ids = implode(',', $productIds); 
} 


//product all
$query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)"); //ดึงสินค้าถ้ามีค่ามากกว่า 0
$rows = mysqli_num_rows($query);
?>


<!-- // theme bootstrap -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    
    <link rel="stylesheet" href="<?php echo $base_url; ?> /asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?> /asset/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?> /asset/fontawesome/css/brands.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?> /asset/fontawesome/css/solid.min.css">
</head>
<body style="background-color: #D3D3D3;">
    <?php include 'include/mene.php'; ?>
    <div>
        <class="container" style="margin-top: 30px;">
        <?php if(!empty($_SESSION['message'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']) ?>
        <?php endif; ?>
        <h4>ตะกร้าสินค้า</h4> 
        <div class="row">
            <div class="col-12">
                <!-- สร้าง table สามารถ copy จากไฟล์ index.php ได้-->
                <table class="table table-bordered border-info">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Image</th>
                            <th>Product Name</th>
                            <th style="width: 200px;">Price</th>
                            <th style="width: 100px;">Quantity</th>
                            <th style="width: 200px;">Total</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($rows > 0): ?>
                            <?php while($product = mysqli_fetch_assoc($query)): ?>
                                <tr>
                                    <td>
                                        <!-- เช็คว่ามีรูปภาพที่เรา upload มาหรือไม่ -->
                                        <?php if(!empty($product['profile_image'])): ?>
                                            <img src="<?php echo $base_url; ?>/upload_image/<?php echo $product['profile_image'];?> " width="100" alt="Product Image">
                                        <!-- ถ้าไม่มีรูปภาพให้ทำการ upload ภาพใน folder pictures-->
                                        <?php else:?>
                                            <img src="<?php echo $base_url; ?>/asset/pictures/fish.jpg" width="100" alt="Product Image">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $product['product_name']; ?>
                                        <div>
                                            <small class="text-muted"><?php echo nl2br($product['detail']); ?></small>
                                        </div>
                                    </td>
                                    <td><?php echo number_format($product['price'], 2); ?></td>
                                    <td><input type="" name="" value="<?php echo $_SESSION['cart'][$product['id']]; ?> " class="form-control"> </td>
                                    <td><?php echo number_format($product['price'] * $_SESSION['cart'][$product['id']], 2); ?> </td>
                                    <td>
                                        <a onclick="return confirm('คุณต้องการลบหรือไม่')" role="button" href="<?php echo $base_url; ?>/cart-delete.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-danger">
                                        <i class="fa-solid fa-trash-can me-1"></i></i>Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <!-- เพิ่ม 6 column ตามแถวข้างบน -->
                                <td colspan="6"><h4 class="text-center text-danger">ไม่มีรายการสินค้าในตะกร้า</h4></td> 
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="<?php echo $base_url; ?> /asset/css/bootstrap.min.js"></script>
</body>
</html>
