<?php

$con = mysqli_connect("localhost", "root", "", "ecommerce");

if (mysqli_connect_errno()){
    echo "The Connection was not established: " . mysqli_connect_error();
}
// получить ip пользователя
function getIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
// функция добавляет новый продук и айпи пользователя в таблицу и делает предварительно несколько проверок.
//==================================================================================
function cart(){
    if (isset($_GET['add_cart'])){

        global $con;
        $ip = getIp();

        $pro_id = $_GET['add_cart'];

        $check_pro = "select * from cart where ip_add='$ip' AND p_id='$pro_id'";

        $run_check = mysqli_query($con, $check_pro);

        if (mysqli_num_rows($run_check) > 0) {
            echo "";
        } else {
            $insert_pro = "insert into cart (p_id, ip_add) values ('$pro_id', '$ip')";

            $run_pro = mysqli_query($con, $insert_pro);

            echo "<script>window.open('index.php', '_self')</script>";
        }
    }
}

// получить общее количество добавленных позиций
//==================================================================================
function total_items() {
    global $con;

    if(isset($_GET['add_cart'])) {
        $ip = getIp();

        $get_items = "select * from cart where ip_add='$ip'";

        $run_items = mysqli_query($con, $get_items);

        $count_items = mysqli_num_rows($run_items);

    } else {
        $ip = getIp();

        $get_items = "select * from cart where ip_add='$ip'";

        $run_items = mysqli_query($con, $get_items);

        $count_items = mysqli_num_rows($run_items);

    }

    echo $count_items;
}
// получить полную сумму элементов в корзине
//==================================================================================
function total_price() {
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

            $values = array_sum($product_price);

            $total += $values;
        }

    }

    echo "&#x20bd; $total" ;

}

// получить лист категоий или брендов для файла index.php
//==================================================================================
function getData($table){
    global $con;
    $get_ = "select * from ";
    $get_ .= $table;
    $run_ = mysqli_query($con, $get_);


    while ($row_ = mysqli_fetch_array($run_)){
        if($table == "categories") {
            $id = 'cat_id';
            $title = 'cat_title';
            $nameID = 'cat';
        } elseif($table == "brands"){
            $id = 'brand_id';
            $title = 'brand_title';  
            $nameID = 'brand';         
        }

        $_id = $row_[$id];
        $_title = $row_[$title];

        $open = "<li><a href='index.php?".$nameID."=$_id'>";
        $close = "</a></li>";

        $mainString = $open.$_title.$close;
        echo $mainString;
    }
}
//==================================================================================
//==================================================================================
// эта функция существует для рандомного взятия некоторого числа продуктов для отображения их на странице html
function getPro(){
    global $con;

    $name = 'cat';
    if(!isset($_GET['cat'])){
        if(!isset($_GET['brand'])){

        $get_pro = "select * from products order by RAND() LIMIT 0,6";
            
            $run_pro = mysqli_query($con, $get_pro);
            
            $count_ = mysqli_num_rows($run_pro);
            
            
            if($count_ == 0){
                // показать сообщение ошибки
                echo "<h2 style='padding:20px;'>No products where found</h2>";
            }else{
                // при успешном прохождении условия показать продукты
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
                    <p><b>Price: &#x20bd;  $pro_price </b></p>
                    
                    <a href='details.php?pro_id=$pro_id' style='float:left;'>Details</a>
                    
                    <a href='index.php?add_cart=$pro_id'><button style='float:right'>Add to Cart</button></a>
                    
                    </div>
                    
                    ";
                    
                }
            }
            
        }
    }
}    
//==================================================================================
// вывести товары в соответствии с выбраной категорией
function getCatPro(){
    global $con;

    if(isset($_GET['cat'])){

        $_id = $_GET['cat'];

        $get_pro = "select * from products where product_cat='$_id'";    

        $run_pro = mysqli_query($con, $get_pro);
            
        $count_ = mysqli_num_rows($run_pro);
        
        
        if($count_ == 0){
            echo "<h2 style='padding:20px;'>No products where found this category</h2>";
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
}    
//==================================================================================
// вывести товары в соответствии с выбранным брендом
function getBrandPro(){
    global $con;

    if(isset($_GET['brand'])){

        $_id = $_GET['brand'];

        $get_pro = "select * from products where product_brand='$_id'";    

        $run_pro = mysqli_query($con, $get_pro);
            
        $count_ = mysqli_num_rows($run_pro);
        
        
        if($count_ == 0){
            echo "<h2 style='padding:20px;'>No products where found associated with this brand</h2>";
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
}    
//==================================================================================
// функция которая используется в details.php для вывода информации по определенному продукту
// так же здесь добавляется ссылка вернуться назад и добавить продукт в корзину
function getDetails($con){
    // понять что есть id со страницы index.php для успешного входа в блок
    if(isset($_GET['pro_id'])) {
        
        $product_id = $_GET['pro_id'];
        
        $get_pro = "select * from products where product_id='$product_id'";
        
        $run_pro = mysqli_query($con, $get_pro);
        
        while($row_pro = mysqli_fetch_array($run_pro)){
            $pro_id = $row_pro['product_id'];
            $pro_title = $row_pro['product_title'];
            $pro_price = $row_pro['product_price'];
            $pro_image = $row_pro['product_image'];
            $pro_desc = $row_pro['product_desc'];
            
            echo "
            <div id='single_product'>
            
            <h3>$pro_title</h3>
            <img src='admin_area/product_images/$pro_image' width='400' height='300' />
            <p><b>&#x20bd;  $pro_price </b></p>
            
            <p>$pro_desc</p>
            
            <a href='index.php' style='float:left;'>Go Back</a>
            
                    <a href='index.php?pro_id=$pro_id'><button style='float:right'>Add to Cart</button></a>
                    
                    </div>
                    
                    ";
                }
            }
            
            
        }
//==================================================================================



?>