<?php require_once('../min/utils.php');?>
Group By: <select id="battingStatisticsSelect">
	<option value="firstname">By Name</option>
	<option value="team_name">By Team</option>
	<option value="match_number">By Match</option>
	<option value="clear">Remove Grouping</option>	
</select>
<br />
<br/>
<table id="battingStatistics"></table>
<div id="pbattingStatistics"></div>
<script type="text/javascript" src="<?php echo Minify_getUri('batting_stats_js') ?>"></script>