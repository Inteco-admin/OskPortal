<?php
ini_set('mssql.charset', 'UTF-8');
ini_set('display_errors', 0);
include '.config.php';
$srv = $_SERVER;
	if ($srv['REQUEST_METHOD'] == "POST"){
		header('Access-Control-Allow-Origin: '.$srv['HTTP_ORIGIN']);
	} else {
		header('Access-Control-Allow-Origin: *');
	}
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$_REQUEST_lower = array_change_key_case($_REQUEST, CASE_LOWER);

$req_guid =  isset($_REQUEST_lower['guid']) ? htmlspecialchars($_REQUEST_lower['guid'], ENT_QUOTES, 'UTF-8') ?? null : null;
$req_modelId = isset($_REQUEST_lower['mid']) ? htmlspecialchars($_REQUEST_lower['mid'], ENT_QUOTES, 'UTF-8') ?? null : null;
$req_text = isset($_REQUEST_lower['text']) ? htmlspecialchars($_REQUEST_lower['text'], ENT_QUOTES, 'UTF-8') ?? null : null;
$req_do = isset($_REQUEST_lower['do']) ? htmlspecialchars($_REQUEST_lower['do'], ENT_QUOTES, 'UTF-8') ?? null : null;
$req_filter =  isset($_REQUEST_lower['filter']) ? htmlspecialchars($_REQUEST_lower['filter'], ENT_QUOTES, 'UTF-8') ?? null : null;

switch ($req_do){
	case "midsearch":
		$keyArr = explode(",",$req_modelId);
		foreach ($keyArr as $mdl){
			$key = array_search(intval($mdl), array_column($data, 'ModelId'));
			if ($key){
				$ret[] = $data[$key];
			} else {
				$ret[] = Array();
			}
			
		}
		header('Content-Type: application/json');
		echo json_encode($ret,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
		break;
	case "midlist":
		if ($req_filter){
			$query_add = " WHERE Name = '".$req_filter."' OR Name IS NULL";
		}
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		$query = "SELECT * FROM ModelElements".$query_add;
		$data = null;
		if( $conn ){
			$stmt = sqlsrv_query( $conn, $query);
			while( $row = sqlsrv_fetch_array( $stmt , SQLSRV_FETCH_ASSOC) ) {
				$data[] = $row;
			}
			sqlsrv_free_stmt( $stmt);
		} else {
			http_response_code(500);
			die();
		}
		sqlsrv_close($conn);
		header('Content-Type: application/json');
		echo json_encode($data,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
		break;
	case "workstatus":
		if ($req_filter){
			$query = "SELECT ModelId,Guid,WorkStatus FROM ModelElements WHERE (Name = '".$req_filter."' OR  Name IS NULL) AND WorkStatus = '".$req_text."'";
		}else {
			$query = "SELECT ModelId,Guid,WorkStatus FROM ModelElements WHERE WorkStatus = '".$req_text."'";
		}
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		
		$data = null;
		if( $conn ){
			$stmt = sqlsrv_query( $conn, $query);
			while( $row = sqlsrv_fetch_array( $stmt , SQLSRV_FETCH_ASSOC) ) {
				$data[] = $row;
			}
			sqlsrv_free_stmt( $stmt);
		} else {
			http_response_code(500);
			die();
		}
		sqlsrv_close($conn);
		
		header('Content-Type: application/json');
		echo json_encode($data,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
		break;
	case "workstatus_update":
		$postedData = json_decode(file_get_contents("php://input"));
		foreach ($postedData as $postElement){
			foreach ($postElement->data as $keyname => $msg) {
				$toUpdate[] = array("whatUpdate" => $keyname, "valueUpdate" => $msg, "whereUpdate" => $postElement->key->Id);
			}
		}
		
		header('Content-Type: application/json');
		foreach($toUpdate as $upd){
			$sql[]["sql"] = "UPDATE ModelElements SET [".$upd["whatUpdate"]."] = '".$upd["valueUpdate"]."' WHERE Id = ".$upd["whereUpdate"];
		}
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( sqlsrv_begin_transaction($conn) === false ){
			 $status_msg = "Could not begin transaction.";
			 http_response_code(503);
			 echo json_encode(["module" => "dbCommit","msg" => $status_msg],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
		} 
		if (perform_trans_ops($conn, $sql)){
			if(sqlsrv_commit($conn)){
				$status_msg = "Transaction commited";
				echo json_encode(["module" => "dbCommit","msg" => $status_msg,"srv" => $_SERVER],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
			} else {
				$status_msg = "Commit failed - rolling back";
				http_response_code(503);
				echo json_encode(["module" => "dbCommit","msg" => $status_msg],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
				sqlsrv_rollback($conn);
			}
		} else {
			$status_msg = "Error in transaction operation - rolling back";
			http_response_code(503);
			echo json_encode(["module" => "dbUpdate","msg" => $status_msg],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
			sqlsrv_rollback($conn); 
		}
		sqlsrv_close($conn);
		break;
	default:
		break;
}

function perform_trans_ops($conn, $sqlqueries)  
{  
    foreach ($sqlqueries as $sql){
		$sql_ret = sqlsrv_query( $conn, $sql["sql"]);
		if($sql_ret === false ) {
			return false;
		}
	}
    return true;  
}
?>