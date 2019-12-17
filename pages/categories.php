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
$offset = $page * $limit - $limit;
$colorId = $_SESSION['colorid'];
$minPrice = $_SESSION['minprice'];
$maxPrice = $_SESSION['maxprice'];
$size = $_SESSION['size'];


$sessionOptions = $function->getOptions();
$stockAllCategories = $database->DBQuery('SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON si.StockItemID = sisg.StockItemID WHERE sisg.StockGroupID in (SELECT StockGroupID FROM stockgroups WHERE StockGroupID = ?)', [$cat]);
$stockCategories = $database->DBQuery('SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON si.StockItemID = sisg.StockItemID WHERE sisg.StockGroupID in (SELECT StockGroupID FROM stockgroups WHERE StockGroupID = ?) LIMIT ? OFFSET ?', [$cat, $limit, $offset]);




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
/*Pagination*/
$maxPages = ceil(count($stockAllCategories) / $limit);
$minPages = 1;
$pagemin = $page - 1;
$pageminTwo = $page - 2;
$pageplusTwo = $page + 2;
$mpagemin = $maxPages - 1;
$mpageminTwo = $maxPages - 2;
$mpageminThree = $maxPages - 3;
$pageplus = $page + 1;
$mpageplus = $minPages + 1;
$mpageplusTwo = $minPages + 2;
$mpageplusThree = $minPages + 3;

if($maxPages <= $minPages){
    $page = 1;
    echo 'Disabled';
}
elseif($page < 1){
    header('Location: /home');
}
elseif($page > $maxPages){
    header('Location: /home');
}
elseif($maxPages >= 2 AND $maxPages <= 4){
    for($i = 1; $i <= $maxPages; $i++){
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$i' class='button'>$i</a>";
        echo "</br>";
    }
    
}
elseif($maxPages > 4){
    if($page <= 3){
    echo "<a href='http://kbs.local/categories?catid=$cat&page=1' class='button'>1</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpageplus' class='button'>$mpageplus</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpageplusTwo' class='button'>$mpageplusTwo</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpageplusThree' class='button'>$mpageplusThree</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/categories?catid=$cat&page=$pageplusTwo' class='button'>...</a>";
    echo "<a href='http://kbs.local/categories?catid=$cat&page=$maxPages' class='button'>$maxPages</a>";
    }
    if ($page >= 4 AND $page <= $maxPages - 3){
        echo "<a href='http://kbs.local/categories?catid=$cat&page=1' class='button'>1</a>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$pageminTwo' class='button'>...</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$pagemin' class='button'>$pagemin</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$page' class='button'>$page</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$pageplus' class='button'>$pageplus</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$pageplusTwo' class='button'>...</a>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$maxPages' class='button'>$maxPages</a>";
    }
    if($page >= $maxPages - 2){
        echo "<a href='http://kbs.local/categories?catid=$cat&page=1' class='button'>1</a>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$pageminTwo' class='button'>...</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpageminThree' class='button'>$mpageminThree</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpageminTwo' class='button'>$mpageminTwo</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpagemin' class='button'>$mpagemin</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/categories?catid=$cat&page=$maxPages' class='button'>$maxPages</a>";
    }
}


print('<div class="row container">');
for ($i=0; $i < count($stockCategories); $i++) {
    $getimg = $database->DBQuery('SELECT * FROM picture WHERE StockItemID = ? AND isPrimary IS NOT NULL', [$stockCategories[$i]['StockItemID']]);
    if ($getimg == '0 results found!') {
        $img = '/public/img/product/no-image.png';
    }
    else {
        $img = $getimg[0]['ImagePath'];
    }

    showItem($stockCategories[$i]['StockItemID'], $img, $stockCategories[$i]['StockItemName'], '', $stockCategories[$i]['SearchDetails'], $stockCategories[$i]['RecommendedRetailPrice']);
}
print('</div>');
$database->closeConnection();
