<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Lists;
use Input;

class UniqueList implements Rule
{
  public function passes($attribute, $value)
  {
    $exist = Lists::whereAppId(\Auth::user()->app_id)->whereName($value)->whereGroupId(Input::get('group_id'))->exists();
    return !$exist ? true : false;
  }
  public function message()
  {
    return __('validation.custom.unique_list.name');
  }
}
