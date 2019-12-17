$(document).ready(function() {

if(window.location.href.indexOf('#cart') != -1) {
    $('#cart').modal('show');
}

});

function showSwall(title, text, icon, redirect) {
    swal({ title: title, text: text, icon: icon, }).then(function(){ 
        location.replace(redirect);
        }
     );  
}

