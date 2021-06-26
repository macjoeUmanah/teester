<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\CustomField;

class UniqueCustomField implements Rule
{
  public function passes($attribute, $value)
  {
    $exist = CustomField::whereAppId(\Auth::user()->app_id)->whereName($value)->exists();
    return !$exist ? true : false;
  }
  public function message()
  {
    return __('validation.unique');
  }
}
