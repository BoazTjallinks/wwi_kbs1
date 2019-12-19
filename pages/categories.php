<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * Shows al items in categorie
 */


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
    $stockCategories = $getcolor;
}

if ($minPrice !== $function->getDefaultnr('minprice') || $maxPrice !== $function->getDefaultnr('maxprice')) {
    $getPrice = [];
    for ($i=0; $i < count($stockCategories); $i++) {
        if ($stockCategories[$i]['RecommendedRetailPrice'] < $maxPrice && $stockCategories[$i]['RecommendedRetailPrice'] > $minPrice) {
            array_push($getPrice, $stockCategories[$i]);
        }
    }

    $stockCategories = $getPrice;
}

if ($size !== $function->getDefaultnr('size')) {
    $getSize = [];
    for ($i=0; $i < count($stockCategories); $i++) {
        if ($stockCategories[$i]['Size'] == $size) {
            array_push($getSize, $stockCategories[$i]);
        }
    }

    $stockCategories = $getSize;
}


/*Pagination*/
$maxPages = ceil(count($stockAllCategories) / $limit);
// $maxPages = 100;
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
                <form action="/categories" method="post">
                    <input type="hidden" name="catid" value="<?php echo $cat; ?>">
                    <select onChange="autoSubmit();">
                    <?php
                        $getColors = $database->DBQuery('SELECT * FROM colors WHERE ColorID IN (SELECT ColorID FROM stockitems JOIN stockitemstockgroups s on stockitems.StockItemID = s.StockItemID WHERE s.StockGroupID = ?)', [$stockCategories[0]['StockGroupID']]);
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
                    ?>
                    </select>
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
                                        // $amountPages = ceil(count($stockAllCategories) / $limit);
                                        // print_r('<li>'.$amountPages.'</li>');
                                        
                                        // if ($amountPages > 5) {
                                        //     echo '<li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                                        //     for ($i=0; $i < $amountPages; $i++) {
                                        //         echo '<li class="page-item"><a class="page-link" href="#">'.$i.'</a></li>';
                                        //     }
                                        //     echo '<li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                                        // } else {
                                        //     for ($i=0; $i < $amountPages; $i++) {
                                        //         if (($i + 1) == $page) {
                                        //             echo '<li class="page-item"><a class="page-link wwi_mainbgcolor wwi_mainborder wwi_mainbgcolorhover wwi_text_light wwi_mainborderhover" href="/categories?catid='.$cat.'&page='.($i + 1).'">'.($i + 1).'</a></li>';
                                        //         } else {
                                        //             echo '<li class="page-item"><a class="page-link" href="/categories?catid='.$cat.'&page='.($i + 1).'">'.($i + 1).'</a></li>';
                                        //         }
                                        //     }
                                        // }
                                        if ($maxPages <= $minPages) {
                                            $page = 1;
                                        // echo '<li class="page-item"><a class="page-link wwi_mainbgcolor wwi_mainborder wwi_mainbgcolorhover wwi_text_light wwi_mainborderhover" href="/categories?catid='.$cat.'&page=1">1</a></li>';
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
                                                echo " <li class='page-item'><a href='/categories?catid=$cat&page=$mpageminTwo' class='button page-link'>$mpageminTwo</a</li>>";
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

<?php


$database->closeConnection();
