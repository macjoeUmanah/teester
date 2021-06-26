<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
  protected $fillable = ['type', 'file', 'attributes', 'total', 'user_id', 'app_id'];
  public $timestamps = false;
}
