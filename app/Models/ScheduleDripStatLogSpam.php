<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDripStatLogSpam extends Model
{
  protected $fillable = ['schedule_drip_stat_log_id', 'email', 'detail', 'created_at'];

  public $timestamps = false;
}
