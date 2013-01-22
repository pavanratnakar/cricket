<?php 
	require_once('../min/utils.php');
	require_once('class/fixture.php');
	require_once('class/team_owner.php');
	$fixture=new Fixture();
	$team=new Team();
	$fixtures=$fixture->getFixturesArray();
	$teams=$team->getTeamsArray();
?>
	Match : <select id="matchBattingSelect">
<?php
	for($i=0;$i<sizeof($fixtures);$i++)
	{
	?>
		<option value="<?php echo $fixtures[$i]['fixture_id'];?>"><?php echo $fixtures[$i]['fixture_datetime'];?></option>
	<?php
	}
?>
	</select>
	Team : <select id="teamBattingSelect">
<?php
	for($i=0;$i<sizeof($teams);$i++)
	{
	?>
		<option value="<?php echo $teams[$i]['team_id'];?>"><?php echo $teams[$i]['team_name'];?></option>
	<?php
	}
?>
</select>
<button id="teamBattingButton" class="searchButton">Scorecard</button>
<br/>
<br/>
<table id="battingScore"></table>
<div id="pbattingScore"></div>
<script type="text/javascript" src="<?php echo Minify_getUri('batting_score_js') ?>"></script>