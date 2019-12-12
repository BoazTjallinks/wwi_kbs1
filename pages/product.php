<?php 

$database = new database();


$ShowTemprature = $database->DBQuery('SELECT si.stockitemid, si.stockitemname, ischillerstock,  crt.ColdRoomTemperatureID, crt.temperature FROM stockitems AS si LEFT JOIN coldroomstockitems AS crsi ON si.stockitemid = crsi.stockitemid LEFT JOIN coldroomtemperatures AS crt ON crsi.ColdRoomTemperatureID = crt.ColdRoomTemperatureID WHERE IsChillerStock = ?',[1]);

If ($ShowTemprature['Chillerstock']=1){
    print($ShowTemprature['temprature']); 
    }


$database->closeConnection();