<?php
session_start();
include 'config.php' ;

if(!empty($_GET['id'])){
    if(empty($_SESSION['cart'][$_GET['id']])) {   // สร้าง array cart ตัวแปร SESSION เก็บไว้ใน cart และ สินค้า id ให้จำนวนเป็น 1 / สินค้า id นั้น = 1
        $_SESSION['cart'] [$_GET['id']] = 1;   // ตรวจสอบถ้า cart ไม่มีสินค้า id ที่นั้น ให้ จำนวน คือ 1 (ถ้าสินค้ามีอยู่แล้ว) ให้ +1 เพิ่ม
    } else{
        $_SESSION['cart'] [$_GET['id']] += 1;
    }
   
    $_SESSION['message'] = 'Cart add success' ;   // ใส่ SESSION ที่ชื่อว่า message 
}

header('location:' .  $base_url . '/product-list.php');

?>