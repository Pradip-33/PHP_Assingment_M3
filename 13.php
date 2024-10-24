/ Write program for Static Keyword in PHP
<?php
class Calculator {

    public static $count = 0;


    public static function add($a, $b) {
        self::$count++; 
        return $a + $b;
    }

    public static function getCount() {
        return self::$count;
    }
}


echo "<br>Sum of 10 and 20: " . Calculator::add(10, 20) . "<br>";
echo "Sum of 15 and 25: " . Calculator::add(15, 25) . "<br>";


echo "Number of operations performed: " . Calculator::getCount() . "<br>";
?>