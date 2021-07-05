<?php
require_once "ShoppingCart.php";
session_start();
// Dacă utilizatorul nu este conectat redirecționează la pagina de autentificare ...
if (!isset($_SESSION['loggedin'])) {
header('Location: index.html');
exit;
}
// pt membrii inregistrati
$member_id=$_SESSION['id'];
$shoppingCart = new ShoppingCart();
if (! empty($_GET["action"])) {
 switch ($_GET["action"]) {
 case "add":
 $productResult = $shoppingCart->getProductByCode($_GET["id"]);
$cartResult = $shoppingCart->getCartItemByProduct($productResult[0]["id"], $member_id);
if ( empty($_POST["quantity"])) {
 // Modificare cantitate in cos
 $newQuantity = $cartResult[0]["quantity"] + $_POST["quantity"];
 $shoppingCart->updateCartQuantity($newQuantity, $cartResult[0]["id"]);
 } else {
 // Adaugare in tabelul cos
 $shoppingCart->addToCart($productResult[0]["id"], $_POST["quantity"], $member_id);
 }
 
 break;
 case "remove":
 // Sterg o sg inregistrare
 $shoppingCart->deleteCartItem($_GET["id"]);
 break;
 case "empty":
 // Sterg cosul
 $shoppingCart->emptyCart($member_id);
 break;
 case "update":
 $shoppingCart->updateCartQuantity($_POST["quantity"], $_GET["id"]);
 }

}
?>
<html>
<head>
<title>Shopping Cart</title>
<link href="style.css" type="text/css" rel="stylesheet" />
</head>
<div class="topnav">
  <a href="magazin.php">Products</a>
  <a class="active" href="Cos.php">Shopping Cart</a>
  <a href="administrator.php">Administrator</a>
  <a href="logout.php">Log out</a>
</div>
<body>
 <div id="shopping-cart">
 <div class="txt-heading">
 <div><h1>Shopping Cart</h1></div> <a id="btnEmpty" href="cos.php?action=empty"><img src="empty-cart.png" alt="empty-cart" title="Empty Cart" /></a>
 </div>
<?php
$cartItem = $shoppingCart->getMemberCartItem($member_id);
if (! empty($cartItem)) {
 $item_total = 0;
 ?>
<table cellpadding="10" cellspacing="1">
 <tbody>
 <tr>
 <th style="text-align: left;"><strong>Name</strong></th>
 <th style="text-align: left;"><strong>Code</strong></th>
 <th style="text-align: right;"><strong>Quantity</strong></th>
 <th style="text-align: right;"><strong>Price</strong></th>
 <th style="text-align: center;"><strong>Action</strong></th>
  <th style="text-align: center;"><strong>Update</strong></th>
 </tr>
 <?php
 foreach ($cartItem as $item) {
?>  
<tr>
<form method="post" action="cos.php?action=update&id=<?php echo $item["cart_id"]; ?>">
 <td style="text-align: left; border-bottom: #F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
 <td style="text-align: left; border-bottom: #F0F0F0 1px solid;"><?php echo $item["id"];?></td>
 <td style="text-align: right; border-bottom: #F0F0F0 1px solid;"><input type="number" name="quantity" value="<?php echo $item["quantity"]; ?>"></td>
 <td style="text-align: right; border-bottom: #F0F0F0 1px solid;"><?php echo "$".$item["rrp"]; ?></td>
 <td style="text-align: center; border-bottom: #F0F0F0 1px solid;">
 <a href="cos.php?action=remove&id=<?php echo $item["cart_id"]; ?>" class="btnRemoveAction">
 <img src="icon-delete.png" alt="icon-delete" title="Remove Item" />
 </a>
 </td>
 <td style="text-align: center; border-bottom: #F0F0F0 1px solid;">
 <input type="submit" value="Update">
 </td>
 </form>
 </tr>
<?php
 $item_total += ($item["price"] * $item["quantity"]);
 }
 ?>
<tr>
 <td colspan="3" align=right><strong>Total</strong></td>
 <td align=right><?php echo "$".$item_total; ?></td>
 <td></td>
 </tr>
 </tbody>
 </table>
 <?php if (isset($_SESSION['loggedin'])): ?>
 <form method="post" action="placeorder.php">
 <?php else: ?>
 <form method="post" action="autentificare.php">
 <?php endif?>
 <input type="submit" value="Place Order">
 </form>
 <?php
}
?>
</div>
</body>
</html>