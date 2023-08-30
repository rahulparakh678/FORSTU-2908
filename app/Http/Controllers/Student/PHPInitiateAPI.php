<?php 
require_once "PaytmChecksum.php";


//define('PAYTM_ENVIRONMENT', 'https://securegw-stage.paytm.in');
define('PAYTM_ENVIRONMENT', 'https://securegw.paytm.in');

/**
* Generate checksum by parameters we have
* Find your Merchant ID, Merchant Key and Website in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
define('PAYTM_MID', 'KWIoPe48558252418479');
define('PAYTM_MERCHANT_KEY', '2_5y5pUfxLWzggUf');


//define('PAYTM_WEBSITE', 'WEBSTAGING');
define('PAYTM_WEBSITE', 'retail'); // for production

function getTransactionToken($amount){

    $generatedOrderID = "PYTM_BLINK_".time();
    //$amount = "1800.00";
    //$amount1 ="6000.00";
    $callbackUrl = route('studentsview');

    $paytmParams["body"] = array(
                                "requestType"   => "Payment",
                                "mid"           => PAYTM_MID,
                                "websiteName"   => PAYTM_WEBSITE,
                                "orderId"       => $generatedOrderID,
                                "callbackUrl"   => $callbackUrl,
                                "txnAmount"     => array(
                                                        "value" => $amount,
                                                        "currency" => "INR",
                                                    ),
                                
                                "userInfo"      => array(
                                                    "custId" => "CUST_".time(),
                                                ),
                            );

        $generateSignature = PaytmChecksum::generateSignature(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES), PAYTM_MERCHANT_KEY);

        $paytmParams["head"] = array(
                                "signature" => $generateSignature
                            );

        $url = PAYTM_ENVIRONMENT."/theia/api/v1/initiateTransaction?mid=". PAYTM_MID ."&orderId=". $generatedOrderID;

        $getcURLResponse = getcURLRequest($url, $paytmParams);

        if(!empty($getcURLResponse['body']['resultInfo']['resultStatus']) && $getcURLResponse['body']['resultInfo']['resultStatus'] == 'S'){
            $result = array('success' => true, 'orderId' => $generatedOrderID, 'txnToken' => $getcURLResponse['body']['txnToken'], 'amount' => $amount,'message' => $getcURLResponse['body']['resultInfo']['resultMsg']);
             //$result1 = array('success' => true, 'orderId' => $generatedOrderID, 'txnToken' => $getcURLResponse['body']['txnToken'],'amount1' => $amount1,'message' => $getcURLResponse['body']['resultInfo']['resultMsg']);
        }else{
            $result = array('success' => false, 'orderId' => $generatedOrderID, 'txnToken' => '', 'amount' => $amount, 'message' => $getcURLResponse['body']['resultInfo']['resultMsg']);
            
        }
        return $result;
    
    }


    function getcURLRequest($url , $postData = array(), $headers = array("Content-Type: application/json")){

        $post_data_string = json_encode($postData, JSON_UNESCAPED_SLASHES);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
        $response = curl_exec($ch);
        return json_decode($response,true);
    }

    function getSiteURL(){

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        return str_replace('config.php', '', $actual_link);
    }
?>