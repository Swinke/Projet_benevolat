$(document).ready(function() {
    console.log("test");
    $.getJSON("./php/chercherBenevole.php", function(data) {
        $.each(data, function (i,benevole) {
            $('table').append("<tr id='"+benevole.idBenevole+"'><td>"+benevole.idBenevole+"</td><td>"+benevole.nom+"</td><td>"+benevole.prenom+"</td><td>"+benevole.integration+"</td></tr>");
            if(benevole.integration == "false") {
                $("#"+benevole.idBenevole).css("background-color","yellow");
            }
        });
    });
});