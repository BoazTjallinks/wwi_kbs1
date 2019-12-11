<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Abdullah, Boaz, Jesse, Jordy, Kahn, Ton
 * Card functions
 */

function showItem($productId, $productImage, $productName, $productSpecial, $productDescription, $productPrice) {

    // Product Image
    echo '<div class="col-xl-4"><div class="card wwi_prdcts_card wwi_mat_3"><div class="card-body"><figure class="figure wwi_prdcts_imgcenter"><img class="img-fluid figure-img wwi_prdcts_imgsize" src="'.$productImage.'"></figure>';
    // Product Name
    echo '<h4 class="card-title">'.$productName.'</h4>';
    // Product Special
    echo '<h6 class="text-muted card-subtitle mb-2">'.$productImage.'</h6>';
    // Product Description
    echo '<p class="card-text">'.$productDescription.'</p>';
    // Product btn
    echo '<div class="row"><div class="col"><a href="/productview?id='.$productId.'" class="btn btn-primary wwi_mainbgcolor wwi_mainborder wwi_mainbgcolorhover wwi_mainborderhover" role="button">View product</a></div>';
    // Product Price
    echo '<div class="col"><h3 class="wwi_text_right">€'.$productPrice.'<br></h3></div></div></div></div></div>';
}