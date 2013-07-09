<?php

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

class owa_reportDashboardController extends owa_reportController {
	
	function __construct($params) {
	
		return parent::__construct($params);
	}
	
	function action() {

		// set view stuff
		$this->setSubview('ppm.reportDashboard');
		$this->setTitle('Dashboard');
		
		//$current_user = owa_coreAPI::getRequestParam('user');
		$current_user = $this->getParam('current_user');
		
		$p = owa_coreAPI::supportClassFactory('ppm', 'ppmAPI');
		$users = $p->getAllPPMUserNames();
		$this->set('users', $users);
		$this->set('current_user', $current_user);
		
		$user_actions = array();
		if ($current_user){
			//$user_actions = $p->getUserActions($current_user);
			$params = array('do'		  => 'getResultSet',
						'period' 	  => $this->get('period'),
						'startDate'	  => $this->get('startDate'),
						'endDate'	  => $this->get('endDate'),
						'metrics' 	  => 'actions',
						'dimensions'  => 'actionName,hostName',
						'siteId' 	  => $this->getParam('siteId')
						);
			$user_actions = owa_coreAPI::executeApiCommand($params);
		}
		$this->set('user_actions',$user_actions);
		
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

class owa_reportDashboardView extends owa_view {
	function render() {
		$this->setJs('owa.report.ppm', 'ppm/js/owa.ppm.js'); 
		$this->body->setTemplateFile('ppm','ppm_dashboard.php');
		$this->body->set('test', 'blah');
		$this->body->set('users', $this->get('users'));
		$this->body->set('current_user', $this->get('current_user'));
		$this->body->set('user_actions',$this->get('user_actions'));
	}
}

?>