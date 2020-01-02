<?php
$database = new database();
$date = date('Y-m-d');
$fullDate = date('Y-m-d H:i:s');
$NewDate = date('Y-m-d', strtotime("+3 days"));
$customerId = $_SESSION['isloggedIn'];
$ordersAmount = $database->DBQuery('SELECT OrderID FROM orders ORDER BY OrderID DESC LIMIT 1', []);
$newOrderId = ($ordersAmount[0]['OrderID'] + 1);
$queryArray = [$newOrderId, $customerId, $date, $NewDate];

$database->DBQuery('INSERT INTO orders (OrderID, CustomerID, SalespersonPersonID, PickedByPersonID, ContactPersonID, BackorderOrderID, OrderDate, ExpectedDeliveryDate, CustomerPurchaseOrderNumber, IsUndersupplyBackordered, Comments, DeliveryInstructions, InternalComments, PickingCompletedWhen, LastEditedBy, LastEditedWhen)
VALUES (?, ?, 0, NULL, 0, NULL, ?, ?, NULL, 0, NULL, NULL, NULL, now(), 0, now())', $queryArray);


for ($i = 0; $i < count($_SESSION['shoppingCart']); $i++) {
    if ($_SESSION['shoppingCart'][$i] !== 'nAn') {
        $shoppedID = $_SESSION['shoppingCart'][$i]['ItemID'];
        $shoppedAmount = $_SESSION['shoppingCart'][$i]['ItemAmount'];
        
        $itemsToSubtract = $database->DBQuery("SELECT StockItemID, QuantityOnHand FROM quantity_test WHERE stockitemid = ?", [$shoppedID]);

        $instock = $itemsToSubtract[0]['QuantityOnHand'];         
        $newinstock = $instock - $shoppedAmount;

        $database->DBQuery("UPDATE quantity_test SET QuantityOnHand = ? WHERE StockItemID = ?", [$newinstock, $shoppedID]);
        
        //-------------- CODE OM DE ORDER IN DE DATABASE TE GOOIEN --------------=
        $stockitemcolumns = $database->DBQuery("SELECT StockItemName, OuterPackageID, RecommendedRetailPrice, TaxRate FROM stockitems WHERE StockItemID = ?", [$_SESSION['shoppingCart'][$i]['ItemID']]);

        $array = [$newOrderId, $shoppedID, $stockitemcolumns[0]['StockItemName'], $stockitemcolumns[0]['OuterPackageID'], $shoppedAmount,$stockitemcolumns[0]['RecommendedRetailPrice'], $stockitemcolumns[0]['TaxRate'], $shoppedAmount, $date, 7, $date];

        $updateDatabaseStock = $database->DBQuery("INSERT INTO orderlines (OrderID, StockItemID, Description, PackageTypeID, Quantity, UnitPrice, TaxRate, PickedQuantity, PickingCompletedWhen, LastEditedBy, LastEditedWhen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $array);
    }
}

$database->closeConnection();