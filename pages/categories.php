<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * Shows al items in categorie
 */

// session_destroy();
class cat
{
    protected $options = [
        "limit",
        "colorid",
        "minprice",
        "maxprice",
        "size"
    ];
    
    private $defaultvalue;
    
    public function setFilter($size)
    {
        $this->defaultvalue = [
            25,
            "nAn",
            $size[0]['MIN(RecommendedRetailPrice)'],
            $size[0]['MAX(RecommendedRetailPrice)'],
            "nAn"
        ];
    }
    
    public function checkGetParams()
    {
        if (!isset($_GET['catid']) || !isset($_GET['page'])) {
            header('location: /home');
        }
    }
    
    public function checkFilterSession()
    {
        for ($i=0; $i < count($this->options); $i++) {
            if (!isset($_SESSION[$this->options[$i]])) {
                $_SESSION[$this->options[$i]] = $this->defaultvalue[$i];
            }
        }
    }
    
    public function clearSession()
    {
        for ($i=0; $i < count($this->options); $i++) {
            unset($_SESSION[$this->options[$i]]);
            if ($i == (count($this->options)-1)) {
                header("Refresh:0");
            }
        }
    }
    
    public function getOptions()
    {
        return $this->options;
    }
    
    public function getDefaultnr($param)
    {
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


if (isset($_POST['catupdater'])) {
    if ($_POST['catupdater'] == session_id()) {
        if (isset($_POST['colorid'])) {
            if (is_numeric($_POST['colorid'])) {
                $_SESSION['colorid'] = $_POST['colorid'];
                header('location: /categories?catid='.$_GET['catid'].'&page=1');
            }
        }

        if (isset($_POST['limit'])) {
            if ($_POST['limit'] == 25 || $_POST['limit'] == 50 || $_POST['limit'] == 100) {
                $_SESSION['limit'] = $_POST['limit'];
                header('location: /categories?catid='.$_GET['catid'].'&page=1');
            }
        }

        if (isset($_POST['size'])) {
            $_SESSION['size'] = $_POST['size'];
            header('location: /categories?catid='.$_GET['catid'].'&page=1');
        }

        if (isset($_POST['Minprice'])) {
            if (is_numeric($_POST['Minprice'])) {
                $_SESSION['minprice'] = $_POST['Minprice'];
                header('location: /categories?catid='.$_GET['catid'].'&page=1');
            }
        }

        if (isset($_POST['Maxprice'])) {
            if (is_numeric($_POST['Maxprice'])) {
                $_SESSION['maxprice'] = $_POST['Maxprice'];
                header('location: /categories?catid='.$_GET['catid'].'&page=1');
            }
        }

        if (isset($_POST['clearItem'])) {
            if ($_POST['clearItem'] == 'clear filter') {
                $function->clearSession();
                $function->setFilter($sizePriceStockItems);
                header('location: /categories?catid='.$_GET['catid'].'&page=1');
            }
        }
    }
}


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


// print_r($_SESSION);


$sessionOptions = $function->getOptions();
$stockAllCategories = $database->DBQuery('SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON si.StockItemID = sisg.StockItemID WHERE sisg.StockGroupID in (SELECT StockGroupID FROM stockgroups WHERE StockGroupID = ?)', [$cat]);
$stockCategories = $database->DBQuery('SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON si.StockItemID = sisg.StockItemID WHERE sisg.StockGroupID in (SELECT StockGroupID FROM stockgroups WHERE StockGroupID = ?) LIMIT ? OFFSET ?', [$cat, $limit, $offset]);


if ($stockAllCategories == '0 results found!') {
    echo 'No items in this categorie!';
    return false;
}

if ($colorId !== $function->getDefaultnr('colorid')) {
    $getcolor = [];
    $getColor2 = [];
    for ($i=0; $i < count($stockCategories); $i++) {
        if ($stockCategories[$i]['ColorID'] == $colorId) {
            array_push($getcolor, $stockCategories[$i]);
        }
    }

    for ($i=0; $i < count($stockAllCategories); $i++) {
        if ($stockAllCategories[$i]['ColorID'] == $colorId) {
            array_push($getColor2, $stockAllCategories[$i]);
        }
    }
    $stockCategories = $getcolor;
    $stockAllCategories = $getColor2;
}

// print_r($stockAllCategories);

if ($minPrice !== $function->getDefaultnr('minprice')) {
    $getPrice = [];
    $getPrice2 = [];
    for ($i=0; $i < count($stockCategories); $i++) {
        if ($stockCategories[$i]['RecommendedRetailPrice'] > $minPrice) {
            array_push($getPrice, $stockCategories[$i]);
        }
    }

    for ($i=0; $i < count($stockAllCategories); $i++) {
        if ($stockAllCategories[$i]['RecommendedRetailPrice'] > $minPrice) {
            array_push($getPrice2, $stockCategories[$i]);
        }
    }

    $stockCategories = $getPrice;
    $stockAllCategories = $getPrice2;
}

if ($maxPrice !== $function->getDefaultnr('maxprice')) {
    $getPrice = [];
    $getPrice2 = [];
    for ($i=0; $i < count($stockCategories); $i++) {
        if ($stockCategories[$i]['RecommendedRetailPrice'] < $maxPrice) {
            array_push($getPrice, $stockCategories[$i]);
        }
    }

    for ($i=0; $i < count($stockAllCategories); $i++) {
        if ($stockAllCategories[$i]['RecommendedRetailPrice'] < $maxPrice) {
            array_push($getPrice2, $stockCategories[$i]);
        }
    }

    $stockCategories = $getPrice;
    $stockAllCategories = $getPrice2;
}


if ($size !== $function->getDefaultnr('size')) {
    $getSize = [];
    $getSize2 = [];
    for ($i=0; $i < count($stockCategories); $i++) {
        if ($stockCategories[$i]['Size'] == $size) {
            array_push($getSize, $stockCategories[$i]);
        }
    }

    for ($i=0; $i < count($stockAllCategories); $i++) {
        if ($stockAllCategories[$i]['Size'] == $size) {
            array_push($getSize2, $stockAllCategories[$i]);
        }
    }
    $stockCategories = $getSize;
    $stockAllCategories = $getSize2;
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

?>

<section id="homequathead" class="wwi_text_left wwi_float_left">
        <div class="row container-fluid wwi_margin_top_normal">
            <div class="col-xl-2 offset-xl-1 wwi_bgsidebar d-none d-lg-block wwi_mat_3">
                <h1 class="wwi_light wwi_textalign_center"><strong>Filter</strong></h1>
                <form action="/categories?catid=<?php echo $cat; ?>&page=1" method="post" id="filter">
                <input type="hidden" name="catupdater" value="<?php echo session_id(); ?>">
                    <select name="limit" onChange="autoSubmit();">
                        <option value="<?php echo $limit; ?>" selected hidden><?php echo $limit; ?> filtered</option>
                        <?php
                        
                            $optlim = [25, 50, 100];
                            for ($i=0; $i < count($optlim); $i++) {
                                if ($limit !== $optlim) {
                                    echo '<option value="'.$optlim[$i].'">'.$optlim[$i].'</option>';
                                }
                            }
                        ?>
                    </select>
                    <select name="colorid" onChange="autoSubmit();">
                    <?php
                        $getColors = $database->DBQuery('SELECT * FROM colors WHERE ColorID IN (SELECT ColorID FROM stockitems JOIN stockitemstockgroups s on stockitems.StockItemID = s.StockItemID WHERE s.StockGroupID = ?)', [$stockCategories[0]['StockGroupID']]);
                        if ($getColors !== '0 results found!') {
                            if ($colorId == 'nAn') {
                                echo '<option value="'.$colorId.'" selected hidden>Color</option>';
                            }
                            for ($i=0; $i < count($getColors); $i++) {
                                if ($colorId == $getColors[$i]['ColorID']) {
                                    echo "<option value='".$getColors[$i]['ColorID']."'selected hidden>" .$getColors[$i]['ColorName']."</option><br>";
                                } else {
                                    echo "<option value='".$getColors[$i]['ColorID']."'>" .$getColors[$i]['ColorName']."</option><br>";
                                }
                            }
                        }
                    ?>
                    </select>
                    <select name="size" onchange="autoSubmit();">
                        <?php
                            $getAllsizes = $database->DBQuery('SELECT DISTINCT Size FROM stockitems WHERE SupplierID = ? AND Size IS NOT NULL', [$cat]);
                            if ($getAllsizes !== '0 results found!') {
                                if ($size == 'nAn') {
                                    echo '<option value="'.$size.'" selected hidden>Size</option>';
                                }
                                for ($i=0; $i < count($getAllsizes); $i++) {
                                    if ($getAllsizes[$i]['Size'] !== '') {
                                        if ($size == $getAllsizes[$i]['Size']) {
                                            echo "<option value='".$getAllsizes[$i]['Size']."'selected hidden>" .$getAllsizes[$i]['Size']."</option><br>";
                                        } else {
                                            echo "<option value='".$getAllsizes[$i]['Size']."'>" .$getAllsizes[$i]['Size']."</option><br>";
                                        }
                                    }
                                }
                            }
                        ?>
                    </select>
                    <select name="clearItem" onchange="autoSubmit();">
                            <option value="" selected hidden>Reset filter</option>
                            <option value="clear filter">Reset filter</option>
                    </select>
                    <h5><strong>min</strong></h5>
                    <div class="d-flex justify-content-center my-4">
                    <span class="font-weight-bold indigo-text mr-2 mt-1"><?php echo $sizePriceStockItems[0]['MIN(RecommendedRetailPrice)']; ?></span>
                        <input class="border-0" value="<?php echo $minPrice; ?>" name="Minprice" type="range" min="<?php echo $minPrice; ?>" max="<?php echo $sizePriceStockItems[0]['MAX(RecommendedRetailPrice)']; ?>" onchange="autoSubmit();" />
                    <span class="font-weight-bold indigo-text ml-2 mt-1"><?php echo $sizePriceStockItems[0]['MAX(RecommendedRetailPrice)']; ?></span>
                    </div>
                    <h5><strong>max</strong></h5>
                    <div class="d-flex justify-content-center my-4">
                    <span class="font-weight-bold indigo-text mr-2 mt-1"><?php echo $sizePriceStockItems[0]['MIN(RecommendedRetailPrice)']; ?></span>
                        <input class="border-0" value="<?php echo $maxPrice; ?>" name="Maxprice" type="range" min="<?php echo $sizePriceStockItems[0]['MIN(RecommendedRetailPrice)']; ?>" max="<?php echo $sizePriceStockItems[0]['MAX(RecommendedRetailPrice)']; ?>" onchange="autoSubmit();" />
                    <span class="font-weight-bold indigo-text ml-2 mt-1"><?php echo $sizePriceStockItems[0]['MAX(RecommendedRetailPrice)']; ?></span>
                    </div>
                </form>
            </div>
            <div class="col-xl-8 offset-xl-0">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div>
                                <h1 class="wwi_maincolor"><strong><?php echo count($stockCategories); ?> product(s)</strong></h1>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <nav>
                                    <ul class="pagination">
                                <!-- <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> -->

                                        <?php
                                        if ($maxPages <= $minPages) {
                                            $page = 1;
                                        } elseif ($page < 1) {
                                            header('Location: /home');
                                        } elseif ($page > $maxPages) {
                                            header('Location: /home');
                                        } elseif ($maxPages >= 2 and $maxPages <= 4) {
                                            for ($i = 1; $i <= $maxPages; $i++) {
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$i' class='button page-link'>$i</a></li>";
                                            }
                                        } elseif ($maxPages > 4) {
                                            if ($page <= 3) {
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=1' class='button page-link'>1</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$mpageplus' class='button page-link'>$mpageplus</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$mpageplusTwo' class='button page-link'>$mpageplusTwo</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$mpageplusThree' class='button page-link'>$mpageplusThree</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$pageplusTwo' class='button page-link'>...</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$maxPages' class='button page-link'>$maxPages</a></li>";
                                            }
                                            if ($page >= 4 and $page <= $maxPages - 3) {
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=1' class='button page-link'>1</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$pageminTwo' class='button page-link'>...</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$pagemin' class='button page-link'>$pagemin</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$page' class='button page-link'>$page</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$pageplus' class='button page-link'>$pageplus</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$pageplusTwo' class='button page-link'>...</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$maxPages' class='button page-link'>$maxPages</a></li>";
                                            }
                                            if ($page >= $maxPages - 2) {
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=1' class='button page-link'>1</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$pageminTwo' class='button page-link'>...</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$mpageminThree' class='button page-link'>$mpageminThree</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$mpageminTwo' class='button page-link'>$mpageminTwo</a</li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$mpagemin' class='button page-link'>$mpagemin</a></li>";
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$maxPages' class='button page-link'>$maxPages</a></li>";
                                            }
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="row row-flex">
                    <?php
                    for ($i=0; $i < count($stockCategories); $i++) {
                        $getimg = $database->DBQuery('SELECT * FROM picture WHERE StockItemID = ? AND isPrimary IS NOT NULL', [$stockCategories[$i]['StockItemID']]);
                        if ($getimg == '0 results found!') {
                            $img = '/public/img/products/no-image.png';
                        } else {
                            $img = $getimg[0]['ImagePath'];
                        }
                        
                        showItem($stockCategories[$i]['StockItemID'], $img, $stockCategories[$i]['StockItemName'], '', $stockCategories[$i]['SearchDetails'], $stockCategories[$i]['RecommendedRetailPrice']);
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function autoSubmit() {
        var formObject = document.forms['filter'];
        formObject.submit();
    }
</script>
<?php


$database->closeConnection();
