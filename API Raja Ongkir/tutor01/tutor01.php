<?php

function cekresi() {
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
	//   CURLOPT_URL => "https://api.rajaongkir.com/basic/waybill",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "waybill=0110872101438397&courier=jne",
	  CURLOPT_HTTPHEADER => array(
		"content-type: application/x-www-form-urlencoded",
		"key: 4b4d44ef700ac4b7bedb77511a68f871"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}	
}

function getCost($apikey, $origin) {
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "origin=$origin&destination=114&weight=1700&courier=jne",
	  CURLOPT_HTTPHEADER => array(
		"content-type: application/x-www-form-urlencoded",
		"key: $apikey"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl); 
	
	return $response; 
}

function getListKota($apikey) {
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"key: $apikey"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	return $response; 
}

$apikey = "5871496d6aeddd58790a98a8ea36ccd9"; 
// $res 	= getListKota($apikey); 
//$node   = json_decode($res); 
//echo $node.status.code; 
// echo $res; 
//print_r($node);
//echo count($node);
//echo 	getListKota($apikey); 

$jne = getCost($apikey, 444);
 
echo $jne; 
echo "<br><br>"; 

//echo cekresi(); 
?>