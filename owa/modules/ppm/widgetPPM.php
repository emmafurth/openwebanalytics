<?php

require_once(OWA_BASE_CLASS_DIR.'widget.php');
//require_once(OWA_BASE_DIR.'/owa_news.php');

class owa_widgetPPMController extends owa_widgetController {

	function __construct($params) {
	
		return parent::__construct($params);
	}
	
	function action() {
		$current_user = $this->get('current_user');
		
		$this->set('title', 'Title!');
		$p = owa_coreAPI::supportClassFactory('ppm', 'ppmAPI');
		$user_actions = array();
		if ($current_user)
			$user_actions = $p->getUserActions($current_user);
		
		$this->set('user_actions',$user_actions);

		//$data['params'] = $this->params;
		
		//Fetch latest OWA news
		//$rss = new owa_news;
		//print_r($this->config);
		//$news = $rss->Get($this->config['owa_rss_url']);
		//$this->set('news', $news);
		
		
		$this->setView('ppm.widgetPPM');
	}
	
}
require_once(OWA_BASE_DIR.'/owa_view.php');

class owa_widgetPPMView extends owa_view {

	function render($data) {
		/*echo "<pre>";
		print_r($data);
		echo "</pre>";*/
		$this->setJs('owa.chart', 'base/js/owa.chart.js'); 
		$this->t->set_template('wrapper_blank.tpl');		
		$this->body->setTemplateFile('ppm','ppm_widget.php');
		$this->body->set('user_actions', $data['user_actions']);
		$this->body->set('dom_id', $data['dom_id']);
		
	}

}

?>