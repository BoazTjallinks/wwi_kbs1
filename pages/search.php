<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file searches through the file
 */

// Checks query $_GET variable and redirects if not
if (!isset($_GET['Searchquery']) || !isset($_GET['page'])) {
    header('location: /search?Searchquery=&page=1');
}

$productName = $_GET['Searchquery'];
$page = $_GET['page'];
$limit = $_SESSION['limit'];
$offset = $page * $limit - $limit;

// print_r($limit .'  '.$offset);

$database = new database();
$result2 = $database->DBQuery("SELECT * FROM stockitems WHERE StockItemName LIKE CONCAT('%',?,'%') OR StockItemID LIKE CONCAT('%',?,'%') OR SearchDetails LIKE CONCAT('%',?,'%')", [$productName, $productName, $productName]);
$result = $database->DBQuery("SELECT * FROM stockitems WHERE StockItemName LIKE CONCAT('%',?,'%') OR StockItemID LIKE CONCAT('%',?,'%') OR SearchDetails LIKE CONCAT('%',?,'%') LIMIT ? OFFSET ?", [$productName, $productName, $productName, $limit, $offset]);


if ($result == '0 results found!') {
    print("<h3>Sorry, we're unable to find any items related to your search</h3>");
} else {
    for ($i=0; $i < count($result); $i++) {
        print('<div class="row container wwi_center">');
        // print_r(count($result));
        for ($i=0; $i < count($result); $i++) {
            $getimg = $database->DBQuery('SELECT * FROM picture WHERE StockItemID = ? AND isPrimary IS NOT NULL', [$result[$i]['StockItemID']]);
            if ($getimg == '0 results found!') {
                $img = '/public/img/products/no-image.png';
            } else {
                $img = $getimg[0]['ImagePath'];
            }

            showItem($result[$i]['StockItemID'], $img, $result[$i]['StockItemName'], '', $result[$i]['SearchDetails'], $result[$i]['RecommendedRetailPrice']);
        }
        print('</div>');
    }

    $maxPages = ceil(count($result2) / $limit);
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
    $mpageplusThree = $minPages + 3; ?>
<nav>
<ul class="pagination container">

<?php
if ($maxPages <= $minPages) {
        $page = 1;
    } elseif ($page < 1) {
        header('Location: /search?Searchquery=".$productName."?page=1');
    } elseif ($page > $maxPages) {
        header('Location: /search?Searchquery=".$productName."?page=1');
    } elseif ($maxPages >= 2 and $maxPages <= 4) {
        for ($i = 1; $i <= $maxPages; $i++) {
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$i' class='button page-link'>$i</a></li>";
        }
    } elseif ($maxPages > 4) {
        if ($page <= 3) {
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=1' class='button page-link'>1</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$mpageplus' class='button page-link'>$mpageplus</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$mpageplusTwo' class='button page-link'>$mpageplusTwo</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$mpageplusThree' class='button page-link'>$mpageplusThree</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$pageplusTwo' class='button page-link'>...</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$maxPages' class='button page-link'>$maxPages</a></li>";
        }
        if ($page >= 4 and $page <= $maxPages - 3) {
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=1' class='button page-link'>1</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$pageminTwo' class='button page-link'>...</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$pagemin' class='button page-link'>$pagemin</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$page' class='button page-link'>$page</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$pageplus' class='button page-link'>$pageplus</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$pageplusTwo' class='button page-link'>...</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$maxPages' class='button page-link'>$maxPages</a></li>";
        }
        if ($page >= $maxPages - 2) {
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=1' class='button page-link'>1</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$pageminTwo' class='button page-link'>...</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$mpageminThree' class='button page-link'>$mpageminThree</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$mpageminTwo' class='button page-link'>$mpageminTwo</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$mpagemin' class='button page-link'>$mpagemin</a></li>";
            echo " <li class='page-item'><a href='/search?Searchquery=".$productName."&page=$maxPages' class='button page-link'>$maxPages</a></li>";
        }
    } ?>
</ul>
</nav>

<?php
}
?>

