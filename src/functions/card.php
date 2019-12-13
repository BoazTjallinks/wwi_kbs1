<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Abdullah, Boaz, Jesse, Jordy, Kahn, Ton
 * Card functions
 */

function showItem($productId, $productImage, $productName, $productSpecial, $productDescription, $productPrice) {

            // Product image
            echo '<div class="col-xl-4"><div class="card wwi_noborder"><div class="card-body"><figure class="figure wwi_prdcts_imgcenter"><img class="img-fluid figure-img wwi_prdcts_imgsize" src="assets/img/products/testproduct.png"></figure>';
            // Product name
            echo '<h4 class="card-title"></h4>';
            // Special info
            echo '<h6 class="text-muted card-subtitle mb-2"></h6>';
            // Description
            echo '<p class="card-text"></p>';
            // View product btn
            echo '<div class="row"><div class="col"><a href="" class="btn btn-primary wwi_mainbgcolor wwi_mainborder wwi_mainbgcolorhover wwi_mainborderhover" type="button">View product</button></div>';
            // Price
            echo '<div class="col"><h3 class="wwi_text_right">€47.84<br></h3></div></div></div></div></div>';
}