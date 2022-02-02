<?php
$namereg = "/^[a-zA-Z\s]*$/";
$usernamereg = "^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$"; // Only contains alphanumeric characters, underscore and dot, Underscore and dot can't be at the end or start of a username, 
//Underscore and dot can't be next to each other , Underscore or dot can't be used multiple times in a row, Number of characters must be between 8 to 20.

$passwordreg = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/"; //Minimum eight characters, at least one letter and one number:
$addressreg = "/[a-zA-Z\d\s\-\,\#\.\+]+/"; // allow only alphanumeric characters, spaces and few other characters like comma, period and hash symbol in the form input field.
$contactreg = "/[6|8|9]\d{7}|\+65[6|8|9]\d{7}|\+65\s[6|8|9]\d{7}/";  //allows singaporean phone numbers, aka starting with 6, 8 or 9
$emailreg = "/^[\w.+\-]+@.com/"; //test if is an email or not
$dobreg = "((0[1-9])|(1[0-2]))[\/-]((0[1-9])|(1[0-9])|(2[0-9])|(3[0-1]))[\-](\d{4})"; // date of birth, mm-dd-yyyy format
$cardnumreg = "/^\d{16}$/"; //only allow 16 digits of number with no space
$cvvreg = "/^\d{3}$/";
$expiryreg = "/^(0[1-9])\/(|[0-9]{2})$/";
$postalreg = "/^\d{6}$/"
?>