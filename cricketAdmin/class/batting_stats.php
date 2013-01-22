<?php
include_once('db.php');
include_once ('functions.php');
class Batting
{
	public function __construct()
	{
		$db=new DB();
	}
	public function getDetails($page,$limit,$sidx,$sord,$wh="")
	{
		$function=new Functions();
		$page=$function->dbCheckValues($page);
		$limit=$function->dbCheckValues($limit);
		$sidx=$function->dbCheckValues($sidx);
		$sord=$function->dbCheckValues($sord);
		$wh=$function->dbCheckValues($wh);
		$result = mysql_query("SELECT COUNT(*) AS count FROM ".BATTING."");
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
        $SQL = "SELECT a.id as batting_id, score, four_count, six_count, extra_runs, out_status, b.firstname,b.lastname,overs_played,d.fixture_datetime as match_number, overs_bowled, wickets,wide_balls, no_balls, catches_taken, runs_conceived, c.team_name FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE b.team=c.team_id AND a.player_id=b.uid AND d.fixture_id=a.match_number ".$wh." ORDER BY $sidx $sord LIMIT $start , $limit";
		$result = mysql_query( $SQL ) or die("Couldn’t execute query.".mysql_error());
		$responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
		$i=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			$responce->rows[$i]['batting_id']=$row['batting_id'];
            $responce->rows[$i]['cell']=array($row['batting_id'],$row['firstname'],$row['lastname'],$row['team_name'],$row['match_number'],$row['four_count'],$row['six_count'],$out_status,$row['overs_played'],$row['score'],$row['overs_bowled'],$row['wickets'],$row['wide_balls'],$row['no_balls'],$row['extra_runs'],$row['runs_conceived'],$row['catches_taken']);
            $i++;
		}
		return $responce;
	}
	public function getBattingDetails($page,$limit,$sidx,$sord,$wh="")
	{
		$function=new Functions();
		$page=$function->dbCheckValues($page);
		$limit=$function->dbCheckValues($limit);
		$sidx=$function->dbCheckValues($sidx);
		$sord=$function->dbCheckValues($sord);
		$wh=$function->dbCheckValues($wh);
		$result = mysql_query("SELECT COUNT(*) AS count FROM ".BATTING."");
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
        $SQL = "SELECT a.id as batting_id, score, four_count, six_count, out_status, b.firstname,b.lastname,overs_played,d.fixture_datetime as match_number, overs_bowled, wide_balls, no_balls, catches_taken, runs_conceived, c.team_name FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE b.team=c.team_id AND a.player_id=b.uid AND d.fixture_id=a.match_number ".$wh." ORDER BY $sidx $sord LIMIT $start , $limit";
		$result = mysql_query( $SQL ) or die("Couldn’t execute query.".mysql_error());
		$responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
		$i=0; $score=0; $batting_average=0; $total=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			$score=$row['score'];
			$total=$total+$score;
			if($row['overs_played']==0)
			$batting_average=0;
			else
			$batting_average=($score*100)/$row['overs_played'];
			$batting_average=number_format($batting_average, 2);
			if($row['out_status']==1)
			$out_status='Out';
			else if($row['out_status']==2)
			$out_status='Not Out';
			else if($row['out_status']==3)
			$out_status='Did not play';
			$responce->rows[$i]['batting_id']=$row['batting_id'];
            $responce->rows[$i]['cell']=array($row['batting_id'],$row['firstname'].' '.$row['lastname'],$row['team_name'],$row['match_number'],$row['four_count'],$row['six_count'],$out_status,$row['overs_played'],$score,$batting_average);
            $i++;
		}
		$responce->userdata['score'] = $total;
		return $responce;
	}
	public function getTeamBattingDetails($page,$limit,$sidx,$sord,$fixture_id,$team_id,$wh="")
	{
		$function=new Functions();
		$page=$function->dbCheckValues($page);
		$limit=$function->dbCheckValues($limit);
		$sidx=$function->dbCheckValues($sidx);
		$sord=$function->dbCheckValues($sord);
		$wh=$function->dbCheckValues($wh);
		$fixture_id=$function->dbCheckValues($fixture_id);
		$team_id=$function->dbCheckValues($team_id);
		$result = mysql_query("SELECT COUNT(*) AS count FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE d.fixture_id=".$fixture_id." AND c.team_id=".$team_id." AND b.team=c.team_id AND d.fixture_id=a.match_number AND a.player_id=b.uid");
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
        $SQL = "SELECT a.id as batting_id, score, four_count, six_count, out_status, b.firstname,b.lastname,overs_played,d.fixture_datetime as match_number, overs_bowled, wide_balls, no_balls, catches_taken, runs_conceived, c.team_name FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE b.team=c.team_id AND c.team_id=".$team_id." AND a.player_id=b.uid AND d.fixture_id=a.match_number AND d.fixture_id=".$fixture_id." ".$wh." ORDER BY $sidx $sord LIMIT $start , $limit";
		//$SQL1 = "SELECT sum(extra_runs) as extra FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE b.team=c.team_id AND c.team_id not in (".$team_id.") AND a.player_id=b.uid AND d.fixture_id=a.match_number AND d.fixture_id=".$fixture_id."";
		$SQL1 = "SELECT sum(wide_balls)+sum(no_balls) as extra FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE b.team=c.team_id AND c.team_id not in (".$team_id.") AND a.player_id=b.uid AND d.fixture_id=a.match_number AND d.fixture_id=".$fixture_id."";
		$result = mysql_query( $SQL ) or die("Couldn’t execute query.".mysql_error());
		$result1 = mysql_query( $SQL1 ) or die("Couldn’t execute query.".mysql_error());
		$responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
		$i=0; $score=0; $batting_average=0; $total=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			$score=$row['score'];
			$total=$total+$score;
			if($row['overs_played']==0)
			$batting_average=0;
			else
			$batting_average=($score*100)/$row['overs_played'];
			$batting_average=number_format($batting_average, 2);
			if($row['out_status']==1)
			$out_status='Out';
			else if($row['out_status']==2)
			$out_status='Not Out';
			else if($row['out_status']==3)
			$out_status='Did not play';
			$responce->rows[$i]['batting_id']=$row['batting_id'];
            $responce->rows[$i]['cell']=array($row['batting_id'],$row['firstname'].' '.$row['lastname'],$row['team_name'],$row['match_number'],$row['four_count'],$row['six_count'],$out_status,$row['overs_played'],$score,$batting_average);
            $i++;
		}
		while($row1 = mysql_fetch_array($result1,MYSQL_ASSOC)) 
		{
			$extra_runs=$row1['extra'];
			if($extra_runs==null)
			{
				$extra_runs=0;
			}
		}
		$responce->userdata['score'] = $total;
		$responce->userdata['out_status'] ='Extra : '.$extra_runs;
		$sum=$total+$extra_runs;
		$responce->userdata['batting_average'] ='Total : '.$sum;
		return $responce;
	}
	public function getBowlingDetails($page,$limit,$sidx,$sord,$fixture_id=null,$team_id=null,$wh="")
	{
		$function=new Functions();
		$page=$function->dbCheckValues($page);
		$limit=$function->dbCheckValues($limit);
		$sidx=$function->dbCheckValues($sidx);
		$sord=$function->dbCheckValues($sord);
		$wh=$function->dbCheckValues($wh);
		$fixture_id=$function->dbCheckValues($fixture_id);
		$team_id=$function->dbCheckValues($team_id);
		if($fixture_id==null && $team_id==null)
		{
			$result = mysql_query("SELECT COUNT(*) AS count FROM ".BATTING."");
		}
		else
		{
			$result = mysql_query("SELECT COUNT(*) AS count FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE d.fixture_id=".$fixture_id." AND c.team_id=".$team_id." AND b.team=c.team_id AND d.fixture_id=a.match_number AND a.player_id=b.uid");
		}
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
		if($fixture_id==null && $team_id==null)
		{
			$SQL = "SELECT a.id as batting_id, b.firstname,b.lastname,wickets,extra_runs,d.fixture_datetime as match_number, overs_bowled, wide_balls, no_balls, runs_conceived, c.team_name FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE b.team=c.team_id AND a.player_id=b.uid AND d.fixture_id=a.match_number ".$wh." ORDER BY $sidx $sord LIMIT $start , $limit";
		}
		else
		{
			$SQL = "SELECT a.id as batting_id, b.firstname,b.lastname,wickets,extra_runs,d.fixture_datetime as match_number, overs_bowled, wide_balls, no_balls, runs_conceived, c.team_name FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE b.team=c.team_id AND c.team_id=".$team_id." AND a.player_id=b.uid AND d.fixture_id=a.match_number AND d.fixture_id=".$fixture_id." ".$wh." ORDER BY $sidx $sord LIMIT $start , $limit";
		}
		$result = mysql_query( $SQL ) or die("Couldn’t execute query.".mysql_error());
		$responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
		$i=0; $bowling_score=0; $bowling_average=0; $bowling_total=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			$bowling_score=$row['runs_conceived']+$row['extra_runs'];
			$bowling_total=$bowling_total+$bowling_score;
			if($row['overs_bowled']==0)
			$bowling_average=0;
			else
			$bowling_average=($bowling_score)/$row['overs_bowled'];
			$bowling_average=number_format($bowling_average, 2);
			$responce->rows[$i]['batting_id']=$row['batting_id'];
            $responce->rows[$i]['cell']=array($row['batting_id'],$row['firstname'].' '.$row['lastname'],$row['team_name'],$row['match_number'],$row['overs_bowled'],$row['wickets'],$row['wide_balls'],$row['no_balls'],$bowling_score,$bowling_average);
            $i++;
		}
		$responce->userdata['runs_conceived'] = $bowling_total;
		return $responce;
	}
	public function getFieldingDetails($page,$limit,$sidx,$sord,$fixture_id=null,$team_id=null,$wh="")
	{
		$function=new Functions();
		$page=$function->dbCheckValues($page);
		$limit=$function->dbCheckValues($limit);
		$sidx=$function->dbCheckValues($sidx);
		$sord=$function->dbCheckValues($sord);
		$wh=$function->dbCheckValues($wh);
		$fixture_id=$function->dbCheckValues($fixture_id);
		$team_id=$function->dbCheckValues($team_id);
		if($fixture_id==null && $team_id==null)
		{
			$result = mysql_query("SELECT COUNT(*) AS count FROM ".BATTING."");
		}
		else
		{
			$result = mysql_query("SELECT COUNT(*) AS count FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE d.fixture_id=".$fixture_id." AND c.team_id=".$team_id." AND b.team=c.team_id AND d.fixture_id=a.match_number AND a.player_id=b.uid");
		}
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
		if($fixture_id==null && $team_id==null)
		{
			$SQL = "SELECT a.id as batting_id, b.firstname,b.lastname,d.fixture_datetime as match_number, catches_taken, c.team_name FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE b.team=c.team_id AND a.player_id=b.uid AND d.fixture_id=a.match_number ".$wh." ORDER BY $sidx $sord LIMIT $start , $limit";
		}
		else
		{
			$SQL = "SELECT a.id as batting_id, b.firstname,b.lastname,d.fixture_datetime as match_number, catches_taken, c.team_name FROM ".BATTING." a,".REGISTER." b,".TEAM_NAME." c,".FIXTURE." d WHERE b.team=c.team_id AND c.team_id=".$team_id." AND a.player_id=b.uid AND d.fixture_id=a.match_number AND d.fixture_id=".$fixture_id." ".$wh." ORDER BY $sidx $sord LIMIT $start , $limit";
		}
		$result = mysql_query( $SQL ) or die("Couldn’t execute query.".mysql_error());
		$responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
		$i=0; $catches_score=0;$catches_total=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			$catches_score=$row['catches_taken'];
			$catches_total=$catches_score+$catches_total;
			$responce->rows[$i]['batting_id']=$row['batting_id'];
            $responce->rows[$i]['cell']=array($row['batting_id'],$row['firstname'].' '.$row['lastname'],$row['team_name'],$row['match_number'],$catches_score);
            $i++;
		}
		$responce->userdata['catches_taken'] = $catches_total;
		return $responce;
	}
	public function addDetails($four_count,$six_count,$score,$out_status,$player_id,$overs_played,$match_number,$overs_bowled,$wickets,$wide_balls,$no_balls,$extra_runs,$runs_conceived,$catches_taken)
	{
		$function=new Functions();
		$four_count=$function->dbCheckValues($four_count);
		$six_count=$function->dbCheckValues($six_count);
		$score=$function->dbCheckValues($score);
		$out_status=$function->dbCheckValues($out_status);
		$player_id=$function->dbCheckValues($player_id);
		$overs_played=$function->dbCheckValues($overs_played);
		$match_number=$function->dbCheckValues($match_number);
		$overs_bowled=$function->dbCheckValues($overs_bowled);
		$wickets=$function->dbCheckValues($wickets);
		$wide_balls=$function->dbCheckValues($wide_balls);
		$no_balls=$function->dbCheckValues($no_balls);
		$extra_runs=$function->dbCheckValues($extra_runs);
		$runs_conceived=$function->dbCheckValues($runs_conceived);
		$catches_taken=$function->dbCheckValues($catches_taken);
		$result=mysql_query("INSERT INTO ".BATTING."(four_count,six_count,score,out_status,player_id,overs_played,match_number,overs_bowled,wickets,wide_balls,no_balls,extra_runs,runs_conceived,catches_taken) VALUES('$four_count','$six_count','$score','$out_status','$player_id','$overs_played','$match_number','$overs_bowled','$wickets','$wide_balls','$no_balls','$extra_runs','$runs_conceived','$catches_taken')");
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function editDetails($batting_id,$four_count,$six_count,$score,$out_status,$player_id,$overs_played,$match_number,$overs_bowled,$wickets,$wide_balls,$no_balls,$extra_runs,$runs_conceived,$catches_taken)
	{
		$function=new Functions();
		$batting_id=$function->dbCheckValues($batting_id);
		$four_count=$function->dbCheckValues($four_count);
		$six_count=$function->dbCheckValues($six_count);
		$score=$function->dbCheckValues($score);
		$out_status=$function->dbCheckValues($out_status);
		$player_id=$function->dbCheckValues($player_id);
		$overs_played=$function->dbCheckValues($overs_played);
		$match_number=$function->dbCheckValues($match_number);
		$overs_bowled=$function->dbCheckValues($overs_bowled);
		$wickets=$function->dbCheckValues($wickets);
		$wide_balls=$function->dbCheckValues($wide_balls);
		$no_balls=$function->dbCheckValues($no_balls);
		$extra_runs=$function->dbCheckValues($extra_runs);
		$runs_conceived=$function->dbCheckValues($runs_conceived);
		$catches_taken=$function->dbCheckValues($catches_taken);
		mysql_query("UPDATE ".BATTING." SET four_count='$four_count',six_count='$six_count',score='$score',out_status='$out_status',player_id='$player_id',overs_played='$overs_played',wickets='$wickets',match_number='$match_number',overs_bowled='$overs_bowled',wide_balls='$wide_balls',no_balls='$no_balls',extra_runs='$extra_runs',runs_conceived='$runs_conceived',catches_taken='$catches_taken' WHERE id='$batting_id'");
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
	public function deleteDetails($batting_id)
	{
		$function=new Functions();
		$batting_id=$function->dbCheckValues($batting_id);
		mysql_query("DELETE FROM ".BATTING." WHERE id='$batting_id'");
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