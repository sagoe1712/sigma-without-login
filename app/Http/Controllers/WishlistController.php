<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    //

    private $wish_no = 20;
    
    private function get_offset($page, $limit){

        $offset = ($page - 1) * $limit;
        return $offset;

    }

    private function delete_wishlist($id, $member_id, $company_id){

        $delete_list = Wishlist::where('user_id', $member_id)
                            ->where('company_id',$company_id)
                            ->where('id',$id)
                            ->first()
                            ->delete();
        if($delete_list){
            $response_array['message'] = "Product deleted";

            return $response_array;

        } else {

            return "Error Deleting from list";
        }
    }

    private function delete_oldest_wishlist ($member_id, $company_id){

        $delete_oldest = Wishlist::where('user_id', $member_id)
                        ->where('company_id',$company_id)
                        ->oldest()
                        ->first()
                        ->delete();

    }

    private function update_product_status ($company_id, $product_name, $product_code, $status){

        if ($status == 1 || $status == 2){

            $update_status = Wishlist::where('product_code', $product_code)
                                ->where('company_id', $company_id);

            if($status == 0) {

                $update_status= $update_status->update(['status' => 0]);
                $message = $product_name. " disabled";
            } else {

                $update_status= $update_status->update(['status' => 1]);
                $message = $product_name. " enabled";
            }

            if($update_status){

                $response_array['product_code'] = $product_code;
                $response_array['product_name'] = $product_name;
                $response_array['message'] = $message;

                return $response_array;
            } else{

                return "Error updating status";
            }

        } else {

            return "Invalid Status";
        }



    }

    private function get_all_user_wishlist($member_id, $company_id){

        $get_user_list = Wishlist::where('user_id', $member_id)
            ->where('company_id',$company_id)
            ->get();

        return $get_user_list;
    }

    private function check_product_code ($member_id, $company_id, $product_code){

        $get_product_code = Wishlist::where('user_id', $member_id)
            ->where('company_id',$company_id)
            ->where('product_code',$product_code)
            ->get();

        return $get_product_code;
    }

    private function check_wishlist_id ($member_id, $company_id, $id){

        $get_product = Wishlist::where('user_id', $member_id)
            ->where('company_id',$company_id)
            ->where('id',$id)
            ->get();

        return $get_product;
    }

    private function list_wishlist($member_id, $company_id, $limit =12 , $page =1 ,$delivery_type = null, $sort = null) {

        $offset = $this->get_offset($page, $limit);

        $get_wish =  Wishlist::select('id', 'product_name','image','product_code','delivery_type','status','price')
            ->where('user_id', $member_id)
            ->where('company_id', $company_id);


        if ($delivery_type == 1 || $delivery_type == 2 || $delivery_type == 3){

            $get_wish = $get_wish->where('delivery_type', $delivery_type);

        }

        if($sort == 1){ //high to low

            $get_wish =  $get_wish ->orderBy('price', 'DESC');
        } elseif ($sort == 2) { //low to high

            $get_wish =  $get_wish ->orderBy('price', 'ASC');
        }

        $get_wish=$get_wish->offset($offset)
                            ->limit($limit)
                            ->get();

        return $get_wish;

    }

    private function insert_wishlist($member_id, $company_id, $product_name, $image, $price, $product_code, $delivery_type){

        $wish = new Wishlist();
        $wish->user_id = $member_id;
        $wish->company_id = $company_id;
        $wish-> product_name = $product_name;
        $wish->image =  $image;
        $wish->product_code = $product_code;
        $wish->price = $price;
        $wish->delivery_type = $delivery_type;
        $wish->status = 1;

        if($wish->save()){
            $response_array['product_name'] = $product_name;
            $response_array['product_code'] = $product_code;

            return $response_array;
        } else{

            return "Unable to to add to wish list";
        }

    }
    public function create_wishlist (Request $request){

        if(isset($request['formdata']['product_name']) && isset($request['formdata']['image']) && isset($request['formdata']['price']) && isset($request['formdata']['product_code']) && isset($request['formdata']['delivery_type'])){
            $member_id = Auth::user()->id;
            $company_id = Auth::user()->company_id;

            $check_product = $this->check_product_code($member_id, $company_id, $request['formdata']['product_code']);

            if(count($check_product) > 0) {

                return response()->json(['status'=>200, 'message' => $request['formdata']['product_name'].' Already exists on Wishlist'], 200);


            } else {
                $check_amount = $this->get_all_user_wishlist($member_id, $company_id);


                if (count($check_amount) >= $this->wish_no) {

                    return response()->json(['message' => "Wish list cannot exceed Maximum allowed(" . $this->wish_no . ")"], 400);

                } else {


                    $insert_data = $this->insert_wishlist($member_id,$company_id,$request['formdata']['product_name'], $request['formdata']['image'], $request['formdata']['price'], $request['formdata']['product_code'], $request['formdata']['delivery_type']);

                   if($insert_data){
                       $count = Auth::user()->wishlistCount();
                       return response()->json(['status'=>200, 'message' => 'Items has been added to your wishlist.', 'count'=>$count], 200);
                   }
                   else{
                       return response()->json(['message' => 'Failed to insert wishlist.'], 400);
                   }
                }
            }


        } else {

            return response()->json(['message' => 'Missing parameter'], 400);

        }


    }

    public function delete_wishlist_item(Request $request){
        if(isset($request['id'])){

            $member_id = Auth::user()->id;
            $company_id = Auth::user()->company_id;
            $check_item = $this->check_wishlist_id($member_id, $company_id, $request['id']);

            if (count($check_item) > 0){

                $deletecmd = $this->delete_wishlist($request['id'], $member_id, $company_id);

                if($deletecmd){
                    $count = Auth::user()->wishlistCount();
                    return response()->json(['status'=>200, 'message' => 'Items has been deleted to your wishlist.', 'count'=>$count], 200);
                }
                else{
                    return response()->json(['message' => 'Failed to delete item from wishlist.'], 400);
                }

            }else {
                return response()->json(['message' => 'Item does not exist in list.'], 400);
            }


        } else {

            return response()->json(['message' => 'No item selected.'], 400);
          }


    }

    public function list_wishlist_request(Request $request){

        $title = "Wishlist";
        $member_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;

        if(isset($request['page'])){

            $page = $request['page'];
        } else {

            $page = 1;
        }

        if(isset($request['limit'])){

            $limit = $request['limit'];

        } else {

            $limit = 12;
        }

        if(isset($request['delivery_type'])){

            if ($request['delivery_type'] == 1 || $request['delivery_type'] == 2 || $request['delivery_type'] == 3) {

                $delivery_type = $request['delivery_type'];
            } else {

                $delivery_type = null;
            }
        } else {

            $delivery_type = null;
        }

        if(isset($request['sort'])){

            if ($request['sort'] == 1 || $request['sort'] == 2) {

                $sort = $request['sort'];
            } else {

                $sort = null;
            }

        } else {

            $sort = null;
        }


        $get_list = $this->list_wishlist($member_id, $company_id,$limit,$page,$delivery_type,$sort);

        if(count($get_list) > 0){

            $response_array = array();
            foreach ($get_list as $list){

                $list['price'] = ceil(Auth::user()->currency->rate * $list['price']);

                $response_array[] = $list;
            }

//            return $response_array;
            return view('pages.wishlist.index',compact('response_array', 'title'));

        }
        else {
            $data = "No Data Found";
            return view('pages.wishlist.index',compact('data', 'title'));

        }
    }

//    public function test_insert(){
//
//        return $this->insert_wishlist(1,2,"test product2", "image_url","5000","xyzabc",1);
//    }
//
//    public function test_update_status(){
//
//        return $this->update_product_status(2, 'test2','xyz',1);
//    }
//
//    public function test_delete_list(){
//
//        return $this->delete_wishlist(3,1,2);
//    }
//
//    public function test_check_product_code(){
//
//        return count($this->check_product_code(1,2,"xyz1"));
//    }
//
//    public function test_get_all(){
//
//        return count($this->get_all_user_wishlist(1,2));
//    }
//
//    public function test_list() {
//
//        return $this->list_wishlist(1,2);
//    }
}
