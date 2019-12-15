<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Abdullah, Boaz, Jesse, Jordy, Kahn, Ton
 * Card functions
 */

function showItem($productId, $productImage, $productName, $productSpecial, $productDescription, $productPrice) {

    // Product Image
    echo '<div class="col-xl-4"><div class="card wwi_prdcts_card wwi_mat_3"><div class="card-body d-flex flex-column"><figure class="figure wwi_prdcts_imgcenter"><img class="img-fluid figure-img d-xl-flex wwi-itemimg wwi-center" src="'.$productImage.'"></figure>';
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

function showInput(int $amount, array $inputName, array $inputId, array $inputTitle, array $inputType, array $formClass, array $inputPlaceholder, array $inputClass) {
    for ($i=0; $i < $amount; $i++) { 
        echo '<div class="form-group '.$formClass[$i].'">';
            echo '<label for="'.$inputId[$i].'">'.$inputTitle[$i].'</label>';
            echo '<input name="'.$inputName[$i].'" type="'.$inputType[$i].'" class="form-control '.$inputClass[$i].'" id="'.$inputId[$i].'" placeholder="'.$inputPlaceholder[$i].'">';
        echo '</div>';
    }
}

function showSwall($title, $text, $icon, $redirect) {
    // return '<script> showSwall('.$title.', '.$text.', '.$icon.', '.$redirect.'); </script>';

    return '<script> swal({ title: '.$title.', text: '.$text.', icon: '.$icon.', }).then(function(){ 
        location.replace('.$redirect.');
        }
     ); </script>';

} 