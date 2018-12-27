<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use App\Traits\Category;
use Illuminate\Http\Request;

/**
 * 后台-重置密码控制器
 * Class ResetPasswordsController
 * @package App\Http\Controllers
 */
class ResetPasswordsController extends Controller
{
    use Category;
    /**
     * 重置密码链接视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reset_passwords_view($email)
    {
        $category = $this->all();

        $data = [
            'categorys' => $category,
            'email' => $email
        ];

        return view('reset_password',$data);
    }

    /**
     * 重置密码
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset_passwords(Request $request)
    {
        $email = $request->input('email');
        $email = base64_decode($email);
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');
        if ($password == $confirm_password){
            $user = User::where('email',$email)->first();
            $user->password = bcrypt($password);
            $user->save();
        }

        return redirect()->route('login.view');
    }
}
