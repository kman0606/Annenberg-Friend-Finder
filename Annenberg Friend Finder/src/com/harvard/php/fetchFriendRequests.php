<?php 

require_once ('db_aff.php');
require_once("JSON.php");
$xml=array();
$reqarray =array();
if(!$db->open()){
   	$xml['status']="We are encountering temporary technical difficulties. Please try again later";
	$json = new Services_JSON();
	echo $json->encode($xml);
	exit();
}
	
	$user  = intval($_POST['huid']);
		
	if ( empty($user))
	{
		$xml['status']="Missing information.";
	} else {
		$sql = "SELECT users.name as name, users.huid as huid, users.image as imageUri from friends, users WHERE friends.friend = $user and mutual = 0 and users.huid = friends.user";
		$result=$db->sql_query($sql);
		if($result)
		{
			while($raw = mysql_fetch_assoc($result))
				$reqarray[] = $raw;
				
			$xml['status'] = "OK";
			$xml['list'] = $reqarray;
		}
		else
			$xml['status'] = "We are encountering temporary technical difficulties. Please try again later.";
	}
	$json = new Services_JSON();
	
	echo $json->encode($xml);
	exit();
?>
