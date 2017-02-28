<?php
require_once('sms.php');

// sendtext("Pt Angela Mureti 00502 - SPT ","0723777115","2017-02-27T10:00:00+03:00");

function sendtext($summary,$number,$time){
//echo "it works ". $summary . " - ". $time;
//die;
  // $txt=$msg;

  $re1='(Pt)';	# Word 1
  $re2='.*?';	# Non-greedy match on filler
  $re3=' ';	# Uninteresting: ws
  $re4='.*?';	# Non-greedy match on filler
  $re5=' ';	# Uninteresting: ws
  $re6='.*?';	# Non-greedy match on filler
  $re7='( )';	# White Space 1
  $re8='(\\d+)';	# Integer Number 1
  $re9='.*?';	# Non-greedy match on filler
  $re10='(-)';	# Any Single Character 1
  $msg = "";

  if ($c=preg_match_all ("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7.$re8.$re9.$re10."/is", $summary, $matches))
  {
  	$word1=$matches[1][0];
  	$ws1=$matches[2][0];
  	$int1=$matches[3][0];
  	$c1=$matches[4][0];

  	print "($word1) ($ws1) ($int1) ($c1) \n";

      // $time = substr(str_replace('T', " ", $time), 0,16);
      // echo date('Y-m-d', strtotime($time)).'     ';
      // $time = strtotime($time);   //1488236400
      // echo strtotime('tomorrow'); //1488236400
  	// echo($time);
      // $time = str_replace('T', " ", $time);

  	if (strtotime($time) < strtotime('tomorrow')){
  		$msg = "Hope you are fine. Just to remind you of your appointment today at the periodontist at ". substr(str_replace("T", " ", $time),11,5) .". For queries or confirmations kindly call/text 0716521043. Regards, The periodontist dental centre.";
  	}else{

  		echo($msg);
  		$msg = "Hope you are fine. Just to remind you of your appointment tomorrow at the periodontist at " . substr(str_replace("T", " ", $time),11,5) . ". For queries or confirmations kindly call/text 0716521043. Regards, The periodontist dental centre.";

  	}

  	$data = array("from" => "PDC Dental",
  		"to" => "254".substr($number, 1),
  		"text" => $msg,
  		"sendAt"=>"");
  	print_r($data);
  //	$sm = new sms();
//  	$sm->sendsms($data);
  }

} 



?>
