<?php
session_start();
?>

<?php
// Check if session is not registered, redirect back to main page.
// Put this code in first line of web page.
session_start();

// set time-out period (in seconds)
$inactive = 120;

// check to see if $_SESSION["timeout"] is set
if (isset($_SESSION["timeout"])) {
    // calculate the session's "time to live"
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactive) {
        session_destroy();
        header("Location: loginform.php");
    }
}

$_SESSION["timeout"] = time();

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
        <td> <input type="submit" value="Checkout"></td>
    </tr>

</table>
</form>
