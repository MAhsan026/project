<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        // $request->validate([
        //     'userid' => 'required|exists:users,id',
        //     'name' => 'required|string|max:255',
        //     'price' => 'required|numeric',
        //     'description' => 'nullable|string',
        //     'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        // ]);

        // $user = Auth::user();
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // dd($user);
        $product = new Product;
        $product->userid = $request->userid;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->stock = $request->stock;

        $file = $request->file('file');
        if ($file) {
            $product->file = $file->getClientOriginalName();
            $file->move(public_path('file'), $product->file);
        } else {
            $product->file = null;
        }

        $product->save();

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function edit($id, Request $request)
    {
        $user = User::findOrFail($id);

        $product = Product::where('userid', $user->id)->firstOrFail();

        // $request->validate([
        //     'userid' => 'required|exists:users,id',
        //     'name' => 'required|string|max:255',
        //     'price' => 'required|numeric',
        //     'description' => 'nullable|string',
        //     'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        // ]);

        $product->userid = $request->userid;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->stock = $request->stock;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $product->file = $file->getClientOriginalName();
            $file->move(public_path('file'), $product->file);
        }
        $product->save();
        return response()->json([
            'message' => 'Product updated successfully',

            'product' => $product,
        ], 200);
    }

    public function getallproduct($id)
    {
        $user = User::findOrFail($id);
        $product = Product::where('userid', $user->id)->orderBy('price', 'desc')->paginate(10);
        return response()->json([
            'product' => $product
        ], 201);
    }
    public function deleteproduct($id)
    {
        $user = User::findOrFail($id);
        $product = Product::where('userid', $user->id);
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
    public function searchproduct($id, Request $request){
        $user = User::findOrFail($id);
        $product = Product::where('userid', $user->id)->where('name', 'like', '%'.$request->search.'%')->where('stock', 'like', '%'.$request->search.'%')->paginate(10);
        return response()->json([
            'product' => $product
        ], 201);
    }
}
