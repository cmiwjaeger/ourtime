<?php
/**
 * 
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;

class UserSession extends Eloquent
{
	protected $fillable = [
		'user_id', 
		'session',
		'user_agent'

	];

	public static function getFromCookie()
	{
		if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
			$userSession = Capsule::table('user_sessions')
			->where([
				'user_agent' => Session::uagent_no_version(), 
				'session' => Cookie::get(REMEMBER_ME_COOKIE_NAME)])
			->first();
		} else {
			$userSession = false;
		}
		if (!$userSession) return false;
		return $userSession;
		
	}




	public function user()
	{
		return $this->belongsTo('User');
	}
	
}