<?php
namespace App\Traits;

use Event;
use App\Events\TransactionSuccessful;

trait EventsTrigger {
    public function notifyTransactionSuccess($token, $email_payload, $type){
        Event::fire(new TransactionSuccessful($token, $email_payload, $type));
    }

    public function buildTable($data, $address, $oderno)
    {

        $shipaddress = $address != null ? $address : false;
        $date = date("Y/m/d");
        $table = "<table border='1' style='border-collapse: collapse; width: 500px; padding: 10px;' >";
        $table .= "<thead>";
        $table .= "<th></th>";
        $table .= "<th style='border-right: none; padding: 10px;'>Order No: {$oderno}</th>";
        $table .= "<th colspan='5' style='border-left: none; padding: 10px;'></th>";
        $table .= "</thead>";
        $table .= "<tr>
        <td style='padding: 10px;'><b>Date</b></td>
        <td style='padding: 10px;'><b>Item Name</b></td>
        <td style='padding: 10px;'><b>Voucher</b></td>
        <td style='padding: 10px;'><b>Quantity</b></td>
        <td style='padding: 10px;'><b>Price</b></td>
        <td style='padding: 10px;'><b>Delivery Type</b></td>
        <td style='padding: 10px;'><b>Pickup Location</b></td>
        </tr>";
        foreach ($data as $item) {
            $table .= "<tr>";
            $table .= "<td>".$date."</td>";
            $table .= "<td>".$item->name."</td>";
            $table .= "<td>".$item->voucher."</td>";
            $table .= "<td>".$item->quantity."</td>";
            $table .= "<td>".$item->virtual_price."</td>";
            $table .= "<td>".$item->delivery_type_name."</td>";
            $table .= "<td>".$item->pickup_location_name."</td>";
            $table .= "</tr>";
        }
        $table .= " <tr>";
        if($shipaddress){
            $table .= "<td colspan='7' style='border-bottom: none; padding: 10px'><b>Delivery Address</b></td>";
        }
        $table .= "</tr>";

    if($shipaddress){
        $table .= "<tr>";
        $table .= "<td colspan='7' style='border-top: none; padding: 10px'>{$address->address}</td>";
    $table .= "</tr>";
    }

    $table .= "</table>";
    return $table;
    }
}