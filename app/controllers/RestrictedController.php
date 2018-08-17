<?php
/**
 * 
 */
class RestrictedController extends Controller
{
	
	function __construct($controller, $action)
	{
		parent::__construct($controller, $action);
	}

	public function indexAction()
	{
		$this->view->render("restricted/index");
	}

	public function viewNotFound($path)
	{
		$this->view->render("restricted/viewNotFound");
	}
}