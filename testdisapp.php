<?php
    require "dbconnection.php";
   
    $accessToken = "yQw5mqImEwMHcau8Hb9CXnPQaTlz11cUCGhUZL64yG1GyAyMJddLMqfjiLwlZgvKfdC2yo896ykJVwW8Xne9++3BjCqj9xsNEdeENjtWVda5UTFIw149B2ygMnCp/4Fcn/nAV1YYOX1YLNxEJkiHwwdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    //รับข้อความจากผู้ใช้
$message = $arrayJson['events'][0]['message']['text'];
#ตัวอย่าง Message Type "Text"
      if($message == "location")
    {
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $sql = "SELECT iddb, lati, longt FROM db order by iddb desc limit 0,1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $latu = $row["lati"];//users location 
          $longu = $row["longt"];
          $lat1 = 35.364219; //1st 7-11
          $long1 = 139.267804;
          $lat2 = 35.366817; //2nd lawson
          $long2 = 139.272703;
          $lat3 = 35.372509; //3rd Family
          $long3 = 139.271988;
          $lat4 = 35.360643; //4th lawson
          $long4 = 139.275320;
          $lat5 = 35.361172; //5th Daily
          $long5 = 139.269099;
          $R = 6371;
   $deltaLat1 = deg2rad($lat1 - $latu);
   $deltaLong1 = deg2rad($long1 - $longu);
   $deltaLat2 = deg2rad($lat2 - $latu);
   $deltaLong2 = deg2rad($long2 - $longu);
   $deltaLat3 = deg2rad($lat3 - $latu);
   $deltaLong3 = deg2rad($long3 - $longu);
   $deltaLat4 = deg2rad($lat4 - $latu);
   $deltaLong4 = deg2rad($long4 - $longu);
   $deltaLat5 = deg2rad($lat5 - $latu);
   $deltaLong5 = deg2rad($long5 - $longu);
  $a1 = sin($deltaLat1/2) * sin($deltaLat1/2) + cos(deg2rad($lat1)) * cos(deg2rad($latu)) * sin($deltaLong1/2) * sin($deltaLong1/2);
  $c1 = 2 * atan2(sqrt($a1), sqrt(1-$a1));
  $dis1 = $R * $c1;
  $a2 = sin($deltaLat2/2) * sin($deltaLat2/2) + cos(deg2rad($lat2)) * cos(deg2rad($latu)) * sin($deltaLong2/2) * sin($deltaLong2/2);
  $c2 = 2 * atan2(sqrt($a2), sqrt(1-$a2));
  $dis2 = $R * $c2;
  $a3 = sin($deltaLat3/2) * sin($deltaLat3/2) + cos(deg2rad($lat3)) * cos(deg2rad($latu)) * sin($deltaLong3/2) * sin($deltaLong3/2);
  $c3 = 2 * atan2(sqrt($a3), sqrt(1-$a3));
  $dis3 = $R * $c3;
  $a4 = sin($deltaLat4/2) * sin($deltaLat4/2) + cos(deg2rad($lat4)) * cos(deg2rad($latu)) * sin($deltaLong4/2) * sin($deltaLong4/2);
  $c4 = 2 * atan2(sqrt($a4), sqrt(1-$a4));
  $dis4 = $R * $c4;
  $a5 = sin($deltaLat5/2) * sin($deltaLat5/2) + cos(deg2rad($lat5)) * cos(deg2rad($latu)) * sin($deltaLong5/2) * sin($deltaLong5/2);
  $c5 = 2 * atan2(sqrt($a5), sqrt(1-$a5));
  $dis5 = $R * $c5;
$dis = min ($dis1,$dis2,$dis3,$dis4,$dis5);
if ($dis == $dis1) {
           $arrayPostData['messages'][0]['type'] = "location";
           $arrayPostData['messages'][0]['title'] = "Nearest convenience";
           $arrayPostData['messages'][0]['address'] =   $row["lati"].",".$row["longt"];
           $arrayPostData['messages'][0]['latitude'] = $lat2;
           $arrayPostData['messages'][0]['longitude'] = $long1;
}
else if ($dis == $dis2) {
           $arrayPostData['messages'][0]['type'] = "location";
           $arrayPostData['messages'][0]['title'] = "Nearest convenience";
           $arrayPostData['messages'][0]['address'] =   $row["lati"].",".$row["longt"];
           $arrayPostData['messages'][0]['latitude'] = $lat1;
           $arrayPostData['messages'][0]['longitude'] = $long2;  
}
else if ($dis == $dis3) {
           $arrayPostData['messages'][0]['type'] = "location";
           $arrayPostData['messages'][0]['title'] = "Nearest convenience";
           $arrayPostData['messages'][0]['address'] =   $row["lati"].",".$row["longt"];
           $arrayPostData['messages'][0]['latitude'] = $lat3;
           $arrayPostData['messages'][0]['longitude'] = $long3;
}
else if ($dis == $dis4) {
           $arrayPostData['messages'][0]['type'] = "location";
           $arrayPostData['messages'][0]['title'] = "Nearest convenience";
           $arrayPostData['messages'][0]['address'] =   $row["lati"].",".$row["longt"];
           $arrayPostData['messages'][0]['latitude'] = $lat4;
           $arrayPostData['messages'][0]['longitude'] = $long4;
}
else if ($dis == $dis5) {
           $arrayPostData['messages'][0]['type'] = "location";
           $arrayPostData['messages'][0]['title'] = "Nearest convenience";
           $arrayPostData['messages'][0]['address'] =   $row["lati"].",".$row["longt"];
           $arrayPostData['messages'][0]['latitude'] = $lat5;
           $arrayPostData['messages'][0]['longitude'] = $long5;
}
        }else{
          $arrayPostData['messages'][0]['type'] = "text";
          $arrayPostData['messages'][0]['text'] = "error";
        }
        replyMsg($arrayHeader,$arrayPostData);
    }
    else
    {
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "please input 'location' and bot will show location or 'earthquake' bot will show earthquake location";
        replyMsg($arrayHeader,$arrayPostData);
    }
      function replyMsg($arrayHeader,$arrayPostData){
        $strUrl = "https://api.line.me/v2/bot/message/reply";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }
    
     function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/v2/bot/message/push";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($ch);
      curl_close ($ch);
   }
 
        
   exit;
?>