<?php
// Added by Emma Furth

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
 * Action by Visitor Report Controller
 * 
 * @author    	Emma Furth <emma.furth@puppetlabs.com 
 * @copyright   Copyright &copy
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.3.0
 */

class owa_reportActionByVisitorController extends owa_reportController {

	function action() {
	
		//$actionName = $this->getParam('actionName');
		//$actionGroup = $this->getParam('actionGroup');
		
		$this->setSubview('base.reportSimpleDimensional');
		$this->setTitle('Action by Visitor');
		//$this->set('metrics', 'actions,actionsValue');
		//$this->set('dimensions', 'actionLabel');
		
		$this->set('metrics','actions,uniqueActions');
		$this->set('dimensions','customVarValue1,actionGroup,actionName,actionLabel');
		$this->set('resultsPerPage', '30');
		$this->set('sort', 'actions-');
		$this->set('trendChartMetric', 'actions');
		//$this->set('haveFreqChart',true);
		//$this->set('freqChartMetric','actions');
		//$this->set('freqChartDimension','actionLabel');
		//$this->set('trendTitle', 'There were <*= this.d.resultSet.aggregates.actions.formatted_value *> actions of this type.');
		//$this->set('constraints', 'actionName=='.urlencode($actionName).',actionGroup=='.urlencode($actionGroup));	
	}
}

?>
