<?php

namespace App\Http\Controllers;

use App\ShippingAddress;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web', 'auth']);
    }

    public function index()
    {

        $accounts = \App\Order::where([
            ['user_id', '=', Auth::user()->id],
            ['company_id', '=', Auth::user()->company_id]
        ])
            ->select('success','fail','created_at', 'sub_total_cost', 'shipping_cost', 'is_shipping', 'id', 'order_no')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $title = "Orders";

        return view('pages.order.index', compact('accounts', 'title'));
    }

    public function statement()
    {
        $accounts = \App\Transaction::where([
            ['member_id', '=', Auth::user()->id],
            ['company_id', '=', Auth::user()->company_id]
        ])
            ->select('point_virtual','point_raw','balance_raw', 'balance_virtual', 'type','created_at', 'order_id', 'id as trans_no')
            ->orderBy('created_at', 'desc')
            ->paginate(10);



        return view('pages.order.statement', compact('accounts'));
    }

    public function getOrderItems($id){
        $data = [];
        $accounts = \App\Order::where('id', '=', $id)
            ->get();
        $order = $accounts->first() ;
        $delivery_charge = $accounts->pluck('shipping_cost')->first() * (Auth::user()->currency->is_currency_fixed == 0 ? Auth::user()->currency->rate : 1);
        $address = null;
        if(head($accounts->pluck('is_shipping'))[0] === 1){
            $address = \App\ShippingAddress::where('id',head($accounts->pluck('address_id'))[0])->first();
        }
        if(count(head($accounts->pluck('success')))){
            foreach (head($accounts->pluck('success'))[0] as $item){
                $cartitem = \App\Cart::
                where('cart.id',$item['ref_no'])
                    ->leftJoin('shipping_address', 'cart.delivery_location', '=', 'shipping_address.id')
                    ->leftJoin('cart_items_attr', 'cart.id', '=', 'cart_items_attr.cart_item_id')
                    ->get();
                $scrathdata = head($cartitem->toArray());
                $scrathdata['voucher'] = $item['voucher_code'];
                array_push($data,(object)$scrathdata);
            }
        }

        if(count(head($accounts->pluck('fail')))){
            if(isset($accounts->pluck('fail')[0]['reference'])) {
                foreach (head($accounts->pluck('fail'))[0]['reference'] as $item){
                    $cartitem = \App\Cart::
                    where('cart.id',$item)
                        ->leftJoin('shipping_address', 'cart.delivery_location', '=', 'shipping_address.id')
                        ->leftJoin('cart_items_attr', 'cart.id', '=', 'cart_items_attr.cart_item_id')
                        ->get();

                    array_push($data,(object)head($cartitem->toArray()));
                }
            }
        }

        return view('pages.order.orderitems', compact('data', 'order', 'delivery_charge'));
    }

    public function getOrderId(Request $request){
        $id = $request->id;
        $data = [];
        $order = \App\Order::where('id', '=', $id)->select('order_no', 'created_at')->first();
        $accounts = \App\Order::where('id', '=', $id)
            ->select('success','fail', 'shipping_cost')->get();
        $delivery_charge = $accounts->pluck('shipping_cost')->first() * (Auth::user()->currency->is_currency_fixed == 0 ? Auth::user()->currency->rate : 1);;

//        dd(head($accounts->pluck('success'))[0]['ref_no']);
        if(count(head($accounts->pluck('success')))){
            foreach (head($accounts->pluck('success'))[0] as $item){
                $cartitem = \App\Cart::
                where('cart.id',$item['ref_no'])
                    ->leftJoin('shipping_address', 'cart.delivery_location', '=', 'shipping_address.id')
                    ->leftJoin('states', 'states.state_id', '=', 'shipping_address.state_id')
                    ->leftJoin('cities', 'cities.city_id', '=', 'shipping_address.city_id')
                    ->leftJoin('cart_items_attr', 'cart.id', '=', 'cart_items_attr.cart_item_id')
                    ->get();
                array_push($data,(object)head($cartitem->toArray()));
            }
        }


        if(count(head($accounts->pluck('fail')))){
            if(isset($accounts->pluck('fail')[0]['reference'])) {
                foreach (head($accounts->pluck('fail'))[0]['reference'] as $item) {
                    $cartitem = \App\Cart::
                    where('cart.id', $item)
                        ->leftJoin('shipping_address', 'cart.delivery_location', '=', 'shipping_address.id')
                        ->leftJoin('cart_items_attr', 'cart.id', '=', 'cart_items_attr.cart_item_id')
                        ->get();
                    array_push($data, (object)head($cartitem->toArray()));
                }
            }
        }

        return response()->json(['delivery_details'=>$data, 'order'=>$order, 'delivery_charge'=>$delivery_charge, 'status'=>200],200);
    }


    public function orderComplete($id){
        $data = [];
        $order = \App\Order::where('id', '=', $id)->select('order_no', 'created_at')->first();
        $accounts = \App\Order::where('id', '=', $id)
            ->select('success','fail', 'shipping_cost')->get();
        $delivery_charge = $accounts->pluck('shipping_cost')->first() * (Auth::user()->currency->is_currency_fixed == 0 ? Auth::user()->currency->rate : 1);;

//        dd(head($accounts->pluck('success'))[0]['ref_no']);
        if(count(head($accounts->pluck('success')))){
            foreach (head($accounts->pluck('success'))[0] as $item){
                $cartitem = \App\Cart::
                where('cart.id',$item['ref_no'])
                    ->leftJoin('shipping_address', 'cart.delivery_location', '=', 'shipping_address.id')
                    ->leftJoin('states', 'states.state_id', '=', 'shipping_address.state_id')
                    ->leftJoin('cities', 'cities.city_id', '=', 'shipping_address.city_id')
                    ->leftJoin('cart_items_attr', 'cart.id', '=', 'cart_items_attr.cart_item_id')
                    ->get();
                array_push($data,(object)head($cartitem->toArray()));
            }
        }


        if(count(head($accounts->pluck('fail')))){
            if(isset($accounts->pluck('fail')[0]['reference'])) {
                foreach (head($accounts->pluck('fail'))[0]['reference'] as $item) {
                    $cartitem = \App\Cart::
                    where('cart.id', $item)
                        ->leftJoin('shipping_address', 'cart.delivery_location', '=', 'shipping_address.id')
                        ->leftJoin('cart_items_attr', 'cart.id', '=', 'cart_items_attr.cart_item_id')
                        ->get();
                    array_push($data, (object)head($cartitem->toArray()));
                }
            }
        }

        return view('pages.order.order_complete', compact('data', 'order', 'delivery_charge'));
    }

    public function addorderaddress(Request $request){
        $messages = [
            'phone_no.numeric' => 'Phone number must be numbers',
            'city_id.required' => 'Please select a city',
            'state_id.required' => 'Please select a state',
        ];

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|regex:/[0-9]{9}/|bail',
            'email' => 'required|min:5|max:255|email|bail',
            'lastname' => 'required|bail',
            'firstname' => 'required|bail',
            'address' => 'required|bail',
            'state_id' => 'required|bail',
            'city_id' => 'required|bail',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first(), 'status' => 'validation'], 200);
        }

        if (strlen($request->phone) > 11 || strlen($request->phone) < 10) {
            return response()->json(['message' => 'Phone number must be between 10 and 11 digits', 'status' => 'validation'], 200);
        }


        try {
            $query = ShippingAddress::create(
                [
                    'user_id' => Auth::user()->id,
                    'company_id' => Auth::user()->company_id,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                ]
            );
            if($query){
                return response()->json(['data' => 'Address saved', 'status' => '200'], 200);
            }
        }catch (\Exception $e){
            return response()->json(['data' => 'Please complete the form', 'status' => '400'], 400);
        }

    }

    public function getOrderAddress($id){
        $address = ShippingAddress::where('id', $id)->first();
        return response()->json(['data' => $address, 'status' => 'complete'], 200);
    }

    public function updateorderaddress(Request $request, $id){
        $messages = [
            'phone.numeric' => 'Phone number must be only numbers',
            'city_id.required' => 'Please select a city',
            'state_id.required' => 'Please select a state',
        ];

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|regex:/[0-9]{9}/|bail',
            'email' => 'required|min:5|max:255|email|bail',
            'lastname' => 'required|bail',
            'firstname' => 'required|bail',
            'address' => 'required|bail',
            'state_id' => 'required|bail',
            'city_id' => 'required|bail',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first(), 'status' => 'validation'], 200);
        }

        if (strlen($request->phone) > 11 || strlen($request->phone) < 10) {
            return response()->json(['message' => 'Phone number must be between 10 and 11 digits', 'status' => 'validation'], 200);
        }

        $data = null;
        if(!$request->has('city_id')){
            $data = [
                'user_id' => Auth::user()->id,
                'company_id' => Auth::user()->company_id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'state_id' => $request->state_id
            ];
        }else if($request->has('city_id'))
        {
            $data = [
                'user_id' => Auth::user()->id,
                'company_id' => Auth::user()->company_id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id
            ];
        }
        try {
            $query = ShippingAddress::where('id', $id)
                ->update(
                    $data
                );

            if($query){
                return response()->json(['data' => 'Address updated', 'status' => 'complete'], 200);
            }
        }catch (\Exception $e){
            return response()->json(['data' => $e->getMessage(), 'status' => 'fail'], 400);
        }

    }

    public function deleteorderaddress($id){
        $query = ShippingAddress::destroy($id);
        if($query){
            return response()->json(['data' => 'Address Deleted', 'status' => 'complete'], 200);
        }
        return response()->json(['data' => 'Failed to delete Address', 'status' => 'fail'], 400);
    }
}
