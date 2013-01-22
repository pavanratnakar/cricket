<?php
include_once('db.php');
include_once ('functions.php');
class Fixture
{
	public function __construct()
	{
		$db=new DB();
	}
	public function getFixtures()
	{
		//$fixtures=array();
		$sql = mysql_query("SELECT * FROM ".FIXTURE."");
		$i=1;
		while($row=mysql_fetch_assoc($sql))
		{
			$fixtures .= $row['fixture_id'].':'.$row['fixture_datetime'];
			if(mysql_num_rows($sql)!=$i)
			{
				$fixtures .=';';
			}
			$i++;
		}
		return $fixtures;
	}
	public function getFixturesArray()
	{
		$sql = mysql_query("SELECT * FROM ".FIXTURE."");
		for ($i = 0, $numRows = mysql_num_rows($sql); $i < $numRows; $i++) 
		{
			$row = mysql_fetch_assoc($sql);
			$response_array = array();
			$response_array['fixture_id'] = $row['fixture_id'];
			$response_array['fixture_datetime'] = $row['fixture_datetime'];
			$response[] = $response_array;
		}
		return $response;
	}
	public function getDetails($page,$limit,$sidx,$sord,$wh="")
	{
		$function=new Functions();
		$page=$function->dbCheckValues($page);
		$limit=$function->dbCheckValues($limit);
		$sidx=$function->dbCheckValues($sidx);
		$sord=$function->dbCheckValues($sord);
		$wh=$function->dbCheckValues($wh);
		$result = mysql_query("SELECT COUNT(*) AS count FROM ".FIXTURE." ");
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$count = $row['count'];
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
        if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
        $SQL = "SELECT a.fixture_id, a.fixture_datetime, b.team_name as fixture_team1, c.team_name as fixture_team2, d.team_name as fixture_winner, a.fixture_type FROM ".FIXTURE." a,".TEAM_NAME." b,".TEAM_NAME." c,".TEAM_NAME." d WHERE a.fixture_team1=b.team_id AND a.fixture_team2=c.team_id AND a.fixture_winner=d.team_id ".$wh." ORDER BY $sidx $sord LIMIT $start , $limit";
		$result = mysql_query( $SQL ) or die("Couldn’t execute query.".mysql_error());
		$responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
		$i=0; $amttot=0; $taxtot=0; $total=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			if($row['fixture_type']==1)
			{
				$match_type='Round Robin';
			}
			else if($row['fixture_type']==2)
			{
				$match_type='Final';
			}
			if($row['fixture_datetime']=='0000-00-00 00:00:00')
			{
				$fixture_datetime='To be decided';
			}
			else
			{
				$fixture_datetime=$row['fixture_datetime'];
			}
			$responce->rows[$i]['fixture_id']=$row['fixture_id'];
            $responce->rows[$i]['cell']=array($row['fixture_id'],$fixture_datetime,$row['fixture_team1'],$row['fixture_team2'],$row['fixture_winner'],$match_type);
            $i++;
		}
		return $responce;
	}
	public function addDetails($fixture_datetime, $fixture_team1, $fixture_team2, $fixture_winner, $fixture_type)
	{
		$function=new Functions();
		$fixture_datetime = $function->datetime_php2sql($function->dbCheckValues($fixture_datetime));
		$fixture_team1=$function->dbCheckValues($fixture_team1);
		$fixture_team2=$function->dbCheckValues($fixture_team2);
		$fixture_winner=$function->dbCheckValues($fixture_winner);
		$fixture_type=$function->dbCheckValues($fixture_type);
		$SQL="INSERT INTO ".FIXTURE."(fixture_datetime, fixture_team1, fixture_team2, fixture_winner, fixture_type) VALUES('$fixture_datetime', '$fixture_team1', '$fixture_team2', '$fixture_winner', '$fixture_type')";
		$result=mysql_query($SQL);
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function editDetails($fixture_id,$fixture_datetime, $fixture_team1, $fixture_team2, $fixture_winner, $fixture_type)
	{
		$function=new Functions();
		$fixture_id=$function->dbCheckValues($fixture_id);
		$fixture_datetime = $function->datetime_php2sql($function->dbCheckValues($fixture_datetime));
		$fixture_team1=$function->dbCheckValues($fixture_team1);
		$fixture_team2=$function->dbCheckValues($fixture_team2);
		$fixture_winner=$function->dbCheckValues($fixture_winner);
		$fixture_type=$function->dbCheckValues($fixture_type);
		mysql_query("UPDATE ".FIXTURE." SET fixture_datetime='$fixture_datetime',fixture_team1='$fixture_team1',fixture_team2='$fixture_team2',fixture_winner='$fixture_winner',fixture_type='$fixture_type' WHERE fixture_id='$fixture_id'");
		if(mysql_affected_rows()>=1)
		{
			mysql_query("COMMIT");
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function deleteDetails($fixture_id)
	{
		$function=new Functions();
		$fixture_id=$function->dbCheckValues($fixture_id);
		mysql_query("DELETE FROM ".FIXTURE." WHERE fixture_id='$fixture_id'");
		if(mysql_affected_rows()>=1)
		{
			mysql_query("COMMIT");
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
?>