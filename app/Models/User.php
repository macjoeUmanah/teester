<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
  use Notifiable;
  use SoftDeletes;
  use HasRoles;

  protected $dates = ['deleted_at'];
  protected $fillable = ['name', 'email', 'password', 'api_token', 'api', 'language', 'address', 'country_code', 'phone', 'time_zone', 'role_id', 'package_id', 'parent_id', 'app_id', 'active', 'is_client', 'attributes'];

  protected $hidden = ['password', 'remember_token'];

  public function role()
  {
    return $this->belongsTo('Spatie\Permission\Models\Role');
  }

  public function package()
  {
    return $this->belongsTo('App\Models\Package');
  }

  public static function getUserValue($id, $value)
  {
    return User::whereId($id)->value($value);
  }

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPassword($token));
  }

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('parent_id', \Auth::user()->app_id);
  }
}
