<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Request $request,Product $product){

        $comments = $product->comments()->get();
        return response()->json($comments);
    }

    public function store(Request $request,Product $product){
        $request->validate([
            'value'=>['required','string','min:1','max:400']
        ]);
        $comment=$product->comments()->create([
            'value'=>$request->value,
            'user_id'=>Auth::id(),

       ] );
        return response()->json($comment);
    }
}
