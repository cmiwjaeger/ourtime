<?php 
/**
 * 
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;

class User extends Eloquent 
{

	private $_isLoggedIn, $_sessionName, $_cookieName;
	public static $currentLoggedInUser = null;

	public $timestamps = false;

	protected $fillable = ['fname', 'username', 'email', 'lname','password'];


	function __construct($user="")
	{
		$this->_sessionName = CURRENT_USER_SESSION_NAME;
		$this->_cookieName = REMEMBER_ME_COOKIE_NAME;
	}

	public static function loginUserFromCookie()
	{
		$user = '';
		$userSession = UserSession::getFromCookie();
		if ($userSession && $userSession->user_id != '') {
			$user = User::find($userSession->user_id)->first();
		}
		if ($user) {
			$user->login();
		}
		return $user;
	}

	public function login($rememberMe = false)
	{
		Session::set($this->_sessionName, $this->id);
		if ($rememberMe) {
			$hash = md5(uniqid() . rand(0,100));
			$user_agent = Session::uagent_no_version();
			Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
			
			Capsule::table('user_sessions')->where([
				'user_id' => $this->id, 
				'user_agent' => $user_agent
			])->delete();
			$fields = ['session'=>$hash,'user_agent'=>$user_agent,'user_id'=>$this->id];
			UserSession::Create($fields);
		}
		return true;
	}

	public function logout()
	{
		$user_agent = Session::uagent_no_version();
		$userSession = UserSession::getFromCookie();
		if ($userSession) {
			// UserSession::where()
		}
		Capsule::table('user_sessions')->where([
			'user_id' => $this->id, 
			'user_agent' => $user_agent
		])->delete();
		Session::delete(CURRENT_USER_SESSION_NAME);
		if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
			Cookie::delete(REMEMBER_ME_COOKIE_NAME);
		}
		self::$currentLoggedInUser = null;
		return true;
	}

	public static function currentLoggedInUser()
	{
		if (!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
			$u = User::find(Session::get(CURRENT_USER_SESSION_NAME))->first();
			self::$currentLoggedInUser = $u;
		}
		
		return self::$currentLoggedInUser;

	}

	public function registerNewUser($params)
	{
		$this->fname = $params->fname;
		$this->lname = $params->lname;
		$this->email = $params->email;
		$this->username = $params->username; 
		$this->password = password_hash($params->password, PASSWORD_DEFAULT);
		$this->deleted = 0;
		$this->save();

	}

	public function acls()
	{
		if (empty($this->acl)) return [];
		return json_decode($this->acl, true);
	}

	public function userSession()
	{
		return $this->hasMany('UserSession','user_id');
	}



}