<?php

// This is an example of how you can use the existing API and Grid Features to display reports
require_once(OWA_BASE_DIR.'/owa_reportController.php');

/**
 * Browser Type Report Controller
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.3.0
 */

class owa_subReportController extends owa_reportController {
	
	function action() {
			
		$actionGroup = $this->getParam('actionGroup');
		
		$this->setSubview('base.reportSimpleDimensional');
		$this->setTitle('Action Group: ', $actionGroup);
		$this->set('metrics', 'actions,uniqueActions,actionsValue');
		$this->set('dimensions', 'actionGroup,actionName');
		$this->set('sort', 'actions-');
		$this->set('resultsPerPage', 25);
		$this->set('dimensionLink', array(
				'linkColumn' => 'actionName', 
				'template' => array(
						'do' => 'base.reportActionDetail', 
						'actionName' => '%s', 
						'actionGroup' => '%s'), 
				'valueColumns' => array('actionName', 'actionGroup')));
				
		$this->set('trendChartMetric', 'actions');
		$this->set('constraints', 'actionGroup=='.urlencode($actionGroup));
		$this->set('trendTitle', 'There were <*= this.d.resultSet.aggregates.actions.formatted_value *> actions for this action group.');
		$this->set('excludeColumns', "'actionGroup'");
		//$this->set('gridTitle', 'Top Page Types');		
	}
}

?>