<?php
// Emma Furth, June 21, 2013
// This is a template module, created by Emma Furth for PuppetLabs

// Because OpenWebAnalytics' documentation on modules is so very sparse, this module is 
// meant to illustrate how Puppet Patch Manager developers can create customized reports
// using OpenWebAnalytics.

// This must be required. Always.
// OWA_BASE_DIR will equal /your/path/to/owa.
require_once(OWA_BASE_DIR.'/owa_module.php');

/**
 * Example Module
 * 
 * @author      Emma Furth	<emma.furth@puppetlabs.com>
 * @copyright   Copyright &copy; 
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

// You must always include an extension of owa_module. Think of it as "module central control" 
class owa_exampleModule extends owa_module {
	
	//var $db;
	
	function __construct() {
		// Some basic metadata about your module. 
		$this->name = 'example';	
		$this->display_name = 'Example';
		$this->group = 'example';	// You will often refer to other components of your module as example.componentName
		$this->author = 'PuppetLabs';
		$this->version = '1.0';
		$this->description = 'Example module';
		$this->config_required = false;
		$this->required_schema_version = 1;
		//$this->$db = owa_coreAPI::dbSingleton();
		
		return parent::__construct();
	}
	
	// Adds control panel(s) for your module to the Admin section of the website
	
	function registerAdminPanels() {
		// You will need to have a file called "exampleSettings.php" in the example
		// folder for this to register
		$this->addAdminPanel(array( 'do' 			=> 'example.exampleSettings', 
									'priviledge' 	=> 'admin', 
									'anchortext' 	=> 'Hello World!',
									'group'			=> 'example',
									'order'			=> 1));
		
									
		return;
		
	}
	
	// Adds navigation panels (called subgroups) to the navigation bar on the left side of the page
	public function registerNavigation() {
		//$this->addNavigationSubGroup('Subgroup Name', 'moduleName.ReportName', 'Anchor Text', order (int, optional),'privlege (optional)', 'Group Name (optional)');
		// Note that moduleName.reportName should match the report you want the subgroup to link to
		// E.g.: example.reportDashboard links to the report controlled by reportDashboard.php
		$this->addNavigationSubGroup('Example', 'example.reportDashboard', 'Example');
		
		// (same args as addNavigationSubgroup)
		$this->addNavigationLinkInSubGroup('Example','example.subReport','Example Subreport',1);
		$this->addNavigationLinkInSubGroup('Example','example.reportCharts','Assorted Charts',2);
		
	}
	
	/*function registerApiMethods(){
		$this->registerApiMethod('getPPMUserNames',
			array($this, 'getPPMUserNames'),
			
	}*/
	
	/**
	 * Registers Event Handlers with queue queue
	 *
	 */
	function _registerEventHandlers() {
		
		
		// Clicks
		//$this->_addHandler('base.click', 'clickHandlers');
		
		return;
		
	}
	
	function _registerEntities() {
		
		//$this->entities[] = 'myentity';
	}
	
		/**
	 * Registers Package Files To be Built
	 *
	 */
	/*function registerBuildPackages() {
		
		$package = array(
			'name'			=> 'owa.report',
			'output_dir'	=> OWA_MODULES_DIR.'ppm/js/',
			'type'			=> 'js',
			'files'			=> array(
					'owa.report' 	=> array(
											'path'			=> OWA_MODULES_DIR.'ppm/js/owa.report.js',
											'compression'	=> 'minify'
										)
			)
		);
		
		$this->registerBuildPackage( $package );
	}*/
	
}


?>