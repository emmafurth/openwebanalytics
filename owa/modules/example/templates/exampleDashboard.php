<script>
function reloadNewUser(list){
	var properties = OWA.items['<?php echo $dom_id;?>'].properties;
	var currentUser = list.value;
	if (currentUser != undefined) {
		properties['currentUser'] = currentUser;
	}
	var url = OWA.util.makeUrl(OWA.config.link_template, OWA.config.main_url, properties);
	window.location.href = url;
}
</script>
<!-- If, in the view controller you wrote $this->body->set('currentUser',$currentUser);, you can access that here as a normal PHP variable -->
<?php if (!$currentUser) : ?>
No user selected
<?php else: ?>
User selected: <?php echo $currentUser; ?><br/>
<?php endif; ?>
<br/><br/>
<select name="owa_user" id="owa_user_list" onchange="reloadNewUser(this)">
<option>-Select User-</option>
<?php foreach ($users as $user) : ?>
<option value="<?php echo $user?>" <?php if ($user === $currentUser) echo "selected = 'selected'"; ?>><?php echo $user; ?></option>
<?php endforeach; ?>
</select>
<br/>

<?php 
	// To display the data: you could simply create something from scratch, like below
?>
<?php if ( !$actionsByUser ) : ?>
No data to display
<?php else : ?>
<table>
	<tr>
		<td>Time</td>
		<td>Action Group</td>
		<td>Action Name</td>
		<td>Action Label</td>
	</tr>
	<?php foreach ( $actionsByUser as $action ) : ?>
	<tr>
		<td><?php echo date('Y-n-j G:i:s', $action['timestamp']) ?></td>
		<td><?php echo $action['action_group'] ?></td>
		<td><?php echo $action['action_name'] ?></td>
		<td><?php echo $action['action_label'] ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>
<pre>
<?php 
// One can also use the existing OWA.resultSetExplorer Javascript class.
// Note that this this requires you to make a call to the Data Access API in the template file
?>
</pre>
<div class="owa_reportSectionContent">
	
	<div id="dimension-grid" style="width:;"></div>
	
	<script>
		var dimurl = "<?php echo $this->makeApiLink(array('do' => 'getResultSet', 
																	'metrics' => 'actions', 
																	'dimensions' => 'actionGroup,actionName', 
																	'sort' => 'actions-',
																	'resultsPerPage' => 25,
																	'format' => 'json'
																	),true);?>";
		<?php $dimensionLink = array(
				'linkColumn' => 'actionName', 
				'template' => array(
						'do' => 'base.reportActionDetail', 
						'actionName' => '%s', 
						'actionGroup' => '%s'), 
				'valueColumns' => array('actionName', 'actionGroup')); ?>															  
		var dim = new OWA.resultSetExplorer('dimension-grid');
		
		<?php if (!empty($dimensionLink)):?>
		var link = '<?php echo $this->makeLink($dimensionLink['template'], true);?>';
		var values = <?php if (is_array($dimensionLink['valueColumns'])) { 
						$values = "[";
						$i = 0;
						$count = count($dimensionLink['valueColumns']);
						foreach ($dimensionLink['valueColumns'] as $v) {
							$values .= "'$v'";
							if ($i < $count) {
								$values .= ', ';
							}
							$i++;
						}
						$values .= "]";
						echo $values; 
					} else {
						echo "['".$dimensionLink['valueColumns']."']";
					}
					?>;
		dim.addLinkToColumn('<?php echo $dimensionLink['linkColumn'];?>', link, values);
		<?php endif; ?>
		<?php if (!empty($excludeColumns)):?>
		dim.options.grid.excludeColumns = [<?php echo $excludeColumns;?>];
		<?php endif; ?>
		dim.asyncQueue.push(['refreshGrid']);
		dim.load(dimurl);
		
		console.log( dim );
	</script>

</div>
<?php require_once(OWA_BASE_DIR.'/modules/base/templates/js_report_templates.php');?>

<?php 
// You can also include templates within templates 
include('miniTemplate.php');