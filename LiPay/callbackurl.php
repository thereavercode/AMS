<?php
header("Content-Type: application/json");

$stkCallbackResponse = file_get_contents('php://input');
$logFile = "stkTinypesaResponse.json";
$log = fopen($logFile, "a");
fwrite($log, $stkCallbackResponse);
fclose($log);

$callbackContent = json_decode($stkCallbackResponse);

$ResultCode = $callbackContent->Body->stkCallback->ResultCode;
$CheckoutRequestID = $callbackContent->Body->stkCallback->CheckoutRequestID;
$Amount = $callbackContent->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$MpesaReceiptNumber = $callbackContent->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$PhoneNumber = $callbackContent->Body->stkCallback->CallbackMetadata->Item[4]->Value;

if ($ResultCode == 0) {

    //Use localhost DB
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'tinypesa');

$link = new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

 /* 
    //Get Heroku ClearDB connection information
    $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $cleardb_server = $cleardb_url["host"];
    $cleardb_username = $cleardb_url["user"];
    $cleardb_password = $cleardb_url["pass"];
    $cleardb_db = substr($cleardb_url["path"],1);
    $active_group = 'default';
    $query_builder = TRUE;
    // Connect to DB
    $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
*/



    // Check connection
    if ($link->connect_error) {
        die("<h1>Connection failed:</h1> " . $link->connect_error);
    }
   else{

      
    $insert = $link->query("INSERT INTO tinypesa(CheckoutRequestID,ResultCode,amount,MpesaReceiptNumber,PhoneNumber) VALUES ('$CheckoutRequestID','$ResultCode','$Amount','$MpesaReceiptNumber','$PhoneNumber')");
      if($conn->query == TRUE ){
          echo"New record created";
      } else{
          echo"Error:" .$link->error;
      }
    $link = null;
}
}