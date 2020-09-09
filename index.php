<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hi</title>
</head>
<body>
    <h1>Get days of the week for Christmas for the past 30 years!</h1>
    <form action="" method="POST">
        <label for="Enter year:"></label>
        <input type="number" name="year">
        <input type="submit" name="print" value="Get day!">
    </form>



<?php

    function check_prime($num)
    {
    if ($num == 1)
    return 0;
    for ($i = 2; $i <= $num/2; $i++)
    {
        if ($num % $i == 0)
        return 0;
    }
    return 1;
    }


    if (isset($_POST['print']) && $_POST['year'])
    {
        $inputYear = $_POST['year'];

        $checkPrimeYear = check_prime($inputYear);

        $primeyears = array();

        for($i=$inputYear; $i>=1; $i--){
            $primeyear = check_prime($i);
            if ($primeyear === 1 ){
                if (count($primeyears) < 30) {
                    array_push($primeyears, $i);
                    // echo $i. "<br>";

                }
            }
        }
    // echo count($primeyears);
    // print_r($primeyears);
    // echo implode(", ", $primeyears);  // dont need this
    }


    $christmas = array(
        'month' => 12,
        'date' => 25
    );

    foreach ($primeyears as $year) {
        // echo $year ."<br>";
        $calc =  $christmas['date'] .'-'. $christmas['month'] .'-'. $year;
        // echo $calc;
        echo "<br>";
        echo date("l - Y-m-d", strtotime($calc))."<br>";  
    }

?>
    
</body>
</html>