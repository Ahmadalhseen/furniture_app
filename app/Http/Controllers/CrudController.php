<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\product;
use App\Models\categories;
use Illuminate\Http\Request;
use App\Models\favorite;
class CrudController extends Controller
{
       public function get_user(){
        return User::all();
       }
/////////////////////////////////////////Product_crud///////////////////////////////////
public function Create_Product(Request $request)
{
    // Validate request data
    // $request->validate([
    //     'p_name' => 'required|string|max:255',
    //     'p_price' => 'required|numeric',
    //     'cat_id' => 'required|integer',
    //     'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Add validation for the image
    //     'description' => 'nullable|string',
    //     'color' => 'nullable|string',
    //     'material' => 'nullable|string',
    //     'fabric' => 'nullable|string',
    //     'length' => 'nullable|numeric',
    //     'depth' => 'nullable|numeric',
    //     'height' => 'nullable|numeric',
    //     'seat_height' => 'nullable|numeric',
    //     'arm_height' => 'nullable|numeric',
    //     'seat_depth' => 'nullable|numeric',
    //     'leg_height' => 'nullable|numeric',
    // ]);

    // Handle image upload and storage
    if ($request->hasFile('main_image')) {
        $image = $request->file('main_image');
        $imageName = time() . '.' . $image->getClientOriginalExtension(); // Create a unique filename
        $image->move(public_path('images'), $imageName); // Store the image in the 'public/images' directory
        $imagePath = 'images/' . $imageName; // Save the path to the image
    }

    // Create a new product
    $product = new Product();
    $product->p_name = $request->p_name;
    $product->p_price = $request->p_price;
    $product->cat_id = $request->cat_id;
    $product->description = $request->description;
    $product->color = $request->color;
    $product->material = $request->material;
    $product->fabric = $request->fabric;
    $product->main_image = isset($imagePath) ? $imagePath : null; // Store the image path
    $product->length = $request->length;
    $product->depth = $request->depth;
    $product->height = $request->height;
    $product->seat_height = $request->seat_height;
    $product->arm_height = $request->arm_height;
    $product->seat_depth = $request->seat_depth;
    $product->leg_height = $request->leg_height;
    $product->save();

    return response()->json(["message" => "Product created successfully"], 200);
}
public function Get_Product_Detille(Request $data){
 $product=Product::where("id",$data->id)->first();
 return response()->json(["data"=>$product], 200);
}
public function getDiscountedProducts(Request $request)
    {
        // Join products with discount table
        $products = Product::join('discount', 'product.id', '=', 'discount.p_id')
            ->select('product.id', 'product.p_name', 'product.p_price', 'product.main_image', 'discount.discount_value', 'product.cat_id')
            ->get();
        return response()->json([
            'product' => $products
        ], 200);
    }
public function Get_All_Product()  {
        $product=product::all();
        return response()->json($product, 200);
}
////////////////////////////Categorie crud////////////////////////////////////////////
public function Create_Catigorie(Request $request){
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension(); // Create a unique filename
        $image->move(public_path('images'), $imageName); // Store the image in the 'public/images' directory
        $imagePath = 'images/' . $imageName; // Save the path to the image
    }
    $categories=new categories();
    $categories->name=$request->name;
    $categories->save();
}
public function Get_Categories()  {
    $categories=categories::get();
    $count=categories::count();
    return response()->json(['categories'=>$categories,'count'=>$count], 200);

}
//////////////////////favorite crud////////////////////////////
public function Add_To_Favorite(Request $request){
    $favorite=new favorite();
    $favorite->p_id=$request->p_id;
    $favorite->user_id=$request->user_id;
    $favorite->save();
    return response()->json(["message"=>"favorite created succefully"], 200);

}
public function Delete_From_Favorite(Request $data)  {
    favorite::where("p_id",$data->p_id)->where("user_id",$data->user_id)->delete();
    return response()->json(["message"=>"data deleted succefuly"], 200);
}
}
