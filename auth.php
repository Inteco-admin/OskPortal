<?php 
$url = 'https://developer.api.autodesk.com/authentication/v1/authenticate';
$data = array("client_id" => "<client_id>", "client_secret" => "client_secret", "grant_type" => "client_credentials", "scope" => "viewables:read");

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$srv = $_SERVER;
if ($srv['REQUEST_METHOD'] == "POST"){
	header('Access-Control-Allow-Origin: '.$srv['HTTP_ORIGIN']);
} else {
	header('Access-Control-Allow-Origin: *');
}
header('Content-Type: application/json');
if ($result === FALSE) {
	$status_msg = "Failed auth";
	$s = json_decode($result,true);
	echo json_encode(array($s,$status_msg),JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
} else {
	$s = json_decode($result,true);
	echo json_encode($s,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
}
?>