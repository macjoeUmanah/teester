<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoFollowupStatLogOpen extends Model
{
  protected $fillable = ['auto_followup_stat_log_id', 'ip', 'country', 'country_code', 'city', 'zipcode', 'user_agent', 'created_at'];

  public $timestamps = false;
}
