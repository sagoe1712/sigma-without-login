<?php
namespace App\Traits;

trait EmailTemplates {

    public function deliveryPickupReceipt($data, $address, $oderno, $total_cost, $delivery_cost, $grand_total, $country, $state, $city)
    {

//        var_dump($shipaddress);
//        dd();

        $shipaddress = $address != null ? $address : false;
        $date = date("Y/m/d");
        $table = "<table style=' width: 500px; border-bottom: 2px solid #000;' >";
        $table .= "<tr style='border-bottom: 2px solid #000;'>";
        $table .="<td style='padding: 20px 0px;'><p><b>Order No: </b> <span>{$oderno}</span></p><p><b>Date: </b> <span>{$date}</span></p></td>";
        $table .="</tr>";
        //$table .="<div style='width:100%;background-color: #000; height: 2px;'></div>";

        if($shipaddress){


            $table .= "<tr>";
            $table .= "<td colspan='5' style='border-top: 2px solid #000;border-bottom: 1px solid #000; margin: 0px; padding: 10px  0px; margin-bottom: 10px'>";
            $table .= "<p><b>Delivery Recipient:</b>". $shipaddress->firstname. " " .$shipaddress->lastname."</p>";
            $table .= "<p style='padding-top: 10px;'><b>Delivery Address:</b>". $shipaddress->address.", ".ucwords(strtolower($city)).", ".ucwords(strtolower($state)).", ".ucwords(strtolower($country))."</p>";

            $table .= "</tr>";
        }
        $table .= "<tr style='border-bottom: 1px solid #000'>";
        $table .= "<td colspan='4' style='border-bottom: 1px solid #000; padding: 10px  0px;'><b>Item Description</b></td>";
        $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #000; padding: 10px  0px;'><b>Price</b></td>";
        $table .= "</tr>";
        foreach ($data as $item) {
            if($item->delivery_type == 2) {
                $table .= "<tr>";
                $table .= "<td colspan='4' style='border-bottom: 1px solid #ccc;'>";
                $table .= "<p style='padding-top: 10px;'><b>Delivery Type: </b><span style='margin-right: 5px;'>" . $item->delivery_type_name . "</span></p>";

                $table .= "<p style='padding-top: 2px;'>" . $item->name. " ";
                if(isset($item->remark)){
                    $table .= "( " . $item->remark . ")";
                }
                $table .= "</p>";
                $table .= "<p style='padding-bottom: 10px;'><b>Qty: </b><span style='margin-right: 5px;'>" . $item->quantity . "</span><b>Voucher: </b><span style='margin-right: 5px;'>" . $item->voucher . "</span></p>";

                $table .= "</td>";
                $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #ccc;'><p>{$item->price}</p></td>";
                $table .= "</tr>";
            }else if ($item->delivery_type == 1){
                $table .= "<tr>";
                $table .= "<td colspan='4' style='border-bottom: 1px solid #ccc;'>";
                $table .= "<p style='padding-top: 10px;'><b>Delivery Type: </b><span style='margin-right: 5px;'>" . $item->delivery_type_name . "</span></p>";
                $table .= "<p style='padding-top: 2px;'>" . $item->name. " ";
                if(isset($item->remark)){
                    $table .= "( " . $item->remark . ")";
                }
                $table .= "</p>";
                $table .= "<p><b>Qty: </b><span style='margin-right: 5px;'>" . $item->quantity . "</span><b>Voucher: </b><span style='margin-right: 5px;'>" . $item->voucher . "</span></p>";
                $table .= "<p style='padding-bottom: 10px;'><b>Pickup Location: </b>" . $item->pickup_location_name . "</p>";

                $table .= "</td>";
                $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #ccc;'><p>{$item->price}</p></td>";
                $table .= "</tr>";
            }
        }
        if($shipaddress) {
            $table .= " <tr>";
            $table .= "<td colspan='2'></td>";
            $table .= "<td style='text-align: right; padding: 10px 0px;'>Delivery Cost</td>";
            $table .= "<td style='text-align: right; padding: 10px 0px;' colspan='2'><b>{$delivery_cost}</b></td>";
            $table .= "</tr>";
        }

        $table .= " <tr>";
        $table .= "<td colspan='2'></td>";
        $table .= "<td style='text-align: right; padding: 10px 0px;'>Sub Total</td>";
        $table .= "<td style='text-align: right; padding: 10px 0px;' colspan='2'><b>{$total_cost}</b></td>";
        $table .= "</tr>";

        $table .= " <tr style='border-bottom: 2px solid #000;'>";
        $table .= "<td colspan='2'></td>";
        $table .= "<td style='text-align: right; padding: 10px 0px;'><b>Grand Total</b></td>";
        $table .= "<td style='text-align: right; padding: 10px 0px;' colspan='2'><b>{$grand_total}</b></td>";
        $table .= "</tr>";

        $table .= "</table>";
        return $table;
    }


