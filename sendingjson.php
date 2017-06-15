<?php

include 'db.php';
//API Url
//$url = 'http://localhost/coba_api_b/receivejson.php';
$url = 'http://rsjd-sujarwadi.com/informasitt/insert.php';

//Initiate cURL.
$ch = curl_init($url);

/*
//The JSON data.
$jsonData = array(
    'id' => '12',
    'nama' => 'Server 1',
    'os' => 'Windows Server 2012',
    'ram' => '16GB',
    'chipset' => 'Intel Xeon'
);
*/

$tsql ="SELECT * FROM V_INFOJMLTT";
$result=sqlsrv_query($conn, $tsql);
if( $result === false) {
                      die( print_r( sqlsrv_errors(), true) );
                     }

/*
$row = array();

while($row = mysqli_fetch_assoc($query))
$jsonData = $row;
*/

  $jsonData= array();
  while($k=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
  $jsonData[] = array(
    "KODEBAGIAN"=>$k["KODEBAGIAN"],
    "NAMABAGIAN"=>$k["NAMABAGIAN"],
    "KDGRPTRF"=>$k["KDGRPTRF"],
    "NMGRPTRF"=>$k["NMGRPTRF"],
    "JMLTT"=>$k["JMLTT"],
    "TTISI"=>$k["TTISI"],
    "TTKOSONG"=>$k["TTKOSONG"],
    "TTPULANG"=>$k["TTPULANG"],
    "TTRENOVASI"=>$k["TTRENOVASI"]);
  }

echo json_encode($jsonData);

//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData, true);

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request
$result = curl_exec($ch);
