function showSwall(title, text, icon, redirect) {
    swal({ title: title, text: text, icon: icon, }).then(function(){ 
        location.replace(redirect);
        }
     );  
}