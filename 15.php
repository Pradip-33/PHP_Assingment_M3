Write PHP Script of Object Iteration?<br>
<?php
class person{
    public $name,$age,$email;
    public function __construct( $name,$age,$email){
        $this->name = $name;
        $this->age = $age;
        $this->email = $email;
    }
}
$person = new person("pradip suthar",21,"pfsuthar33@gmail.com");
foreach($person as $key => $value){
    echo "<br>$key : $value ";}
?>