<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * ورود کاربر و دریافت توکن JWT
     */
    public function login(Request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ]);

        // تلاش برای لاگین و ساخت توکن
        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'success'=>false,
                 'message'=>'نام کاربری یا کلمه عبور صحیح نمی باشد',
                'error' => 'Invalid credentials'
            ], 401);
        }

        // بازگشت پاسخ با توکن
        return response()->json([
            'success'=>true,
            'message'=>'ورود موفقیت آمیز بود',
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60,
            'user'         => Auth::guard('api')->user(),
        ]);
    }

    /**
     * خروج از سیستم (ابطال توکن)
     */
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * دریافت اطلاعات کاربر لاگین‌شده
     */
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }
}
