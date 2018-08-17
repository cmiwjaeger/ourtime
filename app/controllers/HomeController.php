<?php
/**
 * Ourtime Framework 
 * (c) Billy
 * Home Controller
 */
class HomeController extends Controller
{
	function __construct($controller, $action)
	{
		parent::__construct($controller, $action);
		$this->view->setLayout('default');
		
	}

	public function indexAction()
	{
		$this->view->render('tools/index');
		echo "Ini adalah home controller";
	}

	public function tytydAction()
	{
		$this->view->render('coba/sads');
	}

}