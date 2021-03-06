$(document).ready(function() {

    /** Cacher les différentes sections en fonction du type de membre */
    $('input[name=type_contrat]').change(function() {
        if($(this).is(':checked') && ($(this).attr("value") == "membre" || $(this).attr("value") == "membre engage"
                                        || $(this).attr("value") == "autre")) {
            $('#implication').hide();
            $('#dispo').hide();
            $('#form_eng').hide();
            $('#socio').show();
        }
    });

    $('#type_autre').change(function() {
        if($(this).is(':checked')) {
            $('#socio').hide();
            $('#contact_urg').hide();
            $('#langue_c').hide();
            $('#premier_rdv').hide();
        }
    });

    $('#membre_eng').change(function() {
        if($(this).is(':checked')) {
            $('#socio').show();
            $('#langue_c').show();
            $('#dispo').show();
            $('#form_eng').show();
            $('#implication').show();
            $('#contact_urg').show();
            $('#premier_rdv').show();
        }
    });
    
    $('#type_benevole').change(function() {
        if($(this).is(':checked')) {
            $('#socio').hide();
            $('#langue_c').show();
            $('#dispo').show();
            $('#form_eng').show();
            $('#implication').show();
            $('#contact_urg').show();
            $('#premier_rdv').show();
        }
    });

    /** Evenement option autre*/
    $('input[name=statut]').change(function() {
        if($(this).attr("id")  == "sautre" && $(this).is(':checked'))
            $('input[type=text][name=statut]').attr("disabled",false);
        else if($(this).attr('type') == "radio") 
            $('input[type=text][name=statut]').attr("disabled",true);
    });

    $('input[name=logement]').change(function() {
        if($(this).attr("id")  == "logautre" && $(this).is(':checked'))
            $('input[type=text][name=logement]').attr("disabled",false);
        else if($(this).attr('type') == 'radio')
            $('input[type=text][name=logement]').attr("disabled",true);
    })

    $('input[name=menage]').change(function() {
        if($(this).attr("id")  == "menautre" && $(this).is(':checked'))
            $('input[type=text][name=menage]').attr("disabled",false);
        else if($(this).attr('type') == 'radio')
            $('input[type=text][name=menage]').attr("disabled",true);
    })

    $('input[name=langue]').change(function() {
        if($(this).attr("id")  == "lautre" && $(this).is(':checked'))
            $('input[type=text][name=langue]').attr("disabled",false);
        else if($(this).attr('type') == 'radio')
            $('input[type=text][name=langue]').attr("disabled",true);
    })

    $('input[name=occupation]').change(function() {
        if($(this).attr("id")  == "occupautre" && $(this).is(':checked'))
            $('input[type=text][name=occupation]').attr("disabled",false);
        else if($(this).attr('type') == 'radio')
            $('input[type=text][name=occupation]').attr("disabled",true);
    })

    $('input[name=source_revenu]').change(function() {
        if($(this).attr("id")  == "revautre" && $(this).is(':checked'))
            $('input[type=text][name=source_revenu]').attr("disabled",false);
        else if($(this).attr('type') == 'radio')
            $('input[type=text][name=source_revenu]').attr("disabled",true);
    })

    /** Transformation des majuscules en minuscule dans les inputs */
    $('.form-control[name != courriel]').keyup(function(){
        var val = $(this).val().toLowerCase();
        $(this).val(val);
    });

    /** Maximum de 255 caractères dans les textareas (maximum varchar)  */
    $('textarea').keyup(function(){
        var para = $(this).prev().children();
        var taille = 255 - $(this).val().length;
        
        if(taille > 0) {
            para.text(taille);
            $(this).css("border-color","grey");
        }
        else {
            $(this).css("border-color","red");
        }
    });

    /** Verication chiffre input revenu et numéro civique, numéro bénévole */
    $('#idB').keyup(function() {
        var input = $(this).val();
        var regex = new RegExp("[^0-9]");
        if (regex.test(input)) {
            //$(this).val(input.substr(0, input.length-1));
            $(this).css("border-color","red");
        }
        else {
            $(this).css("border-color","grey");
        }
    });

    $('#civique').keyup(function() {
        var input = $(this).val();
        var regex = new RegExp("[^0-9]");
        if (regex.test(input)) {
            //$(this).val(input.substr(0, input.length-1));
            $(this).css("border-color","red");
        }
        else {
            $(this).css("border-color","grey");
        }
    });

    $('#revenu').keyup(function() {
        var input = $(this).val();
        var regex = new RegExp("[^0-9]");
        if (regex.test(input)) {
            //$(this).val(input.substr(0, input.length-1));
            $(this).css("border-color","red");
        }
        else {
            $(this).css("border-color","grey");
        }
    });

    /** Envoie formulaire */
    //Vérification champs
    $("#submit").click(function(event) {
        event.preventDefault();
        erreur = false;
        $('#erreur').attr("class","")
        $('#erreur').html("");
        $("#benevole input[name != date_ins][name != montant]").each(function() {
            if($(this).val() == "") {
                $(this).css("border-color","red");
                erreur = true;
            }
            else
                $(this).css("border-color","grey");
        });
        

        if(!$('#type_autre').is(':checked')) {

            // Verification input contact d'urgence
            $("#contact_urg input").each(function() {
                if($(this).val() == "") {
                    $(this).css("border-color","red");
                    erreur = true;
                }
                else
                    $(this).css("border-color","grey");
            });

            // verification langue commnunication
            compt = 0;
            $("input[name=langue]").each(function() {
                if($(this).is(':checked'))
                    compt++;
            });
            if($("input[name=langue][type=text]").val() != "")
                compt++;
            $('#langue').html("");
            $('#langue').attr("class","");
            if(compt == 0) {
                    erreur = true;
                    $('#langue').attr("class","alert alert-danger");
                    $('#langue').append("<strong>Attention!</strong> Veuillez cocher un choix");
            }

            if($('#type_benevole').is(':checked') || $('#membre_eng').is(':checked')) {
                // Verification input premier rendez vous
                $("#premier_rdv input").each(function() {
                    if($(this).val() == "") {
                        $(this).css("border-color","red");
                        erreur = true;
                    }
                    else
                        $(this).css("border-color","grey");
                });

                // verification competence
                compt = 0;
                $("#comp input").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                $('#comp_err').html("");
                $('#comp_err').attr("class","");
                if(compt == 0) {
                        erreur = true;
                        $('#comp_err').attr("class","alert alert-danger");
                        $('#comp_err').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }

                // verification nature engagement
                compt = 0;
                $("input[name=engagement]").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                $('#eng_err').html("");
                $('#eng_err').attr("class","");
                if(compt == 0) {
                        erreur = true;
                        $('#eng_err').attr("class","alert alert-danger");
                        $('#eng_err').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }

                // verification intégration
                compt = 0;
                $("input[name=integration]").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                $('#int_err').html("");
                $('#int_err').attr("class","");
                if(compt == 0) {
                        erreur = true;
                        $('#int_err').attr("class","alert alert-danger");
                        $('#int_err').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }

                //verification charge
                compt = 0;
                $("#charge input").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                $('#charge_err').html("");
                $('#charge_err').attr("class","");
                if(compt == 0) {
                        erreur = true;
                        $('#charge_err').attr("class","alert alert-danger");
                        $('#charge_err').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }

                //verification dispo
                compt = 0;
                $("#dispo input").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                $('#dispo_err').html("");
                $('#dispo_err').attr("class","");
                if(compt == 0) {
                        erreur = true;
                        $('#dispo_err').attr("class","alert alert-danger");
                        $('#dispo_err').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }
            }

            if(!$('#type_benevole').is(':checked')) {

                // verification nationalite
                compt = 0;
                $("input[name=nationalite]").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                
                $('#natio_err').html("");
                $('#natio_err').attr("class","");
                if(compt == 0) {
                        erreur = true;
                        $('#natio_err').attr("class","alert alert-danger");
                        $('#natio_err').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }

                // verification statut coché
                compt = 0;
                $("input[name=statut]").each(function() {
                    if($(this).is(':checked')) {
                        compt++;
                    }
                });
                if($("input[name=statut][type=text]").val() != "")
                    compt++;
                $('#statut').html("");
                $('#statut').attr("class","");
                console.log(compt);
                if(compt == 0) {
                        $('#statut').attr("class","alert alert-danger");
                        $('#statut').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }

                // verification logement
                compt = 0;
                $("input[name=logement]").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                if($("input[name=logement][type=text]").val() != "")
                    compt++;
                $('#logement').html("");
                $('#logement').attr("class","");
                if(compt == 0) {
                        erreur = true;
                        $('#logement').attr("class","alert alert-danger");
                        $('#logement').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }

                // verification menage
                compt = 0;
                $("input[name=menage]").each(function() {
                    if($(this).is(':checked'))
                        compt++;
                });
                if($("input[name=menage][type=text]").val() != "")
                    compt++;
                $('#menage').html("");
                $('#menage').attr("class","");
                if(compt == 0) {
                        erreur = true;
                        $('#menage').attr("class","alert alert-danger");
                        $('#menage').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }

                // verification occupation
                compt = 0;
                $('#occupation').html("");
                $('#occupation').attr("class","");
                $("input[name=occupation]").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                if($("input[name=occupation][type=text]").val() != "")
                    compt++;
                if(compt == 0) {
                        erreur = true;
                        $('#occupation').attr("class","alert alert-danger");
                        $('#occupation').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }
                
                // verification source revenu
                compt = 0;
                $('#source_revenu').html("");
                $('#source_revenu').attr("class","");
                $("input[name=source_revenu]").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                if($("input[name=source_revenu][type=text]").val() != "")
                    compt++;
                if(compt == 0) {
                        erreur = true;
                        $('#source_revenu').attr("class","alert alert-danger");
                        $('#source_revenu').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }

                // verification niveau scolarité
                compt = 0;
                $('#sco_err').html("");
                $('#sco_err').attr("class","");
                $("input[name=niveau_sco]").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                if(compt == 0) {
                        erreur = true;
                        $('#sco_err').attr("class","alert alert-danger");
                        $('#sco_err').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }

                // verification référence
                compt = 0;
                $('#ref_err').html("");
                $('#ref_err').attr("class","");
                $("input[name=referer]").each(function() {
                    if($(this).is(':checked')) 
                        compt++;
                });
                if(compt == 0) {
                        erreur = true;
                        $('#ref_err').attr("class","alert alert-danger");
                        $('#ref_err').append("<strong>Attention!</strong> Veuillez cocher un choix");
                }
            }
        }

        //enregistrement benevole
        if(!erreur) {

            if($('#type_autre').is(':checked')) 
                dataform = $('#benevole input').serialize()+"&"+$('#dossier_revenu').serialize();
            else if($('#type_benevole').is(':checked'))
                dataform = $('#benevole input').serialize()+ "&"+ $('#langue_c').serialize()+ "&"+ $('#form_eng').serialize()
                            +"&"+$('#type_benevole').serialize()+"&"+$('#contact_urg').serialize()+"&"+$('#premier_rdv').serialize();
            else
                dataform = $('#benevole input').serialize()+ "&"+ $('#socio input').not($('#socio input[id *= autre]')).serialize()+ "&"+ $('#form_eng').serialize()
                +"&"+$('#type_benevole').serialize()+"&"+$('#contact_urg').serialize()+ "&"+ $('#langue_c').serialize()+"&"+$('#premier_rdv').serialize();
            console.log(dataform);
            $('#erreur').html("");
            $('#erreur').attr("class","");
            $.ajax({
                url: './php/ajoutB.php',
                type: 'post',
                dataType: 'json',
                data: dataform
            })
            .done(function(data) {
                console.log(data);
                if(data['exist']) {
                    erreur = true;
                    $('#erreur').attr("class","alert alert-warning");
                    $('#erreur').html("<strong>Attention !</strong> benevole ou numéro bénévole existant !");
                }
                else if(data['correct']) {
                    $('#erreur').attr("class","alert alert-success");
                    $('#erreur').html("benevole enregistrer !");
                    
                    if(!$('#type_autre').is(':checked')) {

                        if($('#type_benevole').is(':checked') || $('#membre_eng').is(':checked')) {
                            //enregistrement compétence
                            $.ajax({
                                url: './php/ajoutBComp.php',
                                type: 'post',
                                dataType: 'json',
                                data: $('#comp input').serialize()+"&nom="+$('input[name=nom]').val()+"&prenom="+$('input[name=prenom]').val() //+ "&"+ $('#socio').serialize()
                            })
                            .done(function(data) {
                                console.log("ajout compétence: " +data);
                            })

                            //enregistrement charges
                            $.ajax({
                                url: './php/ajoutBCharge.php',
                                type: 'post',
                                dataType: 'json',
                                data: $('#charge input').serialize()+"&nom="+$('input[name=nom]').val()+"&prenom="+$('input[name=prenom]').val() //+ "&"+ $('#socio').serialize()
                            })
                            .done(function(data) {
                                console.log("ajout charge: "+ data);
                            })
                    
                            //enregistrement dispo
                            $('#dispo tr[name != entete]').each(function() {
                                var name = $(this).attr("name");                                
                                $.ajax({
                                    url: './php/ajoutBDispo.php',
                                    type: 'post',
                                    dataType: 'json',
                                    data: $('tr[name ='+name+'] input').serialize()+"&nom="+$('input[name=nom]').val()+"&prenom="+$('input[name=prenom]').val()+"&dispo="+name//+ "&"+ $('#socio').serialize()
                                })
                                .done(function(data) {
                                    console.log("ajout dispo " + data);
                                })
                            });

                           
                        }

                        //enregistrement commentaire
                        //console.log($('#ob_comp').serialize()+$('#ob_charge').serialize()+"&"+$('#ob_dispo').serialize()+"&"+$('#ob').serialize());
                        $.ajax({
                            url: './php/ajoutOb.php',
                            type: 'post',
                            dataType: 'json',
                            data:$('#ob_comp').serialize()+"&"+$('#ob_charge').serialize()+"&"+$('#ob_dispo').serialize()+"&"+$('#ob').serialize()
                                +"&prenom="+$('input[name=prenom]').val()+"&nom="+$('input[name=nom]').val() 
                        })
                        .done(function(data) {
                            console.log("ajout obs" + data);
                        })

                        // Enregistrement dossier revenu
                        $.ajax({
                            url: './php/ajoutDosRev.php',
                            type: 'post',
                            dataType: 'json',
                            data:$('#dossier_revenu').serialize()+"&prenom="+$('input[name=prenom]').val()+"&nom="+$('input[name=nom]').val() 
                        })
                        .done(function(data) {
                            console.log("ajout dossier revenu" + data);
                        })
                    }

                    setTimeout(function() {
                        $('#erreur').slideUp();
                        $('#erreur').html("").attr("class","").slideDown();
                        location.reload();
                        $('input').val('');
                        $('input:checked').prop('checked',false);
                        $('input[type=text][name=statut]').attr("disabled",true);
                        $('input[type=text][name=langue]').attr("disabled",true);
                        $('input[type=text][name=logement]').attr("disabled",true);
                        $('input[type=text][name=menage]').attr("disabled",true);
                        $('input[type=text][name=occupation]').attr("disabled",true);
                        $('input[type=text][name=source_revenu]').attr("disabled",true);
                        $('#date').val('année/mois/jour');
                        $('textarea').val('');
                    },5000);
                }
            })
            erreur =false;
        }
        else {
            $('#erreur').attr("class","alert alert-danger")
            $('#erreur').append("<strong>Attention!</strong> oublie champs obligatoire")
            erreur = false;
        }
    });
});