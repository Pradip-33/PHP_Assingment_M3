Create multiple Traits and use it in to a single class?
<?php
trait logger{
    public function log($message){
        echo "<br> logging message : $message <br>";
    }
} 

trait filehandler{
    public function readfile($filename){
        echo "<br> readding file : $filename <br>";
    }
    public function writefile($filename,$content){
        echo"<br> writing file : $filename with $content <br>";
    }
}

trait DataParser {
    public function parseData($data) {
        echo "<br> Parsing data : $data<br>";
    }
}

class app{
    use logger,filehandler,DataParser;
    public function run(){
        $this->log("Application Started");
        $this->readFile("data.txt");
        $this->writeFile("data.txt", "Sample content");
        $this->parseData("Sample data");
        $this->log("Application finished");
    }
}
$app = new App();
$app->run();
?>