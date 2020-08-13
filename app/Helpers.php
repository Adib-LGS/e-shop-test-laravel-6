<?php

function getPrice($decimalsPrice)
{
    //dd(floatval($price));
    $price = floatval($decimalsPrice) / 100;

    return number_format($price, 2, '.' , ',') . '$';
}