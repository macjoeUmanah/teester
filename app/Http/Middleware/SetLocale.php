<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use App;
use Auth;

class SetLocale
{
  public function handle($request, Closure $next)
  {
    $language = !empty(Auth::user()->language) ? Auth::user()->language : 'en';
    App::setLocale($language);
    return $next($request);
  }
}
