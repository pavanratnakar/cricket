<?php
include_once ('../class/records.php');
include_once ('../class/functions.php');
$function=new Functions();
$type=$function->checkValues($_REQUEST['ref']);
if($type=='recordStats')
{
	$records=new Records();
	echo $records->getDetails();
}
else if($type=='tournamentStats')
{
	$records=new Records();
	echo $records->getTournamentDetails();
}
?>