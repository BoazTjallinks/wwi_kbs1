<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * View item page
 */


$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
if (!is_numeric($id)) {
    header('location: /home');
}

$database = new database();
//$result = $database->getStockItemspurchaseOrderlines($id);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $soldOut = false;

    $stockItemID = $row["StockItemID"];
    $stockItemName = $row["StockItemName"];
    $recomretprice  = $row["RecommendedRetailPrice"];
    $description = $row["Description"];
    $video = "<iframe width=\"560\" height=\"315\" src=\"https:'//'www.youtube-nocookie.com/embed/dQw4w9WgXcQ?start=42\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
    #$video = $row["[HIER DE ROUTE NAAR DE VIDEO]"];
    
    $GetStockItemHolding = $row["QuantityOnHand"];
    //zorgt ervoor dat er verschillende kleuren worden gebruikt bij een X hoeveelheid stockitems
    if($GetStockItemHolding > 15){
        $stockItemHolding = "Enough in stock for you to order!";
        $styleColor = "style=\"\"";
    }elseif(($GetStockItemHolding <= 15) AND ($GetStockItemHolding > 5)){
        $stockItemHolding = "Only <strong>".$GetStockItemHolding."</strong> left! Order Now!";
        $styleColor = "style=\"background-color: orange;\"";
    }elseif(($GetStockItemHolding <= 5) AND ($GetStockItemHolding >0)){
        $stockItemHolding = "Nearly sold out! Only <strong>".$GetStockItemHolding."</strong> left! Order Now!";
        $styleColor = "style=\"background-color: red;\"";
    }else{
        $stockItemHolding = "Out of stock!";
        $styleColor = "style=\"background-color: grey;\"";
        $soldOut = true;
    }


    #$database = new database();
    

    $photoPath = "../public/img/id".$id.".png";

    if(file_exists($photoPath)){                                    
        $photo = $photoPath;
    }else{
        $photo = "../public/img/no-image.png";
    }
    //checkt of er een bestand bestaat op de plek van $photoPath
    //if(file_exists($photoPath)){$photo = "src='/public/img/id".$id.".png'";}else{$photo = "src='/public/img/no-image.png'";}
    

?>