    public function billsReceipt($data, $oderno, $virtual_price)
    {
        $date = date("Y/m/d");
        $table = "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        $table .= "<tr style='border-bottom: 2px solid #000;'>";
        $table .="<td style='padding: 10px 0px 20px'><p><b>Order No: </b> <span>{$oderno}</span></p><p><b>Date: </b> <span>{$date}</span></p></td>";
        $table .="</tr>";
        $table .="<h3 style='padding-top: 20px; border-top: 2px solid #000;'>Airtime & Bills Redemption</h3>";
        $table .= "<tr style='border-bottom: 1px solid #000'>";
        $table .= "<td colspan='4' style='border-bottom: 1px solid #000; padding: 10px  0px;'><b>Item Description</b></td>";
        $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #000; padding: 10px  0px;'><b>Price</b></td>";
        $table .= "</tr>";
        foreach ($data as $item) {
                $table .= "<tr>";
                $table .= "<td colspan='4' style='border-bottom: 1px solid #ccc;'>";
                $table .= "<h3 style='padding-top: 10px;'>".$item->name."</h3>";
                $table .= "<p style='padding-bottom: 10px;'><b>Qty: </b><span style='margin-right: 5px;'>" . $item->quantity . "</span><b>Voucher: </b><span style='margin-right: 5px;'>" . $item->voucher . "</span></p>";
                $table .= "<p style='padding-bottom: 10px;'><b>Beneficiary: </b><span style='margin-right: 5px;'>" . $item->beneficiary . "</span></p>";
                $table .= "</td>";
                $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #ccc;'><p>{$item->price}</p></td>";
                $table .= "</tr>";
        }

        $table .= " <tr>";
        $table .= "<td colspan='2' style='border-bottom: 2px solid #000;'></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;border-bottom: 2px solid #000;'><b>Grand Total</b></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;border-bottom: 2px solid #000;' colspan='2'><b>{$virtual_price}</b></td>";
        $table .= "</tr>";

        $table .= "</table>";
        return $table;
    }

