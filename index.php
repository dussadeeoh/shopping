<?php

use LDAP\Result;

session_start();
include 'config.php';

//product all query
$query = mysqli_query($conn, "SELECT * FROM products");
$rows = mysqli_num_rows($query);

// var product form ให้บันทึกใน area()   //
$result = [
    'id' => '',
    'product_name' => '',
    'price' => '',
    'detail' => '',
    'product_image' => '',

];

//product select edit (ข้อมูล ID มีค่า http://localhost/shoppingcart/index.php?id=13) ทำการดึงข้อมูล
if(!empty ($_GET['id'])) {
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id='{$_GET['id']}'");
    //จากนั้นทำการตรวจสอบสินค้า
    $row_product = mysqli_num_rows($query_product);
    
    // การนับแถวถ้าเท่ากับ 0 ให้ redirect กลับไป 
    if($row_product == 0) {
        header('localtion:' .$base_url . '/index.php');
    }
    // ถ้าไม่ใช้ให้เก็บไว้ และการนำ $result ไปเก็บไว้ใน form
    $result = mysqli_fetch_assoc($query_product);
    var_dump($result);
}

?>

<!-- // theme bootstrap -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
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
        

        <h4>Home - Manage Product</h4>
        <!-- Coding form product -->
        <div class="row g-5">
            <div class="col-md-8 col-sm-12">
                <form action="<?php echo $base_url;?>/product-form.php" method="post" enctype="multipart/form-data">
                <!-- ส่ง ID กลับไปที่ form -->
                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                <div class="row g-3 mb-3">
                    <!-- ตั้งชื่อให้ตรงกับ database phpMyAdmin -->
                    <div class="col-sm-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control" value="<?php echo $result['product_name']; ?>">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" value="<?php echo $result['price']; ?>">     
                    </div>

                    <class="col-sm-6">
                            <!-- ถ้าไม่ใช่ค่าว่าให้แสดงรูปภาพ -->
                    <?php if(!empty($result['profile_image'])): ?>
                        <div><img src="<?php echo $base_url; ?>/upload_image/<?php echo $result['profile_image'];?> " width="100" alt="Product Image"></div>
                    <?php endif; ?>
                        <label for="formFile" class="form-label">Image</label>
                        <input type="file" name="profile_image" class="form-control" accept="image/png, image/jpg, image/jpeg">
                </div>

                    <div class="col-sm-12">
                        <label class="form-label">Detail</label>
                        <textarea name="detail" class="form-control" rows="3"> <?php echo $result['detail']; ?></textarea>
                    </div>
                
                    <!-- ถ้า ID เป็นค่าว่างให้แสดง edit -->
                    <?php if(empty($result['id'])): ?>
                    <!-- input form--> <!-- ใส่ Icon เวลา save -->
                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk me-1"></i>Create</button>
                    <?php else: ?>
                    <!-- แต่ถ้า ID ไม่ใช่ค่าว่าง ให้แสดง Update -->
                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk me-1"></i>Update</button>
                    <?php endif; ?>
                    <!-- Creat Cancel button and back to page index.php -->
                        <a role="button" class="btn btn-secondary" href="<?php echo $base_url; ?> /index.php"><i class="fa-solid fa-rotate-left me-1"></i></i>Cancel</a>
                </form>
            </div>
        </div>

            <div class="row">
                <div class="col-12">
                    <table class="table table-border-info">
                        <thead>
                            <tr>
                                <th style="width: 100px;">Image</th>
                                <th>Product Name</th>
                                <th style="width: 200px;">Price</th>
                                <th style="width: 200px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- query ข้อมูลมาแสดงผล -->
                            <?php if($rows > 0): ?>
                            <!-- วนลูป สร้างตัวแปรไว้รับข้อมูล-->
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

                                    <!-- สร้างปุ่ม Edit and Delete ส่งค่า product id ไปที่ index.php -->
                                    <td>
                                        <a role="button" href="<?php echo $base_url; ?>/index.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-dark"><i class="fa-regular fa-pen-to-square me-1"></i>Edit</a>
                                        <a onclick="return confirm('คุณต้องการลบหรือไม่')" role="button" href="<?php echo $base_url; ?>/product-delete.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-danger">
                                        <i class="fa-solid fa-trash-can me-1"></i></i>Delete</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <!-- colspan 4 คือการรวมแถวที่สร้างขึ้นก็คือ 4 แถว ขึ้นอยู่กับจำนวนแถวที่เราต้องการรวม -->
                                <td colspan="4"><h4 class="text-center text-danger">ไม่มีรายการสินค้า</h4></td> 
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>                       
    </div>


    <script src="<?php echo $base_url; ?> /asset/css/bootstrap.min.js"></script>
</body>
</html>
