<?php require_once('../min/utils.php');?>
Group By: <select id="chngroup">
	<option value="team">By Team</option>
	<option value="choice">By Skill</option>
	<option value="sexselect">By Gender</option>
	<option value="clear">Remove Grouping</option>	
</select>
<br />
<br/>
<table id="team01"></table>
<div id="pteam01"></div>
<script type="text/javascript" src="<?php echo Minify_getUri('team_statistics_js') ?>"></script>