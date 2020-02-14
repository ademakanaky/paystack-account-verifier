<?php

namespace UCOM;

require dirname(dirname(__FILE__)). DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use UCOM\BankAccountVerify;
use UCOM\PaymentsInterface;
use UCOM\TransactionRefGen as TransRef;

class Transfer ///implements PaymentsInterface
{

    private $bankname;
    private $account;
    private $accountName;
    private $amount;
    public $verifier;
    private $recipientCodeEndpoint = 'https://api.paystack.co/transferrecipient';
    private $initiateTransferEndpoint = 'https://api.paystack.co/transfer';
    private $checkBalanceEndpoint = 'https://api.paystack.co/balance';
    private $fetchTransferStatusEndpoint = 'https://api.paystack.co/transfer/';

    public function __construct($bankname, $accountNo, $accountName, $amount)
    {
        $this->bankname = $bankname;
        $this->account = $accountNo;
        $this->amount = $amount * 100;
        $this->accountName = $accountName;
        //$this->verifier = new BankAccountVerify;
    }

    private function api_secret(){
        //should fetch from config file
        return 'sk_test_70da1cd7cdbfadd3ca9efdd9c2866e1261bac113';
    }

    private function InsufficientBalanceMessage(){
        return 'A friendly message should be sent to customer in this scenario.';
    }
    public function curl($url, $requestType = 'POST', $body = [])
    {
        $curl = curl_init();
        if ($requestType === 'GET')
        {

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "authorization: Bearer ". $this->api_secret(),
                    "cache-control: no-cache",
                ),
            ));
        } else {
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_VERBOSE => TRUE,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $requestType,
                CURLOPT_HTTPHEADER => array(
                    "authorization: Bearer ". $this->api_secret(),
                    "cache-control: no-cache",
                ),
            ));
        }
        
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $res = json_decode($response);
            return $res;

        }
    }


    protected function validateAccount()
    {
        $bankCode = (new BankAccountVerify)->fetchBankCode($this->bankname);
        $accName = (new BankAccountVerify)->fetchAccount($this->bankname, $this->account);
        
        if ($accName == $this->accountName) {
            ///account details provided is valid
            $data = array('code'=> $bankCode, 'accname' => $accName);
            return json_encode($data);
        }else{
            ////account details provided is invalid
            return 'Could not resolve account at the moment';
        }
    }

    public function createRecipient()
    {
        $rs = json_decode($this->validateAccount(),true);
       
        if (!is_array($rs)) {
            return "Could not resolve provided details.";
        }
        $code = $rs['code'];
        $validatedAccName = $rs['accname'];
        $accNo = $this->account;
        $body = ["type" => "nuban", "name" => $validatedAccName, "description" =>"Wayray desc","account_number" => $accNo,"bank_code" => $code, "currency" => "NGN","metadata" => [
            "job" => "Eleran Ara Test"]];
        $url = $this->recipientCodeEndpoint;
        $recipientCode = $this->curl($url, 'POST', $body);
        ///This code should be stored in the db against the user
        return $recipientCode->data->recipient_code;
    }

    private function genTranxRef()
    {
        return TransactionRefGen::getHashedToken();
    }

    public function initiateTransfer()
    {
        /// Only transfer if there is enough balance.
        /// So there is a need to check balance before initiating transfer. You should uncomment the /// code block below

        /*if (!$this->canTransfer()) {
            return $this->InsufficientBalanceMessage();
        }*/

        //save this $transref in db transactions table alongside other details of the transaction
        $transref = self::genTranxRef();
        
        $url = $this->initiateTransferEndpoint;
        $body = ["source" => "balance", "reason" => "Calm down", "amount" => $this->amount, "recipient" => $this->createRecipient(), "reference" => $transref];

        $transferResponse = $this->curl($url,'POST', $body);
        
        $paystackTransCode = $transferResponse->data->transfer_code;
        if (is_null($paystackTransCode) || $paystackTransCode === "") {
            return "Transaction not successful. Please try again.";
        }
        //this code should be saved in db for checking status of transaction
        ///you update logic goes here
        return $paystackTransCode;
    }

    public function canTransfer()
    {
        $url = $this->checkBalanceEndpoint;
        $balance = $this->curl($url, 'GET');
        $balance = json_encode($balance->data);

        foreach (json_decode($balance) as $bal) {
            $balancec = $bal->balance;
        }
        if ($balancec < $this->amount){
            return false;
        }
        return true;
    }

    public function listenForNotification()
    {
        // TODO: Implement listenForNotification() method.
    }

    public function fetchTransferStatus(String $paystackTransCode)
    {
        ///use unique transfer code to fetch transaction status
        /// status can be any of 'pending', 'success', 'failed' or 'otp'
        $url = $this->fetchTransferStatusEndpoint.$paystackTransCode;
        $status = $this->curl($url, 'GET');
        return $status->data->status;
    }
}