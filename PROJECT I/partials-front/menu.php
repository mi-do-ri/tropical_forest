<?php include('admin/config.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tropical Forest</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <link rel="stylesheet" href="style.css?v=1.1">
</head>

<body>
<div id="wrapper">
<!--header section starts-->
    <header class="header">
        <a class="logo" href="index.php">
            <img src="assets/Background/logo.png" alt="">
        </a>

        <nav class="navbar">
            <li><a href="<?php echo SITEURL; ?>shop.php">SHOP</a></li>
            <li><a href="#event">SỰ KIỆN</a></li>
            <li><a href="#blog">BLOG</a></li>
            <li><a href="#explore">VỀ CHÚNG TÔI</a>
                <ul class="sub-menu">
                    <li><a href="">Cơ Hội Nghề Nghiệp</a></li>
                    <li><a href="">Liên Hệ</a></li>
                </ul>
            </li>
        </nav>

        <div class="icons">
            <li><input type="text" placeholder="Tìm kiếm"><i class="fas fa-search" id="search-btn"></i></li>
            <li><a href="<?php echo SITEURL; ?>cart.php"><div class="fas fa-shopping-cart" id="cart-btn">
            </div></a></li>
        </div>
    </header>
<!--header section ends-->