<div>
        <div class="container d-lg-none">
            <div class="row">
                <div class="col">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><span>Home</span></a></li>
                        <li class="breadcrumb-item"><a href="#"><span>Library</span></a></li>
                        <li class="breadcrumb-item"><a href="#"><span>Data</span></a></li>
                    </ol>
                    <h1><?php print($stockItemName); ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="carousel slide" data-ride="carousel" id="carousel-1">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active"><img class="w-100 d-block" src="<?php print($photo); ?>" alt="<?php print($stockItemName); ?>"></div>
                            <!-- <div class="carousel-item"><img class="w-100 d-block" <?php #print($photo); ?> alt="Slide Image"></div>
                            <div class="carousel-item"><img class="w-100 d-block" <?php #print($photo); ?> alt="Slide Image"></div> -->
                        </div>
                        <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button"
                                data-slide="next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a></div>
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-1" data-slide-to="1"></li>
                            <li data-target="#carousel-1" data-slide-to="2"></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h2 id="price-mobile"><?php print("€".$recomretprice); ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col" id="id-column-cooling-mobile"><small>Cooled or not</small></div>
                    </div>
                    <div class="row">
                        <div class="col" id="column-badge-stock-mobile"><span class="badge badge-primary" id="badge-mobile" <?php print($styleColor); ?>><?php print($stockItemHolding); ?></span><small id="stock-mobile">ffff</small></div>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                    <?php
                    if(!$soldOut){
                        print(" <div class=\"col\"><button class=\"btn btn-primary\" id=\"add-button-mobile\" type=\"button\">Add to shopping cart</button></div>");
                    }else{
                        print("<div class=\"col\"><span class=\"badge badge-primary\" id=\"sold-out-button-mobile\">This product is sold out</span></div>");
                    }
                    ?>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <p id="beschrijving-mobile"><h5>Beschrijving:</h5><?php print($description); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ?>
        <div class="container d-none d-lg-block">
            <div class="row">
                <div class="col">
                <ol class="breadcrumb" id="breadcrumb-desktop">
                        <li class="breadcrumb-item"><a href="#"><span>Home</span></a></li>
                        <li class="breadcrumb-item"><a href="#"><span>Library</span></a></li>
                        <li class="breadcrumb-item"><a href="#"><span>Data</span></a></li>
                    </ol>
                    <h1 id="title-product-desktop"><?php print($stockItemName); ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="carousel slide" data-ride="carousel" id="carousel-1-desktop">
                        <div class="carousel-inner" role="listbox">
                            
                            <?php
                            
                            $resultgetPicture = $database->getPictures($stockItemID);
                            $nieuwvar = mysqli_fetch_array($resultgetPicture, MYSQLI_ASSOC);
                            while ($row = mysqli_fetch_array($resultgetPicture, MYSQLI_ASSOC)) {
                                
                                $pictureID = $row['PictureID'];
                                $imgPath = $row["ImagePath"];
                                
                                $amountOfPictures = count($nieuwvar);
                                // //print $amountOfPictures;
                                // if($amountOfPictures > 1){
                                //     for($i=0; $i<$amountOfPictures; $i++){
                                        
                                //         if(file_exists($imgPath)){                                    
                                //             if($i==0){
                                //                 print ("<div class=\"carousel-item active\"><img class=\"w-100 d-block\" src=\"".$imgPath."\" alt=\"Slide Image\"></div>");
                                //             }else{
                                //                 print ("<div class=\"carousel-item\"><img class=\"w-100 d-block\" src=\"".$imgPath."\" alt=\"Slide Image\"></div>");
                                //             }
                                //         }else{
                                //             print ("<div class=\"carousel-item active\"><img class=\"w-100 d-block\" src=\"../public/img/no-image.png\" alt=\"Slide Image\"></div>");
                                //         }
                                //     }
                                // }
                                
                                //print_r($row["PictureId"]);
                                //foreach($rowone as $pictureId){$image = $row['ImagePath'];if(file_exists($image)){$photo = $image;}else{$photo = "../public/img/no-image.png";}}
                                // $pictureId = $row["PictureId"];$stockItemID_Picture = $row["StockItemID"];$image = $row['ImagePath'];print($pictureId);print($image);
                                // if(file_exists($image)){$photo = $image;}else{$photo = "../public/img/no-image.png";}
                            }
                            
                            ?>
                            <div class="carousel-item active"><img class="w-100 d-block" src="<?php print($photo); ?>" alt="Slide Image"></div>
                            <div class="carousel-item" active><img class="w-100 d-block" src="<?php print($photo); ?>" alt="Slide Image"></div>
                            <div class="carousel-item" active><img class="w-100 d-block" src="<?php print($photo); ?>" alt="Slide Image"></div>
                        </div>
                        <div><a class="carousel-control-prev" href="#carousel-1-desktop" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1-desktop"
                                role="button" data-slide="next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a></div>
                        <ol class="carousel-indicators">
                            
                            <?php
                            for ($i=0; $i < count($nieuwvar); $i++) {
                                print("<li data-target=\"#carousel-1-desktop\" data-slide-to=\"".$i."\"></li>");
                            }
                            ?>
                        </ol>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col">
                            <h1 id="price-desktop"><?php print("€".$recomretprice); ?></h1>
                        </div>
                        <div class="col" id="cooling-desktop"><small>Cooled or not</small></div>
                    </div>
                    <div class="row">
                        <div class="col" id="column-badge-stock-desktop"><span class="badge badge-primary" id="badge-desktop" <?php print($styleColor); ?>><?php print($stockItemHolding); ?></span></div>
                    </div>
                    <div class="row">
                    <?php
                    if(!$soldOut){
                        print("<div class=\"col\"><button class=\"btn btn-primary\" id=\"add-button-desktop\" type=\"button\">Add to shopping cart</button></div>");
                    }else{
                        print("<div class=\"col\"><span class=\"badge badge-primary\" id=\"sold-out-button-desktop\">This product is sold out</span></div>");
                    }
                    ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p id="beschrijving-desktop"><h3>Beschrijving:</h3><?php print($description); ?></p>
                </div>
            </div>
        </div>
    </div>






<?php
//print("f");
    
}
//ends the while-loop, niet aankomen

//moet nog implementeren: <h5><a href='https://www.youtube.com/?gl=NL' target='_blank'  title='Go to youtube'>link to the videos</a></h5>




//misschien ooit nodig; een button om een pagina terug te gaan: <script>document.write('<a href="' + document.referrer + '"><button type="button">Back</button></a>');</script>

?>