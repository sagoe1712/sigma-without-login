<?php
namespace App\Traits;
use App\Order;
use Illuminate\Support\Facades\Auth;
trait OrderActions{

    public function addOrder($order_no, $success, $cost){
        try {
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->company_id = Auth::user()->company_id;
            $order->address_id = null;
            $order->sub_total_cost = $cost;
            $order->shipping_cost = null;
            $order->is_shipping = 0;
            $order->order_no = $order_no;
            $order->success = $success;
            $order->fail = [];
            $order->save();

            if($order){
                return $order->id;
            }else{return false;}
        }catch (\Exception $e){
            throw new \Exception('Failed record Order.' . $e->getMessage());
        }
    }
}