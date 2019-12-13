<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * View item page
 */


$id = $_GET['id'];
if (!is_numeric($id)) {
    header('location: /home');
}

$database = new database();
$result = $database->DBQuery("SELECT DISTINCT S.StockItemID, S.StockItemName, S.RecommendedRetailPrice, P.Description, SH.QuantityOnHand FROM stockitems AS S JOIN purchaseorderlines AS P ON S.StockItemID = P.StockItemID JOIN stockitemholdings AS SH ON S.StockItemID = SH.StockItemID WHERE S.StockItemID = ? ORDER BY S.StockItemID;",[$id]);
$showTemprature = $database->DBQuery('SELECT si.stockitemid, si.stockitemname, ischillerstock,  crt.ColdRoomTemperatureID, crt.temperature FROM stockitems AS si LEFT JOIN coldroomstockitems AS crsi ON si.stockitemid = crsi.stockitemid LEFT JOIN coldroomtemperatures AS crt ON crsi.ColdRoomTemperatureID = crt.ColdRoomTemperatureID WHERE IsChillerStock = ?',[1]);
  


    $soldOut = false;

    $stockItemID = $result[0]["StockItemID"];
    $stockItemName = $result[0]["StockItemName"];
    $recomretprice  = $result[0]["RecommendedRetailPrice"];
    $description = $result[0]["Description"];
    $video = "<iframe width=\"560\" height=\"315\" src=\"https:'//'www.youtube-nocookie.com/embed/dQw4w9WgXcQ?start=42\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
    #$video = $result[0]["[HIER DE ROUTE NAAR DE VIDEO]"];
    
    $GetStockItemHolding = $result[0]["QuantityOnHand"];
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
    

    $photoPath = "../../public/img/products/id".$id.".png";

    if(file_exists($photoPath)){                                    
        $photo = $photoPath;
    }else{
        $photo = "../../public/img/products/no-image.png";
    }
    //checkt of er een bestand bestaat op de plek van $photoPath
    //if(file_exists($photoPath)){$photo = "src='/public/img/id".$id.".png'";}else{$photo = "src='/public/img/no-image.png'";}
    

?>

<!-- mobile responsive  --> 
<div>
        <div class="container d-lg-none">
            <div class="row">
                <div class="col">
                    <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><span>Home</span></a></li>
                        <li class="breadcrumb-item"><a href="#"><span>Library</span></a></li>
                        <li class="breadcrumb-item"><a href="#"><span>Data</span></a></li>
                    </ol> -->
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
            <?php 
            for ($i=0; $i < count($showTemprature); $i++) { 
                if ($stockItemID == $showTemprature[$i]['stockitemid']) {
                  if ($showTemprature[1]['ischillerstock'] == 1){
                    print("<p>" . "Dit product is nu: " . $showTemprature[$i]['temperature']. '°C' . "</p>" ); 
                    } 
                  } 
                }   
            ?>
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
                        <div class="col" id="column-badge-stock-mobile"><span class="badge badge-primary" id="badge-mobile" <?php print($styleColor); ?>><?php print($stockItemHolding); ?></span><small id="stock-mobile"></small></div>
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
        <!-- pc Browser --> 
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
                <div id="carousel-thumb" class="carousel slide carousel-fade carousel-thumbnails" data-ride="carousel">
                    <!--Slides-->
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <iframe class="d-block w-100 wwi_35height" src="https://www.youtube.com/embed/thGH8jYlQCc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <?php
                        $allPictures = $database->DBQuery('SELECT PictureID, StockItemID, ImagePath FROM picture where StockItemId = ?', [$id]);
                        for ($i=0; $i < count($allPictures); $i++) { 
                            echo '<div class="carousel-item"><img class="d-block w-100 wwi_35height" src="'.$allPictures[$i]['ImagePath'].'"></div>';
                        }
                        ?>
                    </div>
                    <!--/.Slides-->
                    <!--Controls-->
                    <a class="carousel-control-prev" href="#carousel-thumb" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-thumb" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <!--/.Controls-->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-thumb" class="active" data-slide-to="0"><img src="" width="100"></li>
                        <?php 
                         for ($i=0; $i < count($allPictures); $i++) { 
                            echo '<li data-target="#carousel-thumb" data-slide-to="'.$i.'"><img src="'.$allPictures[$i]['ImagePath'].'" width="100"></li>';
                        }
                        ?>
                    </ol>
                    </div>
                    <!--/.Carousel Wrapper-->
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col">
                            <h1 id="price-desktop"><?php print("€".$recomretprice); ?></h1>
                        </div>
                        <div class="col" id="cooling-desktop"><small>
                            <?php
                            for ($i=0; $i < count($showTemprature); $i++) { 
                                if ($stockItemID == $showTemprature[$i]['stockitemid']) {
                                  if ($showTemprature[1]['ischillerstock'] == 1){
                                    print("<h6 >" . "Dit product is nu: " .  $showTemprature[$i]['temperature']. '°C' . "</h6>"); 
                                    } 
                                  } 
                                }  

                            ?>
                            
                        </small></div>
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
    

//while ($result[0] = $result) {}
//ends the while-loop, niet aankomen

//moet nog implementeren: <h5><a href='https://www.youtube.com/?gl=NL' target='_blank'  title='Go to youtube'>link to the videos</a></h5>




//misschien ooit nodig; een button om een pagina terug te gaan: <script>document.write('<a href="' + document.referrer + '"><button type="button">Back</button></a>');</script>

?>