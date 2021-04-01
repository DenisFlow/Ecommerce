<!DOCTYPE html>
<?php
session_start();
include("functions/functions.php");

?>
    <html>
        <head>
            <!--      Заголовок магазина      -->
            <title>My Online Shop</title>
            <!--      Делает ссылку на css документ      -->
            <link rel="stylesheet" href="styles/style.css" media="all">
        </head>

  
        <body>

            <!-- Main container starts here -->
            <div class="main_wrapper">
                
                <!-- Header starts here -->            
                <div class="header_wrapper">
                    <a href="index.php"><img id="logo" src="images/logo.gif" /></a>
                    <img id="banner" src="images/ad_banner.gif" />

            
                </div>
                <!-- Header ends here -->

                <!-- Navigation bar starts here -->
                <div class="menubar">
                        <ul id="menu">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="all_products.php">All products</a></li>
                            <li><a href="customer/my_account.php">My Account</a></li>
                            <li><a href="#">Sign Up</a></li>
                            <li><a href="cart.php">Shopping Cart</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                        <!--             Поисковое меню           -->
                        <div id="form">
                            <form method="get" action="results.php" enctype="multipart/form-data">
                                <input type="text" name="user_query" placeholder="Search a Product"/>
                                <input type="submit" name="search" value="Search" />
                            </form>
                        </div>
                </div>
                <!-- Navigation bar ends here -->

                <!-- Content wrapper starts here -->
                <div class="content_wrapper">
                    <div id="sidebar">
                        <div id="sidebar_title">
                            Categories
                        </div>
                        <ul id="cats">
                            <?php getData("categories"); ?>
                            <!-- <li><a href="#">Одежда</a></li>
                            <li><a href="#">Текстиль</a></li>
                            <li><a href="#">Трикотаж</a></li>
                            <li><a href="#">Big изделия</a></li>
                            <li><a href="#">Аксессуары</a></li>
                            <li><a href="#">Косметика</a></li>
                            <li><a href="#">Игрушки</a></li>
                            <li><a href="#">Коляски</a></li> -->
                        </ul>

                        <div id="sidebar_title">
                            Brands
                        </div>
                        <ul id="cats">
                            <?php 
                            getData("brands"); ?>
                            <!-- <li><a href="#">Molo</a></li>
                            <li><a href="#">ZARA</a></li>
                            <li><a href="#">MANGO</a></li>
                            <li><a href="#">H&M</a></li>
                            <li><a href="#">GAP</a></li>
                            <li><a href="#">BLUKIDS</a></li>-->
                        </ul> 

                    </div>

                    
                    <div id="content_area">
                        <?php cart(); ?>
                        <!--            Создам ссылку на карзину и сопутствующую информацию по корзине            -->
                        <div id="shoping_cart">
                            <span style="float:right; font-size:16px; padding:5px; line-height:40px">

                                <?php

                                if (isset($_SESSION['customer_email'])) {
                                    echo "<b>Welcome: </b>" . $_SESSION['customer_email'] . "<b style='color: yellow'>Your</b>";
                                } else {
                                    echo "<b>Welcome Guest:</b>";
                                }

                                ?>

                                <b style="color:yellow">Shoping Cart -  </b> Total items:  <?php total_items(); ?> Total Price: <?php total_price() ?> <a href="cart.php" style="color:yellow" >Go to Cart</a>

                                <?php

                                if (!isset($_SESSION['customer_email'])) {

                                    echo "<a href='checkout.php' style='color: orange;'>Login</a>";
                                } else {
                                    echo "<a href='logout.php' style='color: orange;'>Logout</a>";
                                }

                                ?>

                            </span>
                        </div>

                        <div id="products_box">
                            <?php getPro();?> 
                            <?php getCatPro();?> 
                            <?php getBrandPro();?> 
                        </div>
                    
                    </div>
                </div>
                <!-- Content wrapper ends here -->
                
                <div id="footer">
                    <h2 style="text-align:center; panding-top: 30px;">
                        &copy; 2021 by Denis Davydenko from ZPiD-116; VLGU;
                    </h2>
                </div>

            </div>

            <!-- Main container ends here -->
        </body>
    </html>



