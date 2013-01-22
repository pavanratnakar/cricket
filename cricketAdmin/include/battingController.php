<?php
include_once ('../class/batting_stats.php');
include_once ('../class/functions.php');
$function=new Functions();
$type=$function->checkValues($_REQUEST['ref']);
$page = $function->checkValues($_REQUEST['page']); // get the requested page
$limit = $function->checkValues($_REQUEST['rows']); // get how many rows we want to have into the grid
$sidx = $function->checkValues($_REQUEST['sidx']); // get index row - i.e. user click to sort
$sord =$function->checkValues( $_REQUEST['sord']); // get the direction
$searchOn = $function->checkValues($_REQUEST['_search']);
if(isset($_REQUEST['_search']) && $searchOn!='false' && $type=='battingStats')
{
	$fld =  $function->checkValues($_REQUEST['searchField']);
	if( $fld=='batting_id' || $fld=='score' || $fld=='four_count' || $fld=='six_count' || $fld=='out_status' || $fld=='player_id' || $fld=='overs_played' || $fld=='wickets' || $fld=='match_number' || $fld=='team_name' || $fld=='overs_bowled' || $fld=='wide_balls' || $fld=='no_balls' || $fld=='extra_runs' || $fld=='runs_conceived' || $fld=='catches_taken') 
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
	$batting=new Batting();
	$response=$batting->getDetails($page,$limit,$sidx,$sord,$wh);
	echo json_encode($response);
	unset($response);
}
else if($type=='battingStats')
{
	$batting=new Batting();
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$batting->getBattingDetails($page,$limit,$sidx,$sord);
	echo json_encode($response);
	unset($response);
}
else if($type=='teamBattingStats')
{
	$batting=new Batting();
	$fixture_id = $function->checkValues($_REQUEST['fixture_id']);
	$team_id = $function->checkValues($_REQUEST['team_id']);
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$batting->getTeamBattingDetails($page,$limit,$sidx,$sord,$fixture_id,$team_id);
	echo json_encode($response);
	unset($response);
}
else if($type=='bowlingStats')
{
	$batting=new Batting();
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$batting->getBowlingDetails($page,$limit,$sidx,$sord);
	echo json_encode($response);
	unset($response);
}
else if($type=='teamBowlingStats')
{
	$batting=new Batting();
	$fixture_id = $function->checkValues($_REQUEST['fixture_id']);
	$team_id = $function->checkValues($_REQUEST['team_id']);
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$batting->getBowlingDetails($page,$limit,$sidx,$sord,$fixture_id,$team_id);
	echo json_encode($response);
	unset($response);
}
else if($type=='fieldingStats')
{
	$batting=new Batting();
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$batting->getFieldingDetails($page,$limit,$sidx,$sord);
	echo json_encode($response);
	unset($response);
}
else if($type=='teamFieldingStats')
{
	$batting=new Batting();
	$fixture_id = $function->checkValues($_REQUEST['fixture_id']);
	$team_id = $function->checkValues($_REQUEST['team_id']);
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$batting->getFieldingDetails($page,$limit,$sidx,$sord,$fixture_id,$team_id);
	echo json_encode($response);
	unset($response);
}
else if($type=='scoreStats')
{
	$batting=new Batting();
	if(!$sidx) 
	{
		$sidx =1;
	}
	$totalrows = isset($_REQUEST['totalrows']) ? $function->checkValues($_REQUEST['totalrows']): false;
	if($totalrows) 
	{	
		$limit = $totalrows;
	}
	$response=$batting->getDetails($page,$limit,$sidx,$sord);
	echo json_encode($response);
	unset($response);
}
else if($type=='scoreOperation')
{
	$oper=$function->checkValues($_REQUEST['oper']);
	if($oper=='add')
	{
		$batting=new Batting();
		$response=$batting->addDetails(
			$function->checkValues($_POST['four_count']),
			$function->checkValues($_POST['six_count']),
			$function->checkValues($_POST['score']),
			$function->checkValues($_POST['out_status']),
			$function->checkValues($_POST['firstname']),
			$function->checkValues($_POST['overs_played']),
			$function->checkValues($_POST['match_number']),
			$function->checkValues($_POST['overs_bowled']),
			$function->checkValues($_POST['wickets']),
			$function->checkValues($_POST['wide_balls']),
			$function->checkValues($_POST['no_balls']),
			$function->checkValues($_POST['extra_runs']),
			$function->checkValues($_POST['runs_conceived']),
			$function->checkValues($_POST['catches_taken'])
		);
		if($response)
		{
			$status=TRUE;
			$message="Batting stats Added";
		}
		else
		{
			$status=FALSE;
			$message="Batting stats could not be added.";
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
		$batting=new Batting();
		$response=$batting->editDetails(
			$function->checkValues($_POST['id']),
			$function->checkValues($_POST['four_count']),
			$function->checkValues($_POST['six_count']),
			$function->checkValues($_POST['score']),
			$function->checkValues($_POST['out_status']),
			$function->checkValues($_POST['firstname']),
			$function->checkValues($_POST['overs_played']),
			$function->checkValues($_POST['match_number']),
			$function->checkValues($_POST['overs_bowled']),
			$function->checkValues($_POST['wickets']),
			$function->checkValues($_POST['wide_balls']),
			$function->checkValues($_POST['no_balls']),
			$function->checkValues($_POST['extra_runs']),
			$function->checkValues($_POST['runs_conceived']),
			$function->checkValues($_POST['catches_taken'])
		);
		if($response)
		{
			$status=TRUE;
			$message="Batting stats Edited";
		}
		else
		{
			$status=FALSE;
			$message="Batting stats could not be Edited";
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
		$batting=new Batting();
		$response=$batting->deleteDetails($function->checkValues($_POST['id']));
		if($response)
		{
			$status=TRUE;
			$message="Batting stats Deleted";
		}
		else
		{
			$status=FALSE;
			$message="Batting stats could not be deleted";
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
?>