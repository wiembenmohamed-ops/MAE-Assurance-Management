<?php
include 'db-connect.php';

// التأكد من وجود المعرف (ID) في الرابط
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // أمر الحذف من قاعدة البيانات
    $sql = "DELETE FROM contrats WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // العودة لصفحة القائمة بعد الحذف بنجاح
        header("Location: liste-contrats.php");
    } else {
        echo "خطأ في عملية الحذف: " . mysqli_error($conn);
    }
} else {
    // إذا لم يوجد ID، العودة للقائمة
    header("Location: liste-contrats.php");
}
?>