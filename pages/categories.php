<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * Shows al items in categorie
 */


class cat {
    protected $options = [
        "limit",
        "colorid",
        "minprice",
        "maxprice",
        "size"
    ];
    
    private $defaultvalue;
    
    public function setFilter($size) {
        $this->defaultvalue = [
            25,
            "nAn",
            $size[0]['MIN(RecommendedRetailPrice)'],
            $size[0]['MAX(RecommendedRetailPrice)'],
            "nAn"
        ];
    }
    
    public function checkGetParams() {
        if (!isset($_GET['catid']) || !isset($_GET['page'])){
            header('location: /home');
        }
    }
    
    public function checkFilterSession() {    
        for ($i=0; $i < count($this->options); $i++) {
            if (!isset($_SESSION[$this->options[$i]])) {
                $_SESSION[$this->options[$i]] = $this->defaultvalue[$i];
            }
        }
    }
    
    public function clearSession() {
        for ($i=0; $i < count($this->options); $i++) {
            unset($_SESSION[$this->options[$i]]);
            if ($i == (count($this->options)-1)) {
                header("Refresh:0");
            }
        }
    }
    
    public function getOptions() {
        return $this->options;
    }
    
    public function getDefaultnr($param) {
        for ($i=0; $i < count($this->options); $i++) {
            if ($param == $this->options[$i]) {
                return $this->defaultvalue[$i];
            }
        }
    }
}


$function = new cat();
$database = new database();

$function->checkGetParams();

$sizePriceStockItems = $database->DBQuery('SELECT MIN(RecommendedRetailPrice), MAX(RecommendedRetailPrice) FROM stockitems si JOIN stockitemstockgroups sisg ON si.StockItemID = sisg.StockItemID WHERE sisg.StockGroupID in (SELECT StockGroupID FROM stockgroups WHERE StockGroupID = ?)', [$_GET['catid']]);

$function->setFilter($sizePriceStockItems);

$function->checkFilterSession();

$cat = $_GET['catid'];
$page = $_GET['page'];
$limit = $_SESSION['limit'];
$colorId = $_SESSION['colorid'];
$minPrice = $_SESSION['minprice'];
$maxPrice = $_SESSION['maxprice'];
$size = $_SESSION['size'];


$sessionOptions = $function->getOptions();
$stockAllCategories = $database->DBQuery('SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON si.StockItemID = sisg.StockItemID WHERE sisg.StockGroupID in (SELECT StockGroupID FROM stockgroups WHERE StockGroupID = ?)', [$cat]);
$stockCategories = $database->DBQuery('SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON si.StockItemID = sisg.StockItemID WHERE sisg.StockGroupID in (SELECT StockGroupID FROM stockgroups WHERE StockGroupID = ?) LIMIT ?', [$cat, $limit]);


/*Pagination*/
$maxPages = ceil(count($stockAllCategories) / $limit);
$maxPages = 100;

if ($colorId !== $function->getDefaultnr('colorid')) {
    $getcolor = [];
    for ($i=0; $i < count($stockCategories); $i++) {
        if ($stockCategories[$i]['ColorID'] == $colorId) {
            array_push($getcolor, $stockCategories[$i]);
        }
    }
}

if ($minPrice !== $function->getDefaultnr('minprice') || $maxPrice !== $function->getDefaultnr('maxprice')) {
    $getPrice = [];
    for ($i=0; $i < count($stockCategories); $i++) {
        if ($stockCategories[$i]['RecommendedRetailPrice'] < $maxPrice && $stockCategories[$i]['RecommendedRetailPrice'] > $minPrice) {
            array_push($getPrice, $stockCategories[$i]);
        }
    }
    print_r(count($stockCategories));
    print('</br>');
    $stockCategories = $getPrice;
    print_r(count($stockCategories));
}

if ($size !== $function->getDefaultnr('size')) {
    $getSize = [];
    for ($i=0; $i < count($stockCategories); $i++) {
        if ($stockCategories[$i]['Size'] == $size) {
            array_push($getSize, $stockCategories[$i]);
        }
    }
    print_r(count($stockCategories));
    print('</br>');
    $stockCategories = $getSize;
    print_r(count($stockCategories));
}

for ($i=0; $i < count($stockCategories); $i++) { 
    print_r($stockCategories[$i]['StockItemName']);
    echo '</br>';
}

$pagemin = $page - 1;
$mpagemin = $maxPages - 1;
$mpageminmin = $maxPages - 2;
$mpageminminmin = $maxPages - 3;
$pageplus = $page + 1;
$pageplusplus = $page + 2;
$pageplusplusplus = $page + 3;

if($maxPages <= 1){
    echo 'Disabled';
}
elseif($maxPages >= 2){
    if($page <= 3){
    echo "<a href='http://kbs.local/categories?catid=3&page=1' class='button'>1</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/categories?catid=3&page=$pageplus' class='button'>$pageplus</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/categories?catid=3&page=$pageplusplus' class='button'>$pageplusplus</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/categories?catid=3&page=$pageplusplusplus' class='button'>$pageplusplusplus</a>";
    echo "</br>";
    echo "...";
    echo "<a href='http://kbs.local/categories?catid=3&page=$maxPages' class='button'>$maxPages</a>";
    }
    if ($page >= 4 AND $page <= $maxPages-2){
        echo "<a href='http://kbs.local/categories?catid=3&page=1' class='button'>1</a>";
        echo "...";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=3&page=$pagemin' class='button'>$pagemin</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=3&page=$page' class='button'>$page</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=3&page=$pageplus' class='button'>$pageplus</a>";
        echo "</br>";
        echo "...";
        echo "<a href='http://kbs.local/categories?catid=3&page=$maxPages' class='button'>$maxPages</a>";
    }
    if($page >= $maxPages - 3){
        echo "<a href='http://kbs.local/categories?catid=3&page=1' class='button'>1</a>";
        echo "...";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=3&page=$mpageminminmin' class='button'>$mpageminminmin</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=3&page=$mpageminmin' class='button'>$mpageminmin</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=3&page=$mpagemin' class='button'>$mpagemin</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=3&page=$maxPages' class='button'>$maxPages</a>";
    }
}


print_r(count($stockCategories));
$database->closeConnection();
