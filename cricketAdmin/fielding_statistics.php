<?php require_once('../min/utils.php');?>
Group By: <select id="fieldingStatisticsSelect">
	<option value="firstname">By Name</option>
	<option value="team_name">By Team</option>
	<option value="match_number">By Match</option>
	<option value="clear">Remove Grouping</option>	
</select>
<br />
<br/>
<table id="fieldingStatistics"></table>
<div id="pfieldingStatistics"></div>
<script type="text/javascript" src="<?php echo Minify_getUri('fielding_stats_js') ?>"></script>