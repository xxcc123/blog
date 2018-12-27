<?php

namespace App\Http\Controllers;

use App\Traits\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * 联系我们前台-控制器
 * Class ContactController
 * @package App\Http\Controllers
 */
class ContactController extends Controller
{
    use Category;
    /**
     * 联系我们视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $category = $this->all();

        return view('contact',['categorys'=>$category,'session'=>SessionName()]);
    }

    /**
     * 郵件
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function email_send(Request $request)
    {
        Log::info('发件人邮箱：'.$request->input('email'));
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $all = $request->all();

        $info = '发件人邮箱：'.$all['email'].';'.'发件人电话：'.$all['phone_number'].';'.'内容：'.$all['message'];

        Mail::raw($info, function ($message) use ($all) {
            $message->to(env('MAIL_TO_USERNAME'))->subject($all['name']);
        });

        return redirect()->route('contact.me');
    }
}
