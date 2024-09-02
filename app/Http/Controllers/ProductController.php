<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // index  product function
    public function index(){
        return view('products.index', [
            'products'=> Product::get()
        ]);
    }
 
 public function create(){
      return view('products.create');
 }
// store product function
 public function store(Request $request){
  // validate data
  $request->validate([
      'name' => 'required',
      'description' => 'required',
      'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000'
  ]);

  // upload image
  $imageName = time().'.'.$request->image->extension();
  $request->image->move(public_path('product'), $imageName);

  $product = new Product;
  $product-> image = $imageName;
  $product->name = $request->name;
  $product->description = $request->description;

  $product->save();
  return back()->withSuccess('Product Created... !!!');

 }
// update product function
 public function update(Request $request, $id){
   // validate data
   $request->validate([
       'name' => 'required',
       'description' => 'required',
       'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000'
   ]);

   $product = Product::where('id', $id)->first();

   if(isset($request->image)){
    //   uploading images
   $imageName = time().'.'.$request->image->extension();
   $request->image->move(public_path('product'), $imageName);
   $product-> image = $imageName;
   
   }
   $product->name = $request->name;
   $product->description = $request->description;

   $product->save();
//    succses message
   return back()->withSuccess('Product Updated... !!!');

  }
// edit  product function
 public function edit($id){
   $product = Product::where('id',$id)->first();

   return view('products.edit',['product' => $product]);
  }
// delete  product function
  public function destroy($id){
      $product = Product::where('id', $id)->first();
      $product->delete();
      return back()->withSuccess('Product deleted.. !!!');
  }
}
