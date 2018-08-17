<?php
/**
 * 
 */
class AjaxController extends Controller
{
	function __construct($controller, $action)
	{
		parent::__construct($controller, $action);
	}

	public function updateAction()
	{
		if (Kendaraan::find($_POST['id'])->update([$_POST['column_name'] => $_POST["value"]])) {
			echo "Success Update Data" ;
		}
		
	}
}