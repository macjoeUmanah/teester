<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppression extends Model
{
  protected $fillable = ['email', 'group_id', 'list_id', 'app_id', 'user_id'];
}
