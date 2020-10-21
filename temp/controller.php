<?php
require_once "demoDB.php";
//goi 1 view & 1 model rieng
insert();

function insert(){
    $c = new DB();
    // insert row
    $c->sqlInsertPreparePDO('sinhvien',['hoten','number','sothich'],['insertPDO',123,'ok roi nhe']);
    $c->closeDPO();
}

function update(){
    $c = new DB();
    // update col
    $arCol = array("hoten","number");
    $arColVal = array('"xxx"', '111');
    $arSetVal = array($arCol[0]=>$arColVal[0], $arCol[1]=>$arColVal[1] );
    $arCon = array('id','sothich');
    $arConVal = array('2','"A"');
    $arWheCondition = array( $arCon[0] => $arConVal[0], $arCon[1] => $arConVal[1] );
    $c->sqlUpd_PDO('sinhvien',$arSetVal,$arWheCondition);
    $c->closeDPO();
}

function delete(){
    $c = new DB();
    $c->connectByPDO('mvc_crud_tinypc');
    // exx for dell sql
    $arrCon = array('AND','OR');
    $arrThuoctinh = array( 'id', 'hoten' );
    $arrTypeOfCompare = array('>','<','=');
    $arrValToCompare = array('4','"Thanh"');
    $arrArCon = array(
        $arrThuoctinh[0] => [ $arrCon[0] => [ $arrTypeOfCompare[2] , $arrValToCompare[0] ] ],
        $arrThuoctinh[1] => [ $arrCon[0] => [ $arrTypeOfCompare[2] , $arrValToCompare[1] ] ]
    );
   //print_r($arrArCon);
    $c->sqlDel_PDO('sinhvien',$arrArCon);
    $c->closeDPO();
}

function select(){
    $c = new DB();
    $c->connectByPDO('mvc_crud_tinypc');
    // select 
    $arWhat = array('*');
    $arWhat2 = array('hoten','sothich');
    $arrPropertiy = array('id', 'id');
    $arrRelation = array('>','<=');
    $arrValue = array('6', '10');
    $arrQH = array('AND','AND');
    $arWheCondition = [ [ $arrPropertiy[0], $arrValue[0], $arrRelation[0], $arrQH[0] ] ,
                    [ $arrPropertiy[1], $arrValue[1], $arrRelation[1], $arrQH[1] ] ];
    $slec = $c->sqlSelectIn1TablePDO('sinhvien',$arWhat2,$arWheCondition);
    $c->closeDPO();
}

function createDB(){
    //create DB (name)
    //$arrVal = $c->sqlCreateDbPDO('zzzCreateDbPDO');
    //echo $arrVal['dbname'] ;
}
function createTB(){
    $c = new DB();
    // ex Create table(with assosArForm) in db
    $arrColName = array('id','fname','value');
    $arrType = array("INT(6)","VARCHAR(30)");
    $arrValue = array("UNSIGNED AUTO_INCREMENT PRIMARY KEY","NOT NULL");
    $arrAssocKey = array("type", "condition");
    $value = array(
        $arrColName[0] => [ $arrAssocKey[0]=>$arrType[0], $arrAssocKey[1]=>$arrValue[0] ],
        $arrColName[1] => [ $arrAssocKey[0]=>$arrType[1], $arrAssocKey[1]=>$arrValue[1] ],
        $arrColName[2] => [ $arrAssocKey[0]=>$arrType[1], $arrAssocKey[1]=>$arrValue[1] ]
    );
    //print_r($value);
    $c->connectByPDO('mvc_crud_tinypc');
    $c->sqlCreateTbPDO('zzzCreateDbPDO','newTB22',$value);
}