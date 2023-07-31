<?php

function getProduct ($int_1, $int_2) {

    $total = 0;

    for ($x = 1; $x <= $int_2; $x++) {

        $total += $int_1;

        if ($int_1 < 0 & $int_2 < 0) {
            $total = $total;
        } else if ($int_1 < 0 & $int_2 >= 0 || $int_1 >= 0 &  $int_2 < 0) {
            $total = ($total - $total - $total);
        }


    }

    return $total;

}
