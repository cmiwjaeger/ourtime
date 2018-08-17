<?php
/**
 * 
 */
class Controller extends App
{
	protected $_controller, $_action;
	public $view;

	function __construct($controller, $action)
	{
		parent::__construct();
		$this->_controller = $controller;
		$this->_action = $action;
		$this->view = new View();
	}

	protected function addInlineScript($script)
	{
		return $script;
	}

	protected function model($model)
	{
		if (class_exists($model)) {
			require_once ROOT.DS.'app/models'.DS.$model.".php";
			return new $model();
		}
	}

}