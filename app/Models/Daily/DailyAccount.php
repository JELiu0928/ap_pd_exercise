<?php
namespace App\Models\Daily;
use Config;
use BaseFunction;
use Session;
use DB;
use Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as Model_Builder;
use App\Models\FrontBase;
use Exception;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DailyAccount extends Authenticatable implements JWTsubject
{

	use Notifiable;
	public function __construct()
	{
        parent::__construct();

		$TableName = "daily_account";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix,'preview') !== false) ? str_replace("preview_","",$dataBasePrefix).$TableName : $dataBasePrefix.$TableName;
		}
		$this->setTable($TableName);
	}
    protected static function boot()
    {
        parent::boot();

        // static::saving(function ($model) {
        //     throw new Exception("Your text message goes here");
        // });
    }
	public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
