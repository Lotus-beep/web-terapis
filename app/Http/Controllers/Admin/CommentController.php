<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Terapis;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['customer', 'terapis', 'booking']);
        if ($request->id_terapis) {
            $query->where('id_terapis', $request->id_terapis);
        }
        $comments = $query->orderBy('created_at', 'desc')->paginate(15);
        $terapis  = Terapis::orderBy('username')->get();
        return view('admin.comments.index', compact('comments', 'terapis'));
    }
}
