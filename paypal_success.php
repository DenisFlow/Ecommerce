<?php

session_start();

?>



<html>
    <head>
        <title>Payment Successful!</title>
    </head>

<body>

<?php
include("includes/db.php");
include("functions/functions.php");


// this is all for product
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

        $product_id = $pp_price['product_id'];

        $total += $values;
    }

}
// getting quantity of the product
$get_qty = "select * from cart where p_id='$pro_id'";
$run_qty = mysqli_query($con, $get_qty);

$row_qty = mysqli_fetch_array($run_qty);

$qty = $row_qty['qty'];

if ($qty==0) {
    $qty = 1;
} else {
    $qty = $qty;

    $total = $total * $qty;
}

// this is about customer
$user = $_SESSION['customer_email'];
$get_c = "select * from customers where customer_email = '$user' ";

$run_c = mysqli_query($con, $get_c);

$row_c = mysqli_fetch_array($run_c);

$c_id = $row_c['customer_id'];

// payment details from paypal
$amount = $_GET['amt'];
$currency = $_GET['cc'];
$trx_id = $_GET['tx'];

// Generate random number
$invoice = mt_rand();

// inserting the payment to table
$insert_payments = "insert into payments (amount, customer_id, product_id, trx_id, currency, payment_date) values ('$amount', '$c_id', '$pro_id', '$trx_id', '$currency', NOW())";

// inserting the order into table
$run_payments = mysqli_query($con, $insert_payments);

$insert_order = "insert into orders (p_id, c_id, qty, invoice_no, order_date, status) values ('$pro_id', '$c_id', '$qty', '$invoice', NOW(), 'in Progress')";
$run_order = mysqli_query($con, $insert_order);

// removing the products from cart
$empty_cart = "delete from cart ";
$run_cart = mysqli_query($con, $empty_cart);

 if($amount==$total) {
     echo "<h2>Welcome:" . $_SESSION['customer_email'] . "<br>" . "Your Payment was successful!</h2>";
     echo "<a href='http://onlinetutting.com/myshop/customer/my_account.php'>Go to your Account</a>";
 } else {
    echo "<h2>Welcome Guest, Payment was failed</h2><br>";
    echo "<a href='http://onlinetutting.com/myshop'>Go Back to Shop</a>";

 }




?>


</body>
</html>