<?php

    date_default_timezone_set("Asia/kolkata");
    //Data From Webhook
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);
    $chat_id = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $message_id = $update["message"]["message_id"];
    $id = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $firstname = $update["message"]["from"]["first_name"];
    $chatname = $_ENV['CHAT']; 
 /// for broadcasting in Channel
$channel_id = "-100xxxxxxxxxx";

/////////////////////////

    //Extact match Commands
    if($message == "/start"){
        send_message($chat_id,$message_id, "Hey $firstname  \nUse /cmds to view commands \n$chatname");
    }

    if($message == "/cmds" || $message == "/cmds@psychcrypt0_bot"){
        send_message($chat_id,$message_id, "
          /search <query> (Google search)
          \n/bin <bin> (Bin Data)
          \n/weather <name of your city> (Current weather Status)
          \n/dice <dice emoji>
          \n/date (today's date)
          \n/dict <word> (Dictionary)
          \n/time (current time) 
          \n/git <username> (Github User Info)         
          \n/cryptorate
          \n/info (User Info)
          ");
    }
      if($message == "/cryptorate" || $message == "/cryptorate@github_rbot"){
      
        send_message($chat_id,$message_id,"
	 Use command to check current Crypto rates
         \n/btcrateusd  Bitcoin rate in USD
         \n/ethusd Etherum rate in USD
         \n/ltcusd  Litecoin rate in USD
         \n/etcrusd  Ethereum Classic rate in USD
         \n/dogeusd  DogeCoin rate in USD
         ");
    }

    if($message == "/date"){
        $date = date("d/m/y");
        send_message($chat_id,$message_id, $date);
    }
   if($message == "/help"){
        $help = "Contact My Owner @love26aa90b0";
        send_message($chat_id,$message_id, $help);
    }
   if($message == "/time"){
        $time = date("h:i a", time());
        send_message($chat_id,$message_id, "$time IST");
    }

  if($message == "/sc" || $message == "/si" || $message == "/st" || $message == "/cs" || $message == "/ua" || $message == "/at"  ){
   $botdown = "@psychcrytp0_bot is under Maintenance";
        send_message($chat_id,$message_id, $botdown);
    }

  if($message == "/info"){
        send_message($chat_id,$message_id, "User Info \nName: $firstname\nID:$id \nUsername: @$username");
    }




///Commands with text


}


//Bin Lookup
if(strpos($message, "/bin") === 0){
    $bin = substr($message, 5);
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => "https://binssuapi.vercel.app/api/".$bin,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "accept-language: en-GB,en-US;q=0.9,en;q=0.8,hi;q=0.7",
    "sec-fetch-dest: document",
    "sec-fetch-site: none",
    "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1"
   ],
   ]);

 $result = curl_exec($curl);
 curl_close($curl);
 $data = json_decode($result, true);
 $bank = $data['data']['bank'];
 $country = $data['data']['country'];
 $brand = $data['data']['vendor'];
 $level = $data['data']['level'];
 $type = $data['data']['type'];
$flag = $data['data']['countryInfo']['emoji'];
 $result1 = $data['result'];

    if ($result1 == true) {
    send_MDmessage($chat_id,$message_id, "***✅ Valid BIN
Bin: $bin
Brand: $brand
Level: $level
Bank: $bank
Country: $country $flag
Type:$type
Checked By @$username ***");
    }
else {
    send_MDmessage($chat_id,$message_id, "***Enter Valid BIN***");
}
}

   
 /// BTC rate
if(strpos($message, "/btcusd") === 0){
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.coinbase.com/v2/prices/BTC-USD/spot",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7", 
"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$btcvalue = curl_exec($curl);
curl_close($curl);
$currentBTCvalue = json_decode($btcvalue, true);

$BTCvalueinUSD = $currentBTCvalue["data"]["amount"];

send_MDmessage($chat_id,$message_id, "***1 BTC \nUSD = $BTCvalueinUSD $ \nRate checked by @$username ***");
}

/// BTC rate INR
if(strpos($message, "/btcinr") === 0){
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.coinbase.com/v2/prices/BTC-INR/spot",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7", 
"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$btcvalue = curl_exec($curl);
curl_close($curl);
$currentBTCvalue = json_decode($btcvalue, true);

$BTCvalueinINR = $currentBTCvalue["data"]["amount"];

send_MDmessage($chat_id,$message_id, "***1 BTC \nINR = $BTCvalueinINR $ \nRate checked by @$username ***");
}

/// ETH rate
if(strpos($message, "/ethusd") === 0){
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.coinbase.com/v2/prices/ETH-USD/spot",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7", 
"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$ethvalue = curl_exec($curl);
curl_close($curl);
$currentETHvalue = json_decode($ethvalue, true);

$ethValueInUSD = $currentETHvalue["data"]["amount"];
send_MDmessage($chat_id,$message_id, "***1 ETH \nUSD = $ethValueInUSD $ \nRate checked by @$username ***");
}

/// LTC Rate
if(strpos($message, "/ltcusd") === 0){
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.coinbase.com/v2/prices/LTC-USD/spot",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7", 
"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$ltcvalue = curl_exec($curl);
curl_close($curl);
$currentLTCvalue = json_decode($ltcvalue, true);

$LTCvalueinUSD = $currentLTCvalue["data"]["amount"];

send_MDmessage($chat_id,$message_id, "*** Hey There 1 LiteCoin \nUSD = $LTCvalueinUSD $ \nRate checked by @$username ***");
}


/// ETC Rate
if(strpos($message, "/etcusd") === 0){
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.coinbase.com/v2/prices/ETC-USD/spot",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7", 
"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$etcvalue = curl_exec($curl);
curl_close($curl);
$currentETCvalue = json_decode($etcvalue, true);

$ETCvalueinUSD = $currentETCvalue["data"]["amount"];

send_MDmessage($chat_id,$message_id, "***1 ETC \nUSD = $ETCvalueinUSD $ \nRate checked by @$username ***");
}

/// ADARate
if(strpos($message, "/adausd") === 0){
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.coinbase.com/v2/prices/ADA-USD/spot",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7", 
"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
  ],
]);
$adavalue = curl_exec($curl);
curl_close($curl);
$currentADAvalue = json_decode($adavalue, true);

$ADAvalueinUSD = $currentADAvalue["data"]["amount"];

send_MDmessage($chat_id,$message_id, "***1 ADA \nUSD = $ADAvalueinUSD $ \nRate checked by @$username ***");
}
	

?>
