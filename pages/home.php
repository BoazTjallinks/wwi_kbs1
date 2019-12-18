<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file parses the correct page and displayes this for the user. If not it redirects to a 404 page
 */



$database = new database();

// Laad Discounted product zien op home pagina (unfinished)


/*
$discountedItems = $database->DBQuery("SELECT StartDate, EndDate, DiscountAmount, DiscountPercentage, StockItemName, SI.StockItemID, SI.RecommendedRetailPrice
FROM specialdeals AS SD
JOIN stockitems AS SI
ON SD.StockItemID = SI.StockItemID
WHERE UTC_DATE BETWEEN StartDate AND EndDate AND StartDate != ?",[1]);
*/

/*
$discountedItems = $database->DBQuery("SELECT StartDate, EndDate, DiscountAmount, DiscountPercentage, DealDiscription,  SI.StockItemName, SI.StockItemID, SI.RecommendedRetailPrice
FROM specialdeals AS SD
LEFT JOIN stockitems AS SI
ON SD.StockItemID = SI.StockItemID
WHERE  StartDate != ?",[8]);
*/
/*
$InTheNameOfPHPTestQuery= $database-->DBQuery("SELECT RecommendedRetailPrice, UnitPrice FROM StockItems" ,[]);
//var_dump($discountedItems);

if(isset($InTheNameOfPHPTestQuery[8]['RecommendedRetailPrice'])){
$InTheNameOfPHPTestQuery = ($InTheNameOfPHPTestQuery[8]['RecommendedRetailPrice'] - $InTheNameOfPHPTestQuery[8]['UnitPrice']);
print($InTheNameOfPHPTestQuery);
}
//$discountPrice = ($discountedItems[]['RecommendedRetailPrice'] - $discountedItems[]['DiscountAmount']);

*/


//print($discountedItems[1]['StockItemName']);
//print($discountedItems[1]['StartDate']);
/*

//berekent de prijs met korting
$discountPrice= $row['SI.UnitPrice'] - $row['DiscountAmount'];

// Calculates the remaining time of the deal duration //

$dealDayRemaining=round((($dealTime/24)/60)/60);
$dealTime =($row['EndDate'] - date('Y-m-d'));
print($dealTime);

*/

// (unfinished laad korting producten nog niet in)
/*
if($discountedItems == 0){
    print("<ul>");
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');
    print("</ul>");
}else{
    for ($z=0; $z < 6; $z++){

        $getimg = $database->DBQuery('SELECT * FROM picture WHERE stockitemid = ? AND isPrimary IS NOT NULL', [$discountedItems[$z]['stockitemid']]);
        if ($getimg == '0 results found!') {
            $img = '/public/img/products/no-image.png';
        }
        else {
            $img = $getimg[0]['ImagePath'];
        }

        showItem($discountedItems[$z]['stockitemid'], $img, $discountedItems[$z]['stockitemname'], '', $discountedItems[$z]['searchdetails'], $discountedItems[$z]['recommendedretailprice']);

}
}

*/


// populaire producten (geen description)
$PopularProducts = $database->DBQuery("SELECT stockitemname, recommendedretailprice, searchdetails,  ol.stockitemid, count(ol.stockitemid) AS aantal FROM orderlines AS ol JOIN stockitems AS si ON ol.stockitemid = si.stockitemid GROUP BY ol.stockitemid ORDER BY aantal DESC LIMIT ?", [6]);

//$PopulairProducts = 0;

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
					<li><a class="wwi_text_light wwi_text_lighthover" href="#">Hello world</a></li>
				</ul>
			</div>
			<div class="col-xl-8 offset-xl-0">
				<div class="container">
					<div class="row">
						<div class="col">
							<div>
								<h1 class="wwi_maincolor"><strong>Eye catchers</strong></h1>
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
		</div>
	</section>