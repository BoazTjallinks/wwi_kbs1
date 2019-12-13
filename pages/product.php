<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * View all products
 */

$database = new database();

/*
$ShowTemprature = $database->DBQuery('SELECT si.stockitemid, si.stockitemname, ischillerstock,  crt.ColdRoomTemperatureID, crt.temperature FROM stockitems AS si LEFT JOIN coldroomstockitems AS crsi ON si.stockitemid = crsi.stockitemid LEFT JOIN coldroomtemperatures AS crt ON crsi.ColdRoomTemperatureID = crt.ColdRoomTemperatureID WHERE IsChillerStock = ?',[1]);

 
for ($i=0; $i < count($ShowTemprature); $i++) { 
  if ($stockItemId == $ShowTemprature[$i]['StockItemId']) {
    if ($ShowTemprature[1]['ischillerstock'] == 1){
      print($ShowTemprature[$i]['temperature']. '°C' . " " . $ShowTemprature[$i]['stockitemname']); 
     }  
  }    
} 
*/
/*
if ($ShowTemprature[1]['ischillerstock'] == 1){
    print($ShowTemprature[1]['temperature']. '°C' . " " . $ShowTemprature[1]['stockitemname']); 
   }

*/
$database->closeConnection();
