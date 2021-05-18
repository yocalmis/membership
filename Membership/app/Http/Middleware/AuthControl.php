<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Helper\ControlHelper;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AuthControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //  return $next($request);
        $token = ControlHelper::test_input($request->token);
        if ($token == "") {
            $res["status"] = "Empty Token Error";return response()->json($res);
        }
        $is_token = User::where('token', '=', $token)->get();
         $is_token = $is_token->count();
        if ($is_token == 0) {
            $res["status"] = "Invalid Token Error";return response()->json($res);
        }
        return $next($request);

    }

}
