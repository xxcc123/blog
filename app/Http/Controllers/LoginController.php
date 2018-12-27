<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use App\Traits\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

/**
 * 前台-注册登录控制器
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{
    use Category;

    /**
     * 注册页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register_view()
    {
        $categorys = $this->all();
        $data = [
            'categorys' => $categorys
        ];

        return view('register',$data);
    }

    /**
     * 注册用户
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => 'required | unique',
            'email' => 'required | unique',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        $user = User::where('is_admin',0)->first();

        if (($password == $confirm_password) && empty($user)) {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'is_admin' => false
            ]);
        }

        return redirect()->route('login.view');
    }

    /**
     * 登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login_view()
    {
        $categorys = $this->all();
        $data = [
            'categorys' => $categorys
        ];
        return view('login',$data);
    }

    /**
     * 用户登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);

        $email = $request->input('email');
        $password = bcrypt($request->input('password'));

        $user = User::where('email',$email)->first();

        if ($user){
            session_start();
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            return redirect()->route('home');
        } else {
            return redirect()->route('login.view');
        }
    }

    /**
     * 找回密码页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forget_password()
    {
        $category = $this->all();
        $data = [
            'categorys' => $category
        ];
        return view('forget_password',$data);
    }

    /**
     * 找回密码
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function retrieve_password(Request $request)
    {
        $email = $request->input('email');

        $password = User::where('email',$email)->first();
        $url = route("reset.passwords",base64_encode($email));
        $reset_url = route('reset.passwords.post');

        $arr = [
            'email' => $email,
            'url' => $url,
            'reset_url' => $reset_url
        ];

        if($password) {
            Mail::send('email',$arr, function ($message) use ($email) {
                $message->to($email)->subject('重置密码');
            });

            return redirect()->route('login.view');
        }else{
            return redirect()->route('forget.password');
        }
    }

    /**
     * 用户退出
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginout()
    {
        session_start();
        session_destroy();
        return redirect()->route('home');
    }

    public function weixinlogin()
    {
        return Socialite::driver('weixin')->redirect();
    }

    public function weixinCallback()
    {
        $user_data = Socialite::driver('weixin')->user();
        
        return $user_data;
    }
}