    public function experienceReceipt($data, $oderno, $grand_total, $booking_id, $booking_type, $supplier_name, $supplier_email, $supplier_phone, $country, $city, $address, $additional_info){
        $date = date("Y/m/d");
        $table ="";
        //$table = "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        //$table .= "<tr style='border-bottom: 2px solid #000;'>";
//        $table .="<td style='padding: 10px 0px 20px'><h4>Experience Redemption</h4>
//        <p><b>Order No: </b> <span>{$oderno}</span></p>
//        <p><b>Booking ID: </b> <span>{$booking_id}</span></p>
//        <p><b>Date: </b> <span>{$date}</span></p></td>";
//        $table .="</tr></table>";
        $table .= "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        $table .="<h4>Booking details</h4>";
        foreach ($data as $item) {
            $table .= "<tr>";
            $table .= "<td style='border-bottom: 1px solid #ccc;'>";
            $table .= "<h4 style='padding-top: 10px;'>".$item->name."</h4>";
            $table .= "<p style='padding-bottom: 10px;'><b>Cost: </b><span style='margin-right: 5px;'>" . $item->price. "</span></p>";
            $table .= "<p style='padding-bottom: 10px;'><b>Beneficiary: </b><span style='margin-right: 5px;'>" . $item->beneficiary . "</span></p>";
            $table .= "<p style='padding-bottom: 10px;'><b>Booking Session: </b><span style='margin-right: 5px;'>" .$item->session_start  . " - " .$item->session_end . "</span></p>";
            $table .= "<p style='padding-bottom: 10px;'><b>Type: </b><span style='margin-right: 5px;'>" .$booking_type ."</span></p>";
            $table .= "<p style='padding-bottom: 10px;'><b>Booking ID: </b><span style='margin-right: 5px;'>" .$booking_id ."</span></p>";
            $table .= "</td>";
            $table .= "</tr>";
        }

        $table .="</table>";
        $table .= "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        $table .="<h4>Experience details</h4>";
        foreach ($data as $item) {
            $table .= "<tr>";
            $table .= "<td style='border-bottom: 1px solid #ccc; padding: 10px 0px;'>Experience name</td>";
            $table .= "<td style='border-bottom: 1px solid #ccc; padding: 10px 0px;'>";
            $table .= "<p>".$item->name."</p>";
            $table .= "</td>";
            $table .= "</tr>";
            $table .= "<tr>";
            $table .= "<td style='border-bottom: 1px solid #ccc; padding: 10px 0px;'>Location</td>";
            $table .= "<td style='border-bottom: 1px solid #ccc; padding: 10px 0px;'>";
            $table .= "<p>Address: ".$address."</p>";
            $table .= "<p style='padding-top: 10px;'>City: ".$city."</p>";
            $table .= "<p style='padding-top: 10px;'>Country: ".$country."</p>";
            $table .= "</td>";
            $table .= "</tr>";
            $table .= "<tr>";
            $table .= "<td style='border-bottom: 1px solid #ccc; padding: 10px 0px;'>Organizer</td>";
            $table .= "<td style='border-bottom: 1px solid #ccc; padding: 10px 0px;'>";
            $table .= "<p>Name: ".$supplier_name."</p>";
            $table .= "<p style='padding-top: 10px;'>Email: ".$supplier_email."</p>";
            $table .= "<p style='padding-top: 10px;'>Phone: ".$supplier_phone."</p>";
            $table .= "</td>";
            $table .= "</tr>";
        }
        $table .="</table>";
        $table .= "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        $table .= "<tr>";
        $table .= "<td colspan='2' style='padding: 10px 0px;'>";
        $table .="<h4>Additional Information</h4>";
        $table .= "</td>";
        $table .= "</tr>";
        foreach ($additional_info as $info) {
            $table .= "<tr>";
            $table .= "<td style='border-bottom: 1px solid #ccc; padding: 10px 0px;'>".ucwords($info->label)."</td>";
            $table .= "<td style='border-bottom: 1px solid #ccc; padding: 10px 0px;'>";
            $table .= "<p>".$info->value."</p>";
            $table .= "</td>";
            $table .= "</tr>";


        }

        $table .="</table>";
        $table .= "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        $table .= " <tr>";
        $table .= "<td style='text-align: right; padding: 30px 0px;'><b>Grand Total</b></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;'><b>{$grand_total}</b></td>";
        $table .= "</tr>";

        $table .= "</table>";
        return $table;
    }

    public function foodReceipt($data, $oderno, $price, $delivery_cost, $total_cost)
    {

        $date = date("Y/m/d");
        $table = "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        $table .= "<tr style='border-bottom: 2px solid #000;'>";
        $table .="<td style='padding: 10px 0px 20px'><p><b>Order No: </b> <span>{$oderno}</span></p><p><b>Date: </b> <span>{$date}</span></p></td>";
        $table .="</tr>";
        $table .="<h3 style='padding-top: 20px; border-top: 2px solid #000;'>Takeout Redemption</h3>";
        $table .= "<tr style='border-bottom: 1px solid #000'>";
        $table .= "<td colspan='8' style='border-bottom: 1px solid #000; padding: 10px  0px;'><b>Your Order</b></td>";
//        $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #000; padding: 10px  0px;'><b>Price</b></td>";
        $table .= "</tr>";
        foreach ($data as $item) {
            $table .= "<tr>";
            $table .= "<td colspan='8' style='border-bottom: 1px solid #ccc;'>";
            $table .= "<h3 style='padding-top: 10px;'>".ucwords($item->name)."</h3>";
            $table .= "<p style='padding-bottom: 10px;'><b>Delivery Address: </b><span style='margin-right: 5px;'>" . $item->address . "</span></p>";
            $table .= "<p style='padding-bottom: 10px;'><b>Delivery Recipient: </b><span style='margin-right: 5px;'>" . $item->full_name . "</span></p>";
            $table .= "<p style='padding-bottom: 10px;'><b>Recipient's No: </b><span style='margin-right: 5px;'>" . $item->beneficiary . "</span></p>";
            //$table .= "<p style='padding-bottom: 10px;'><b>Qty: </b><span style='margin-right: 5px;'>" . $item->quantity . "</span><b>Voucher: </b><span style='margin-right: 5px;'>" . $item->voucher . "</span></p>";
//            $table .= "<b>Your Order</b>";

            foreach($item->cart as $cart) {
                $table .= "<p>";
                $table .= $cart->name;
                $table .= " (Qty: ";
                $table .= $cart->qty;
                $table .= ")</p>";

            }


            $table .= "</td>";
//            $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #ccc;'><p>{$item->price}</p></td>";
            $table .= "</tr>";


        }



            $table .= " <tr>";
            $table .= "<td colspan='2'></td>";
            $table .= "<td style='text-align: right; padding: 10px 0px;'>Delivery Cost</td>";
            $table .= "<td style='text-align: right; padding: 10px 0px;' colspan='2'><b>{$delivery_cost}</b></td>";
            $table .= "</tr>";

        $table .= " <tr>";
        $table .= "<td colspan='2'></td>";
        $table .= "<td style='text-align: right; padding: 10px 0px;'>Sub Total</td>";
        $table .= "<td style='text-align: right; padding: 10px 0px;' colspan='2'><b>{$total_cost}</b></td>";
        $table .= "</tr>";


        $table .= " <tr>";
        $table .= "<td colspan='2'></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;'><b>Grand Total</b></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;' colspan='2'><b>".$price."</b></td>";
        $table .= "</tr>";

        $table .= "</table>";
        return $table;
    }

