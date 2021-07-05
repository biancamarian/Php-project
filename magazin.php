<?php
require_once "ShoppingCart.php";
session_start();
?>
<html>
<head>
<title>Online Shop </title>
<link href="style.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div class="topnav">
  <a class="active" href="magazin.php">Products</a>
  <a href="Cos.php">Shopping Cart</a>
  <?php if($_SESSION['role']==2):?>
  <a href="administrator.php">Administrator</a>
  <?php endif; ?>
  <a href="logout.php">Log out</a>
</div>
<div id="product-grid">
 <div class="txt-heading"><h1>Products</h1></div>
 <?php
$shoppingCart = new ShoppingCart();
 $query = "SELECT * FROM products";
 $product_array = $shoppingCart->getAllProduct($query);
 if (! empty($product_array)) {
 foreach ($product_array as $key => $value) {
 ?>
 <a href="product.php?id=<?php echo $product_array[$key]["id"];?>">
 <div class="product-item">
 <form method="post" action="cos.php?action=add&id=<?php echo $product_array[$key]["id"]; ?>">
 <div class="product-image">
 <img style="width: 100px" src="<?php echo $product_array[$key]["img"]; ?>">
 </div>
 </a>
 <div>
 <strong><?php echo $product_array[$key]["name"]; ?></strong>
 </div>
 <span class="price">&dollar;<?=$product_array[$key]["price"]?>
                <?php if ($product_array[$key]["rrp"] > 0): ?>
                <span class="rrp"> <= &dollar;<?=$product_array[$key]["rrp"]?></span>
                <?php endif; ?>
 <input type="text" name="quantity" value="1" size="2" />
 <input type="submit" value="Add to cart" />
 </form>
 </div>
 </div>
 <?php
 }
 }
 ?>
</div>
</body>
</html>