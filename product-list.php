<?php
use LDAP\Result;
session_start();
include 'config.php';
//product all query ดึงสินค้าทั้งหมดมาแสดง
$query = mysqli_query($conn, "SELECT * FROM products");
$rows = mysqli_num_rows($query);
?>
<!-- // theme bootstrap -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    
    <link rel="stylesheet" href="<?php echo $base_url; ?> /asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?> /asset/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?> /asset/fontawesome/css/brands.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?> /asset/fontawesome/css/solid.min.css">
</head>
<body style="background-color: #D3D3D3;">
    <?php include 'include/mene.php'; ?>
    <!-- Container -->
    <div class="container" style="margin-top: 30px;">
        <?php if(!empty($_SESSION['message'])): ?>
        <!-- copy code bootstrap Alerts  -->
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <!-- ลบข้อความ -->
        <?php unset($_SESSION['message']) ?>
        <?php endif; ?>

        <h4>Product list</h4> 
        <!-- กำหนดให้รายการสินค้า cart อยู่ตรงกลาง-->
        <div class="row d-flex justify-content-center">
            <!-- ตรวจสอบสินค้า -->
            <?php if($rows > 0): ?>
                <!-- ให้วนค่าสินค้า product query มาจากฐานข้อมูลสินค้า-->
                <?php while($product = mysqli_fetch_assoc($query)): ?>
                    <div class="col-3 mb-3">
                        <div class="card" style="width: 18rem;">
                        <!-- สามารถ copy code เงื่อนไขแสดงรูปมามาจาก file index.php ได้ เพื่อเช็คว่ามีรูปภาพที่เรา upload มาหรือไม่ -->
                            <?php if(!empty($product['profile_image'])): ?>
                                <img src="<?php echo $base_url; ?>/upload_image/<?php echo $product['profile_image'];?>"class="card-img-top" width="100" alt="Product Image">
                                <!-- ถ้าไม่มีรูปภาพให้ทำการ upload ภาพใน folder pictures-->
                                <?php else:?>
                                <img src="<?php echo $base_url; ?>/asset/pictures/fish.jpg" class="card-img-top" width="100" alt="Product Image">
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['product_name']; ?> </h5>
                                <p class="card-text text-success fw-bold mb-0"> <?php echo number_format($product['price'], 2); ?> บาท </p> 
                                <p class="card-text text-muted"> <?php echo nl2br($product['detail']); ?> </p> 
                                <!-- เมื่อกด add cart ให้ส่ง id product ไปด้วย -->
                                <a href="<?php echo $base_url; ?>/cart-add.php?id=<?php echo $product['id']; ?>" class="btn btn-primary w-100"> <i class="fa-solid fa-cart-shopping me-1"></i> Add Cart </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <!-- กรณีที่ไม่มีสินค้า $row = 0 -->
                <?php else: ?>
                    <div class="col-12">
                        <h4 class="text-danger"> ไม่มีรายการสินค้า</h4>
                    </div>
            <?php endif;?>
        </div>
    </div>

    <script src="<?php echo $base_url; ?> /asset/css/bootstrap.min.js"></script>
</body>
</html>
