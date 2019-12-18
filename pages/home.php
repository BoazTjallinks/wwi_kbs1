<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file parses the correct page and displayes this for the user. If not it redirects to a 404 page
 */



$database = new database();

//Laad StockCategories in

$getstockgroups = $database->DBQuery("SELECT stockgroupname, stockgroupID FROM stockgroups WHERE stockgroupID != ?", [2]);

function getStockgroups($getstockgroups, $i)
{
    for ($i=0; $i<count($getstockgroups); $i++) {
        print($getstockgroups[$i]['stockgroupname']."<br>");
    }
}

// Laad Discounted product zien op home pagina
// Dit is de werkende versie die filtered op de datum van nu DESCRIPTION toevoegen

$discountedItems = $database->DBQuery("SELECT StartDate, EndDate, DiscountAmount, DiscountPercentage, StockItemName, SD.StockItemID, SI.RecommendedRetailPrice FROM specialdeals AS SD  LEFT JOIN stockitems AS SI  ON SD.StockItemID = SI.StockItemID WHERE UTC_DATE BETWEEN StartDate AND EndDate AND StartDate != ?", [1]);

function getDiscountedProducts($discountedItems, $b)
{
    if ($discountedItems !== 0  && $discountedItems[$b]['StockItemID'] !== 0) {
        for ($b=0; $b < 6; $b++) {
            return $discountPrice = ($discountedItems[$b]['RecommendedRetailPrice'] - $discountedItems[$b]['DiscountAmount']);
            return $oldPrice = ($discountedItems[$b]['RecommendedRetailPrice']);
            return $discountPercentage =($discountedItems[$b]['DiscountPercentage']);
            return $discountProductName = ($discountedItems[$b]['StockItemID']);
            return $endDate = ($discountedItems[$b]['EndDate']);
            return $b;
        }
    } else {
        print("<ul>");
        print('<li> new items soon </li>');
        print("</ul>");
    }
}

// BEREKENT PRIJS CORRECT
/*
for($b=0; $b < 6; $b++){
    $discountPrice= ($discountedItems[$b]['RecommendedRetailPrice'] - $discountedItems[$b]['DiscountAmount']);
    print($discountPrice);
    }
*/


//TEST QUERYS
/*
    //deze laad bestaande deals in
    $discountedItems = $database->DBQuery("SELECT StartDate, EndDate, DiscountAmount, DiscountPercentage, SI.StockItemName, SI.StockItemID, SI.RecommendedRetailPrice
    FROM specialdeals AS SD
LEFT JOIN stockitems AS SI
ON SD.StockItemID = SI.StockItemID
WHERE  StartDate != ?",[0]);

print($discountedItems[1]['StockItemName']); // Deze is niet bestaand en laat niets zien
//print($discountedItems[1]['StartDate']);     // deze bestsaat wel

// Test Query    voor korting berekenen

$TestQuery= $database->DBQuery("SELECT RecommendedRetailPrice, UnitPrice FROM stockitems WHERE UnitPrice != ?;",[0]);
if(isset($TestQuery[1]['RecommendedRetailPrice'])){
$TestQuerySom = ($TestQuery[1]['RecommendedRetailPrice'] - $TestQuery[1]['UnitPrice']);
print($TestQuerySom);
  }


//berekent de prijs met korting maar niet correcte versie {
    for($b=0; $b < 6; $b++){
$discountPrice= ($TestQuery[$b]['RecommendedRetailPrice'] - $TestQuery[$b]['UnitPrice']);
print($discountPrice);
    }
*/


// (unfinished laad korting producten nog niet in)
/*
if($discountedItems !== 0  && $discountedItems[0]['StockItemID'] !== 0){
    for($b=0; $b < 6; $b++){
        $discountPrice = ($discountedItems[$b]['RecommendedRetailPrice'] - $discountedItems[$b]['DiscountAmount']);
        print($discountPrice);
    }
}else{
    print("<ul>");
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');
    print("</ul>");
}
*/


// populaire producten query
$PopularProducts = $database->DBQuery("SELECT stockitemname, recommendedretailprice, searchdetails,  ol.stockitemid, count(ol.stockitemid) AS aantal FROM orderlines AS ol JOIN stockitems AS si ON ol.stockitemid = si.stockitemid GROUP BY ol.stockitemid ORDER BY aantal DESC LIMIT ?", [6]);

?>

