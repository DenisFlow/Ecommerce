<!DOCTYPE html>
<?php
include("functions/functions.php");

?>
    <html>
        <head>
            <title>My Online Shop</title>
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
                            getData("brands");
                            
                            ?>
                            
                            <!-- <li><a href="#">Molo</a></li>
                            <li><a href="#">ZARA</a></li>
                            <li><a href="#">MANGO</a></li>
                            <li><a href="#">H&M</a></li>
                            <li><a href="#">GAP</a></li>
                            <li><a href="#">BLUKIDS</a></li>-->
                        </ul> 

                    </div>

                    
                    <div id="content_area">
                        
                        <div id="shoping_cart">
                            <span style="float:right; font-size:18px; padding:5px; line-height:40px">
                                Welcome Guest! <b style="color:yellow">Shoping Cart -  </b> Total items: Total Price: <a href="cart.php" style="color:yellow" >Go to Cart</a>
                            </span>
                        </div>

                        <div id="products_box">
                            <?php
                                if(isset($_GET['search'])){

                                    $search_query = $_GET['user_query'];

                                    $get_pro = "select * from products where product_title like '%$search_query%'";
                                        
                                    $run_pro = mysqli_query($con, $get_pro);
                                    
                                    $count_ = mysqli_num_rows($run_pro);
                                    
                                    
                                    if($count_ == 0){
                                        echo "<h2 style='padding:20px;'>No products where found</h2>";
                                    }else{
                                        
                                    while($row_pro = mysqli_fetch_array($run_pro)){
                                        $pro_id = $row_pro['product_id'];
                                        $pro_cat = $row_pro['product_cat'];
                                        $pro_brand = $row_pro['product_brand'];
                                        $pro_title = $row_pro['product_title'];
                                        $pro_price = $row_pro['product_price'];
                                        $pro_image = $row_pro['product_image'];
                                        
                                        
                                        echo "
                                        <div id='single_product'>

                                        <h3>$pro_title</h3>
                                        <img src='admin_area/product_images/$pro_image' width='180' height='180' />
                                        <p><b>&#x20bd;  $pro_price </b></p>
                                        
                                        <a href='details.php?pro_id=$pro_id' style='float:left;'>Details</a>
                                        
                                        <a href='index.php?pro_id=$pro_id'><button style='float:right'>Add to Cart</button></a>
                                        
                                        </div>
                                        
                                        ";
                                    }
                                    }
                                }

                            ?>
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
    