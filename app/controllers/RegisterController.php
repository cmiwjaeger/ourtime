<?php
/**
 * 
 */
class RegisterController extends Controller
{
	function __construct($controller, $action)
	{
		parent::__construct($controller, $action);
		$this->view->setLayout("default");
	}

	public function loginAction()
	{
		$validation = new Validate();
		if ($_POST) {
			$validation->check($_POST, [
				'username' => [
					'display' => "Username",
					'required' => true
				],
				'password' => [
					'display' => "Password",
					'required' => true
				]
			]);
			if ($validation->passed()) {
				$user = User::where('username', $_POST['username'])->first();
				if ($user && password_verify($_POST['password'], $user->password)) {
					$remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
					$user->login($remember);
					Router::redirect('');
				} else {
					$validation->addError("There is an error with ur username or password");
				}
			}
		}
		$this->view->displayErrors = $validation->displayErrors();
		$this->view->render("register/login");
	}

	public function logoutAction()
	{
		if (currentUser()) {
			currentUser()->logout();
		}
		Router::redirect('register/login');
	}
 
	public function registerAction()
	{
		$validation = new Validate();
		$posted_value = (object)[
			'fname' => '',
			'lname' => '',
			'email' => '',
			'username' => '',
			'password' => '',
			'confirm' => ''
		];
		if ($_POST) {
			$posted_value = posted_values($_POST);
			$validation->check($_POST, [
				'fname' => [
					'display' => 'First Name',
					'required' => true
				],
				'lname' => [
					'display' => 'Last Name',
				],
				'email' => [
					'display' => 'Email',
					'required' => true,
					'unique' => 'users',
					'max' => 150,
					'valid_email' => true
				],
				'username' => [
					'display' => 'Username',
					'required' => true,
					'unique' => 'users',
					'min' => 6,
					'max' => 150
				],
				'password' => [
					'display' => 'password',
					'required' => true,
					'min' => 6
				],
				'confirm' => [
					'display' => 'Password Confirm',
					'required' => true,
					'matches' => 'password'
				]
			]);

			if ($validation->passed()) {
				$newUser = new User();
				// $val = posted_values($_POST);
				$newUser->registerNewUser($posted_value);
				Router::redirect('register/login');
			}
		}
		$this->view->displayErrors = $validation->displayErrors();
		$this->view->render('register/register', ['post'=>$posted_value]);
	}



}
