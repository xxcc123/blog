<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index()
    {
        $comment = Comment::all();
    }

}
