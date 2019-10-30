<?php
/**
 * Created by PhpStorm.
 * User: user_1234
 * Date: 2019/7/18
 * Time: 20:38
 */

namespace App;



use Illuminate\Support\Facades\Log;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Teacher extends Authenticatable
{
    use HasApiTokens, /*HasMultiAuthApiTokens,*/ Notifiable;

    protected $fillable = [
        'school_id', 'password',
    ];

    protected $hidden = [
        'password'
    ];

    public function findForPassport($username) {
        Log::debug(__METHOD__.$username);
        return $this->where('school_id', $username)->first();
    }

}