    public function cinemasReceipt($data, $oderno, $grand_total)
    {
        $date = date("Y/m/d");
        $table = "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        $table .= "<tr style='border-bottom: 2px solid #000;'>";
        $table .="<td style='padding: 10px 0px 20px'><h3>Cinemas Redemption</h3><p><b>Order No: </b> <span>{$oderno}</span></p><p><b>Date: </b> <span>{$date}</span></p></td>";
        $table .="</tr>";
        $table .= "<tr style='border-bottom: 1px solid #000'>";
        $table .= "<td colspan='4' style='border-bottom: 1px solid #000; padding: 10px  0px;'><b>Item Description</b></td>";
        $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #000; padding: 10px  0px;'><b>Price</b></td>";
        $table .= "</tr>";
        foreach ($data as $item) {
                $table .= "<tr >";
                $table .= "<td colspan='4' style='border-bottom: 1px solid #ccc;'>";
                $table .= "<h3 style='padding-top: 10px;'>".$item->name."</h3>";
            $table .= "<p style='padding-bottom: 10px;'><b>Show Time: </b><span style='margin-right: 5px;'>" . $item->show_time . "</span></p>";
                $table .= "<p style='padding-bottom: 10px;'><b>Ticket type: </b><span style='margin-right: 5px;'>".$item->type ."(". $item->quantity .")</span></p>";
                $table .= "<p style='padding-bottom: 10px;'><b>Beneficiary: </b><span style='margin-right: 5px;'>" . $item->beneficiary . "</span></p>";
                $table .= "</td>";
                $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #ccc;'><p>{$item->price}</p></td>";
                $table .= "</tr>";
        }

        $table .= " <tr>";
        $table .= "<td colspan='2'></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;'><b>Grand Total</b></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;' colspan='2'><b>{$grand_total}</b></td>";
        $table .= "</tr>";

        $table .= "</table>";
        return $table;
    }


    public function eventsReceipt($data, $oderno, $grand_total)
    {
        $date = date("Y/m/d");
        $table = "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        $table .= "<tr style='border-bottom: 2px solid #000;'>";
        $table .="<td style='padding: 10px 0px 20px'><h3>Events Redemption</h3><p><b>Order No: </b> <span>{$oderno}</span></p><p><b>Date: </b> <span>{$date}</span></p></td>";
        $table .="</tr>";
        $table .= "<tr style='border-bottom: 1px solid #000'>";
        $table .= "<td colspan='4' style='border-bottom: 1px solid #000; padding: 10px  0px;'><b>Item Description</b></td>";
        $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #000; padding: 10px  0px;'><b>Price</b></td>";
        $table .= "</tr>";
        foreach ($data as $item) {
                $table .= "<tr>";
                $table .= "<td colspan='4' style='border-bottom: 1px solid #ccc;'>";
                $table .= "<h3 style='padding-top: 10px;'>".$item->name."</h3>";
            $table .= "<p style='padding-bottom: 10px;'><b>Show Time: </b><span style='margin-right: 5px;'>" . $item->show_time . "</span></p>";
                $table .= "<p style='padding-bottom: 10px;'><b>Ticket type: </b><span style='margin-right: 5px;'>".$item->type ."(". $item->quantity .")</span></p>";
                $table .= "<p style='padding-bottom: 10px;'><b>Beneficiary: </b><span style='margin-right: 5px;'>" . $item->beneficiary . "</span></p>";
                $table .= "</td>";
                $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #ccc;'><p>{$item->price}</p></td>";
                $table .= "</tr>";
        }

        $table .= " <tr>";
        $table .= "<td colspan='2'></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;'><b>Grand Total</b></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;' colspan='2'><b>{$grand_total}</b></td>";
        $table .= "</tr>";

        $table .= "</table>";
        return $table;
    }

