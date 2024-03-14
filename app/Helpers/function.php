<?php

function perFindValue($a = 0, $b = 0) {
    if ($a > 0 || $b > 0) {
        return round((($a * 100) / ($a + $b)), 2);
    }
    return 0;
}

function perFindAvg($a = 0, $b = 0) {
    if ($b > 0) {
        return round(((($a - $b) / $b) * 100), 2);
    } elseif ($a > 0) {
        return 100;
    } else {
        return 0;
    }
}

function numberFormat($a, $precise = 2) {
    if ($a != 0) {
        if ($a >= 10000000)
            return convertCrtoDecimal($a);
        elseif ($a >= 100000)
            return convertCrtoDecimal($a);
        else
            return convertCrtoDecimal($a);
    }
    return 0;
}

function moneyFormatIndia($num) {
    $explrestunits = "";
    if (strlen($num) > 3) {
        $lastthree = substr($num, strlen($num) - 3, strlen($num));
        $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for ($i = 0; $i < sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if ($i == 0) {
                $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i] . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

function arrNumberFormat($a) {
    if (!is_null($a)) {
        return array_map(function($number) {
            return number_format($number, 1);
        }, $a);
    }
    return [];
}

function getPreviousTitle($date) {
    if ($date == 'today') {
        return "Yesterday";
    } else if ($date == 'yesterday') {
        return "Day after Yesterday";
    } elseif ($date == 'this_week') {
        return "Previous Week";
    } elseif ($date == 'last_month') {
        return "Last of last Month";
    } elseif ($date == '3_months') {
        return "Previous 3 Months";
    } elseif ($date == '6_months') {
        return "Previous 6 Month";
    } elseif ($date == 'this_year') {
        return "Previous Year";
    } elseif ($date == 'last_year') {
        return "Last of last Year";
    } else {
        return "N/A";
    }
}

function number_format_short($n, $precision = 1) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }

    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }

    return $n_format . $suffix;
}

function convertCrtoDecimal($amount) {
    $Arraycheck = array("4" => "K", "5" => "K", "6" => "Lacs", "7" => "Lacs", "8" => "Cr", "9" => "Cr");
    // define decimal values
    $numberLength = strlen($amount); //count the length of numbers
    if ($numberLength > 3) {
        foreach ($Arraycheck as $Lengthnum => $unitval) {
            if ($numberLength == $Lengthnum) {
                if ($Lengthnum % 2 == 0) {
                    $RanNumber = substr($amount, 1, 2);
                    $NmckGtZer = ($RanNumber[0] + $RanNumber[1]);
                    if ($NmckGtZer < 1) {
                        $RanNumber = "0";
                    } else {
                        if ($RanNumber[1] == 0) {
                            $RanNumber[1] = "0";
                        }
                    }
                    $amount = substr($amount, 0, $numberLength - $Lengthnum + 1) . "." . $RanNumber . " $unitval ";
                } else {
                    $RanNumber = substr($amount, 2, 2);
                    $NmckGtZer = ($RanNumber[0] + $RanNumber[1]);
                    if ($NmckGtZer < 1) {
                        $RanNumber = 0;
                    } else {
                        if ($RanNumber[1] == 0) {
                            $RanNumber[1] = "0";
                        }
                    }
                    $amount = substr($amount, 0, $numberLength - $Lengthnum + 2) . "." . $RanNumber . " $unitval";
                }
            }
        }
    } else {
        $amount . "Rs";
    }
    return $amount;
}

?>
