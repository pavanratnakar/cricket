<?php
include_once ('../class/cricket_user.php');
include_once ('../class/functions.php');
$function=new Functions();
$type=$function->checkValues($_REQUEST['ref']);
$page = $function->checkValues($_REQUEST['page']); // get the requested page
$limit = $function->checkValues($_REQUEST['rows']); // get how many rows we want to have into the grid
$sidx = $function->checkValues($_REQUEST['sidx']); // get index row - i.e. user click to sort
$sord =$function->checkValues( $_REQUEST['sord']); // get the direction
$searchOn = $function->checkValues($_REQUEST['_search']);
if(isset($_REQUEST['_search']) && $searchOn!='false' && $type=='registerUser')
{
	$fld =  $function->checkValues($_REQUEST['searchField']);
	if( $fld=='uid' || $fld=='mindtreeid' || $fld=='firstname' || $fld=='sexselect' || $fld=='lastname' || $fld=='choice' || $fld=='rating' || $fld=='player' || $fld=='userip' || $fld=='registerDate' || $fld=='description' || $fld=='email' || $fld=='base_price' || $fld=='sold_price' || $fld=='team') 
	{
		$fldata =  $function->checkValues($_REQUEST['searchString']);
		$foper =  $function->checkValues($_REQUEST['searchOper']);
		// costruct where
		$wh .= " AND ".$fld;
		switch ($foper) {
			case "bw":
				$fldata .= "%";
				$wh .= " LIKE '".$fldata."'";
				break;
			case "eq":
				if(is_numeric($fldata)) {
					$wh .= " = ".$fldata;
				} else {
					$wh .= " = '".$fldata."'";
				}
				break;
			case "ne":
				if(is_numeric($fldata)) {
					$wh .= " <> ".$fldata;
				} else {
					$wh .= " <> '".$fldata."'";
				}
				break;
			case "lt":
				if(is_numeric($fldata)) {
					$wh .= " < ".$fldata;
				} else {
					$wh .= " < '".$fldata."'";
				}
				break;
			case "le":
				if(is_numeric($fldata)) {
					$wh .= " <= ".$fldata;
				} else {
					$wh .= " <= '".$fldata."'";
				}
				break;
			case "gt":
				if(is_numeric($fldata)) {
					$wh .= " > ".$fldata;
				} else {
					$wh .= " > '".$fldata."'";
				}
				break;
			case "ge":
				if(is_numeric($fldata)) {
					$wh .= " >= ".$fldata;
				} else {
					$wh .= " >= '".$fldata."'";
				}
				break;
			case "ew":
				$wh .= " LIKE '%".$fldata."'";
				break;
			case "ew":
				$wh .= " LIKE '%".$fldata."%'";
				break;
			default :
				$wh = "";
		}
	}
	$user=new User();
	$response=$user->getDetails($page,$limit,$sidx,$sord,1,$wh);
	echo json_encode($response);
	unset($response);
}
else if(isset($_REQUEST['_search']) && $searchOn!='false' && $type=='registerUmpire')
{
	$fld =  $function->checkValues($_REQUEST['searchField']);
	if( $fld=='uid' || $fld=='mindtreeid' || $fld=='firstname' || $fld=='sexselect' || $fld=='lastname' || $fld=='choice' || $fld=='rating' || $fld=='player' || $fld=='userip' || $fld=='registerDate' || $fld=='description' || $fld=='email' || $fld=='base_price' || $fld=='sold_price' || $fld=='team') 
	{
		$fldata =  $function->checkValues($_REQUEST['searchString']);
		$foper =  $function->checkValues($_REQUEST['searchOper']);
		// costruct where
		$wh .= " AND ".$fld;
		switch ($foper) {
			case "bw":
				$fldata .= "%";
				$wh .= " LIKE '".$fldata."'";
				break;
			case "eq":
				if(is_numeric($fldata)) {
					$wh .= " = ".$fldata;
				} else {
					$wh .= " = '".$fldata."'";
				}
				break;
			case "ne":
				if(is_numeric($fldata)) {
					$wh .= " <> ".$fldata;
				} else {
					$wh .= " <> '".$fldata."'";
				}
				break;
			case "lt":
				if(is_numeric($fldata)) {
					$wh .= " < ".$fldata;
				} else {
					$wh .= " < '".$fldata."'";
				}
				break;
			case "le":
				if(is_numeric($fldata)) {
					$wh .= " <= ".$fldata;
				} else {
					$wh .= " <= '".$fldata."'";
				}
				break;
			case "gt":
				if(is_numeric($fldata)) {
					$wh .= " > ".$fldata;
				} else {
					$wh .= " > '".$fldata."'";
				}
				break;
			case "ge":
				if(is_numeric($fldata)) {
					$wh .= " >= ".$fldata;
				} else {
					$wh .= " >= '".$fldata."'";
				}
				break;
			case "ew":
				$wh .= " LIKE '%".$fldata."'";
				break;
			case "ew":
				$wh .= " LIKE '%".$fldata."%'";
				break;
			default :
				$wh = "";
		}
	}
	$user=new User();
	$response=$user->getDetails($page,$limit,$sidx,$sord,2,$wh);
	echo json_encode($response);
	unset($response);
}
else if($type=='registerUser')
{
	$user=new User();
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$user->getDetails($page,$limit,$sidx,$sord,1);
	echo json_encode($response);
	unset($response);
}
else if($type=='registerUmpire')
{
	$user=new User();
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$user->getDetails($page,$limit,$sidx,$sord,2);
	echo json_encode($response);
	unset($response);
}
else if($type=='registerUserOperation')
{
	$oper=$function->checkValues($_REQUEST['oper']);
	if($oper=='add')
	{
		$user=new User();
		$response=$user->addDetails(
			$function->checkValues($_POST['mindtreeid']),
			$function->checkValues($_POST['firstname']),
			$function->checkValues($_POST['lastname']),
			$function->checkValues($_POST['sexselect']),
			$function->checkValues($_POST['choice']),
			$function->checkValues($_POST['rating']),
			'1',
			$function->checkValues($_POST['description']),
			$function->checkValues($_POST['email']),
			$function->checkValues($_POST['base_price'])
		);
		if($response)
		{
			$status=TRUE;
			$message="Player Added";
		}
		else
		{
			$status=FALSE;
			$message="Player/Umpire with given MindTree ID or Email has already registered.";
		}
		$addOperation= array(
		"status" => $status,
		"message" => $message
		);
		$response = $_POST["jsoncallback"] . "(" . json_encode($addOperation) . ")";
		echo $response;
		unset($response);
	}
	else if($oper=='edit')
	{
		$user=new User();
		$response=$user->editDetails(
			$function->checkValues($_POST['id']),
			$function->checkValues($_POST['base_price']),
			$function->checkValues($_POST['sold_price']),
			$function->checkValues($_POST['rating']),
			$function->checkValues($_POST['team'])
		);
		if($response)
		{
			$status=TRUE;
			$message="Player Details Edited";
		}
		else
		{
			$status=FALSE;
			$message="Player Details could not be Edited";
		}
		$addOperation= array(
		"status" => $status,
		"message" => $message
		);
		$response = $_POST["jsoncallback"] . "(" . json_encode($addOperation) . ")";
		echo $response;
		unset($response);
	}
	else if($oper=='del')
	{
		$product=new Product();
		$response=$product->deleteDetails($function->checkValues($_POST['id']));
		if($response)
		{
			$status=TRUE;
			$message="Product Deleted";
		}
		else
		{
			$status=FALSE;
			$message="Product could not be deleted";
		}
		$deleteOperation= array(
		"status" => $status,
		"message" => $message
		);
		$response = $_POST["jsoncallback"] . "(" . json_encode($deleteOperation) . ")";
		echo $response;
		unset($response);
	}
}
else if($type=='registerUmpireOperation')
{
	$oper=$function->checkValues($_REQUEST['oper']);
	if($oper=='add')
	{
		$user=new User();
		$response=$user->addDetails(
			$function->checkValues($_POST['mindtreeid']),
			$function->checkValues($_POST['firstname']),
			$function->checkValues($_POST['lastname']),
			$function->checkValues($_POST['sexselect']),
			'0',
			'0',
			'2',
			$function->checkValues($_POST['description']),
			$function->checkValues($_POST['email']),
			'0'
		);
		if($response)
		{
			$status=TRUE;
			$message="Player Added";
		}
		else
		{
			$status=FALSE;
			$message="Player/Umpire with given MindTree ID or Email has already registered.";
		}
		$addOperation= array(
		"status" => $status,
		"message" => $message
		);
		$response = $_POST["jsoncallback"] . "(" . json_encode($addOperation) . ")";
		echo $response;
		unset($response);
	}
	else if($oper=='edit')
	{
		$product=new Product();
		$response=$product->editDetails(
			$function->checkValues($_POST['name']),
			$function->checkValues($_POST['uid'])
		);
		if($response)
		{
			$status=TRUE;
			$message="Product Edited";
		}
		else
		{
			$status=FALSE;
			$message="Product could not be edited";
		}
		$addOperation= array(
		"status" => $status,
		"message" => $message
		);
		$response = $_POST["jsoncallback"] . "(" . json_encode($addOperation) . ")";
		echo $response;
		unset($response);
	}
	else if($oper=='del')
	{
		$product=new Product();
		$response=$product->deleteDetails($function->checkValues($_POST['id']));
		if($response)
		{
			$status=TRUE;
			$message="Product Deleted";
		}
		else
		{
			$status=FALSE;
			$message="Product could not be deleted";
		}
		$deleteOperation= array(
		"status" => $status,
		"message" => $message
		);
		$response = $_POST["jsoncallback"] . "(" . json_encode($deleteOperation) . ")";
		echo $response;
		unset($response);
	}
}
else if($type=='listofplayer')
{
	$user=new User();
	$response=$user->getPlayer();
	echo json_encode($response);
	unset($response);
}
?>