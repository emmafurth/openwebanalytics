<script>

//alert($("#owa_test").text());
//jQuery("#owa_user_list").change(reloadNewUser(OWA.items['<?php echo $dom_id;?>'].properties));
/*var rsh = new OWA.resultSetExplorer('site-trend');

rsh.asyncQueue.push(['makeAreaChart', [{x: 'date', y: 'visits'}], 'trend-chart']);
rsh.options.metricBoxes.width = '150px';
rsh.asyncQueue.push(['makeMetricBoxes' , 'trend-metrics']);

rsh.load(aurl);
OWA.items['<?php echo $dom_id;?>'].registerResultSetExplorer('rsh', rsh);*/
</script>

<?php if (!$current_user) : ?>
No user selected
<?php else: ?>
User selected: <?php echo $current_user; ?><br/>
<?php endif; ?>
<br/><br/>
<select name="owa_user" id="owa_user_list" onchange="reloadNewUser(OWA.items['<?php echo $dom_id;?>'].properties)">
<option>-Select User-</option>
<?php foreach ($users as $user) : ?>
<option value="<?php echo $user?>" <?php if ($user === $current_user) echo "selected = 'selected'"; ?>><?php echo $user; ?></option>
<?php endforeach; ?>
</select>
<br/>

<pre>
<?php print_r( $user_actions ); ?>
</pre>
<?php if ( !$user_actions ) : ?>
No data to display
<?php else : ?>
<table>
	<tr>
		<td>Time</td>
		<td>Action Group</td>
		<td>Action Name</td>
		<td>Action Label</td>
	</tr>
	<?php foreach ( $user_actions as $user_action ) : ?>
	<tr>
		<td><?php echo date('Y-n-j G:i:s', $user_action['timestamp']) ?></td>
		<td><?php echo $user_action['action_group'] ?></td>
		<td><?php echo $user_action['action_name'] ?></td>
		<td><?php echo $user_action['action_label'] ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>


<div class="owa_reportSectionContent">
	<div class="section_header">Widget!</div>
	<?php echo $this->getWidget('ppm.widgetPPM',array('current_user' => $current_user),false);?>
</div>