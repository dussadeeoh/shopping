<?php
session_start();
include 'config.php';

// เก็บตัวแปร product_name
$product_name = trim($_POST['product_name']);
//กรณีราคาค่าว่างเป็น 0 
$price = $_POST['price'] ?: 0;
$detail = trim($_POST['detail']);
$image_name = $_FILES['profile_image']['name'];

$image_tmp = $_FILES['profile_image']['tmp_name'];
$folder = 'upload_image/';
$image_location = $folder . $image_name;

if(empty($_POST['id'])){
    $query = mysqli_query($conn,"INSERT INTO products (product_name,price,profile_image,detail) VALUES ('{$product_name}', '{$price}', '{$image_name}', '{$detail}')") or die('query failed');
} else {
    //สร้างเงื่อนไขให้ update รูปภาพ จากภาพเดิมเป็นภาพใหม่ การ update ภาพใหม่ โดยการดึงข้อมูลเก่า $query_product มา 
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id='{$_POST['id']}'");
    $result = mysqli_fetch_assoc($query_product);
        
    if(empty($image_name)){ //ถ้า image_name เป็นค่าว่าง 
        $image_name = $result['profile_image']; //ให้ image_name = ชื่อรูปภาพในฐานข้อมูล profile_image มาเก็บ
    }else{
        @unlink($folder . $result['profile_image']); //และถ้าโหลดมาแล้วให้ลบรูปภาพเดิมออก
    }

    $query = mysqli_query($conn, "UPDATE products SET product_name='{$product_name}', price='{$price}', profile_image='{$image_name}', detail='{$detail}' WHERE id='{$_POST['id']}'") or die('query failed');
}

mysqli_close($conn); // ปิดการเชื่อต่อฐานข้อมูล

// หาค่า boolean ค่า"จริง" (True) หรือ "ไม่จริง " (False) ในการ uploade picture
if($query) {
    move_uploaded_file($image_tmp, $image_location);
    
    // redirect Product  และแสดงข้อความบันทึกสำเร็จ  Product Save 
    $_SESSION['message'] = 'Product Save Success';
    header('location:' . $base_url . '/index.php');
} else {
    // redirect Product  และแสดงข้อความบันทึกไม่สำเร็จ  Product Save 
    $_SESSION['message'] = 'Product Could not be Save!!';
    header('location:' . $base_url . '/index.php');
}
