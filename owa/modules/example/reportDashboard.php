<?php

require_once(OWA_BASE_DIR.'/owa_reportController.php');

/**
 * Dashboard Report Controller
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */


// This class controls the data that appears on your dashboard
class owa_reportDashboardController extends owa_reportController {
	
	function __construct($params) {
	
		return parent::__construct($params);
	}
	
	function action() {

		// moduleName.reportName should match the name of the owa_view class extension you want
		// to use. In this case, that's below.
		$this->setSubview('example.reportDashboard');
		$this->setTitle('Dashboard');
		
		// the getParam method is used to get things from the $_GET and $POST objects
		// note that, if you ask for currentUser, it will look for owa_currentUser
		// Existing OWA code mainly uses the $_GET variable more than $_POST
		// by default, you will have the following parameters in any new module you create:
		// siteId, period (e.g.: last_seven_days), startDate, endDate, action (your reportName)
		$currentUser = $this->getParam('currentUser');
		$startDate = $this->getParam('startDate');
		$endDate = $this->getParam('endDate');
		
		// Getting Data
		// There are a couple ways to get data from the database
		
		// First: you can use OWA's Data Access API (controlled by owa_coreAP.php)
		// Documentation: http://wiki.openwebanalytics.com/index.php?title=Data_Access_API
		// List of all metrics and dimensions: http://wiki.openwebanalytics.com/index.php?title=Metrics_%26_Dimensions
		// The following API request gets the list of all actions performed within the specified date range
		$params = array('do'		  => 'getResultSet',
						'period' 	  => $this->get('period'),
						'startDate'	  => $startDate,
						'endDate'	  => $endDate,
						'metrics' 	  => 'actions,uniqueActions',
						'dimensions'  => 'actionGroup',
						'siteId' 	  => $this->getParam('siteId'),
						'resultsPerPage' => 10,
						'sort' => 'actionGroup-'
						);
		$actions = owa_coreAPI::executeApiCommand($params);

		// But the Data Access API is limited. E.g.:  you can't filter actions by user name, since that's not a dimension
		// To do more normal sql queries, you can do the following (for more info, you can see owa_db.php)
		// The follow DB request gets the list of all actions performed by a particular user (if one is selected)
		if ($currentUser){
			$db = owa_coreAPI::dbSingleton();
			$db->selectFrom('owa_action_fact');
			$db->selectColumn('timestamp,action_group,action_name,action_label');
			$db->where('user_name', $user);
			$actionsByUser = $db->getAllRows();
		}
		// If you expect to do a lot of similar sql commands like above, you can put that functionality into a class
		// Should have path example/classes/className.php 
		// Use the supportClassFactory method to include your class
		// This code gets the list of all visitor names that have performed actions on the site(s) you are tracking
		$p = owa_coreAPI::supportClassFactory('example', 'exampleClass');
		$users = $p->getAllUserNames();
		
		// To make the data compiled here accessible to the view controller class (below), use the set method
		// It's good practice to keep the variable names the same when you do this
		$this->set('actions', $actions);
		if ($currentUser)
			$this->set('actionsByUser', $actionsByUser);
		$this->set('users', $users);
		$this->set('currentUser', $currentUser);
		
		$this->set('actionsByUser',$actionsByUser);
		
	}
}
		
require_once(OWA_BASE_DIR.'/owa_view.php');

/**
 * Dashboard Report View
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */
// This controls the appearance of your report, particularly the templates and data it will use
class owa_reportDashboardView extends owa_view {
	function render() {
		
		// Allows you to access Javascript files in example/js from your template file
		$this->setJs('owa.base', 'base/js/includes/jquery/flot_v0.7/flot.min.js'); 
		
		// Sets the template php file you want to control the appearance of your report
		// Template path should be: example/templates/exampleDashboard.php
		$this->body->setTemplateFile('example','exampleDashboard.php');
		
		// $this->get gets the variables set by the report controller class
		// $this->body->set sets the variables you want your template to be able to access
		$this->body->set('users', $this->get('users'));
		$this->body->set('currentUser', $this->get('currentUser'));
		$this->body->set('actions', $this->get('actions'));
		$this->body->set('actionsByUser',$this->get('actionsByUser'));
		
	}
}

?>