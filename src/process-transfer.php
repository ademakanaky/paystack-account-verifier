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

//1) perform transfer using submitted parameters
$txn = new \UCOM\Transfer($bankname, $accno, $accname,$amount);
echo $txn->initiateTransfer();
///2) use the response returned transaction_code to fetch transaction status later
///as shown below
//echo $txn->fetchTransferStatus('TRF_1ptvuv321ahaa7q');///to check status of transaction