    public function fuelReceipt($data, $oderno, $grand_total)
    {
        $date = date("Y/m/d");
        $table = "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        $table .= "<tr style='border-bottom: 2px solid #000;'>";
        $table .="<td style='padding: 10px 0px 20px'><h3>Fuel Voucher Redemption</h3><p><b>Order No: </b> <span>{$oderno}</span></p><p><b>Date: </b> <span>{$date}</span></p></td>";
        $table .="</tr>";
        $table .= "<tr style='border-bottom: 1px solid #000'>";
        $table .= "<td colspan='4' style='border-bottom: 1px solid #000; padding: 10px  0px;'><b>Item Description</b></td>";
        $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #000; padding: 10px  0px;'><b>Price</b></td>";
        $table .= "</tr>";
        foreach ($data as $item) {
                $table .= "<tr>";
                $table .= "<td colspan='4' style='border-bottom: 1px solid #ccc;'>";
                $table .= "<h3 style='padding-top: 10px;'>".$item->name."</h3>";
            $table .= "<p style='padding-bottom: 10px;'><b>Station: </b><span style='margin-right: 5px;'>" . $item->station . "</span></p>";
                $table .= "<p style='padding-bottom: 10px;'><b>Station Location: </b><span style='margin-right: 5px;'>".$item->address ."(". $item->quantity .")</span></p>";
                $table .= "<p style='padding-bottom: 10px;'><b>Beneficiary: </b><span style='margin-right: 5px;'>" . $item->beneficiary . "</span></p>";
                $table .= "</td>";
                $table .= "<td colspan='4' style='text-align: right; border-bottom: 1px solid #ccc;'><p>{$item->price}</p></td>";
                $table .= "</tr>";
        }

        $table .= " <tr>";
        $table .= "<td colspan='2'></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;'><b>Grand Total</b></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;' colspan='2'><b>{$grand_total}</b></td>";
        $table .= "</tr>";

        $table .= "</table>";
        return $table;
    }




    public function uberReceipt($data, $oderno, $grand_total, $vouchers)
    {
        $date = date("Y/m/d");
        $table = "<h4> Click the links below to activate your vouchers</h4>";
        foreach ($vouchers as $voucher){
            $table .= "<p>{$voucher}</p>";
        }
        $table .= "<table style=' width: 500px; border-bottom: 2px solid #000;'>";
        $table .= "<tr style='border-bottom: 2px solid #000;'>";
       $table .="<td style='padding: 10px 0px 20px'><h3>Uber Voucher Redemption</h3><p><b>Order No: </b> <span>{$oderno}</span></p><p><b>Date: </b> <span>{$date}</span></p></td>";
        $table .="</tr>";
        $table .= "<tr style='border-bottom: 1px solid #000; border-top: 1px solid #000;'>";
        $table .= "<td style='border-bottom: 1px solid #000; border-top: 1px solid #000; padding: 10px  0px;'><b>Item Description</b></td>";
        $table .= "<td colspan='4' style='text-align: right; border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 10px  0px;'><b>Price</b></td>";
        $table .= "</tr>";
        foreach ($data as $item) {
                $table .= "<tr>";
                $table .= "<td colspan='2' style='border-bottom: 1px solid #ccc;'>";
                $table .= "<h3 style='padding-top: 10px;'>".$item->name."</h3>";
                $table .= "</td>";
                $table .= "<td colspan='2' style='text-align: right; border-bottom: 1px solid #ccc;'><p>{$item->price}</p></td>";
                $table .= "</tr>";
        }

        $table .= " <tr>";
        $table .= "<td colspan='2'></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;'><b>Grand Total</b></td>";
        $table .= "<td style='text-align: right; padding: 30px 0px;' colspan='2'><b>{$grand_total}</b></td>";
        $table .= "</tr>";

        $table .= "</table>";
        return $table;
    }

}