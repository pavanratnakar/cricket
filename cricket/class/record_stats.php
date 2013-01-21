<?php
include_once('db.php');
include_once ('functions.php');
class Records
{
	public function __construct()
	{
		$db=new DB();
	}
	public function getDetails()
	{
		$result1 = mysql_query("SELECT b.firstname,b.lastname,SUM(six_count) AS six_column FROM ".BATTING." a, ".REGISTER." b WHERE a.player_id=b.uid GROUP BY player_id ORDER BY six_column DESC LIMIT 1");
		$row1 = mysql_fetch_array($result1,MYSQL_ASSOC);
		$name1 = $row1['firstname'].' '.$row1['lastname'];
		$result2 = mysql_query("SELECT b.firstname,b.lastname,SUM(four_count) AS four_column FROM ".BATTING." a, ".REGISTER." b WHERE a.player_id=b.uid GROUP BY player_id ORDER BY four_column DESC LIMIT 1");
		$row2 = mysql_fetch_array($result2,MYSQL_ASSOC);
		$name2 = $row2['firstname'].' '.$row2['lastname'];
		$result3 = mysql_query("SELECT b.firstname,b.lastname,SUM(score) AS score_column FROM ".BATTING." a, ".REGISTER." b WHERE a.player_id=b.uid GROUP BY player_id ORDER BY score_column DESC LIMIT 1");
		$row3 = mysql_fetch_array($result3,MYSQL_ASSOC);
		$name3 = $row3['firstname'].' '.$row3['lastname'];
		$result4 = mysql_query("SELECT b.firstname,b.lastname,score AS max_score FROM ".BATTING." a, ".REGISTER." b WHERE a.player_id=b.uid AND score=(SELECT MAX(score) FROM ".BATTING.")");
		$row4 = mysql_fetch_array($result4,MYSQL_ASSOC);
		$name4 = $row4['firstname'].' '.$row4['lastname'];
		$result5 = mysql_query("SELECT b.firstname,b.lastname,SUM(wickets) AS total_wickets FROM ".BATTING." a, ".REGISTER." b WHERE a.player_id=b.uid GROUP BY player_id ORDER BY total_wickets DESC LIMIT 1");
		$row5 = mysql_fetch_array($result5,MYSQL_ASSOC);
		$name5 = $row5['firstname'].' '.$row5['lastname'];
		$result6 = mysql_query("SELECT b.firstname,b.lastname,wickets FROM ".BATTING." a, ".REGISTER." b WHERE a.player_id=b.uid AND wickets=(SELECT MAX(wickets) FROM ".BATTING.")");
		$row6 = mysql_fetch_array($result6,MYSQL_ASSOC);
		$name6 = $row6['firstname'].' '.$row6['lastname'];
		$result7 = mysql_query("SELECT b.firstname,b.lastname,SUM(catches_taken) AS total_catches_taken FROM ".BATTING." a, ".REGISTER." b WHERE a.player_id=b.uid GROUP BY player_id ORDER BY total_catches_taken DESC LIMIT 1");
		$row7 = mysql_fetch_array($result7,MYSQL_ASSOC);
		$name7 = $row7['firstname'].' '.$row7['lastname'];
		$result8 = mysql_query("SELECT b.firstname,b.lastname,catches_taken FROM ".BATTING." a, ".REGISTER." b WHERE a.player_id=b.uid AND catches_taken=(SELECT MAX(catches_taken) FROM ".BATTING.")");
		$row8 = mysql_fetch_array($result8,MYSQL_ASSOC);
		$name8 = $row8['firstname'].' '.$row8['lastname'];
		$result9 = mysql_query("SELECT c.team_name,SUM(score) AS max_team_total FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team ORDER BY max_team_total DESC LIMIT 1");
		$row9 = mysql_fetch_array($result9,MYSQL_ASSOC);
		$name9 = $row9['team_name'];
		$records='
			<h3>Batting Records</h3>
			<ul>		
				<li><b>'.$name1.'</b> currently holds the record of <b>Gillette Most Sixes</b> with <b>'.$row1['six_column'].'</b> sixes hit so far in the tournament.</li>
				<li><b>'.$name2.'</b> currently holds the record of <b>Gain Most Four</b> with <b>'.$row2['four_column'].'</b> foures hit so far in the tournament.</li>	
				<li><b>'.$name3.'</b> currently holds the record of <b>Cheer Most runs in a series</b>. His score so far is   <b>'.$row3['score_column'].'</b>.</li>
				<li><b>'.$name4.'</b> currently holds the record of <b>Fixodent Highest Individual Score</b>. His highest score is <b>'.$row4['max_score'].'</b>.</li>
			</ul>
			<h3>Bownling Records</h3>
			<ul>		
				<li><b>'.$name5.'</b> currently holds the record of <b>Metamucil Most wickets in a tournament</b> with <b>'.$row5['total_wickets'].'</b> wickets taken so far in the tournament.</li>
				<li><b>'.$name6.'</b> currently holds the record of <b>Luv Most wickets in a match</b>. He took <b>'.$row6['wickets'].'</b> wickets in a single match.</li>
			</ul>
			<h3>Fielding Records</h3>
			<ul>		
				<li><b>'.$name7.'</b> currently holds the record of <b>Oral B Most catches in a tournament</b> with <b>'.$row7['total_catches_taken'].'</b> catches taken so far in the tournament.</li>
				<li><b>'.$name8.'</b> currently holds the record of <b>Bounce Most catches in a match</b>. He took <b>'.$row8['catches_taken'].'</b> catches in a single match.</li>
			</ul>
			<h3>Team Records</h3>
			<ul>		
				<li><b>'.$name9.'</b> currently holds the record of <b>Crest Most runs by a team in a series</b> with <b>'.$row9['max_team_total'].'</b> runs scored (extras excluded) totally throughout the tournament so far.</li>
			</ul>'
		;
		/*
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
		*/
		return $records;
	}
}
?>