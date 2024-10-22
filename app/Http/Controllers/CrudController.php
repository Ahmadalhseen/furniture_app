<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\product;
use App\Models\categories;
use Illuminate\Http\Request;
use App\Models\favorite;
use App\Models\cart;
use App\Models\payment_card;
use App\Models\delivery_location;
class CrudController extends Controller
{
       public function get_user(){
        return response()->json(User::get(), 200);
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
public function Search(Request $request){
    $product=Product::all();
    foreach ($product as $result) {
       if (strpos($result->p_name, $request->p_name) !== false) {
      return response()->json($product, 200);
    } else {
       return response()->json(["messag"=>"there is no result"], 401);
    }
    }
}
public function filterProducts(Request $request)
{
    // Fetch filters from the request
    $minPrice = $request->min_price ?? 0; // Default to 0 if not provided
    $maxPrice = $request->max_price ?? 1000000; // Set a high value if not provided
    $categoryId = $request->category_id; // Array of category IDs

    // Join products with categories and apply filters
    $query = Product::join('categorie', 'product.cat_id', '=', 'categorie.id')
        ->select('product.*', 'categorie.name as category_name')
        ->whereBetween('product.p_price', [$minPrice, $maxPrice]); // Filter by price range

    // Apply category filter if category IDs are provided
    if ($categoryId) {
        $query->where('product.cat_id', $categoryId); // Filter by a single category ID
        // Filter by category IDs
    }

    // Execute the query and get the filtered products
    $filteredProducts = $query->get();

    return response()->json([
        'status' => 'success',
        'data' => $filteredProducts
    ], 200);
}
public function getUserCartProducts(Request $request)
{
    // Join products, users, and cart
    $cartProducts = Product::join('cart', 'product.id', '=', 'cart.p_id')
        ->join('users', 'cart.user_id', '=', 'users.id')
        ->where('users.id', $request->id)
        ->select('product.id', 'product.p_name', 'product.p_price', 'product.main_image', 'cart.created_at as added_to_cart_at')
        ->get();
    return response()->json([
        'status' => 'success',
        'data' => $cartProducts
    ]);
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
    public function Get_Favorite_Product(Request $request){
    $favoriteProducts = Product::join('favorites', 'product.id', '=', 'favorites.p_id')
            ->join('users', 'favorites.user_id', '=', 'users.id')
            ->where('users.id', $request->id)
            ->select('product.*', 'favorites.created_at as favorited_at') // You can also select specific columns
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $favoriteProducts
        ]);
}
/////////////////////////////////////delivery location crud////////////////////////
public function Add_dellivery_location(Request $data)  {
$location =new delivery_location();
$location->title=$data->title;
$location->content=$data->content;
$location->user_id=$data->user_id;
$location->save();
return response()->json(["message"=>"succefully add"], 200);
}
public function update_delivery_location(Request $data)
{
    // Find the delivery location by id
    $location = delivery_location::where('id', $data->id)->first();

    // Check if location exists
    if (!$location) {
        return response()->json(["message" => "Location not found"], 404);
    }

    // Update fields only if they are provided in the request
    $location->title = $data->title ?? $location->title; // Use the provided title or keep the existing one
    $location->content = $data->content ?? $location->content; // Use the provided content or keep the existing one

    // Save the updated location
    $location->save();

    return response()->json(["message" => "Updated successfully"], 200);
}
public function Get_dellivery_location(Request $data){
    $delivery_location=delivery_location::where("user_id",$data->user_id )->get();
    return response()->json($delivery_location, 200);
}
/////////////////////////////////cart crud/////////////////////////////////
public function addToCart(Request $request)
{
    // Check if the product is already in the user's cart
    $cartItem = cart::where('user_id', $request->user_id)
                    ->where('p_id', $request->p_id)
                    ->first();

    if ($cartItem) {
        // If the product is already in the cart, update the quantity
        $cartItem->quantity += $request->quantity;
        $cartItem->save();
    } else {
        // If the product is not in the cart, create a new cart entry
        $cart=new cart();
        $cart->user_id=$request->user_id;
        $cart->p_id=$request->p_id;
        $cart->quantity=$request->quantity;
        $cart->save();
    }

    return response()->json(['message' => 'Product added to cart successfully'], 200);
}
public function getMostSoldProductsByQuantity()
    {
        // Join products and cart, sum up the quantities and group by product_id
        $mostSoldProducts = Product::join('cart', 'product.id', '=', 'cart.p_id')
            ->select('product.id', 'product.p_name', 'product.p_price', 'product.main_image')
            ->selectRaw('SUM(cart.quantity) as total_sold')
            ->groupBy('product.id', 'product.p_name', 'product.p_price', 'product.main_image')
            ->orderBy('total_sold', 'desc') // Order by the total quantity sold
            ->take(10) // Limit the result to top 10 most sold products
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $mostSoldProducts
        ], 200);
    }
    /////////////////////////payment crud/////////////////////////////////////
public function Add_Payment_Card(Request $data){
      $payment_card=new payment_card();
      $payment_card->holder_name=$data->holder_name;
      $payment_card->card_number=$data->card_number;
      $payment_card->expiry_date=$data->expiry_date;
      $payment_card->user_id=$data->user_id;
      $payment_card->save();
      return response()->json(["message"=>"data saved succefully"], 200);
}
//////////////////////////total price//////////////////////////////////////////
public function calculateTotalPrice(Request $data)
    {
        // Join cart with products to calculate total price
        $cartItems = Cart::join('product', 'cart.p_id', '=', 'product.id')
            ->where('cart.user_id', $data->id)
            ->select('product.p_price', 'cart.quantity', 'cart.id')
            ->get();

        // Initialize the total price
        $totalPrice = 0;

        // Loop through each cart item and calculate the total
        foreach ($cartItems as $item) {
            $totalPrice += $item->p_price * $item->quantity; // Product price * quantity
        }

        // Update the total price in the cart table for the user
        Cart::where('user_id', $data->id)->update(['total_price' => $totalPrice]);

        return response()->json([
            'message' => 'Total price calculated successfully',
            'total_price' => $totalPrice
        ], 200);
    }
    public function Get_Payment_Data(Request $data)  {
    $payment_card=payment_card::where("user_id",$data->user_id)->first();
    return response()->json($payment_card, 200,);
    }
}
