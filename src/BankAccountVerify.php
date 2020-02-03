<?php

namespace UCOM;

class BankAccountVerify{

    private $apiEndpoint = 'https://api.paystack.co/bank';

    public function __construct()
    {
        $this->accountName = null;
    }
    public function api_secret(){
        //should fetch from config file
        return 'sk_test_70da1cd7cdbfadd3ca9efdd9c2866e1261bac113';
    }
    public function curl($url)
    {
        $curl = curl_init();

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

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
           $res = json_decode($response);
           return json_encode($res->data);

        }
    }

    /**
     * @param $AccountNo
     * @param $BankName
     */
    public function fetchAccount($BankName, $AccountNo){
        $Banks = $this->fetchBanks();
        //die(var_dump($Banks));
        //exit();
        foreach ($Banks as $Bank)
        {
            if($Bank->name === $BankName)
            {
                $BankCode = $Bank->code;
            }
        }
        $url = $this->apiEndpoint . '/'. 'resolve?account_number='.$AccountNo.'&bank_code='.$BankCode;
        //die($url);
        ///exit();
        $response = $this->curl($url);
        $response =  json_decode($response);
        if(!is_null($response->account_name))
            echo $response->account_name;
        else
            echo "Could not resolve name. Please try again later.";
    }

    public function fetchBanks(){
        ///resolve bank code from bank name
        $response = $this->curl($this->apiEndpoint);
        //$data = is_file('banks.json') ? json_decode(file_get_contents('banks.json')) : null;
        //return $data->data;
        return json_decode($response);
    }
}