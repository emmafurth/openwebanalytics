<!-- Dimension and Metric Picker code -->
<script>
// When the user selects a new dimension from the picker, this method is called to
// reload the page accordingly.
function reloadNewDim(currentDim){
	var properties = OWA.items['<?php echo $dom_id;?>'].properties;
	if (currentDim != undefined) {
		properties['currentDim'] = currentDim;
	}
	var url = OWA.util.makeUrl(OWA.config.link_template, OWA.config.main_url, properties);
	window.location.href = url;
}
// When the user selects a new metric from the picker, this method is called to
// reload the page accordingly.
function reloadNewMet(currentMet){
	var properties = OWA.items['<?php echo $dom_id;?>'].properties;
	if (currentMet != undefined) {
		properties['currentMet'] = currentMet;
	}
	var url = OWA.util.makeUrl(OWA.config.link_template, OWA.config.main_url, properties);
	window.location.href = url;
}

$(document).ready(function(){
	var dimPicker = new OWA.dimensionPicker('#<?php echo $dom_id;?>_dimPicker');
	var dims = <?php echo json_encode( $dims ); ?>;
	//var dims = { 'Actions':[{'description':'The total number of action events.', 'group':'Actions','label':'Actions','name':'actions'}]};
	dimPicker.setDimensions(dims);
	dimPicker.display('<?php echo $currentDim; ?>');
	// listen for the change to dimension
	jQuery( '#<?php echo $dom_id;?>_dimPicker')
		.bind('dimension_change', function(event, oldname, newname) {
	
		reloadNewDim(newname);
	});
	var metPicker = new OWA.dimensionPicker('#<?php echo $dom_id;?>_metPicker');
	var mets = <?php echo json_encode( $mets ); ?>;

	metPicker.setDimensions(mets);

	metPicker.display('<?php echo $currentMet; ?>');

	// listen for the change to dimension
	jQuery( '#<?php echo $dom_id;?>_metPicker')
		.bind('dimension_change', function(event, oldname, newname) {

		reloadNewMet(newname);
	});
	

});
</script>

<div class="owa_reportSectionContent">
<div class="owa_reportSectionHeader">Select Metric and Dimension:</div>

<table>
<tr>
<td>Dimension:</td>
<td>Metric:</td>
</tr>
<tr>
<td><span id='<?php echo $dom_id;?>_dimPicker'></span></td>
<td><span id='<?php echo $dom_id;?>_metPicker'></span></td>
</tr>
</table>
</div>
<br/><br/>
<!-- Dimension and Metric Picker code -->

<!-- Displaying your data in charts -->
<!-- OWA comes with a few different ways to display your data in chart form. -->
<!-- The OWA.resultSetExplorer object (used in the exampleDashboard to generate a data table) -->
<!-- can be used to make requests from the Data Access API to get data from the database -->
<!-- and display it as either a pie chart or a line graph. One can also use the flot library -->
<!-- (included in OWA) to generate customized graphs, such as bar charts -->


<!-- OWA Pie Chart code -->
<script>
	// to use the OWA Piechart, you have to use this PHP method to generate an API request url, and
	// pass the url to the resultSetExplorer class. resultSetExplorer does not seem to be able to
	// generate pie charts when, for example, you pass data as an array.
	
	// To generate a pie chart without using the Data Access API to get data, it may be easier to
	// simply write a custom pie chart with flot
	var url = '<?php echo $this->makeApiLink(array('do' => 'getResultSet', 
													'metrics' => $currentMet, 
													'dimensions' => $currentDim, 
													'sort' => $currentMet,
													'format' => 'json',
													'constraints' => urlencode($this->substituteValue('siteId==%s,','siteId'))),true);?>';
																	  
	var pie = new OWA.resultSetExplorer('<?php echo $currentDim."-".$currentMet; ?>_pie');
	pie.options.pieChart.metric = '<?php echo $currentMet ?>';
	pie.options.pieChart.dimension = '<?php echo $currentDim ?>';
	pie.setView('pie');
	pie.load(url);
	OWA.items['<?php echo $dom_id;?>'].registerResultSetExplorer( 'pie', pie );
