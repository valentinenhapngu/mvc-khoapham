<?php

class DB{
// classDB prooperties
    private $svrname = "localhost";
    private $uname = "root";
    private $pword = "";
    private $dbname = "mvc_crud_tinypc";
    private $conn = null;
    private $e = "err_lagita";
    private $arrColPreparePDO = null;

function __construct(){
    //$this->conn = $this->connectByPDO($this->svrname,$this->dbname,$this->uname,$this->pword);
    //var_dump($this->conn);
}
function sqlUpd_PDO($tbName,$arSetVal,$arWheCondition){
    try{  
    $sql = "UPDATE $tbName SET ";
    //lastname='Doe' WHERE id=2";
    $tempCol = "";
    foreach ($arSetVal as $key => $value) {
        $tempCol.=$key."=".$value.",";
    }
    var_dump($tempCol);
    $sql .= trim(substr_replace($tempCol,"",-1))." WHERE ";

    $tempCon = "";
    foreach ($arWheCondition as $key => $value) {
        $tempCon.=$key."=".$value." AND ";
    }
    
    $sql .= trim(substr_replace($tempCon,"",-4));
    print_r($sql);
    // Prepare statement
    $stmt = $this->conn->prepare($sql); /// bo qua cai $conn = $this->conn; :)))
    // execute the query
    $stmt->execute();
    // echo a message to say the UPDATE succeeded
    echo $stmt->rowCount() . " records UPDATED successfully";
    } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
    }
}
function sqlDel_PDO($tbName,$assocArCondition){
    try{
    $conn = $this->conn;
    $sql = "DELETE FROM $tbName WHERE ";
    $tempSql = "";
    foreach ($assocArCondition as $ky => $val) {
        $thuoctinh =$ky;
        foreach ($val as $key => $value) {
            $tempSql.=$key." ".$thuoctinh.$value[0].$value[1]." ";
        }
    }
    $sql .= substr($tempSql, 3); // input dau tien mac dinh duoc nhan ( co gia tri and )
    $sql = trim($sql);
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Record deleted successfully";
    } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
    }
}
function sqlCreateTbPDO($tbName,$associateArrKeyValue){
    try{
    $conn = $this->conn;
    // sql to create table
    $sql = "CREATE TABLE $tbName (";

    foreach ($associateArrKeyValue as $key => $value) {
        $sql.=$key." ".$value['type']." ".$value['condition'].",";
    }

    $sql.="reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
  
    echo $sql;
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table $tbName from DB $this->dbName created successfully";
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }

}
function sqlCreateDbPDO($dbname){
    $arr = null;
    try {
        $conn = new PDO("mysql:host=$this->svrname", $this->uname,$this->pword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE $dbname";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Database created successfully<br>";
        $arr['dbname'] = $dbname;
        $arr['conn'] = $conn;
      //var_dump($arr);
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
      return $arr;
      //$conn = null;
}
function sqlInsertPreparePDO($table, $arrColName, $arrValue){
    $col = '(';
    $val = '(';
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
    //var_dump($stmt);
    $stmt->execute();
    
}
function sqlSelectIn1TablePDO($tbName,$arWhat,$arWhere){
    try{
    $conn = $this->conn;
    $sql = "SELECT ";
    $tmpsql="";
    foreach ($arWhat as $value) {
        $tmpsql.=$value.",";
    }
    $sql.= substr_replace($tmpsql,"", -1);

    $sql .=" FROM $tbName WHERE ";
    print_r($arWhere);
    $tmpsql="";
    foreach ($arWhere as $value) {
            $tmpsql.="$value[3] $value[0] $value[2] $value[1] ";
    }
    //echo $tmpsql;
    $sql.= trim(substr($tmpsql, 3));
    echo $sql.PHP_EOL;

    $stmt = $conn->prepare($sql); 
    $stmt->execute();
    $data = $stmt->fetchAll(); 

    return $data;
    }catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }

}
function connectByPDO($dbname){
    try{
        $conn = new PDO("mysql:host=$this->svrname;dbname=$dbname",$this->uname,$this->pword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "connected to $this->svrname -> $dbname".PHP_EOL;
        //var_dump($conn);
        $this->conn = $conn;
    } catch(PDOException $err){
        echo "err tai day roi";
        $this->e = $err->getMessage();
        //echo "e=".$this->e;
    }
}
function closeDPO(){
    echo "disconnected";
    $this->conn = null;
}



}