<?php

$con = mysqli_connect("localhost", "root", "", "ecommerce");

// getting the categories
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

// function getPro($name){
//     global $con;

//     echo "<script>alert('$name')</ script>"; 
    
//     // if(isset($_GET[$name])){
//         $_id = $_GET[$name];
//         $get_pro = "select * from products where product_".$name."='$_id'";
//     // }else{
//     //     exit();
//     // }


//     // if(!isset($_GET['cat']) and !isset($_GET['brand'])){
//     //     $get_pro = "select * from products order by RAND() LIMIT 0,6";
//     // }elseif(isset($_GET['cat']) and $name == 'cat' or isset($_GET['brand']) and $name == 'brand'){
//     //     $_id = $_GET[$name];
//     //     $get_pro = "select * from products where product_".$name."='$_id'"; 
//     // }else{
//     //     exit();
//     // }
            
//             $run_pro = mysqli_query($con, $get_pro);
            
//             $count_ = mysqli_num_rows($run_pro);
            
//             if($name == 'cat') {
//                 $errorName = 'this category';
//             }elseif($name == 'brand'){
//                 $errorName = 'associated with this brand';
//             }else{
//                 $errorName = "";
//             }

            
//             if($count_ == 0){
//                 echo "<h2 style='padding:20px;'>No products where found ".$errorName."</h2>";
//             }else{
                
//                 while($row_pro = mysqli_fetch_array($run_pro)){
//                     $pro_id = $row_pro['product_id'];
//                     $pro_cat = $row_pro['product_cat'];
//                     $pro_brand = $row_pro['product_brand'];
//                     $pro_title = $row_pro['product_title'];
//                     $pro_price = $row_pro['product_price'];
//                     $pro_image = $row_pro['product_image'];
                    
                    
//                     echo "
//                     <div id='single_product'>

//                     <h3>$pro_title</h3>
//                     <img src='admin_area/product_images/$pro_image' width='180' height='180' />
//                     <p><b>&#x20bd;  $pro_price </b></p>
                    
//                     <a href='details.php?pro_id=$pro_id' style='float:left;'>Details</a>
                    
//                     <a href='index.php?pro_id=$pro_id'><button style='float:right'>Add to Cart</button></a>
                    
//                     </div>
                    
//                     ";
                    
//                 }
//             }
            

//     }    
//==================================================================================
function getPro(){
    global $con;

    $name = 'cat';
    if(!isset($_GET['cat'])){
        if(!isset($_GET['brand'])){

        $get_pro = "select * from products order by RAND() LIMIT 0,6";
            
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
    }
}    
//==================================================================================
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
function getDetails($con){
    
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