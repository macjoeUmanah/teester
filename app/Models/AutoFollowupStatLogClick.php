<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoFollowupStatLogClick extends Model
{
  protected $fillable = ['auto_followup_stat_log_id', 'link', 'ip', 'country', 'country_code', 'city', 'zipcode', 'user_agent', 'created_at'];

  public $timestamps = false;
}
