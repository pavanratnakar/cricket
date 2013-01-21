<?php
include_once('db.php');
include_once ('functions.php');
class Team
{
	public function __construct()
	{
		$db=new DB();
	}	
	public function getTeams()
	{
		$sql = mysql_query("SELECT * FROM ".TEAM_NAME." order by team_id");
		$i=1;
		while($row=mysql_fetch_assoc($sql))
		{
			$teams .= $row['team_id'].':'.$row['team_name'];
			if(mysql_num_rows($sql)!=$i)
			{
				$teams .=';';
			}
			$i++;
		}
		return $teams;
	}
	public function getTeamsforFixtureId($fixture_id)
	{
		$sql1 = mysql_query("SELECT team_id,team_name FROM ".TEAM_NAME." WHERE team_id IN (SELECT fixture_team1 FROM ".FIXTURE." WHERE fixture_id='$fixture_id')");
		$sql2 = mysql_query("SELECT team_id,team_name FROM ".TEAM_NAME." where team_id IN (SELECT fixture_team2 FROM ".FIXTURE." WHERE fixture_id='$fixture_id')");
		$response_array = array();
		while($row1=mysql_fetch_assoc($sql1))
		{
			$response_array['team_id1']=$row1['team_id'];
			$response_array['team_name1']=$row1['team_name'];
		}
		while($row2=mysql_fetch_assoc($sql2))
		{
			$response_array['team_id2']=$row2['team_id'];
			$response_array['team_name2']=$row2['team_name'];
		}
		$response[] = $response_array;
		return $response;
	}
	public function getTeamsArray()
	{
		$sql = mysql_query("SELECT * FROM ".TEAM_NAME." order by team_id");
		for ($i = 0, $numRows = mysql_num_rows($sql); $i < $numRows; $i++) 
		{
			$row = mysql_fetch_assoc($sql);
			$response_array = array();
			$response_array['team_id'] = $row['team_id'];
			$response_array['team_name'] = $row['team_name'];
			$response[] = $response_array;
		}
		return $response;
	}
	public function getDetails($page,$limit,$sidx,$sord,$type,$wh="")
	{
		$function=new Functions();
		$page=$function->dbCheckValues($page);
		$limit=$function->dbCheckValues($limit);
		$sidx=$function->dbCheckValues($sidx);
		$sord=$function->dbCheckValues($sord);
		$type=$function->dbCheckValues($type);
		$wh=$function->dbCheckValues($wh);
		$result = mysql_query("SELECT COUNT(*) AS count FROM ".TEAM."");
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
        $SQL = "SELECT a.team_id, owner_firstname, owner_lastname, owner_email, owner_mindtree_id, b.team_name, role FROM ".TEAM." a,".TEAM_NAME." b WHERE a.team_name=b.team_id ".$wh." ORDER BY $sidx $sord LIMIT $start , $limit";
		$result = mysql_query( $SQL ) or die("Couldn’t execute query.".mysql_error());
		$responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
		$i=0; $amttot=0; $taxtot=0; $total=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			$responce->rows[$i]['team_id']=$row['team_id'];
            $responce->rows[$i]['cell']=array($row['team_id'],$row['owner_mindtree_id'],$row['owner_email'],$row['owner_firstname'],$row['owner_lastname'],$row['team_name'],$row['role']);
            $i++;
		}
		return $responce;
	}
	public function addDetails($owner_firstname, $owner_lastname, $owner_email, $owner_mindtree_id, $team_name, $role)
	{
		$function=new Functions();
		$owner_firstname=$function->dbCheckValues($owner_firstname);
		$owner_lastname=$function->dbCheckValues($owner_lastname);
		$owner_email=$function->dbCheckValues($owner_email);
		$owner_mindtree_id=$function->dbCheckValues($owner_mindtree_id);
		$team_name=$function->dbCheckValues($team_name);
		$role=$function->dbCheckValues($role);
		$result=mysql_query("INSERT INTO ".TEAM."(owner_firstname, owner_lastname, owner_email, owner_mindtree_id, team_name,role) VALUES('$owner_firstname', '$owner_lastname', '$owner_email', '$owner_mindtree_id', '$team_name', '$role')");
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function editDetails($team_id,$owner_firstname, $owner_lastname, $owner_email, $owner_mindtree_id, $team_name,$role)
	{
		$function=new Functions();
		$team_id=$function->dbCheckValues($team_id);
		$owner_firstname=$function->dbCheckValues($owner_firstname);
		$owner_lastname=$function->dbCheckValues($owner_lastname);
		$owner_email=$function->dbCheckValues($owner_email);
		$owner_mindtree_id=$function->dbCheckValues($owner_mindtree_id);
		$team_name=$function->dbCheckValues($team_name);
		$role=$function->dbCheckValues($role);
		mysql_query("UPDATE ".TEAM." SET owner_firstname='$owner_firstname',owner_lastname='$owner_lastname',owner_email='$owner_email',owner_mindtree_id='$owner_mindtree_id',team_name='$team_name',role='$role' WHERE team_id='$team_id'");
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
	public function deleteDetails($team_id)
	{
		$function=new Functions();
		$team_id=$function->dbCheckValues($team_id);
		mysql_query("DELETE FROM ".TEAM." WHERE team_id='$team_id'");
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
	public function getTeamScore()
	{
		$sql = mysql_query("SELECT SUM(sold_price) as sum,COUNT(*) as count FROM ".REGISTER." GROUP BY team ORDER BY team") or die("Couldn’t execute query.".mysql_error());
		for ($i = 0, $numRows = mysql_num_rows($sql); $i < $numRows; $i++) 
		{
			$row = mysql_fetch_assoc($sql);
			$score_array = array();
			$score_array['sum'] = $row['sum'];
			$score[] = $score_array;
		}
		return $score;
	}
	public function getTeamPoints($page,$limit,$sidx,$sord,$wh="")  
	{
		$function=new Functions();
		$page=$function->dbCheckValues($page);
		$limit=$function->dbCheckValues($limit);
		$sidx=$function->dbCheckValues($sidx);
		$sord=$function->dbCheckValues($sord);
		$wh=$function->dbCheckValues($wh);
		$result = mysql_query("SELECT COUNT(*) AS count FROM ".FIXTURE." a,".TEAM_NAME." b WHERE b.team_id=a.fixture_winner AND b.team_id NOT IN (0) GROUP BY fixture_winner");
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
		$SQL = "SELECT COUNT(*) as point_count,b.team_name as team_name,b.team_id as team_id FROM ".FIXTURE." a,".TEAM_NAME." b WHERE b.team_id=a.fixture_winner AND b.team_id NOT IN (0) GROUP BY fixture_winner ORDER BY point_count desc";
		$result = mysql_query( $SQL ) or die("Couldn’t execute query.".mysql_error());
		$responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
		$i=0; $amttot=0; $taxtot=0; $total=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			$responce->rows[$i]['team_id']=$row['team_id'];
            $responce->rows[$i]['cell']=array($row['team_id'],$row['team_name'],$row['point_count']);
            $i++;
		}
		return $responce;
	}
}
?>