<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoFollowupStatLogBounce extends Model
{
  protected $fillable = ['auto_followup_stat_log_id', 'email', 'status', 'type', 'code', 'detail', 'created_at'];

  public $timestamps = false;
}
