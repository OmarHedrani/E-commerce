<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class LikeController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if ($product->likes()->where('user_id', Auth::id())->exists()) {
            $product->likes()->where('user_id', Auth::id())->delete();

        } else {
            $product->likes()->create([
                'user_id' => Auth::id()
            ]);
        }
            return Response()->json(null);




}}
