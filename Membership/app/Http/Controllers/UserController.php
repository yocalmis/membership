<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helper\ControlHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    //

    public function register(Request $request)
    {

        // Pass control and validations
        if ($request->input('repass') != $request->input('pass')) {
            $res["status"] = "Validate Error";return response()->json($res);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users',
            'pass' => 'required',
            'repass' => 'required',
        ]);

        if ($validator->fails()) {
            $res["status"] = "Validate Error";return response()->json($res);

        }

        // Member Register
        $user = new User;
        $user->name = ControlHelper::test_input($request->input('name'));
        $user->email = ControlHelper::test_input($request->input('email'));
        $user->password = md5(ControlHelper::test_input($request->input('pass')));
        $user->validation = "123456";
        $user->token = "";
        $user->status = 1;
        $user->save();
        $res["status"] = ($user->save() ? "ok" : "error");
        return response()->json($res);
    }

    public function get_token(Request $request)
    {
        // Validations
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $res["status"] = "Validate Error";return response()->json($res);
        }

        // Auth control
        $em = ControlHelper::test_input($request->input('email'));
        $ps = md5(ControlHelper::test_input($request->input('password')));

        if (count(User::where('email', $em)->where('password', $ps)->get()) == 0) {
            $res["status"] = "Validate Error";return response()->json($res);

        }

          // Set token      
        $token = md5($request->input('email') . "_" . date("Y-m-d H:i:s"));
        $user = User::where('email', $em)
            ->update(['token' => $token]);

        $res["token"] = $token;
        $res["email"] = $em;

        return response()->json($res);

    }

}
