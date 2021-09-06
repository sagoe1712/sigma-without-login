<?php

namespace App\Http\Controllers;

use App\CartItemAttrib;
use App\Http\Proxy\Catalogue;
use App\Http\Requests\PostCartRequest;
use App\Order;
use App\State;
use App\Traits\EventsTrigger;
use App\Traits\EmailTemplates;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use DB;
use Ixudra\Curl\Facades\Curl;
use App\ShippingAddress;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Repository\TransactionRepository;
use App\Http\Controllers\RecentViewController;

class ShopController extends Controller
{

    use EventsTrigger, EmailTemplates;
    //Zero based Status indicators

    public $gnewsign, $gnewprice;

    private $cartstatus = [
        'cancelled' => 0,
        'pending' => 1,
        'shipped' => 2,
        'delivered' => 3,
        'processing' => 4,
        'expired' => 5,
        'deleted' => 6
    ];

    //Zero based Status indicators
    private $transtype = [
        'debit' => 0,
        'credit' => 1
    ];
    private $is_internal_action = [
        'external' => 0,
        'internal' => 1
    ];

    private $catalogueProxy;
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository,  Catalogue $CatalogueProxy)
    {
//        $this->middleware(['web', 'auth']);
        $this->transactionRepository =  $transactionRepository;
        $this->catalogueProxy = $CatalogueProxy;
    }


    public function test(){
        $product_details = [
            (object)[
            'delivery_type' => 2,
            'delivery_type_name' => 'Delivery',
            'pickup_location_name' => "Lekki waterfront, 1 Wole Olateju Street, off Admiralty Way Opposite ‘S’ Car Wash, Lekki Phase I, Lekki",
            'price' => "31,725 Sigma Stars",
            'voucher' => "SP293202KLN",
            'quantity' => 12,
            'name' => "M&M Peanut Pouch 200g (Color: Blue)"
        ],
            (object)[
                'delivery_type' => 1,
                'delivery_type_name' => 'Pickup',
                'pickup_location_name' => "Lekki waterfront, 1 Wole Olateju Street, off Admiralty Way Opposite ‘S’ Car Wash, Lekki Phase I, Lekki",
                'price' => "31,725 Sigma Stars",
                'voucher' => "SP293202KLN",
                'quantity' => 12,
                'name' => "M&M Peanut Pouch 200g (Color: Blue)"
            ],
            ];

$add = "Lekki waterfront, 1 Wole Olateju Street, off Admiralty Way Opposite";
$receipt = $this->deliveryPickupReceipt($product_details, $add, 23456, 4000, 1000, 4000);
echo($receipt);
die();

    }


    public function index(){
        $title = "Catalogue";
//        try{

            $categories = $this->catalogueProxy->getCategories();

//            dd($categories);
            $trending = $this->catalogueProxy->getTrending();
            $bestselling = $this->catalogueProxy->getBestSelling();

              return view('pages.catalogue.index', compact( 'categories', 'title', 'trending', 'bestselling'));
//
//      }catch (\Exception $e){
//            return response()->redirectToRoute('no_content');
//        }
    }

    public function search(Request $request){

//        try{

            $response = $this->catalogueProxy->search($request->product);

            if(!isset($response) && !$response){
                return response()->redirectToRoute('no_content');
            }else if($response->status === 0){
                $categories = $this->catalogueProxy->getCategories();
                if(!isset($categories) && !$categories){
                    return response()->redirectToRoute('no_result');
                }else if($categories->status === 0){
                    return response()->redirectToRoute('no_result');
                }
                return view('errors.no_search_result_with_categories', compact('categories'));
            }

            $categories = $this->catalogueProxy->getCategories();
            if(!isset($categories) && !$categories){
                return response()->redirectToRoute('no_result');
            }else if($categories->status === 0){
                return response()->redirectToRoute('no_result');
            }

            $products = [];
            $products_categories = [];

            foreach ($response->data as $item){
                $products_categories[] = (object)[
                    'category_name' => $item->category_name,
                    'category_id' => $item->category_id
                ];
                foreach ($item->data as $product){
                    $new_item = $product;
                    $new_item->category_name = $item->category_name;
                    $new_item->category_id = $item->category_id;
                    array_push($products, $new_item);
                }
            }

            $total = count($response->data);
            $title = $request->product;
            $search = $request->product;
            return view('pages.catalogue.search', compact( 'products','search', 'products_categories', 'categories', 'total', 'title'));
//        }catch (\Exception $e){
//            return response()->redirectToRoute('no_content');
//        }
    }

    public function getCategoryItems($id){
        $productid = last(explode('-',$id));
        $array = explode('-',$id);
        array_pop($array);
//        try{
            $categories = $this->catalogueProxy->getCategories();

            if(!isset($categories) && !$categories){
                return response()->redirectToRoute('no_content');
            }else if($categories->status === 0){
                return response()->redirectToRoute('no_content_with_categories');
            }
            $payload =  [
                'category_id' => $productid,
                'limit' => 12,
                'page' => 1
            ];

            $products = $this->catalogueProxy->getCategoryContent($payload);
//dd($products);
            if(!isset($products) && !$products){
                return view('errors.no_content_with_categories', compact('categories'));
            }else if($products->status === 0){
                return view('errors.no_content_with_categories', compact('categories'));
            }
            $total = $products->total;
            $title = implode('-',$array);
            return view('pages.catalogue.category', compact( 'products', 'categories', 'total', 'productid', 'title'));
//        }catch (\Exception $e){
//            return response()->redirectToRoute('no_content');
//        }
    }

    public function loadMoreItems(Request $request){
//        try{
            $payload =  [
                'category_id' => $request->productid,
                'limit' => 12,
                'page' => $request->nextPage,
                'delivery_type' => $request->filterval,
                'sort' => $request->sortval
            ];
            $products = $this->catalogueProxy->getCategoryContent($payload);
            if(!isset($products) && !$products){
                return response()->json(['data' => 'Failed to load more products.'], 400);
            }else if($products->status === 0){
                return response()->json(['data' => 'That\'s all for now'], 400);
            }
            return response()->json(['data' =>$products], 200);
//        }catch (\Exception $e){
//            return response()->json(['data' => 'Failed to load more products.'], 400);
//        }
    }

    public function sortItems(Request $request){
//        try{
            $payload =  [
                'category_id' => $request->productid,
                'limit' => 12,
                'page' => 1,
                'sort' => $request->sort
            ];
            $products = $this->catalogueProxy->getCategoryContent($payload);

            if(!isset($products) && !$products){
                return response()->json(['data' => 'Failed to sort products.'], 400);
            }else if($products->status === 0){
                return response()->json(['data' => 'Failed to sort products.'], 400);
            }
            return response()->json(['data' =>$products], 200);
//        }catch (\Exception $e){
//            return response()->json(['data' => 'Failed to sort products.'], 400);
//        }
    }


    public function sort_filterItems(Request $request){
//        try{
            $payload =  [
                'category_id' => $request->productid,
                'limit' => 12,
                'page' => 1,
                'sort' => $request->sort,
                'delivery_type' => $request->filterval
            ];
            $products = $this->catalogueProxy->getCategoryContent($payload);

            if(!isset($products) && !$products){
                return response()->json(['data' => 'Failed to sort products.'], 400);
            }else if($products->status === 0){
                return response()->json(['data' => 'Failed to sort products.'], 400);
            }
            return response()->json(['data' =>$products], 200);
//        }catch (\Exception $e){
//            return response()->json(['data' => 'Failed to sort products.'], 400);
//        }
    }

    public function sortSearchItems(Request $request){
//        try{
            $payload =  [
                'search' => $request->search,
                'limit' => 12,
                'page' => 1,
                'sort' => $request->sort,
                'delivery_type' => $request->filterval
            ];
            $response = $this->catalogueProxy->sortCatalogueSearch($payload);

            if(!isset($response) && !$response){
                return response()->json(['data' => 'Failed to sort products.'], 400);
            }else if($response->status == 0){
                return response()->json(['data' => 'Failed to sort products.'], 400);
            }

            $products = [];

            foreach ($response->data as $item){
                foreach ($item->data as $product){
                    $new_item = $product;
                    $new_item->category_name = $item->category_name;
                    $new_item->category_id = $item->category_id;
                    array_push($products, $new_item);
                }
            }

            return response()->json(['data' => $products], 200);
//        }catch (\Exception $e){
//            return response()->json(['data' => 'Failed to sort products', 'reason' => $e->getMessage()], 400);
//        }

    }

    public function filterItems(Request $request){
        $fail_message = "";
        switch ($request->filterval) {
            case 1:
                $fail_message = "No Pick-up items for this product range";
        break;
            case 2:
                $fail_message = "No Delivery items for this product range";

                break;
            case 2:
                $fail_message = "No Pick-up + Delivery items for this product range";

                default:
                $fail_message = "No products for the filtered range";
        }
//        try{
            $payload =  [
                'category_id' => $request->productid,
                'limit' => 12,
                'page' => 1,
                'delivery_type' => $request->filterval
            ];
            $products = $this->catalogueProxy->getCategoryContent($payload);
            if(!isset($products) && !$products){
                return response()->json(['data' => 'Failed to filter products.'], 400);
            }else if($products->status === 0){
                return response()->json(['data' => $fail_message ], 400);
            }
            return response()->json(['data' => $products], 200);
//        }catch (\Exception $e){
//            return response()->json(['data' => 'Failed to filter products.'], 400);
//        }
    }

    public function filterSearchItems(Request $request){
        $fail_message = "";
        switch ($request->filterval) {
            case 1:
                $fail_message = "No Pick-up items for this product range";
        break;
            case 2:
                $fail_message = "No Delivery items for this product range";

                break;
            case 2:
                $fail_message = "No Pick-up + Delivery items for this product range";

                default:
                $fail_message = "No products for the filtered range";
        }
//        try{
            $payload =  [
                'search' => $request->search,
                'limit' => 12,
                'page' => 1,
                'delivery_type' => $request->filterval
            ];
            $response = $this->catalogueProxy->sortCatalogueSearch($payload);

            if(!isset($response) && !$response){
                return response()->json(['data' => 'Failed to filter products.'], 400);
            }else if($response->status === 0){
                return response()->json(['data' => $fail_message ], 400);
            }

            $products = [];

            foreach ($response->data as $item){
                foreach ($item->data as $product){
                    $new_item = $product;
                    $new_item->category_name = $item->category_name;
                    $new_item->category_id = $item->category_id;
                    array_push($products, $new_item);
                }
            }
            return response()->json(['data' => $products], 200);
//        }catch (\Exception $e){
//            return response()->json(['data' => 'Failed to filter products.'], 400);
//        }
    }

    public function getnewprice($productcode){
//        try{

            $product = $this->catalogueProxy->getProductDetails(preg_replace('/\s+/', '', $productcode));

                    $this->gnewprice = $product->data->price;
                    $this->gnewsign = $product->data->signature;

//
//
//        }catch (\Exception $e){
//            return response()->JSON(['message'=>'Something went wrong'], 400);
//        }
    }

