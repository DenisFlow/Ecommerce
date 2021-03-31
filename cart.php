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
                        </ul>

                        <div id="sidebar_title">
                            Brands
                        </div>
                        <ul id="cats">
                            <?php 
                            getData("brands"); ?>
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


                                <b style="color:yellow">Shoping Cart -  </b> Total items:  <?php total_items(); ?> Total Price: <?php total_price() ?> <a href="index.php" style="color:yellow" >Back to Shop</a>

                                <?php

                                if (!isset($_SESSION['customer_email'])) {

                                    echo "<a href='checkout.php' style='color: orange;'>Login</a>";
                                } else {
                                    echo "<a href='logout.php' style='color: orange;'>Logout</a>";
                                }

                                ?>

                            </span>
                        </div>

<!--                        --><?php //echo $ip = getIp() ;?>

                        <div id="products_box">

                            <form action="" method="post" enctype="multipart/form-data">

                                <table align="center" width="700" bgcolor="#87ceeb">

<!--                                    <tr align="center">-->
<!--                                        <td colspan="5"><h2>Update your cart or checkout</h2></td>-->
<!--                                    </tr>-->

                                    <tr align="center">
                                        <th>Remove</th>
                                        <th>Products(S)</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                    </tr>

                                    <?php
                                        $total = 0;
                                        global $con;
                                        $ip = getIp();
                                        $sel_price = "select * from cart where ip_add='$ip'";

                                        $run_price = mysqli_query($con, $sel_price);

                                        while ($p_price = mysqli_fetch_array($run_price)) {
                                            $pro_id = $p_price['p_id'];

                                            $pro_price = "select * from products where product_id='$pro_id'";

                                            $run_pro_price = mysqli_query($con, $pro_price);

                                            while ($pp_price = mysqli_fetch_array($run_pro_price)) {
                                                $product_price = array($pp_price['product_price']);

                                                $product_title = $pp_price['product_title'];

                                                $product_image = $pp_price['product_image'];

                                                $single_price = $pp_price['product_price'];

                                                $values = array_sum($product_price);

                                                $total += $values;

                                    ?>

                                    <tr align="center">
                                        <td><input type="checkbox" name="remove[]" value="<?php echo $pro_id;?>"/> </td>
                                        <td><?php echo $product_title; ?>
                                        <img src="admin_area/product_images/<?php echo $product_image;?>" width="60" height="60"/>
                                        </td>
                                        <td><input type="text" size="4" name="qty" value="<?php echo $_SESSION['qty'];?>"/></td>
                                        <?php
                                            if (isset($_POST['update_cart'])){
                                                $qty = $_POST['qty'];
                                                $update_qty = "update cart set qty='$qty'";
                                                $run_qty = mysqli_query($con, $update_qty);

                                                $_SESSION['qty'] = $qty;

                                                if (is_numeric($total) && is_numeric($qty)) {

                                                    $total = $total * $qty;

                                                }

                                            }
                                        ?>
                                        <td><?php echo "&#x20bd; " . $single_price; ?></td>
                                    </tr>

                                    <?php } } ?>

                                    <tr>
                                        <td colspan="3"><b>Sub Total:</b></td>
                                        <td colspan="3"><?php echo "&#x20bd; " . $total ?></td>
                                    </tr>

                                    <tr align="center">
                                        <td colspan="2"><input type="submit" name="update_cart" value="Update Cart"/> </td>
                                        <td><input type="submit" name="continue" value="Continue Shopping"/> </td>
                                        <td><button><a href="checkout.php" style="text-decoration: none; color: black">Checkout</a></button> </td>
                                    </tr>
                                </table>
                            </form>

                            <?php
                            function updateCart() {

                                global $con;

                                $ip = getIp();

                                if (isset($_POST['update_cart'])) {
                                    foreach ($_POST['remove'] as $remove_id) {
                                        $delete_product = "delete from cart where p_id='$remove_id' AND ip_add='$ip'";
                                        $run_delete = mysqli_query($con, $delete_product);

                                        if ($run_delete) {
                                            echo "<script>window.open('cart.php', '_self')</script>";
                                        }
                                    }
                                }
                                if (isset($_POST['continue'])) {
                                    echo "<script>window.open('index.php', '_self')</script>";
                                }

                                echo @$up_cart = updateCart();

                            }

                            ?>
<!--                            ?>-->
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



