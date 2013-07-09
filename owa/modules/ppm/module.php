<?php
// Emma Furth


//
// Open Web Analytics - An Open Source Web Analytics Framework
//
// Copyright 2006 Peter Adams. All rights reserved.
//
// Licensed under GPL v2.0 http://www.gnu.org/copyleft/gpl.html
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
// $Id$
//

require_once(OWA_BASE_DIR.'/owa_module.php');

/**
 * PPM Module
 * 
 * @author      Emma Furth	<emma.furth@puppetlabs.com>
 * @copyright   Copyright &copy; 
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_ppmModule extends owa_module {
	
	//var $db;
	
	function __construct() {
		
		$this->name = 'ppm';
		$this->display_name = 'Puppet Patch Manager';
		$this->group = 'ppm';
		$this->author = 'PuppetLabs';
		$this->version = '1.0';
		$this->description = 'Puppet Patch Manager analtyics module';
		$this->config_required = false;
		$this->required_schema_version = 1;
		//$this->$db = owa_coreAPI::dbSingleton();
		
		return parent::__construct();
	}
	
	/**
	 * Registers Admin panels with the core API
	 *
	 */
	/*function registerAdminPanels() {
		
		$this->addAdminPanel(array( 'do' 			=> 'ppm.settings', 
									'priviledge' 	=> 'admin', 
									'anchortext' 	=> 'Hello World!',
									'group'			=> 'Test',
									'order'			=> 1));
		
									
		return;
		
	}*/
	
	public function registerNavigation() {
		$this->addNavigationSubGroup('PPM', 'ppm.reportDashboard', 'PPM Dashboard');
		//$this->addNavigationLinkInSubGroup('PPM','ppm.reportSearchterms','also to the dashboard',1);
		
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