<?php
$c = new DB();
$c->sqlInsertPreparePDO('sinhvien',['hoten','number','sothich'],['insertPDO',123,'ok roi nhe']);
$c->closeDpo();

class DB{
private $svrname = "localhost";
private $uname = "root";
private $pword = "";
private $dbname = "mvc_crud_tinypc";
private $conn = null;
private $e = "err_lagita";
private $arrColPreparePDO = null;

function __construct(){
    $this->conn = $this->connectByDpo($this->svrname,$this->dbname,$this->uname,$this->pword);
    //var_dump($this->conn);
}


function sqlInsertPreparePDO($table, $arrColName, $arrValue){
    $col = '(';
    $val = '(';
    $count = sizeof($arrColName);
    foreach ($arrColName as $key => $value) {
        $this->arrColPreparePDO[$key]=$value;
        $col.=$this->arrColPreparePDO[$key].",";
        $val.=":col".$key.",";
    }
    $col = substr_replace($col, "", -1);
    $val = substr_replace($val, "", -1);
    $col.=")";
    $val.=")";
    var_dump($col);
    var_dump($val);
    $conon = $this->conn;
    $stmt = $conon->prepare("INSERT INTO ".$table." ".
    $col." VALUES ".$val );
    var_dump($stmt);
    foreach ($arrValue as $key => $value) {
        var_dump($key);
        var_dump($value);
        $stmt->bindParam(':col'.$key,$this->arrColPreparePDO[$key]);
        $this->arrColPreparePDO[$key] = $arrValue[$key];
    }
    echo "x<br>";
    var_dump($stmt);
    $stmt->execute();
    
}

function connectByDpo($svrname,$dbname,$uname,$pword){
    try{
        $conn = new PDO("mysql:host=$svrname;dbname=$dbname",$uname,$pword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "connected";
        //var_dump($conn);
        return $conn;
    } catch(PDOException $err){
        echo "err tai day roi";
        $this->e = $err->getMessage();
        //echo "e=".$this->e;
    }
}

    // $x=$sql="CREATE DATABASE myDBPDO"; sql command line
    /*
    $sql = "CREATE TABLE MyGuests (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(30) NOT NULL,
  lastname VARCHAR(30) NOT NULL,
  email VARCHAR(50),
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
    $sql = "INSERT INTO MyGuests (firstname, lastname, email)
  VALUES ('John', 'Doe', 'john@example.com')";
    */

function closeDpo(){
    $this->conn = null;
}



}