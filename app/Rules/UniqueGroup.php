<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Group;
use Input;

class UniqueGroup implements Rule
{
  public function passes($attribute, $value) {
    $exist = Group::whereAppId(\Auth::user()->app_id)->whereTypeId(Input::get('type_id'))->whereName($value)->exists();
    return !$exist ? true : false;
  }

  public function message()
  {
    return __('validation.unique');
  }
}
