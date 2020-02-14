<?php

require 'Transfer.php';

if(!isset($_POST['submit'])){
    echo "Method GET not supported.";
    exit();
}

$bankname = trim($_POST['bankname']);
$accno = trim($_POST['accno']);
$accname = trim($_POST['accname']);
$amount = trim($_POST['amount']);

// perform transfer using submitted parameters
$txn = new \UCOM\Transfer($bankname, $accno, $accname,$amount);
echo $txn->initiateTransfer();
