<?php

namespace App\Http\Middleware;

use Closure;

class VerifyApiStatus
{
  public function handle($request, Closure $next)
  {
    $api_token = str_replace('Bearer ', '', $request->header('authorization'));
    $api = \App\Models\User::whereApiToken($api_token)->value('api');
    if($api == 'Disabled') {
      return response()->json(['response' => __('app.api_disabled')], 403);
    }
    return $next($request);
  }
}
