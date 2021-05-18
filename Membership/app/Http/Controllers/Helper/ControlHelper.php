<?php

namespace App\Http\Controllers\Helper;
use App\Models\User;

class ControlHelper
{
    //

    public static function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function sess($request,$em,$token)
    {
        $request->session()->put('em', $em);
        $request->session()->put('tk', $token);
    }



}
