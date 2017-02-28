<?php

/*
 * Created by Inclusion on 12/9/2015.
 */


class sms 
{

  function __construct()
  {
   $this->url = "http://107.20.199.106/restapi/sms/1/text/single";
   $this->username = "ThePeriodontistDentalCentre";
   $this->password = "pAXsKDof";
   // $this->username = "shemuplc";
   // $this->password = "iUyBbkKy";
   
            // json_sms
 }

 function sendsms($data){
  $ch = curl_init($this->url);
  // {"from":"PDC Dental","to":"254733825140","text":"Hope you are fine. Just to remind you of your appointment tomorrow at the periodontist at 12:00. For queries or confirmations kindly call/text 0716521043. Regards, The periodontist dental centre.","sendAt":""}

  $data_string = json_encode($data); 
  $additionalHeaders = '';
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $additionalHeaders));
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  

  $headers = array(
    'Content-Type:application/json',
    'Authorization: Basic '.  base64_encode($this->username.':'.$this->password),
    'Content-Length: ' . strlen($data_string)                                                                       
  );
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
echo $output;



}

// VGhlUGVyaW9kb250aXN0RGVudGFsQ2VudHJlOnBBWHNLRG9m
}


?>
