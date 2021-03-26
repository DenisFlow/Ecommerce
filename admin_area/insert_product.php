<!DOCTYPE>
<?php
include("../functions/functions.php");

?>
<html>
    <head>
        <title>Inserting Product</title>
    </head>

    <body bgcolor="skyblue">
        <form action="insert_product.php" method="post"  enctype="multipart/form-data">
            <table align="center" width="700" border="2" bgcolor="pink">
                <tr align="center">
                    <td colspan="7"><h2>Insert New Post Here</h2></td>
                </tr>

                <tr>
                    <td align="right"><b>Product Title:</b></td>
                    <td><input type="text" name="product_title" size="60" required /></td>
                </tr>

                <tr>
                    <td align="right"><b>Product Category:</b></td>
                    <td>
                        <select name="product_cat" required>
                            <option>Select a Category</option>
                            <?php 
                            $get_cat = "select * from categories";
                            $run_cat = mysqli_query($con, $get_cat);

                            while($row_cat = mysqli_fetch_array($run_cat)){
                                $cat_id = $row_cat['cat_id'];
                                $cat_title = $row_cat['cat_title'];

                                echo "<option value='$cat_id'>$cat_title</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td align="right"><b>Product Brand:</b></td>
                    
                    <td>
                        <select name="product_brand" required>
                            <option>Select a Brand</option>
                            <?php 
                            $get_brands = "select * from brands";
                            $run_brands = mysqli_query($con, $get_brands);

                            while($row_brands = mysqli_fetch_array($run_brands)){
                                $brand_id = $row_brands['brand_id'];
                                $brand_title = $row_brands['brand_title'];

                                echo "<option value='$brand_id'>$brand_title</option>";
                            }

                            ?>
                        </select>
                    </td>                    
                </tr>

                <tr>
                    <td align="right"><b>Product Image:</b></td>
                    <td><input type="file" name="product_image" required /></td>
                </tr>

                <tr>
                    <td align="right"><b>Product Price:</b></td>
                    <td><input type="text" name="product_price" required /></td>
                </tr>

                <tr>
                    <td align="right"><b>Product Description:</b></td>
                    <td><textarea name="product_desc" id="" cols="50" rows="5" required></textarea></td>
                </tr>

                <tr>
                    <td align="right"><b>Product Keywords:</b></td>
                    <td><input type="text" name="product_keywords" size="50" required /></td>
                </tr>

                <tr align="center">
                    <td colspan="7"><input type="submit" name="insert_post" value="Insert Now" /></td>
                </tr>
            </table>
        </form>
    </body>    

</html>    

<?php
    // getting the text data from the fields
    if(isset($_POST['insert_post'])){
        $product_title = $_POST['product_title'];
        $product_cat = $_POST['product_cat'];
        $product_brand = $_POST['product_brand'];
        $product_price = $_POST['product_price'];
        $product_desc = $_POST['product_desc'];
        $product_keywords = $_POST['product_keywords'];

    // getting image from the filed
        $product_image = $_FILES['product_image']['name'];
        $product_image_tmp = $_FILES['product_image']['tmp_name'];


        // переместить файл в другое место
        move_uploaded_file($product_image_tmp, "product_images/$product_image");
        // строка выражение
         echo $insert_product = "insert into products (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) 
                             values ('$product_cat', '$product_brand', '$product_title', '$product_price', '$product_desc', '$product_image', '$product_keywords')";
         // вставить данные в таблицу
         $insert_pro = mysqli_query($con, $insert_product);
        // если успех, то показать сообщение
         if($insert_pro){

             echo "<script>alert('Product Has  been inserted!')</script>";
             echo "<script>window.open('insert_product.php','_self')</script>";

         }
    }

?>