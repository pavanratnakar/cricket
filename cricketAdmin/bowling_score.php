<?php 
	require_once('../min/utils.php');
	require_once('class/fixture.php');
	require_once('class/team_owner.php');
	$fixture=new Fixture();
	$team=new Team();
	$fixtures=$fixture->getFixturesArray();
	$teams=$team->getTeamsArray();
?>
	Match Time : <select id="matchBowlingSelect">
	<option value="0">--Please select the date--</option>
<?php
	for($i=0;$i<sizeof($fixtures);$i++)
	{
	?>
		<option value="<?php echo $fixtures[$i]['fixture_id'];?>"><?php echo $fixtures[$i]['fixture_datetime'];?></option>
	<?php
	}
?>
	</select>
	Team : <select id="teamBowlingSelect">
	<option value="0">--Please select the date--</option>
	</select>
<br/>
<br/>
<table id="bowlingScore"></table>
<div id="pbowlingScore"></div>
<script type="text/javascript" src="<?php echo Minify_getUri('bowling_score_js') ?>"></script>