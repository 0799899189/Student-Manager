<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý sinh viên</title>
    <link rel="stylesheet" href="public/vendor/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/vendor/fontawesome-free-5.15.1-web/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <!-- link:favicon -->
    <link rel="shortcut icon" href="public/favicon.ico" type="image/x-icon">
</head>
<?php global $c; ?>

<body>
    <div class="container" style="margin-top:20px;">
        <a href="/" class="<?=$c == 'student' ? 'active': ''?> btn btn-info">Students</a>
        <a href="/?c=subject" class="<?=$c == 'subject' ? 'active': ''?> btn btn-info">Subject</a>
        <a href="/?c=register" class="<?=$c == 'register' ? 'active': ''?> btn btn-info">Register</a>

        <?php

$message = '';
$classType = '';
if (!empty($_SESSION['success'])) {
    $message = $_SESSION['success'];
    // xóa phần tử có key là success
    unset($_SESSION['success']);
    $classType = 'alert-success';
} else if (!empty($_SESSION['error'])) {
    $message = $_SESSION['error'];
    // xóa phần tử có key là error
    unset($_SESSION['error']);
    $classType = 'alert-danger';
}
?>
        <?php if ($message): ?>
        <!-- .alert.alert-success -->
        <div class="alert <?=$classType?> mt-3"><?=$message?></div>
        <?php endif?>