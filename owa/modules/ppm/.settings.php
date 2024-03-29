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

require_once(OWA_DIR.'owa_lib.php');
require_once(OWA_DIR.'owa_view.php');
require_once(OWA_DIR.'owa_adminController.php');

/**
 * Settings For PPM module
 * 
 * @author      Emma Furth <emma.furth@puppetlabs.com>
 * @copyright   Copyright &copy; 
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.3.0
 */

class owa_settingsController extends owa_adminController {
	
	function __construct($params) {
	
		parent::__construct($params);
		$this->type = 'options';
		$this->setRequiredCapability('edit_settings');
	}
	
	function action() {
					
		// add data to container
		$this->setView('base.options');
		$this->setSubview('base.settings');
	}
	
}

/**
 * Options View
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_exampleSettingsView extends owa_view {
	
	function __construct($params) {
		//set page type
		$this->_setPageType('Administration Page');		
		return parent::__construct($params);
	}
	
	function render($data) {
		
		// load template
		$this->body->setTemplateFile('hello', 'example_settings.php');
		// assign headline
		$this->body->set('headline', 'Example Settings Page');
	}
	
	
}




?>