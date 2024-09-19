<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\product;
use Illuminate\Http\Request;
class CrudController extends Controller
{
       public function get_user(){
        return User::all();
       }
/////////////////////////////////////////Product_crud///////////////////////////////////
public function Create_Product(Request $request){
        $product=new product();
        $product->p_name=$request->p_name;
        $product->p_price=$request->p_price;
        $product->cat_id=$request->cat_id;
        $product->description=$request->description;
        $product->color=$request->color;
        $product->material=$request->material;
        $product->fabric=$request->fabric;
        $product->main_image=$request->main_image;
        $product->length=$request->length;
        $product->depth=$request->depth;
        $product->height=$request->height;
        $product->seat_height=$request->seat_height;
        $product->arm_height=$request->arm_height;
        $product->seat_depth=$request->seat_depth;
        $product->leg_height=$request->leg_height;
        $product->save();
        return response()->json(["message"=>"data entered succefully"], 200);
}
}
