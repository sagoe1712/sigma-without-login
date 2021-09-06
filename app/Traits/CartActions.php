<?php
namespace App\Traits;
use App\Cart;
use Illuminate\Support\Facades\Auth;
trait CartActions{
    private $cartstatus = [
        'cancelled' => 0,
        'pending' => 1,
        'shipped' => 2,
        'delivered' => 3,
        'processing' => 4,
        'expired' => 5,
        'noncart' => 6,
        'deleted' => 7
    ];

    public function postToCart($price, $name, $signature, $qty){
        try {
            $addtocart = Cart::create([
                'user_id' => Auth::user()->id,
                'company_id' => Auth::user()->company_id,
                'name' => $name,
                'delivery_type' => 5,
                'delivery_location' => null,
                'qty' => $qty,
                'price' => $price,
                'signature' => $signature,
                'combo' => null,
                'status' => $this->cartstatus['noncart']
            ]);
            if($addtocart){
                return $addtocart->id;
            }
            else{
                return false;
            }
        }catch (\Exception $e){
            throw new \Exception('Failed to add to Cart' .$e->getMessage());
        }
    }

    public function updateCart($ref_no, $voucher_code, $status="processing"){
        try {
            Cart::
            where('id', '=', $ref_no)
                ->where('user_id', '=', Auth::user()->id)
                ->where('company_id', '=', Auth::user()->company_id)
                ->update([
                    'status' => $this->cartstatus[$status],
                    'voucher' => $voucher_code
                ]);
            return true;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function deleteFromCart($cartItem){
        try {
            Cart::
            where('id', '=', $cartItem)
                ->delete();
            return true;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

}