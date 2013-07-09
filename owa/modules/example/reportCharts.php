<?php

// The purpose of this report page is:
// 1. To show that you can have more than one
// 2. To show how you can use OWA's JavaScript API to get data from the database, and generate charts.

// On this report, the user selects a dimension and a metric from the two drop down lists.
// When they do, the page refreshes and displays an assortment of charts and graph displaying 
// the relationship between them.

require_once(OWA_BASE_DIR.'/owa_reportController.php');

// This class controls the data that appears on your dashboard
class owa_reportChartsController extends owa_reportController {
	
	function __construct($params) {
	
		return parent::__construct($params);
	}
	
	function action() {

		$this->setSubview('example.reportCharts');
		$this->setTitle('Charts');
		
		
		// Normally, it would probably be simpler to use the owa_coreAPI::getAllDimensions()
		// and owa_coreAPI::getAllMetrics() methods here. However, I wanted to use the existing
		// dimensionPicker class (see modules/base/js/owa.resultSetExplorer.js), to display
		// the dimensions and metrics, since it has more built in functionaly than a bbasic 
		// drop-down list. Unfortunately, dimensionPicker was designed to be used in tables 
		// like the one on exampleDashboard.php, and so is not written to be used in other 
		// contexts. For example, getAllDimensions() does not return arrays in the correct 
		// format for us to pass it to dimensionPicker with an php echo json_encode statement.
		// Hence I wrote custom methods to put the dimensions and metrics in the correct array 
		// format for dimensionPicker. 
		$p = owa_coreAPI::supportClassFactory('example', 'exampleClass');
		$dims = $p->getDimensionsForPicker();
		$mets = $p->getMetricsForPicker();
		
		$this->set('dims', $dims);
		$this->set('mets', $mets);
		
		$this->set('currentDim', $this->getParam('currentDim'));
		$this->set('currentMet', $this->getParam('currentMet'));	
		$this->set('startDate', $this->getParam('startDate'));
		$this->set('endDate', $this->getParam('endDate'));	
		
	}
}
		
require_once(OWA_BASE_DIR.'/owa_view.php');

class owa_reportChartsView extends owa_view {
	function render() {
		
		$this->body->setTemplateFile('example','assortedCharts.php');
		
		$this->body->set('dims', $this->get('dims'));
		$this->body->set('mets', $this->get('mets'));	
		$this->body->set('mets2', $this->get('mets2'));	
		$this->body->set('currentDim', $this->get('currentDim'));
		$this->body->set('currentMet', $this->get('currentMet'));	
		$this->body->set('startDate', $this->get('startDate'));
		$this->body->set('endDate', $this->get('endDate'));	
		
	}
}

?>