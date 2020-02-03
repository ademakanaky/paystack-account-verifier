<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 03/02/2020
 * Time: 12:28 AM
 */

require 'BankAccountVerify.php';

$instanceV = new \UCOM\BankAccountVerify();
///you need to change the parameters to that of the account to be verified.
//// can be fed with form input from your front-end
$details = $instanceV->fetchAccount('Guaranty Trust Bank', '0161199277');

echo $details;