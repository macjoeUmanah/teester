<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoFollowupStatLogSpam extends Model
{
  protected $fillable = ['auto_followup_stat_log_id', 'email', 'detail', 'created_at'];

  public $timestamps = false;
}