//    public function getnewsignature($productcode){
//        try{
//
//            $product = $this->catalogueProxy->getProductDetails(preg_replace('/\s+/', '', $productcode));
//
//            return $product->data->signature;
//        }catch (\Exception $e){
//            return response()->JSON(['message'=>'Something went wrong'], 400);
//        }
//    }


    public function getSingleItem(RecentViewController $recent, $productcode){

//        try{

        if(Auth::guest()){
            redirect()->guest('login');
        }

            $categories = $this->catalogueProxy->getCategories();

            if(!isset($categories) && !$categories){
                return response()->redirectToRoute('no_content');
            }else if($categories->status === 0){
                return response()->redirectToRoute('no_content');
            }

            $product = $this->catalogueProxy->getProductDetails(preg_replace('/\s+/', '', $productcode));

//            dd($product);
            if($product) {
                if($product->status == 0){
//                    return redirect()->to('error');
                    return response()->redirectToRoute('no_content');
                }

                $title = $product->data->product_name;
                //echo $product->data->price;
//                dd($product->data);

                $product_name = $product->data->product_name;
                $image = $product->data->image[0]->image_url;

                if(!Auth::guest()) {
                    $recent->create_recent($product_name, $image, $productcode);
                    $recent_view = $recent->list_recent_request();
                }else{
                    $recent_view = [];
                }

                return view('pages.catalogue.product', compact('product', 'categories', 'title', 'recent_view'));
            }else{
//                return redirect()->to('error');
                return response()->redirectToRoute('no_content');
            }
//        }catch (\Exception $e){
//            return response()->redirectToRoute('no_content');
//        }
    }

    private function addRecentlyViewedProduct($product){

        $rvp = new \App\RecentlyViewedProduct();
        $product_query = $rvp->where('signature', $product->signature)
            ->where('user_id', Auth::user()->id)
            ->where('company_id', Auth::user()->company_id);

        if($product_query->count() < 1){
            //Save a new product when there are no records for the user
            $rvp->signature = $product->signature;
            $rvp->name = $product->product_name;
            $rvp->image = $product->image[0]->image_url;
            $rvp->user_id = Auth::user()->id;
            $rvp->company_id = Auth::user()->company_id;
            $rvp->view_order = 1;
            $rvp->save();
            return true;
        }
        else if(!$product_query->exists()){
            //Save new product that doesn't exist for the user with the last viewed product order
            $current_product = $product_query->orderBy('updated_at', 'ASC')->get()->take(1);
            $rvp->signature = $product->signature;
            $rvp->name = $product->product_name;
            $rvp->image = $product->image[0]->image_url;
            $rvp->user_id = Auth::user()->id;
            $rvp->company_id = Auth::user()->company_id;
            $rvp->view_order = $current_product->view_order + 1;
            $rvp->save();
            return true;
        }
        else if($product_query->exists()){
            //Update existting product's view order
            $get_rvp = $product_query->first();
            $get_rvp->signature = $product->signature;
            $get_rvp->name = $product->product_name;
            $get_rvp->image = $product->image[0]->image_url;
            $get_rvp->view_order = 1;
            $get_rvp->save();
        }
    }

    public function postToCart(Request $request){
//        var_dump($request['formdata']);
//        dd($request['formdata']['pickup_attribute']);

        //run for only Ajax requests

        if(Auth::guest()){
            return response()->json(['data' => [], 'message'=>"not logged in", 'status' => '401'], 200);
//
        }

        if($request->ajax()){
            if($request['formdata']['orderqty'] == '0'){
                return response()->json(['data' => 'Quantity has to be 1 or more.', 'status' => '400'], 200);
            }else if(!isset($request['formdata']['delivery_method'])){
                return response()->json(['data' => 'Please select a Delivery method.', 'status' => '400'], 200);
            }else if($request['formdata']['delivery_method'] == 1 && !isset($request['formdata']['pickup_location']) ){
                return response()->json(['data' => 'Please select a Pick up location.', 'status' => '400'], 200);
            }
            else if($request['formdata']['signature'] == '' || $request['formdata']['price'] == ''){
                return response()->json(['data' => 'Error. Invalid item.', 'status' => '400'], 200);
            }else{
                $pickuploc = null;
                $pickuplocname = null;



                if(isset($request['formdata']['pickup_location'])){
                    $pickuploc = $request['formdata']['pickup_location'];
                    $pickuplocname = $request['formdata']['pickup_location_name'];
                }



                $combo = [];

//                if(isset($request['formdata']['combo'])){
//                    $combo = $request['formdata']['combo'];
//                }

//dd($request['formdata']['pickup_attribute']);
                $attribute ="";
                $type="";
                $value = "";
                $attr_together = "";
                if(isset($request['formdata']['pickup_attribute'])) {
                    $attribute = "";
                    $type = "";
                    $value = "";
                    $attr_together = "";

                    $obj = json_decode(json_encode($request['formdata']['pickup_attribute']), FALSE);
                    foreach ($obj as $data) {
                        $tempcombo = [];
                        $attribute .= $data->product_attribute . " ";
                        $type = $data->product_attribute_type;
                        $value .= $data->variant_name . " ";
                        $attr_together .= $data->product_attribute.": ".$data->variant_name.", ";
                        if(isset($data->variant_id)) {
                            $tempcombo = ["id" => $data->product_attribute_value, "variant_id" => $data->variant_id];
                        }else{
                            $tempcombo = null;
                        }
//                        $combo.push($tempcombo);
                        array_push($combo, $tempcombo);
                    }
                }
//dd($combo);
                $item_in_cart = Cart::where(
                    [

                        ['signature', $request['formdata']['signature']],
                        ['status', $this->cartstatus['pending']],
                        ['user_id', Auth::user()->id],
                        ['company_id', Auth::user()->company_id],
                        ['delivery_type', $request['formdata']['delivery_method']],
                        ['combo', json_encode($combo)],
                    ]);

                //Update cart if item already exists
                if($item_in_cart->exists()) {
                    try {
                        $item_in_cart->update([
                            'qty' => ($request['formdata']['orderqty'] + $item_in_cart->first()->qty),
                            'delivery_location' => $pickuploc,
                            'pickup_location_name' => $pickuplocname,
                            'delivery_type' => $request['formdata']['delivery_method']
                        ]);

                        //Add Product to cart if product has attribute
                        if(isset($request['formdata']['pickup_attribute'])) {
                            if ($request['formdata']['pickup_attribute'][0]['product_has_attribute'] == 'true') {

                                CartItemAttrib::where('cart_item_id', $item_in_cart->first()->id)->update([
                                    'attribute' => $attribute,
                                    'type' => $type,
                                    'value' => $value
                                ]);
                            }
                        }
                        return response()->json(['data' => 'Your Cart has been updated.',"cartqty" => Auth::user()->cartCount(), 'status' => '200'], 200);

                    } catch (\Exception $e) {
                        return response()->json(['data' => 'An Error Occurred. Try again.'. $e->getMessage(), 'status' => '400'], 400);
                    }
                }

                //Insert into cart if item doesn't exist

                try {

                    //Add Product to cart

//echo $pickuplocname;
//dd();
                    $cart_item = Cart::create([
                        'user_id' => Auth::user()->id,
                        'company_id' => Auth::user()->company_id,
                        'name' => $request['formdata']['name'],
                        'delivery_type' => $request['formdata']['delivery_method'],
                        'delivery_location' => $pickuploc,
                        'pickup_location_name' => $pickuplocname,
                        'qty' => $request['formdata']['orderqty'],
                        'price' => $request['formdata']['price'],
                        'signature' => $request['formdata']['signature'],
                        'image' => $request['formdata']['product_image'],
                        'combo' => json_encode($combo),
                        'status' => $this->cartstatus['pending']
                    ]);

//                    dd($cart_item);

                    //Add Product to cart if product has attribute
                    if(isset($request['formdata']['pickup_attribute'])) {
                        if ($request['formdata']['pickup_attribute'][0]['product_has_attribute'] == 'true') {
                            CartItemAttrib::create([
                                'cart_item_id' => $cart_item->id,
                                'attribute' => $attribute,
                                'type' => $type,
                                'value' => $attr_together
                            ]);
                        }
                    }

                    return response()->json(['data' => $request['formdata']['name'].' added to cart successfully. (Qty: ' .$request['formdata']['orderqty'] . ")","cartqty" => Auth::user()->cartCount()[0], 'status' => '200'], 200);

                }catch (\Exception $e){
                    return response()->json(['data' => 'An Error Occurred. Try again.'.$e->getMessage(), 'status' => '400'], 400);
                }

            }
        }

        //Fallback if no Javascript
//            if($request['orderqty'] == '0'){
//            return back()->withErrors("Quantity has to be 1 or more.");
//            }else if($request['formdata']['delivery_method'] == 1 && !isset($request['pickup_location']) && $request['pickup_location'] == ''){
//            return back()->withErrors("Please select a Pick up location.");
//            }else if($request['signature'] == '' || $request['price'] == ''){
//            return back()->withErrors("Error. Invalid item.");
//            }else if($request['delivery_method'] == null){
//            return back()->withErrors("Please select a Delivery method.");
//            }
//
//        if($this->validateCart($request) > 0) {
//            try {
//               Cart::where(
//                    [
////                        ['combo', $request['combo']],
//                        ['signature', $request['signature']],
//                        ['status', $this->cartstatus['pending']],
//                        ['user_id', Auth::user()->id],
//                        ['company_id', Auth::user()->company_id],
//                        ['delivery_type', $request['delivery_method']],
//                    ])->update(['qty' => $request['orderqty']]);
//
//                return back()->withErrors("Cart updated.");
//            }catch (\Exception $e){
//                return back()->withErrors("An Error Occurred. Try again.");
//            }
//        }
//
//        try {
//            $addtocart = Cart::create([
//                'user_id' => Auth::user()->id,
//                'company_id' => Auth::user()->company_id,
//                'name' => $request['name'],
//                'delivery_type' => $request['delivery_method'],
//                'delivery_location' => $request['pickup_location'],
//                'qty' => $request['orderqty'],
//                'price' => $request['price'],
//                'signature' => $request['signature'],
//                'combo' => $request['combo'],
//                'status' => $this->cartstatus['pending'],
//            ]);
//            if($addtocart){
//                return back()->withErrors($request['name']." Added to cart");
//            }
//            else{
//                return back()->withErrors("An Error Occurred. Try again.");
//            }
//        }catch (\Exception $e){
//            return back()->withErrors("An Error Occurred. Try again.");
//        }
    }

    //Validate cart
    public function validateCart(Request $request){
        return(Cart::where(
            [
//                ['combo', $request['payload']['combo'] ],
                ['signature', $request['signature']],
                ['status', $this->cartstatus['pending']],
                ['user_id', Auth::user()->id],
                ['company_id', Auth::user()->company_id],
                ['delivery_type', $request['delivery_method']],
            ])->count());
    }

    //Load cart page with neccessary data
    public function getCart(){

        $table = "";
        $pendingcart = Cart::where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->where('status', '=', $this->cartstatus['pending'])
            ->get();

        if($pendingcart){
            foreach ($pendingcart as $item){
//dd($item->combo);
                $product_details[] = [
                    'delivery_type' => $item->delivery_type,
                    'branch_id' => $item->delivery_location,
                    'price' => $item->price,
                    'variants' => json_decode($item->combo, false),
                    'ref_no' => $item->id,
                    'signature' => $item->signature,
                    'quantity' => $item->qty,
                    'remark' =>$item->attrib ? rtrim(trim($item->attrib->value),",") : "",
                ];

            }
            //Add Product details to the payload
            if(isset($product_details)) {
                $payload['product_details'] = json_encode($product_details);
                $response = $this->catalogueProxy->validateorder($payload);

                if ($response->status === 0) {
                    if (isset($response->error)) {

                        foreach ($response->error as $data) {

                            $getcart = Cart::where('user_id', '=', Auth::user()->id)
                                ->where('company_id', '=', Auth::user()->company_id)
                                ->where('id', '=', $data->ref_no)
                                ->where('status', '=', '1')
                                ->get();

                            if ($data->code === 2003) {
                                $this->getnewprice($data->product_code);
                                $newprice = $this->gnewprice;
                                $newsign = $this->gnewsign;
//                                    dd($newsign);
                                $update = Cart::where('id', $data->ref_no)
                                    ->update(['price' => $newprice, 'signature' => $newsign]);

                            }


                            $table .= "<tr id='mod".$data->ref_no."'>";

                            if ($data->code === 2002) {
                                $table .= '<td><button class="btn btn-red">Item Out of Stock</button></td>';
                            } elseif ($data->code === 2003) {
                                $table .= '<td><button class="btn btn-orange">Item Price Change</button></td>';
                            } elseif ($data->code === 2005) {

                                $table .= '<td><button class="btn btn-red">';
                                $attr = "";
                                $write = "Desired Customization";
                                if (isset($data->details)) {
                                    foreach ($data->details as $details) {
                                        $attr .= $details->attribute_name . ": ";
                                        $attr .= $details->variant_name;
                                    }
                                    $write = trim($attr);
                                }


                                $table .= $write . ' Out of Stock';
                                $table .= '</button></td>';

                            }


                            $table .= "<td>";
                            $table .= "<img class='img80' src='" . $getcart[0]['image'] . "'/>";
                            $table .= "</td>";
                            $table .= "<td>";
                            $table .= $getcart[0]['name'];
                            $table .= "</td>";
                            $table .= "<td>";
                            $table .= $getcart[0]['qty'];
                            $table .= "</td>";
                                $table .= "<td>";
                                if($data->code ===  2003) {
                                    $table .= $newprice;
                                    $table .= " Sigma Stars";
                                }
                                $table .= "</td>";

//                                $table .= "<td>";
//                                $table .= $getcart[0]['price'];
//                                $table .= " Sigma Stars"
//                                $table .= "</td>";
//
                            $table .= "<td>";
                            if ($data->code === 2003) {
                                //pulls new price
                                $table .= "<button class='btn btn-blue-cart btn-remove'  onclick='popupcartitem(" . $data->ref_no . ")'>Remove From Cart</button>";
                            }
                            $table .= "</td>";
                            $table .= "</tr>";

                            if ($data->code === 2002 || $data->code === 2005) {
                                $deleteitm = Cart::where('id', $data->ref_no)
                                    ->delete();
                            }


                        }

                    }
                }

            }



        }

        $pendingcartsum = DB::table('cart')
            ->select(DB::raw('sum(price*qty) as subtotal'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->where('status', '=', $this->cartstatus['pending'])
            ->pluck('subtotal');


        $cartqty = Auth::user()->cartCount();

        return view('pages.cart.index', compact( 'pendingcart', 'pendingcartsum','table', 'cartqty'));
    }

    public function checkout(){
        $table = "";
        $products = [];
        $pendingcartsum = Cart::select(DB::raw('sum(price*qty) as subtotal'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->where('status', '=', $this->cartstatus['pending'])
            ->pluck('subtotal');

        $pendingcart = Cart::where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->where('status', '=', '1')
            ->get();

        if($pendingcart){
            foreach ($pendingcart as $item){
//dd($item->combo);
                $product_details[] = [
                    'delivery_type' => $item->delivery_type,
                    'branch_id' => $item->delivery_location,
                    'price' => $item->price,
                    'variants' => json_decode($item->combo, false),
                    'ref_no' => $item->id,
                    'signature' => $item->signature,
                    'quantity' => $item->qty,
                    'remark' => $item->attrib ? rtrim(trim($item->attrib->value),",") : "",
                ];

            }
            //Add Product details to the payload
            if(isset($product_details)) {
                $payload['product_details'] = json_encode($product_details);
                $response = $this->catalogueProxy->validateorder($payload);

                if ($response->status === 0) {
                    if (isset($response->error)) {

                        foreach ($response->error as $data) {

                            $getcart = Cart::where('user_id', '=', Auth::user()->id)
                                ->where('company_id', '=', Auth::user()->company_id)
                                ->where('id', '=', $data->ref_no)
                                ->where('status', '=', '1')
                                ->get();

                            if ($data->code === 2003) {
                                $this->getnewprice($data->product_code);
                                $newprice = $this->gnewprice;
                                $newsign = $this->gnewsign;
//                                    dd($newsign);
                                $update = Cart::where('id', $data->ref_no)
                                    ->update(['price' => $newprice, 'signature' => $newsign]);

                            }


                            $table .= "<tr id='mod".$data->ref_no."'>";

                            if ($data->code === 2002) {
                                $table .= '<td><button class="btn btn-red">Item Out of Stock</button></td>';
                            } elseif ($data->code === 2003) {
                                $table .= '<td><button class="btn btn-orange">Item Price Change</button></td>';
                            } elseif ($data->code === 2005) {

                                $table .= '<td><button class="btn btn-red">';
                                $attr = "";
                                $write = "Desired Customization";
                                if (isset($data->details)) {
                                    foreach ($data->details as $details) {
                                        $attr .= $details->attribute_name . ": ";
                                        $attr .= $details->variant_name;
                                    }
                                    $write = trim($attr);
                                }


                                $table .= $write . ' Out of Stock';
                                $table .= '</button></td>';

                            }


                            $table .= "<td>";
                            $table .= "<img class='img80' src='" . $getcart[0]['image'] . "'/>";
                            $table .= "</td>";
                            $table .= "<td>";
                            $table .= $getcart[0]['name'];
                            $table .= "</td>";
                            $table .= "<td>";
                            $table .= $getcart[0]['qty'];
                            $table .= "</td>";
                            $table .= "<td>";
                            if($data->code ===  2003) {
                                $table .= $newprice;
                                $table .= " Sigma Stars";
                            }
                            $table .= "</td>";

//                                $table .= "<td>";
//                                $table .= $getcart[0]['price'];
//                                $table .= " Sigma Stars"
//                                $table .= "</td>";
//
                            $table .= "<td>";
                            if ($data->code === 2003) {
                                //pulls new price
                                $table .= "<button class='btn btn-blue-cart btn-remove'  onclick='popupcartitem(" . $data->ref_no . ")'>Remove From Cart</button>";
                            }
                            $table .= "</td>";
                            $table .= "</tr>";

                            if ($data->code === 2002 || $data->code === 2005) {
                                $deleteitm = Cart::where('id', $data->ref_no)
                                    ->delete();
                            }


                        }

                    }
                }

            }



        }

        $addresses = ShippingAddress::where(['user_id' => Auth::user()->id, 'company_id' => Auth::user()->company_id])
            ->join('states', 'shipping_address.state_id', '=', 'states.state_id')
            ->join('cities', 'shipping_address.city_id', '=', 'cities.city_id')
            ->select('shipping_address.*', 'states.state_name','states.state_id', 'cities.city_name', 'cities.city_id')
            ->get();
        $states = DB::table('states')->get();
        $cities = DB::table('cities')->get();

        $cartqty = Auth::user()->cartCount();
        return view('pages.cart.checkout', compact(['states', 'cities', 'pendingcartsum', 'addresses', 'pendingcart', 'table', 'cartqty']));
    }

    public function updateCart(Request $request)
    {

        foreach ($request->items as $item)
        {
            if ($item['qty'] > 0) {
                $updatecart = Cart::where('id', $item['id'])
                    ->update(['qty' => $item['qty']]);
            }else{
                $updatecart = Cart::where('id', $item['id'])
                    ->delete();
            }
        }
        if($updatecart){
            return response()->json(['data' => $updatecart, "cartqty" => Auth::user()->cartCount()[0], 'status' => '200'], 200);
        }
        else{
            return response()->json(['data' => 'Failed to update Cart.', 'status' => '400'], 400);
        }
    }

    public function destroyCart(Request $request){
        try{
//            $cartitem = Cart::findOrFail($request->id);
//            $cartitem->status = $this->cartstatus['deleted'];
//            $cartitem->save();

            $cartitem = Cart::where('id',$request->id)
                ->delete();

            if($cartitem){
//                return response()->json(['data' => $cartitem,"cartqty" => Auth::user()->cartCount()[0], 'status' => '200'], 200);
                return response()->json(['data' => $cartitem,"cartqty" => Auth::user()->cartCount(), 'status' => '200'], 200);
            }else{
                return response()->json(['data' => 'Failed to update Cart', 'status' => '400'], 400);
            }

        }
        catch (\Exception $e){
            return response()->json(['data' => json_encode($e->getMessage()), 'status' => '400'], 400);
        }
    }

    public function loadcities(Request $request){
        return DB::table('cities')->where('state_id', $request->id)->get();
    }

    public function getdeliveryprice(Request $request){
        $cart = [];
        $product_details =[];
        try{
            $address = ShippingAddress::findOrFail($request->address_id);
            if($address){
                $cart['state_id'] = $address->state_id;
                $cart['city_id'] = $address->city_id;
            }
        }catch (\Exception $e){
            return response()->json(['data' => 'An error occurred', 'status' => '400'], 400);
        }

        try {
            $pendingcart = DB::table('cart')
                ->where('user_id', '=', Auth::user()->id)
                ->where('company_id', '=', Auth::user()->company_id)
                ->where('status', '=', '1')
                ->where('delivery_type', '=', '2')
                ->get();
//dd($pendingcart);
            if($pendingcart){
                foreach ($pendingcart as $item){
                    $product_details[] = [
                        'ref_no'=> $item->id,
                        'signature' => $item->signature,
                        'quantity' => $item->qty,
                        'location' => $item->pickup_location_name
                    ];
                }
                $cart['product_details'] = json_encode($product_details);
            }
        }catch (\Exception $e){
            return response()->json(['data' => 'An error occurred','reason' => $e->getMessage(), 'status' => '400'], 400);
        }

//        try{
//            $pendingcartsum = DB::table('cart')
//                ->select(DB::raw('sum(price*qty) as subtotal'))
//                ->where('user_id', '=', Auth::user()->id)
//                ->where('company_id', '=', Auth::user()->company_id)
//                ->where('status', '=', $this->cartstatus['pending'])
//                ->pluck('subtotal');
//        }catch (\Exception $e){
//            return response()->json(['data' => 'An error occurred', 'reason' => $e->getMessage(), 'status' => '400'], 400);
//        }

        try{
            $response = $this->catalogueProxy->calculateDelivery($cart);
//            dd($response);
            if($response) {
                if($response->status == 0){
//                    dd($response->data);
                    if(isset($response->data)){
                        $table = null;
                        foreach($response->data as $data){

                            $getcart = Cart::where('user_id', '=', Auth::user()->id)
                                ->where('company_id', '=', Auth::user()->company_id)
                                ->where('id', '=', $data->ref_no)
                                ->where('status', '=', '1')
                                ->get();

                            if($data->code ===  2003){

                                $this->getnewprice($data->product_code);
                                $newprice = $this->gnewprice;
                                $newsign = $this->gnewsign;
                                Cart::where('id', $data->ref_no)
                                    ->update(['price' => $newprice, 'signature'=>$newsign]);
                            }


                            $table .= "<tr id='mod".$data->ref_no."'>";

                            if($data->code === 2002) {
                                $table .='<td><button class="btn btn-red">Item Out of Stock</button></td>';
                            }elseif($data->code === 2003){
                                $table .= '<td><button class="btn btn-orange">Item Price Change</button></td>';
                            }elseif($data->code ===2005){

                                $table .='<td><button class="btn btn-red">';
                                $attr ="";
                                $write = "Desired Customization";
                                if(isset($data->details)) {
                                    foreach ($data->details as $details) {
                                        $attr .= $details->attribute_name . ": ";
                                        $attr .= $details->variant_name;
                                    }
                                    $write = trim($attr);
                                }


                                $table .= $write.' Out of Stock';
                                $table .='</button></td>';

                            }

                            $table .= "<td>";
                            $table .= "<img class='img80' src='".$getcart[0]['image']."'/>";
                            $table .= "</td>";
                            $table .= "<td>";
                            $table .= $getcart[0]['name'];
                            $table .= "<br/>";
                            $table .= "</td>";
                            $table .= "<td>";
                            $table .= $getcart[0]['qty'];
                            $table .= "</td>";
                            $table .= "<td>";

                            if($data->code ===  2003) {
                                $table .= $newprice;
                                $table .= " Sigma Stars";
                            }
                            $table .= "</td>";

//                            $table .= "<td>";
//                            $table .= $getcart[0]['price'];
//                            $table .= " Sigma Stars";
//                            $table .= "/<td>";

                        $table .= "<td>";
                            if($data->code ===  2003){
                                //pulls new price
                                $table .= "<button class='btn btn-blue-cart btn-remove'  onclick='popupcartitem(".$data->ref_no.")'>Remove From Cart</button>";
                            }
                            $table .= "</td>";
                            $table .= "</tr>";

                            if($data->code ===  2002 ||$data->code ===  2005) {
                                $deleteitm = Cart::where('id', $data->ref_no)
                                    ->delete();
                            }


                        }
                        $cartqty = Auth::user()->cartCount();
                        return response()->json(['data' => 'An error occurred','table'=>$table, 'reason' => $response->message, 'status' => '300', 'cartqty'=>$cartqty], 200);

                    }
                    return response()->json(['data' => 'An error occurred', 'reason' => $response->message, 'status' => '400'], 400);
                }

                return response()->json(['data' => $response, 'status' => '200'], 200);
            }

        }catch (\Exception $e){
            return response()->json(['data' => 'An error occurred','reason' => $e->getMessage(), 'status' => '400'], 400);
        }

    }

    private function deductFromAccount($pendingcart, $deliveryprice){
        $totalCostPlusShipping = null;
        //get total price of successfull items
        try {

            if($deliveryprice){
                $totalCostPlusShipping = ($pendingcart + $deliveryprice);
            }else{
                $totalCostPlusShipping = $pendingcart;
            }
            //Deduct cost from Account
            $deduct = \App\Accounts::
            where('user_id', '=', Auth::user()->id)
                ->where('company_id', '=', Auth::user()->company_id)
                ->decrement('point', ceil($totalCostPlusShipping));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function refundFailedTransToAccount($pendingcart, $deliveryprice){
        $totalCost = null;
        //get total price of successfull items
        try {

            if($deliveryprice){
                $totalCost = ($pendingcart + $deliveryprice);
            }else{
                $totalCost = $pendingcart;
            }
            //Deduct cost from Account
            $deduct = \App\Accounts::
            where('user_id', '=', Auth::user()->id)
                ->where('company_id', '=', Auth::user()->company_id)
                ->increment('point', (int)$totalCost);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function canPurcahseWithDelivery($pendingcart, $deliveryprice){

        //Check the user's current point
        $currentuserpoints = DB::table('accounts')
            ->where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->pluck('point');
        if( ($pendingcart + $deliveryprice) > $currentuserpoints[0] ){
            return true;
        }else{
            return false;
        }
    }

    private function canPurcahseWithPickUp($pendingcart){

        //Check the user's current point
        $currentuserpoints = DB::table('accounts')
            ->where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->pluck('point');
        if( ($pendingcart) > $currentuserpoints[0] ){
            return true;
        }else{
            return false;
        }
    }

    public function redeemcart(Request $request){


        //Create an empty arrays to hold the payload to be sent to the redemption API
        $payload = [];
        $product_details =[];
        $shipping_details = [];
        $canpurchase = null;
        $address = null;
        $type = "pickup";
        $delivery_country="pickup";
        $delivery_state="pickup";
        $delivery_city="pickup";

        $table = null;

        //Get total price of prending cart items
        $pendingcartTotalPrice = DB::table('cart')
            ->where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->where('status', '=', '1')
            ->select(DB::raw('sum(price*qty) as totalprice'))
            ->pluck('totalprice');


        //Check if any item in cart is to be shipped/delivered
        $isshipping = DB::table('cart')->select(DB::raw('DISTINCT delivery_type'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->where('status', '=', $this->cartstatus['pending'])
            ->get();



        if(collect($isshipping)->pluck('delivery_type')->count() > 1){
            $type = "pickup_delivery";
        }
        else if (collect($isshipping)->first()->delivery_type == 1){
            $type = "pickup";
        }else if (collect($isshipping)->first()->delivery_type == 2){
            $type = "delivery";
        }


        //Add Shipping flag property
        if($type == "delivery" || $type == "pickup_delivery"){
            $payload['is_shipping'] = 1;
        }else{
            $payload['is_shipping'] = 0;
        }

        if($payload['is_shipping'] == 1){
            if(!isset($request['deliveryprice']) ){
                return response()->json(['data' => 'Delivery cost required.', 'status' => 'fail'], 200);
            }
            $canpurchase = $this->canPurcahseWithDelivery($pendingcartTotalPrice[0], $request->deliveryprice);
        }else{
            if(isset($request['deliveryprice']) ){
                return response()->json(['data' => 'Delivery cost not required.', 'status' => 'fail'], 200);
            }
            $canpurchase = $this->canPurcahseWithPickUp($pendingcartTotalPrice[0]);
        }

        //Check if the user has enough account balance before proceeding with the transaction
        if($canpurchase){
            return response()->json(['data' => 'Apologies! Your current balance is insufficient for this transaction.', 'status' => 'fail'], 200);
        }else{

        //Add properties to the array
        $payload['member_no'] = Auth::user()->member_id;
        $payload['delivery_details'] = [];


        //Get Products details
        try {
            $pendingcart = Cart::where('user_id', '=', Auth::user()->id)
                ->where('company_id', '=', Auth::user()->company_id)
                ->where('status', '=', '1')
                ->get();
            if($pendingcart){
                foreach ($pendingcart as $item){
//dd($item->combo);
                        $product_details[] = [
                            'delivery_type' => $item->delivery_type,
                            'branch_id' => $item->delivery_location,
                            'price' => $item->price,
                            'variants' => json_decode($item->combo, false),
                            'ref_no' => $item->id,
                            'signature' => $item->signature,
                            'quantity' => $item->qty,
                            'remark' => $item->attrib ? rtrim(trim($item->attrib->value),",") : "",
                        ];

                }
                //Add Product details to the payload
                $payload['product_details'] = json_encode($product_details);


            }
        }catch (\Exception $e){
            return response()->json(['data' => 'An error occurred. Failed to aggretate product details.', 'status' => '200'], 200);
        }
                //Get shipping address for the current transaction
                if($payload['is_shipping'] === 1) {
                    try {
                        $address = ShippingAddress::findOrFail($request->address_id);
                        if ($address) {
                            $shipping_details['state_id'] = $address->state_id;
                            $shipping_details['city_id'] = $address->city_id;
                            $shipping_details['first_name'] = $address->firstname;
                            $shipping_details['last_name'] = $address->lastname;
                            $shipping_details['email'] = $address->email;
                            $shipping_details['phone_no'] = $address->phone;
                            $shipping_details['shipping_cost'] = $request->deliveryprice;
                            $shipping_details['address'] = $address->address;
                            $delivery_country= "Nigeria";

                            $str = DB::table('states')->select('state_name')->where('state_id', '=', $address->state_id)->first();
                            $delivery_state = $str->state_name;
                           // $address['state_name'] = $str->state_name;

                            $cty = DB::table('cities')->select('city_name')->where('city_id', '=', $address->city_id)->first();
                            $delivery_city = $cty->city_name;
                            //$address['city_name'] = $cty->city_name;

//                            var_dump($shipping_details);
//                            dd('stop');

                        }
                        $payload['delivery_details'] = json_encode($shipping_details);
                    } catch (\Exception $e) {
                        return response()->json(['data' => 'An error occurred. Shipping address not available', 'status' => 'fail'], 200);
                    }
                }else{
                    $payload['delivery_details'] = json_encode([]);
                }

            if($this->deductFromAccount($pendingcartTotalPrice[0], $request->deliveryprice) ){

            }else{
                return response()->json(['data' => 'An error occurred. Cost deduction failed', 'status' => 'fail'], 200);
            }
        //Send the redemption request to the API

        try{
//            $response = Curl::to(config('app.rb_base_api').'bulk_purchase')
//                ->withHeader('token: '.Auth::user()->company->token)
//                ->withData($payload)'
//                ->asJsonResponse()
//                ->post();

            $response = $this->catalogueProxy->redeem($payload);

            if($response){
                if ($response->status === 0){
                    if($this->refundFailedTransToAccount($pendingcartTotalPrice[0], $request->deliveryprice)){

                        if(isset($response->data->error)){
//
                            foreach($response->data->error as $data){

                                $getcart = Cart::where('user_id', '=', Auth::user()->id)
                                    ->where('company_id', '=', Auth::user()->company_id)
                                    ->where('id', '=', $data->ref_no)
                                    ->where('status', '=', '1')
                                    ->get();

                                if($data->code ===  2003){
                                    $this->getnewprice($data->product_code);
                                    $newprice = $this->gnewprice;
                                    $newsign = $this->gnewsign;
//                                    dd($newsign);
                                     $update= Cart::where('id', $data->ref_no)
                                        ->update(['price' => $newprice,'signature' => $newsign]);

                                }


                                $table .= "<tr id='mod".$data->ref_no."'>";

                                if($data->code === 2002) {
                                    $table .='<td><button class="btn btn-red">Item Out of Stock</button></td>';
                                }elseif($data->code === 2003){
                                    $table .= '<td><button class="btn btn-orange">Item Price Change</button></td>';
                                }elseif($data->code ===2005){

                                        $table .='<td><button class="btn btn-red">';
                                        $attr ="";
                                        $write = "Desired Customization";
                                        if(isset($data->details)) {
                                            foreach ($data->details as $details) {
                                                $attr .= $details->attribute_name . ": ";
                                                $attr .= $details->variant_name;
                                            }
                                            $write = trim($attr);
                                        }


                                        $table .= $write.' Out of Stock';
                                        $table .='</button></td>';

                                }


                                $table .= "<td>";
                                $table .= "<img class='img80' src='".$getcart[0]['image']."'/>";
                                $table .= "</td>";
                                $table .= "<td>";
                                $table .= $getcart[0]['name'];
                                $table .= "</td>";
                                $table .= "<td>";
                                $table .= $getcart[0]['qty'];
                                $table .= "</td>";
                                $table .= "<td>";
                                if($data->code ===  2003) {
                                    $table .= $newprice;
                                    $table .= " Sigma Stars";
                                }
                                $table .= "</td>";

//                                $table .= "<td>";
//                                $table .= $getcart[0]['price'];
//                                $table .= " Sigma Stars"
//                                $table .= "</td>";
//
                                $table .= "<td>";
                                if($data->code ===  2003){
                                    //pulls new price
                                    $table .= "<button class='btn btn-blue-cart btn-remove'  onclick='popupcartitem(".$data->ref_no.")'>Remove From Cart</button>";
                                }
                                $table .= "</td>";
                                $table .= "</tr>";

                                if($data->code ===  2002 || $data->code === 2005) {
                                    $deleteitm = Cart::where('id', $data->ref_no)
                                        ->delete();
                                }


                            }
                            $cartqty = Auth::user()->cartCount();
                            return response()->json(['data' => "Somethings are wrong with item(s) in cart", 'table'=>$table, 'status' => '300', 'cartqty'=>$cartqty], 200);
                        }
                        return response()->json(['data' => $response, 'status' => '400'], 200);
                    }else{
                        return response()->json(['data' => 'An error occurred. Refund action failed', 'status' => 'fail'], 200);
                    }

                }

                if($this->updateCartAfterRedeem($response, $request->deliveryprice, $request->address_id) ){
                    try {
                        $order = new Order();
                        $order->user_id = Auth::user()->id;
                        $order->company_id = Auth::user()->company_id;
                        $order->address_id = $request->address_id;
                        $order->sub_total_cost = $pendingcartTotalPrice[0];
                        $order->shipping_cost = $request->deliveryprice;
                        $order->is_shipping = $payload['is_shipping'];
                        $order->order_no = $response->data->order_no;
                        $order->success = $response->data->success;
                        $order->fail = $response->data->failed;
                        $order->save();

                        $delivery_price = $request->has('deliveryprice') ? $request->deliveryprice : null;

                        $this->transactionRepository->SaveTransaction($request, $order->id, $pendingcartTotalPrice[0], $delivery_price);

                        if($order){

                            //Handle Success
                            if(isset($response->data->success)) {
                                if (count($response->data->success) > 0) {
                                    $product_details = [];
                                    $total_cost = null;
                                    foreach ($response->data->success as $item) {
                                        $success_items = Cart::where('cart.id', '=', $item->ref_no)->select('cart.voucher', 'cart.price', 'cart.delivery_type','cart.pickup_location_name', 'cart.name', 'cart.qty', 'cart_items_attr.value')
                                            ->leftJoin('cart_items_attr', 'cart.id', '=', 'cart_items_attr.cart_item_id')->first();

                                        $virtual_price = null;
                                        $unit_price = null;
                                        $total_cost += ceil($success_items->price * $success_items->qty);
                                        if (Auth::user()->currency->is_currency_fixed == '1'){
                                            $unit_price = " '&#8358 '.(number_format(ceil($success_items->price)) ";
                                            $virtual_price =" '&#8358 '.(number_format(ceil($success_items->price * $success_items->qty)) ";
                                        }
                                        else
                                        {
                                            $unit_price = number_format( ceil(Auth::user()->currency->rate * $success_items->price) ) . ' ' . Auth::user()->currency->currency;
                                            $virtual_price = number_format( ceil(Auth::user()->currency->rate * $success_items->price * $success_items->qty) ) . ' ' . Auth::user()->currency->currency;
                                        }
//                                        $product_details[] = (object)[
//                                            'delivery_type_name' => $success_items->delivery_type == 1 ? 'Pickup' : 'Delivery',
//                                            'pickup_location_name' => $success_items->pickup_location_name,
//                                            'virtual_price' => $virtual_price,
//                                            'voucher' => $success_items->voucher,
//                                            'quantity' => $success_items->qty,
//                                            'name' => $success_items->value ? $success_items->name . ( $success_items->value ) : $success_items->name
//                                        ];



                                        $product_details[] = (object)[
                                            'delivery_type' => $success_items->delivery_type,
                                            'delivery_type_name' => $success_items->delivery_type == 1 ? 'Pick Up' : 'Delivery',
                                            'pickup_location_name' => $success_items->pickup_location_name,
                                            'unit_price' => $unit_price,
                                            'price' => $virtual_price,
                                            'voucher' => $success_items->voucher,
                                            'remark'=> trim($success_items->value),
                                            'quantity' => $success_items->qty,
                                            'name' => $success_items->name
                                            //'name' => $success_items->value ? $success_items->name . ( $success_items->value ) : $success_items->name
                                        ];


                                    }
                                }
                            }
                            $total_with_delivery = ceil($total_cost + $delivery_price);
                            $spend_amount = null;
                            $grant_amount = null;
                            if (Auth::user()->currency->is_currency_fixed == '1'){
                                $total_cost = '&#8358'. number_format($total_cost, 0, '.', ',');
                                $delivery_price = '&#8358'.number_format($delivery_price, 0, '.', ',');
                                $spend_amount = $total_with_delivery;
                                $grant_amount = '&#8358'.number_format($total_cost + $delivery_price, 0, '.', ',');
                            }
                            else
                            {
                                $total_cost = number_format(Auth::user()->currency->rate * $total_cost, 0, '.', ',') . ' ' . Auth::user()->currency->currency;
                                $delivery_price = number_format(Auth::user()->currency->rate * $delivery_price, 0, '.', ',') . ' ' . Auth::user()->currency->currency;
                                $spend_amount = Auth::user()->currency->rate * $total_with_delivery;
                                $grant_amount = number_format(Auth::user()->currency->rate * $total_with_delivery, 0, '.', ',') . ' ' . Auth::user()->currency->currency;

                            }


//                            var_dump($product_details);
//                            dd();
                            $receipt = $this->deliveryPickupReceipt($product_details, $address, $response->data->order_no, $total_cost, $delivery_price, $grant_amount, $delivery_country, $delivery_state, $delivery_city);

                            $email_payload = [
                                'order_no' => $response->data->order_no,
                                'details' => $receipt,
                                'spend_amount' => number_format(ceil(floatval($spend_amount)))
                            ];

                            $token = DB::table('company')->where('id', Auth::user()->company_id)->select('token')->first();

                            $this->notifyTransactionSuccess($token->token, $email_payload, $type);
                            return response()->json(['data' => $order->id, 'status' => '200', 'account' => Auth::user()->accountBalaceText()], 200);

//                            return response()->redirectToRoute('ordercomplete', ['id' => $order->id]);
//                            return response()->json(['data' => $order->id, 'status' => '200', 'account' => Auth::user()->accountBalaceText()], 200);
                            //Record transaction and update users account account balance
                        }
                    }catch (\Exception $e){
                        return response()->json(['data' => 'Failed to record Order ' . $e->getMessage(), 'status' => '400'], 400);
                    }
                    return response()->json(['data' => 'Transaction successful', 'status' => '200'], 200);
                }else{
                    return response()->json(['data' => 'Transaction failed', 'status' => '400'], 400);
                };
//                return response()->json(['data' => $response, 'status' => '200'], 200);
            }else{
                return response()->json(['data' => 'No response from the network', 'status' => '400'], 400);
            }
        }catch (\Exception $e){
            return response()->json(['data' => 'Try again please. A network error occurred.'.$e->getMessage(), 'status' => '400'], 400);
        }

        }
    }

    private function updateCartAfterRedeem($data, $deliveryprice , $address){
        $totalPriceForSuccess = null;
        $totalPriceForFailed = null;
        $status = false;

        //Handle Success
        if(isset($data->data->success)){
            if(count($data->data->success) > 0) {
                //get total price of successfull items
                foreach ($data->data->success as $item) {
                    $totalPriceForSuccess = DB::table('cart')
                        ->where('id', '=', $item->ref_no)
                        ->where('user_id', '=', Auth::user()->id)
                        ->where('company_id', '=', Auth::user()->company_id)
                        ->select(DB::raw('sum(price*qty) as totalprice'))
                        ->pluck('totalprice');
                }

                //Change status of successfull items in Cart
                    if(count($data->data->success) > 0) {
                        try {
                            foreach ($data->data->success as $item) {
                                Cart::
                                where('id', '=', $item->ref_no)
                                    ->where('user_id', '=', Auth::user()->id)
                                    ->where('company_id', '=', Auth::user()->company_id)
                                    ->update([
                                        'status' => $this->cartstatus['processing'],
                                        'voucher' => $item->voucher_code,
                                        'delivery_location' => $address,
                                        'pickup_location_name' => $item->branch_name . ', '. $item->branch_address
                                    ]);
                            }
                            $status = true;
                        } catch (\Exception $e) {
                            $status = false;
                            throw new \Exception('Failed to update cart items upon transaction success.' . $e->getMessage());
                        }
                    }
                }
            }


        //Handle shipping
        if(isset($data->data->failed->shipping)){
                if($data->data->failed->shipping == 1) {
                    try {
                        \App\Accounts::
                        where('user_id', '=', Auth::user()->id)
                            ->where('company_id', '=', Auth::user()->company_id)
                            ->increment('point', (int)$deliveryprice);
                        $status = true;
                    } catch (\Exception $e) {
                        $status = false;
                        throw new \Exception('Failed to refund delivery charge upon transaction failure.' . $e->getMessage());
                    }
                }
        }

                //Handle cart failed items
                if(isset($data->data->failed)) {
                    if (count($data->data->failed) > 0)
                    {
                        //Change status of failed items in Cart
                        try {
                            foreach ($data->data->failed->reference as $id) {
                                Cart::
                                where('id', '=', $id)
                                    ->where('user_id', '=', Auth::user()->id)
                                    ->where('company_id', '=', Auth::user()->company_id)
                                    ->update([
                                        'status' => $this->cartstatus['fail'],
                                        'voucher' => null,
                                        'delivery_location' => $address,
                                        'pickup_location_name' => $item->branch_name . ', '. $item->branch_address
                                    ]);
                            }
                            $status = true;
                        } catch (\Exception $e) {
                            $status = false;
                            throw new \Exception('Failed to update cart items upon transaction failure.' . $e->getMessage());
                        }

                    //Refund failed transactions to account
                    try {
                        //get total price of successfull items
                        foreach ($data->data->failed->reference as $item) {
                            $totalPriceForFailed = DB::table('cart')
                                ->where('id', '=', $item)
                                ->where('user_id', '=', Auth::user()->id)
                                ->where('company_id', '=', Auth::user()->company_id)
                                ->select(DB::raw('sum(price*qty) as totalprice'))
                                ->pluck('totalprice');
                        }
                        \App\Accounts::
                        where('user_id', '=', Auth::user()->id)
                            ->where('company_id', '=', Auth::user()->company_id)
                            ->increment('point', $totalPriceForFailed[0]);
                        $status = true;
                    } catch (\Exception $e) {
                        $status = false;
                        throw new \Exception('Failed to refund upon transaction failure.' . $e->getMessage());
                    }
                }
                }


        return $status;
    }

}
