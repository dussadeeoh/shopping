<?php
session_start();
include 'config.php' ;

if(!empty($_GET['id'])){ // ถ้าค่าตัวแปร id ที่ส่งไปให้ทำอะไร เป็นค่าไม่ว่าง !empty ถ้าค่าตัวแปรว่างให้ทำข้างล่างต่อไป
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id='{$_GET['id']}'");
    $result = mysqli_fetch_assoc($query_product);
    @unlink('upload_image/' . $result['profile_image']);

    $query = mysqli_query($conn, "DELETE FROM products WHERE id='{$_GET['id']}' ") or die('query failed');
    mysqli_close($conn);
//ตรวจสอบว่า delete สำเร็จหรือไม่

    if($query) {
        $_SESSION['message'] = 'Product Delete Success'; //ถ้า delete สำเร็จ
        header('location: ' . $base_url . '/index.php');
    }else{
        $_SESSION['message'] = 'Product could not be Deleted !!'; //ถ้า delete ไม่สำเร็จ
        header('location: ' . $base_url . '/index.php');
    }
}
?>
