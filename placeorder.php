<html>
<head>
<title>Order</title>
</head>
<body>
<?php require_once "ShoppingCart.php";
session_start();
?>
<div class="topnav">
  <a href="magazin.php">Products</a>
  <a href="Cos.php">Shopping Cart</a>
  <a href="administrator.php">Administrator</a>
  <a href="logout.php">Log out</a>
 <div><strong> Your order has been taken! Thanks for your choice :)</strong></div> 
 <?php 
 $shoppingCart = new ShoppingCart();
 $member_id=$_SESSION['id'];
 $cartItem = $shoppingCart->getMemberCartId($member_id);
 if (! empty($cartItem)) {
 $total = 0;
 foreach ($cartItem as $item =>$value){
	 $shoppingCart->addToPlacedOrders($value['product_id'], $value['id'], $value['quantity'], $member_id);
 }
 }
 $shoppingCart->emptyCart($member_id)
 ;?>
</body>
</div>
</html>