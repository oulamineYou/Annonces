window.onload = () =>{
    let buttons = document.querySelectorAll(".custom-control-input");

    for(let button of buttons)
    {
        button.addEventListener("click", activer);
    }
} 

function activer() {
    let xmlhttp = new XMLHttpRequest;
    
    xmlhttp.open('GET', '/admin/activeAnnonce/'+this.dataset.id);

    xmlhttp.send();
}

function  deleteConfirme(id) {
    res = confirm("êtes vous sûr de vouloir supprimer l'annonce"+id);
    if(res)
        window.location="/annonces/delete/"+id;
}