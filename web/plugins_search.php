<?php
require_once('common.php');

function search_plugin($type=0,$keyword=''){
	// $pType = check_sql($type);
	// $pKeyword = check_sql($keyword);
	// print $pType.$pKeyword;
	$pType = $type;
	$pKeyword = $keyword;
	$query = "SELECT ID,Name,Author,Time,Description FROM Plugin WHERE Name LIKE '%$pKeyword%'";
	$ret = array('data' => array(), );
	$result = mysql_query($query);
	while ($row = mysql_fetch_row($result)){
		// var_dump($row);
		foreach ($row as $key => $value){
			// echo $key.' => '.$value;
			$row[$key] = check_xss($value);
		}
		$ret['data'][] = $row;
		// var_dump($row);
	}
	return $ret;
}

function get_code($name='',$id=1){
	// $pName = check_sql($name);
	$query = "SELECT Code FROM Plugin WHERE Name='$name'";
	// print($query.'<br>');
	// $ret = array('data' => array(), );
	$result = mysql_query($query);
	if ($row = mysql_fetch_row($result)) {
		// $code = check_xss($row[0]);
		$code = $row[0];
		// print $code.'<br>';
		return check_xss($code);
	}
}

$type = check_sql(trim($_REQUEST['type']));
$keyword = check_sql(trim($_REQUEST['keyword']));
$name = check_sql(trim($_REQUEST['name']));
// print($type.$name);
if ($name and $name!='') {
	$data = get_code($name);
	// var_dump($data);
	// echo json_encode($data);
	echo $data;
}
else{
	$data = search_plugin($type,$keyword); 
	echo json_encode($data);
}
?>