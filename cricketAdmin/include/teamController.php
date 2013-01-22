<?php
include_once ('../class/team_owner.php');
include_once ('../class/functions.php');
$function=new Functions();
$type=$function->checkValues($_REQUEST['ref']);
$page = $function->checkValues($_REQUEST['page']); // get the requested page
$limit = $function->checkValues($_REQUEST['rows']); // get how many rows we want to have into the grid
$sidx = $function->checkValues($_REQUEST['sidx']); // get index row - i.e. user click to sort
$sord =$function->checkValues( $_REQUEST['sord']); // get the direction
$searchOn = $function->checkValues($_REQUEST['_search']);
if(isset($_REQUEST['_search']) && $searchOn!='false' && $type=='teamRegister')
{
	$fld =  $function->checkValues($_REQUEST['searchField']);
	if( $fld=='team_id' || $fld=='owner_firstname' || $fld=='owner_lastname' || $fld=='owner_email' || $fld=='owner_mindtree_id' || $fld=='team_name' || $fld=='role') 
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
	$team=new Team();
	$response=$team->getDetails($page,$limit,$sidx,$sord,1,$wh);
	echo json_encode($response);
	unset($response);
}
else if($type=='teamRegister')
{
	$team=new Team();
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$team->getDetails($page,$limit,$sidx,$sord,1);
	echo json_encode($response);
	unset($response);
}
else if($type=='teamDetails')
{
	$team=new Team();
	$response=$team->getTeams();
	echo json_encode($response);
	unset($response);
}
else if($type=='teamDetailsForDate')
{
	$team=new Team();
	$fixture_id =  $function->checkValues($_REQUEST['fixture_id']);
	$response=$team->getTeamsforFixtureId($fixture_id);
	echo json_encode($response);
	unset($response);
}
else if($type=='teamOperation')
{
	$oper=$function->checkValues($_REQUEST['oper']);
	if($oper=='add')
	{
		$team=new Team();
		$response=$team->addDetails(
			$function->checkValues($_POST['owner_firstname']),
			$function->checkValues($_POST['owner_lastname']),
			$function->checkValues($_POST['owner_email']),
			$function->checkValues($_POST['owner_mindtree_id']),
			$function->checkValues($_POST['team_name']),
			$function->checkValues($_POST['role'])
		);
		if($response)
		{
			$status=TRUE;
			$message="Team Added";
		}
		else
		{
			$status=FALSE;
			$message="Team with given MindTree ID or Email has already registered.";
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
		$team=new Team();
		$response=$team->editDetails(
			$function->checkValues($_POST['id']),
			$function->checkValues($_POST['owner_firstname']),
			$function->checkValues($_POST['owner_lastname']),
			$function->checkValues($_POST['owner_email']),
			$function->checkValues($_POST['owner_mindtree_id']),
			$function->checkValues($_POST['team_name']),
			$function->checkValues($_POST['role'])
		);
		if($response)
		{
			$status=TRUE;
			$message="Team Details Edited";
		}
		else
		{
			$status=FALSE;
			$message="Team Details could not be Edited";
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
		$team=new Team();
		$response=$team->deleteDetails($function->checkValues($_POST['id']));
		if($response)
		{
			$status=TRUE;
			$message="Team Deleted";
		}
		else
		{
			$status=FALSE;
			$message="Team could not be deleted";
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
else if($type=='teamAmountRemaining')
{
	$team=new Team();
	$response=$team->getTeamScore();
	if($response)
	{
		$status=TRUE;
		$message=$reponse;
	}
	else
	{
		$status=FALSE;
	}
	$deleteOperation= array(
	"status" => $status,
	"message" => $message
	);
	$response = $_POST["jsoncallback"] . "(" . json_encode($deleteOperation) . ")";
	echo $response;
	unset($response);
}
else if($type=='teamPoints')
{
	$team=new Team();
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$team->getTeamPoints($page,$limit,$sidx,$sord);
	echo json_encode($response);
	unset($response);
}
?>