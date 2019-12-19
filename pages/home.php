<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file parses the correct page and displayes this for the user. If not it redirects to a 404 page
 */



$database = new database();


	



// Laad Discounted product zien op home pagina
// Dit is de werkende versie die filtered op de datum van nu DESCRIPTION toevoegen

$discountedItems = $database->DBQuery("SELECT StartDate, EndDate, DiscountAmount, DiscountPercentage, StockItemName, SD.StockItemID, SI.RecommendedRetailPrice FROM specialdeals AS SD  LEFT JOIN stockitems AS SI  ON SD.StockItemID = SI.StockItemID WHERE UTC_DATE BETWEEN StartDate AND EndDate AND StartDate != ?", [1]);

$checkDeals = $database->DBQuery('SELECT StartDate, EndDate, DiscountAmount, DealDescription, DiscountPercentage, SD.StockItemID, SD.StockGroupID, SI.StockItemName, SI.RecommendedRetailPrice, SG.stockgroupname FROM specialdeals AS SD LEFT JOIN stockitems AS SI ON SD.StockItemID = SI.StockItemID LEFT JOIN stockgroups AS SG ON SD.StockgroupID = SG.StockgroupID WHERE UTC_DATE BETWEEN StartDate AND EndDate', []);

// Checkt voor active deals
function checkDeals($checkDeals)
{
    if ($checkDeals !== '0 results found!') {
        for ($i=0; $i < count($checkDeals); $i++) {
            if ($checkDeals[$i]['StockItemID'] == 0) {	
				print("<h1 class='wwi_text_light'><strong>".$checkDeals[$i]['stockgroupname']."</strong></h1>");
				print("<h3 class='wwi_text_light'><strong>".$checkDeals[$i]['DealDescription']."</strong></h3>");
				print("<h3 class='wwi_text_light'><strong>Lasts until! ".$checkDeals[$i]['EndDate']."</strong></h3>");

			} elseif ($checkDeals[$i]['StockGroupID'] == 0) {
				print("<h1 class='wwi_text_light'><strong>$checkDeals[$i]['StockItemName']</strong></h1>");
				print("<h3 class='wwi_text_light'><strong>".$checkDeals[$i]['DealDescription']."</strong></h3>");
				print("<h3 class='wwi_text_light'><strong>Lasts until! ".$checkDeals[$i]['EndDate']."</strong></h3>");
            } else {
				print("<h1 class='wwi_text_light'><strong>New deals coming soon!</strong></h1>");
			}
        }
    }
}

//Print Knop gaat naar active deal zowel checkt zowel stockitemID 
function Dealbutton ($checkDeals){
	if ($checkDeals !== '0 results found!') {
		for ($i=0; $i < count($checkDeals); $i++) {
			if ($checkDeals[$i]['StockItemID'] == 0) {	
				print("<a href='/categories?catid=".$checkDeals[$i]['StockGroupID']."&page=1'class='btn btn-light btn-lg wwi_banner_btn_overlay wwi_maincolor' role='button'><strong>View product</strong></a>");
		
			} elseif ($checkDeals[$i]['StockGroupID'] == 0) {
				print("<a href='/productview?id=".$checkDeals[$i]['StockItemID']."' class='btn btn-light btn-lg wwi_banner_btn_overlay wwi_maincolor' role='button'><strong>View product</strong></a>");
			}else 
			print("<a href='#' class='btn btn-light btn-lg wwi_banner_btn_overlay wwi_maincolor' role='button'><strong>No deals</strong></a>");
		}
	}
}


// populaire producten query
$PopularProducts = $database->DBQuery("SELECT stockitemname, recommendedretailprice, searchdetails,  ol.stockitemid, count(ol.stockitemid) AS aantal FROM orderlines AS ol JOIN stockitems AS si ON ol.stockitemid = si.stockitemid GROUP BY ol.stockitemid ORDER BY aantal DESC LIMIT ?", [9]);

?>

<section id="homeSubhead" class="container-fluid d-none d-lg-block wwi_margin_top_normal">
			<div class="row no-gutters container-fluid">
				<div class="col wwi_50height">
					<div class="carousel slide wwi_50minheight" data-ride="carousel" id="stockcarousel">
						<div class="carousel-inner" role="listbox">
							<div class="carousel-item wwi_50minheight"><img
									class="w-100 d-block wwi_50height wwi_blur"
									src="public/img/stock/stock2.png" alt="Slide Image">
								<div class="wwi_banner_blur_bgcolr"></div>
								<div>
									<div class="wwi_banner_text_overlay">
										<h1 class="wwi_text_light"><strong>Easy to use</strong></h1>
									</div>
								</div>
							</div>
							<div class="carousel-item active wwi_50minheight"><img
									class="w-100 d-block wwi_50height wwi_blur"
									src="public/img/stock/stock3.png" alt="Slide Image">
								<div class="wwi_banner_blur_bgcolr"></div>
								<div>
									<div class="wwi_banner_text_overlay">
										<h1 class="wwi_text_light"><strong>For every season</strong></h1>
									</div>
								</div>
							</div>
							<div class="carousel-item wwi_50minheight"><img
									class="w-100 d-block wwi_50height wwi_blur"
									src="public/img/stock/stock4.png" alt="Slide Image">
								<div class="wwi_banner_blur_bgcolr"></div>
								<div>
									<div class="wwi_banner_text_overlay">
										<h1 class="wwi_text_light"><strong>For everyone</strong></h1>
									</div>
								</div>
							</div>
							<div class="carousel-item wwi_50minheight"><img
									class="w-100 d-block wwi_50height wwi_blur"
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
                <!-- Kortingsdeals --> 
				<div class="col">
					<div class="carousel slide wwi_50minheight" data-ride="carousel" id="carousel-1">
						<div class="carousel-inner" role="listbox">
							<div class="carousel-item active wwi_50minheight"><img
									class="w-100 d-block wwi_25width wwi_25height .wwi_banner_img wwi_banner_img_overlay"
									src="public/img/products/testproduct.png" alt="Slide Image">
								<div class="wwi_banner_blue_bgcolr"></div>
								<div>
									<div class="wwi_banner_text_overlay">
										<?php checkDeals($checkDeals); ?>
									</div>
									<?php
									Dealbutton($checkDeals);
									?>
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
	<section>
			<!-- Populaire producten --> 
			<div class="col-xl-12 offset-xl-0">
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
                            for ($a=0; $a < 9; $a++) {
                                $getimg = $database->DBQuery('SELECT * FROM picture WHERE stockitemid = ? AND isPrimary IS NOT NULL', [$PopularProducts[$a]['stockitemid']]);
                                if ($getimg == '0 results found!') {
                                    $img = '/public/img/products/no-image.png';
                                } else {
                                    $img = $getimg[0]['ImagePath'];
								}
								
                                if($checkDeals ='0 results found!'){
                                showItem($PopularProducts[$a]['stockitemid'], $img, $PopularProducts[$a]['stockitemname'], '', $PopularProducts[$a]['searchdetails'], $PopularProducts[$a]['recommendedretailprice']);
                            }else{ 
								showItemAndDeals($PopularProducts[$a]['stockitemid'], $img, $PopularProducts[$a]['stockitemname'], '', $PopularProducts[$a]['searchdetails'], $PopularProducts[$a]['recommendedretailprice'], $checkDeals[1]['DiscountPercentage'] );
							}
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