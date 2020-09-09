<?php

include './ClassPrimeYear.php';
use PrimeYear\PrimeYear;

if (isset($_POST['print']) && !empty($_POST['year']))
{
    $inputYear = $_POST['year'];

    $primeYearClass = new PrimeYear($inputYear);

    $checkPrimeYear = $primeYearClass->check_prime($inputYear);

    $primeyears = array();

    for($i=$inputYear; $i>=1; $i--){
        $primeyear = $primeYearClass->check_prime($i);
        if ($primeyear === 1 ){
            if (count($primeyears) < 30) {
                array_push($primeyears, $i);
            }
        }
    }

    $christmas = array(
        'month' => 12,
        'date' => 25
    );

    foreach ($primeyears as $year) {
        $calc =  $christmas['date'] .'-'. $christmas['month'] .'-'. $year;
        echo "<br>";
        echo date("l - Y-m-d", strtotime($calc))."<br>";  
    }
}

?>
