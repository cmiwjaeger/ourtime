<?php
/**
 * 
 */
class ToolsController extends Controller
{
	
	function __construct($controller, $action)
	{
		parent::__construct($controller, $action);
		$this->view->setLayout('default'); // in case we want to set particular layout
	}

	public function indexAction() {

		echo "string";
		// $this->view->render('tools/index');
	}

	public function firstAction() {
		$this->view->render('tools/first');
	}

	public function secondAction() {
		$this->view->render('tools/second');
	}

	public function thirdAction() {
		$this->view->render('tools/third');
	}

}
