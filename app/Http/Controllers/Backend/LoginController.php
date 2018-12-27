<?php

namespace App\Http\Controllers\Backend;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * 后台登录、登出-控制器
 * Class LoginController
 * @package App\Http\Controllers\Backend
 */
class LoginController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * 登录界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login_view()
    {
        return view('backend.login');
    }

    /**
     * 注册界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register_view()
    {
        return view('backend.register');
    }

    /**
     * 注册
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user_name = $request->input('name');
        $user_email = $request->input('email');
        $user_password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        if ($user_password != $confirm_password) {
            return redirect()->route('admin.register');
        }

        $data = [
            'name' => $user_name,
            'email' => $user_email,
            'password' => md5($user_password)
        ];

        User::create($data);

        return redirect()->route('admin.login');
    }

    /**
     * 登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'user_email' => 'required',
            'password' => 'required'
        ]);

        $email = $request->input('user_email');
        $password = $request->input('password');

        $user = User::where('email',$email)
            ->where('password',md5($password))
            ->first();

//        dd(auth::guard('user')->user());

        if (!$user) {
            return redirect()->route('admin.login')->withFlashError('Email or Password Error');
        }

        return redirect()->route('admin.index')->withFlashSuccess('login success');

    }
}
