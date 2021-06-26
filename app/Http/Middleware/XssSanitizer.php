<?php

namespace App\Http\Middleware;

use Closure;

class XssSanitizer
{
  public function handle($request, Closure $next)
  {

    $input = $request->all();
    // No need to strip_tags for html contents
    if(!empty($input['content_html'])) unset($input['content_html']);
    if(!empty($input['content'])) unset($input['content']);
    if(!empty($input['top_left_html'])) unset($input['top_left_html']);
    if(!empty($input['login_html'])) unset($input['login_html']);
    if(!empty($input['api_key'])) unset($input['api_key']);
    if(!empty($input['username'])) unset($input['username']);
    if(!empty($input['password'])) unset($input['password']);
    if(!empty($input['access_key'])) unset($input['access_key']);
    if(!empty($input['secret_key'])) unset($input['secret_key']);
    if(!empty($input['domain'])) unset($input['domain']);
    if(!empty($input['account_id'])) unset($input['account_id']);

    array_walk_recursive($input, function(&$input) {
      $input = htmlentities(strip_tags($input), ENT_QUOTES);
    });

    $request->merge($input);

    return $next($request);
  }
}
