<?php

namespace PrimeYear;

class PrimeYear {
    public $year;

    function __construct($year)
    {
        $this->year = $year;
    }


    public function check_prime($year)
    {
        if ($year == 1)
        return 0;
        for ($i = 2; $i <= $year/2; $i++)
        {
            if ($year % $i == 0)
            return 0;
        }
        return 1;
    }
    
}
?>