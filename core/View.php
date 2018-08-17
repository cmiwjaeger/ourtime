<?php
/**
 *
 */
class View extends App
{
	protected $_script, $_head, $_body, $_siteTitle = SITE_TITLE, $_outputBuffer, $_layout = DEFAULT_LAYOUT;

	public function render($viewName, $data=[])
	{
		$viewAry = explode('/', $viewName);
		$viewString = implode(DS, $viewAry);
		if (file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')) {
			include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
			include(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');
		} else {
			Router::redirect('restricted/viewNotFound');
		}
	}


	public function content($type)
	{
		if ($type == 'head') {
			return $this->_head.$this->_script;
		} elseif ($type == 'body') {
			return $this->_body;
		}
		return false;
	}

	public function start($type)
	{
		$this->_outputBuffer = $type;
		ob_start();
		if (!Session::exists(CURRENT_USER_SESSION_NAME)) {
			$this->flash->display();
		}
	}

	public function end()
	{
		if ($this->_outputBuffer == 'head') {
			$this->_head = ob_get_clean();
		} elseif ($this->_outputBuffer == 'body') {
			$this->_body = ob_get_clean();
		} else {
			die('Yout Must run the start method.');
		}
	}

	public function siteTitle()
	{
		return $this->_siteTitle;

	}

	public function setSiteTitle($title)
	{
		$this->_siteTitle = $title;
	}

	public function setLayout($path)
	{
		$this->_layout = $path;
	}

	public function addScript($value='')
	{
		$this->_script = $value;
	}

}