<section id="homeSubhead" class="container-fluid d-none d-lg-block wwi_margin_top_normal">
			<div class="row no-gutters container-fluid">
				<div class="col-xl-6 wwi_50height">
					<div class="carousel slide wwi_50minheight" data-ride="carousel" id="stockcarousel">
						<div class="carousel-inner" role="listbox">
							<div class="carousel-item wwi_50minheight"><img
									class="w-100 d-block wwi_50width wwi_50height wwi_blur"
									src="public/img/stock/stock2.png" alt="Slide Image">
								<div class="wwi_banner_blur_bgcolr"></div>
								<div>
									<div class="wwi_banner_text_overlay">
										<h1 class="wwi_text_light"><strong>Easy to use</strong></h1>
									</div>
								</div>
							</div>
							<div class="carousel-item active wwi_50minheight"><img
									class="w-100 d-block wwi_50width wwi_50height wwi_blur"
									src="public/img/stock/stock3.png" alt="Slide Image">
								<div class="wwi_banner_blur_bgcolr"></div>
								<div>
									<div class="wwi_banner_text_overlay">
										<h1 class="wwi_text_light"><strong>For every season</strong></h1>
									</div>
								</div>
							</div>
							<div class="carousel-item wwi_50minheight"><img
									class="w-100 d-block wwi_50width wwi_50height wwi_blur"
									src="public/img/stock/stock4.png" alt="Slide Image">
								<div class="wwi_banner_blur_bgcolr"></div>
								<div>
									<div class="wwi_banner_text_overlay">
										<h1 class="wwi_text_light"><strong>For everyone</strong></h1>
									</div>
								</div>
							</div>
							<div class="carousel-item wwi_50minheight"><img
									class="w-100 d-block wwi_50width wwi_50height wwi_blur"
									src="public/img/stock/stock1.png" alt="Slide Image">
								<div class="wwi_banner_blur_bgcolr"></div>
								<div>
									<div class="wwi_banner_text_overlay">
										<h1 class="wwi_text_light"><strong>We've got your back</strong></h1>
									</div>
								</div>
							</div>
						</div>
						<div><a class="carousel-control-prev" href="#stockcarousel" role="button"
								data-slide="prev"><span class="sr-only">Previous</span></a><a
								class="carousel-control-next" href="#stockcarousel" role="button"
								data-slide="next"><span class="sr-only">Next</span></a></div>
					</div>
                </div>
                
				<div class="col">
					<div class="carousel slide wwi_50minheight" data-ride="carousel" id="carousel-1">
						<div class="carousel-inner" role="listbox">
							<div class="carousel-item active wwi_50minheight"><img
									class="w-100 d-block wwi_25width wwi_25height .wwi_banner_img wwi_banner_img_overlay"
									src="public/img/products/testproduct.png" alt="Slide Image">
								<div class="wwi_banner_blue_bgcolr"></div>
								<div>
									<div class="wwi_banner_text_overlay">
										<h1 class="wwi_text_light"><strong>Usb Novalties</strong></h1>
										<h3 class="wwi_text_light"><strong>30% off</strong></h3>
										<h3 class="wwi_text_light"><strong>..</strong></h3>
									</div><button class="btn btn-light btn-lg wwi_banner_btn_overlay wwi_maincolor"
										type="button"><strong>View product</strong></button>
								</div>
							</div>
						</div>
						<div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span
									class="sr-only">Previous</span></a><a class="carousel-control-next"
								href="#carousel-1" role="button" data-slide="next"><span class="sr-only">Next</span></a>
						</div>
                    </div>
                    
                </div>
			</div>
		</section>
	</section>
	<section id="homequathead" class="wwi_text_left wwi_float_left">
		<div class="row container-fluid wwi_margin_top_normal">
			<div class="col-xl-2 offset-xl-1 wwi_bgsidebar d-none d-lg-block wwi_mat_3">
				<h1 class="wwi_light wwi_textalign_center"><strong>Categories</strong></h1>
				<ul class="list-unstyled">
					<li><a class="wwi_text_light wwi_text_lighthover" href="#"><?php getStockgroups($getstockgroups, $i); ?></a></li>
				</ul>
			</div>
			<div class="col-xl-8 offset-xl-0">
				<div class="container">
					<div class="row">
						<div class="col">
							<div>
								<h1 class="wwi_maincolor"><strong>Best Sellers</strong></h1>
							</div>
						</div>
					</div>
					<div class="row row-flex">
                    <?php
                        if ($PopularProducts == !0) {
                            for ($a=0; $a < 6; $a++) {
                                $getimg = $database->DBQuery('SELECT * FROM picture WHERE stockitemid = ? AND isPrimary IS NOT NULL', [$PopularProducts[$a]['stockitemid']]);
                                if ($getimg == '0 results found!') {
                                    $img = '/public/img/products/no-image.png';
                                } else {
                                    $img = $getimg[0]['ImagePath'];
                                }
                        
                                showItem($PopularProducts[$a]['stockitemid'], $img, $PopularProducts[$a]['stockitemname'], '', $PopularProducts[$a]['searchdetails'], $PopularProducts[$a]['recommendedretailprice']);
                            }
                        } else {
                            print("Popular products are temporarily unavailable ");
                        }
                    ?>
				</div>
			</div>
		</div>
	</section>
					</div>