</script>

<div class="owa_reportSectionContent">
<div class="owa_reportSectionHeader">Pie Chart</div>
<div id='<?php echo $currentDim."-".$currentMet; ?>_pie' style="width:250px;margin-top:-10px;"></div>
</div>
<br/><br/>

<!-- end OWA Pie Chart code -->

<!-- OWA Areachart (line graph) code -->
<script>
	// to use the OWA Areachart, you have to use this PHP method to generate an API request url, and
	// pass the url to the resultSetExplorer class. resultSetExplorer does not seem to be able to
	// generate line charts when, for example, you pass data as an array.
	
	// To generate a line chart without using the Data Access API to get data, it may be easier to
	// simply write a custom line chart with flot
	var aurl = '<?php echo $this->makeApiLink(array('do' => 'getResultSet', 
													'metrics' => $currentMet, 
													'dimensions' => 'date', 
													'sort' => $currentMet,
													'format' => 'json',
													'constraints' => urlencode($this->substituteValue('siteId==%s,','siteId'))),true);?>';
	var area = new OWA.resultSetExplorer('action-trend');

	area.asyncQueue.push(['makeAreaChart', [{x: 'date', y: '<?php echo $currentMet ?>'}], 'trend-chart']);
	area.options.metricBoxes.width = '150px';
	area.asyncQueue.push(['makeMetricBoxes' , 'trend-metrics']);
	
	area.load(aurl);
	OWA.items['<?php echo $dom_id;?>'].registerResultSetExplorer('area', area);
</script>
<div class="owa_reportSectionContent">
<div class="owa_reportSectionHeader">Area (line) Chart</div>
<div id='trend-chart' style="width:250px;margin-top:-10px;"></div>
</div>
<!-- end OWA Areachart (line graph) code -->

<!-- Custom flot bar graph code -->
<script>

// Note that the following code still uses the Data Access API. However, custom flot charts 
// would also be useful for displaying custom data gotten straight from an SQL query.
// For more info on using flot, google flot tutorials

// This method is used to generate a simple bar chart using the jQuery flot library
// id = the id of the div element where you want your graph to appear
// xaxis = the name of the dimension to be displayed along the xaxis
// yaxis = the name of the metric to be displayed along the yaxis
// rs = the result set gotten from the Data Access API request
function generateFlotBarChart(id, xaxis, yaxis, rs){

	var rows = rs.resultsRows;
	// Since the resultSet object is complicated, this is useful for understanding this function
	console.log(rs);
	
	var xLabel = rs["labels"][xaxis];
	var yLabel = rs["labels"][yaxis];
	
	// Gets the data and xaxis labels from the rs.resultsRows object into a format that flot can use
	var data = new Array();
	var xTicks = new Array
	for (i=0; i<rows.length; i++){
		
		var freq = parseInt(rows[i][yaxis]["value"]);
		data.push([i,freq]);
		
		var xTick = rows[i][xaxis]["value"]
		xTicks.push([i,xTick]);
	}
	// Generates the chart
	$.plot(
		$("#"+id),
		[
			{
				//label: "Bar Chart",
				data: data,
				bars: {
					show: true,
					barWidth: 0.5,
					align: "center"
				}   
			}
		],
		{
			xaxis: {
		 		ticks: xTicks
	 		}   
		}
	);
	
}

	var url = '<?php echo $this->makeApiLink(array('do' => 'getResultSet', 
													'metrics' => $currentMet, 
													'dimensions' => $currentDim, 
													'sort' => $currentMet,
													'format' => 'json',
													'constraints' => urlencode($this->substituteValue('siteId==%s,','siteId'))),true);?>';
	// This json request gets the result set from the API and passes it to the method
	jQuery.getJSON(url, '', function (data) {
		generateFlotBarChart('bar-chart','<?php echo $currentDim ?>','<?php echo $currentMet ?>',data);
		
	;});

</script>
<div class="owa_reportSectionContent">
<div class="owa_reportSectionHeader">Bar Chart (flot)</div>
<div id="bar-chart" style="width:500px;height:200px"></div>

</div>

<br/>