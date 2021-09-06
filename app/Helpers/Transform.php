<?php
function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}

function transform_product_price($price, $rate){
    if(is_decimal($price)){
        return number_format( ($price * $rate), 2, '.', ',');
    }else{
        return number_format($price * $rate);
    }
}
