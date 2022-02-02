<?php
session_start();
?>
<form action="checkout.php" method="POST">
  <table border="1">
    <tr>
        <td>Shipping: </td>
        <td> <input type="text" name="shipping" value="<?php echo $_SESSION['address'] ?>"></td>
    </tr>
    <tr>
        <td>Postal: </td>
        <td> <input type="text" name="postal"></td>
    </tr>
    <tr>
        <td> Credit Card Number: </td>
        <td> <input type="text" name="card"></td>
    </tr>
    <tr>
        <td>Cvc: </td>
        <td> <input type="text" name="cvc"></td>
    </tr>
    <tr>
        <td>Expiry: </td>
        <td> <input type="text" name="expiry"></td>
    </tr>
    <tr>
        <td></td>
        <td> <input type="submit" value="Action"></td>
    </tr>

</table>
</form>
<!-- Comment -->