<?php require_once('../min/utils.php');?>
Group By: <select id="chnStatistics">
	<option value="choice">By Skill</option>
	<option value="rating">By Rating</option>
	<option value="sexselect">By Gender</option>
	<option value="base_price">By Base Price</option>
	<option value="clear">Remove Grouping</option>	
</select>
<br />
<br/>
<table id="statistics01"></table>
<div id="pstatistics01"></div>
<script type="text/javascript" src="<?php echo Minify_getUri('player_statistics_js') ?>"></script>