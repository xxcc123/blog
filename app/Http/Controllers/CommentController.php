<?php

namespace App\Http\Controllers;

use App\Models\Backend\Comment;
use App\Models\User\User;
use Illuminate\Http\Request;

/**
 * 前台评论-控制器
 * Class CommentController
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('artisan')->get();

    }

    /**
     * 创建评论
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $id = $request->input('id');
        $comment = $request->input('comment');

        $data = [
            'artisan_id' => $id,
            'content' => $comment
        ];
        if (user()) {
            user()->comments()->create($data);
        }
        return redirect()->route('show',base64_encode($id));
    }

}
