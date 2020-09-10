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
        $dateTime =  $christmas['date'] .'-'. $christmas['month'] .'-'. $year;
        // echo "<br>";
        // echo date("l - Y-m-d", strtotime($dateTime))."<br>";  
        $onlyName = date("l", strtotime($dateTime));
        $onlyYear = date("Y", strtotime($dateTime));


        $conn = mysqli_connect("localhost", "homestead", "secret", "laravel_db");
        $sql = "SELECT * FROM prime_years WHERE year='$onlyYear'";
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        // var_dump($result);
        mysqli_close($conn);
        $conn = mysqli_connect("localhost", "homestead", "secret", "laravel_db");


        $fromdb = (!empty($result)) ? ($result[0]['year']) : '';

            if (!$fromdb == $onlyYear) {
                $insertsql = "INSERT INTO prime_years (year, day) 
                VALUES($onlyYear, '$onlyName')";
                $query = mysqli_query($conn, $insertsql);

            } 
 
        mysqli_close($conn);
        // header("Locaton: http://app.test/steets/index.php");
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            // echo 'Connected successfully';
    }
}
?>
