<?php
include_once('db.php');
include_once ('functions.php');
class Records
{
	public function __construct()
	{
		$db=new DB();
	}
	public function getTournamentDetails()
	{
		$result1 = mysql_query("SELECT count(*) as count_players FROM ".REGISTER."");
		$row1 = mysql_fetch_array($result1,MYSQL_ASSOC);
		$result2 = mysql_query("SELECT count(*) as team_count FROM ".TEAM_NAME." where team_id not in (0)");
		$row2 = mysql_fetch_array($result2,MYSQL_ASSOC);
		$result3 = mysql_query("SELECT count(*) as matches_played FROM ".FIXTURE." where fixture_winner not in (0)");
		$row3 = mysql_fetch_array($result3,MYSQL_ASSOC);
		$result4 = mysql_query("SELECT sum(runs_conceived) as runs_scored FROM ".BATTING."");
		$row4 = mysql_fetch_array($result4,MYSQL_ASSOC);
		$result5 = mysql_query("SELECT sum(four_count) as four_count FROM ".BATTING."");
		$row5 = mysql_fetch_array($result5,MYSQL_ASSOC);
		$result6 = mysql_query("SELECT sum(six_count) as six_count FROM ".BATTING."");
		$row6 = mysql_fetch_array($result6,MYSQL_ASSOC);
		$result7 = mysql_query("SELECT sum(overs_bowled) as overs_bowled FROM ".BATTING."");
		$row7 = mysql_fetch_array($result7,MYSQL_ASSOC);
		$result8 = mysql_query("SELECT sum(wickets) as wickets FROM ".BATTING."");
		$row8 = mysql_fetch_array($result8,MYSQL_ASSOC);
		$result9 = mysql_query("SELECT sum(wide_balls+no_balls) as extra FROM ".BATTING."");
		$row9 = mysql_fetch_array($result9,MYSQL_ASSOC);
		$result10 = mysql_query("SELECT sum(catches_taken) as catches FROM ".BATTING."");
		$row10 = mysql_fetch_array($result10,MYSQL_ASSOC);
		$result11 = mysql_query("SELECT sum(score) as score FROM ".BATTING."");
		$row11 = mysql_fetch_array($result11,MYSQL_ASSOC);
		$records='
			<h3>Overall Statistics</h3>
			<ul>		
				<li><b>'.$row1['count_players'].'</b> players had registered for the tournament.</li>
				<li><b>'.$row2['team_count'].'</b> teams were formed.</li>
				<li><b>'.$row3['matches_played'].'</b> matches have been played so far.</li>
				<li><b>'.$row11['score'].'</b> runs (extras excluded) have been scored by the batsmen so far in the tournament.</li>
				<li><b>'.$row5['four_count'].'</b> fours have been hit so far in the tournament.</li>
				<li><b>'.$row6['six_count'].'</b> six have been hit so far in the tournament.</li>
				<li><b>'.$row4['runs_scored'].'</b> runs (extras included) have been given by the bowlers so far in the tournament.</li>
				<li><b>'.$row7['overs_bowled'].'</b> over\'s have been bowled so far in the tournament.</li>
				<li><b>'.$row8['wickets'].'</b> wickets haven been taken by bowlers (run outs excluded) so far in the tournament.</li>
				<li><b>'.$row9['extra'].'</b> extras have been given so far in the tournament.</li>
				<li><b>'.$row10['catches'].'</b> catches have been taken so far in the tournament.</li>
			</ul>'
		;
		return $records;
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
		$result10 = mysql_query("SELECT c.team_name,SUM(score) AS max_team_total FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team,a.match_number ORDER BY max_team_total DESC LIMIT 1");
		$row10 = mysql_fetch_array($result10,MYSQL_ASSOC);
		$name10 = $row10['team_name'];
		$result11 = mysql_query("SELECT c.team_name,SUM(score) AS max_team_total FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team ORDER BY max_team_total ASC LIMIT 1");
		$row11 = mysql_fetch_array($result11,MYSQL_ASSOC);
		$name11 = $row11['team_name'];
		$result12 = mysql_query("SELECT c.team_name,SUM(score) AS max_team_total FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team,a.match_number ORDER BY max_team_total ASC LIMIT 1");
		$row12 = mysql_fetch_array($result12,MYSQL_ASSOC);
		$name12 = $row12['team_name'];
		$result13 = mysql_query("SELECT c.team_name,SUM(wide_balls+no_balls) AS min_extra FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team,a.match_number ORDER BY min_extra ASC LIMIT 1");
		$row13 = mysql_fetch_array($result13,MYSQL_ASSOC);
		$name13 = $row13['team_name'];
		$result14 = mysql_query("SELECT c.team_name,SUM(wide_balls+no_balls) AS min_extra FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team ORDER BY min_extra ASC LIMIT 1");
		$row14 = mysql_fetch_array($result14,MYSQL_ASSOC);
		$name14 = $row14['team_name'];
		$result15 = mysql_query("SELECT c.team_name,SUM(wide_balls+no_balls) AS max_extra FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team,a.match_number ORDER BY max_extra DESC LIMIT 1");
		$row15 = mysql_fetch_array($result15,MYSQL_ASSOC);
		$name15 = $row15['team_name'];
		$result16 = mysql_query("SELECT c.team_name,SUM(wide_balls+no_balls) AS max_extra FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team ORDER BY max_extra DESC LIMIT 1");
		$row16 = mysql_fetch_array($result16,MYSQL_ASSOC);
		$name16 = $row16['team_name'];
		$result17 = mysql_query("SELECT c.team_name,SUM(runs_conceived) AS min_runs FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team,a.match_number ORDER BY min_runs ASC LIMIT 1");
		$row17 = mysql_fetch_array($result17,MYSQL_ASSOC);
		$name17 = $row17['team_name'];
		$result18 = mysql_query("SELECT c.team_name,SUM(wide_balls+runs_conceived) AS min_runs FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team ORDER BY min_runs ASC LIMIT 1");
		$row18 = mysql_fetch_array($result18,MYSQL_ASSOC);
		$name18 = $row18['team_name'];
		$result19 = mysql_query("SELECT c.team_name,SUM(runs_conceived) AS max_runs FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team,a.match_number ORDER BY max_runs DESC LIMIT 1");
		$row19 = mysql_fetch_array($result19,MYSQL_ASSOC);
		$name19 = $row19['team_name'];
		$result20 = mysql_query("SELECT c.team_name,SUM(wide_balls+runs_conceived) AS max_runs FROM ".BATTING." a, ".REGISTER." b,".TEAM_NAME." c WHERE a.player_id=b.uid AND b.team=c.team_id GROUP BY b.team ORDER BY max_runs DESC LIMIT 1");
		$row20 = mysql_fetch_array($result20,MYSQL_ASSOC);
		$name20 = $row20['team_name'];
		$records='
			<h3>Batting Records</h3>
			<ul>		
				<li><b>'.$name1.'</b> currently holds the record of <b>Gillette Most Sixes</b> with <b>'.$row1['six_column'].'</b> sixes hit so far in the tournament.</li>
				<li><b>'.$name2.'</b> currently holds the record of <b>Gain Most Four</b> with <b>'.$row2['four_column'].'</b> fours hit so far in the tournament.</li>	
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
			<h3>Team Highest Records</h3>
			<ul>		
				<li><b>'.$name9.'</b> currently holds the record of <b>Crest Most runs by a team in a series</b> with <b>'.$row9['max_team_total'].'</b> runs scored (extras excluded) totally throughout the tournament so far.</li>
				<li><b>'.$name10.'</b> currently holds the record of <b>Vicks Most runs by a team in a match</b> with <b>'.$row10['max_team_total'].'</b> runs scored (extras excluded) during the match.</li>
				<li><b>'.$name18.'</b> currently holds the record of <b>Downy Least runs given by a team in a series</b> with <b>'.$row18['min_runs'].'</b> runs given (extra included) totally throughout the tournament so far.</li>
				<li><b>'.$name17.'</b> currently holds the record of <b>Prilosec Least runs given by a team in a match</b> with <b>'.$row17['min_runs'].'</b> runs given (extra included) during the match.</li>
				<li><b>'.$name14.'</b> currently holds the record of <b>Cascade Least extra given by a team in a series</b> with <b>'.$row14['min_extra'].'</b> extras totally throughout the tournament so far.</li>
				<li><b>'.$name13.'</b> currently holds the record of <b>Ariel Least extra given by a team in a match</b> with <b>'.$row13['min_extra'].'</b> extras during the match.</li>
			</ul>
			<h3>Team Lowest Records</h3>
			<ul>		
				<li><b>'.$name11.'</b> currently holds the record of <b>Duracell Least runs by a team in a series</b> with <b>'.$row11['max_team_total'].'</b> runs scored (extras excluded) totally throughout the tournament so far.</li>
				<li><b>'.$name12.'</b> currently holds the record of <b>Charmin Least runs by a team in a match</b> with <b>'.$row12['max_team_total'].'</b> runs scored (extras excluded) during the match.</li>
				<li><b>'.$name20.'</b> currently holds the record of <b>Head &amp; Shoulders most runs given by a team in a series</b> with <b>'.$row20['max_runs'].'</b> runs given (extra included) totally throughout the tournament so far.</li>
				<li><b>'.$name19.'</b> currently holds the record of <b>Rejoice most runs given by a team in a match</b> with <b>'.$row19['max_runs'].'</b> runs given (extra included) during the match.</li>
				<li><b>'.$name16.'</b> currently holds the record of <b>Olay Most extra given by a team in a series</b> with <b>'.$row16['max_extra'].'</b> extras totally throughout the tournament so far.</li>
				<li><b>'.$name15.'</b> currently holds the record of <b>Pantene Most extra given by a team in a match</b> with <b>'.$row15['max_extra'].'</b> extras during the match.</li>
			</ul>'
		;
		return $records;
	}
}
?>