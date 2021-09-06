<?php

namespace App\Http\Controllers;

use App\RecentView;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RecentViewController extends Controller
{
    //

    private $recent_no = 10;


    private function delete_recent($id, $member_id, $company_id){

        $delete_list = RecentView::where('user_id', $member_id)
                            ->where('company_id',$company_id)
                            ->where('id',$id)
                            ->first()
                            ->delete();
        if($delete_list){
            $response_array['message'] = "Product deleted";

            return $response_array;

        } else {

            return "Error Deleting Product";
        }
    }

    private function delete_oldest_recent ($member_id, $company_id){

        $delete_oldest = RecentView::where('user_id', $member_id)
                        ->where('company_id',$company_id)
                        ->oldest()
                        ->first()
                        ->delete();
        return $delete_oldest;
    }




    private function get_all_user_recent($member_id, $company_id){

        $get_user_list = RecentView::where('user_id', $member_id)
            ->where('company_id',$company_id)
            ->get();

        return $get_user_list;
    }

    private function check_product_code ($member_id, $company_id, $product_code){

        $get_product_code = RecentView::where('user_id', $member_id)
            ->where('company_id',$company_id)
            ->where('product_code',$product_code)
            ->get();

        return $get_product_code;
    }

    private function check_recent_id ($member_id, $company_id, $id){

        $get_product = RecentView::where('user_id', $member_id)
            ->where('company_id',$company_id)
            ->where('id',$id)
            ->get();

        return $get_product;
    }

    private function list_recent($member_id, $company_id) {

        $get_recent =  RecentView::select('id', 'product_name','image','product_code')
            ->where('user_id', $member_id)
            ->where('company_id', $company_id)
            ->orderBy('id', 'DESC')
            ->get();

        return $get_recent;

    }

    private function insert_recent($member_id, $company_id, $product_name, $image, $product_code){

        $recent = new RecentView();
        $recent->user_id = $member_id;
        $recent->company_id = $company_id;
        $recent-> product_name = $product_name;
        $recent->image =  $image;
        $recent->product_code = $product_code;

        if($recent->save()){
            $response_array['product_name'] = $product_name;
            $response_array['product_code'] = $product_code;

            return $response_array;
        } else{

            return "Unable to to add to Recently viewed";
        }

    }
    public function create_recent ($product_name, $image, $productcode){
        $name = $product_name;
        $img = $image;
        $product_code = $productcode;
        if(isset($name) && isset($img)  && isset($product_code)){
            $member_id = Auth::user()->id;
            $company_id = Auth::user()->company_id;



            $check_amount = $this->get_all_user_recent($member_id, $company_id);
            $check_amount_array = $check_amount->toArray();
            if(in_array($product_code,array_column($check_amount_array, 'product_code'))){

                return "Item has already been viewed";
            } else {


                if (count($check_amount) >= $this->recent_no) {

                    $delete_old = $this->delete_oldest_recent($member_id, $company_id);
                    if($delete_old) {

                       $insert_data = $this->insert_recent($member_id, $company_id, $product_name, $img, $product_code);
                    } else {

                        return "Error deleting oldest view";
                    }
                } else {


                    $insert_data = $this->insert_recent($member_id, $company_id, $product_name, $img, $product_code);


                }

                return $insert_data;
            }

        } else {

            return "Missing Parameter";
        }


    }

    public function delete_recent_item(Request $request){
        if(isset($request['id'])){

            $member_id = Auth::user()->id;
            $company_id = Auth::user()->company_id;
            $check_item = $this->check_recent_id($member_id, $company_id, $request['id']);

            if (count($check_item) > 0){

                return $this->delete_recent($request['id'], $member_id, $company_id);

            }else {

                return "Item does not exist in list";
            }


        } else {

            return "No item selected";
        }


    }

    public function list_recent_request(){

        $member_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;

        //dd($member_id);

        $get_list = $this->list_recent($member_id, $company_id);

//        dd($get_list);

        if(count($get_list) > 0){

            $response_array = [];
      $response_array = $get_list;


            return $response_array;

        } else {

            return "No data found";
        }
    }

//    public function test_insert(){
//
//        return $this->create_recent("test product2", "image_url","456abcdfgh6");
//    }
//
//
//    public function test_get_all(){
//
//        return $this->list_recent(1,2);
//    }
//

}
