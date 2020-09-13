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
        // echo date("l - Y-m-d", strtotime($dateTime))."<br>";  
        $onlyName = date("l", strtotime($dateTime));
        $onlyYear = date("Y", strtotime($dateTime));

        $conn = mysqli_connect("localhost", "homestead", "secret", "laravel_db");
        $selectUniqueYearsSql = "SELECT * FROM prime_years WHERE year='$onlyYear'";
        $query = mysqli_query($conn, $selectUniqueYearsSql);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        $fromdb = (!empty($result)) ? ($result[0]['year']) : '';

        if (!$fromdb == $onlyYear) {
            $string_to_encrypt="$onlyName";
            $password="password";
            $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
            $insertSql = "INSERT INTO prime_years (year, day) 
            VALUES($onlyYear, '$encrypted_string')";
            $query = mysqli_query($conn, $insertSql);
        } 
 
        mysqli_close($conn);
    }
        

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        // echo 'Connected successfully';
    
    $conn = mysqli_connect("localhost", "homestead", "secret", "laravel_db");
    $selectsql = "SELECT * FROM prime_years";
    $selectQuery = mysqli_query($conn, $selectsql);
    $result = mysqli_fetch_all($selectQuery, MYSQLI_ASSOC);

    echo "<table>";
    echo "
        <tr>
            <th>day</th>
            <th>year</th>
        </tr>
    ";

    foreach ($result as $x) {
        $hashedDays = $x['day'];
        $password="password";
        $decrypted_day=openssl_decrypt($hashedDays,"AES-128-ECB",$password);
        $year = $x['year'];

        // var_dump($decrypted_day);
        // var_dump($year);
        // $decrypted_day . ", " . $year . "<br>";

        echo "
            <tr>
                <td>" . $decrypted_day . "</td>
                <td>" . $year . "</td>
            </tr>
        ";
    }

    echo "</table>";
    mysqli_close($conn);

}
?>




<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;    
}
</style>