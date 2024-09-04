<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\our_modules\reuse_modules\ReuseModule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // ------------ admin login method -------------
    public function login(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => ''
        ];
        $request_field = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $post_data = [
            'email' => $request->email,
            'password' => $request->password,
            'active' => 1
        ];
        $validator = ReuseModule::reuseValidator($request, $request_field);
        if ($validator->fails()) {
            $res_data['message'] = $validator->errors()->all();
        } else {
            $res_data['status'] = 401;
            try {
                if (Auth::guard('admin_guard')->attempt($post_data)) {
                    $res_data['message']="Login Successfull !";
                    $res_data['status']=200;
                } else {
                    $res_data['message'] = "Credentials not found !";
                }
            } catch (Exception $err) {
                $res_data['message']="Server error please try again !";
            }
        }
        return response()->json(['res_data' => $res_data],200);
    }
    // ------------ admin logout method ---------------
    public function adminLogout(Request $request){
        if(Auth::guard('admin_guard')->user()){
            Auth::guard('admin_guard')->logout();
        }
        return redirect('/admin/login');
    }
}
