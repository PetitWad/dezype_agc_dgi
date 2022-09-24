var conter = 1;

function add_more_field(){
    conter += 1;
    HTML ='<div class="row" id="row'+conter+ '">\
            <div class="col-3 mb-2">\
                <input type="text" name="nom'+conter+ '" class="multiForm" placeholder="Nom employé">\
            </div>\
            <div class="col-3 mb-2">\
                <input type="text" name="prenom'+conter+ '" class="multiForm"  placeholder="Prenom employé">\
            </div>\
            <div class="col-3 mb-2">\
                <input type="number" name="nif'+conter+ '" class="multiForm"  placeholder="Nif employé">\
            </div>\
            <div class="col-3 mb-2">\
                <input type="number" name="salaire'+conter+ '" class="multiForm"  placeholder="salaire employé">\
            </div>\
        </div>'

        var form = document.getElementById('product_form');
        form.innerHTML += html

}






