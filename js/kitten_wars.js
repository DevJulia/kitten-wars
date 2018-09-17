$(function() {
    var nbChecked = 0;
    
    //Menu positionné en haut de page lors du scroll
    $(window).scroll(function() {
        if ($(document).scrollTop() > 370) {
            $('#main-nav').addClass('fixed-top');        
        } else {
            $('#main-nav').removeClass('fixed-top');
        }
    });
    
    //Affichage des attributs du chat au hover sur son avatar
    function hoverKitten() {
        $('.kitten_info').hover(function() {
            $(this).addClass('selected');  
        }, function() {
            $(this).removeClass('selected');    
        });    
    }
    
	var selectedCats = [];
    //Affichage du bouton "lancer combat" lors de la sélection de 2 chatons
	function fightCheckbox() {

		$(".select-kitten").change(function(){
				
            $(this).each(function(index) {            
                 if($(this).is(":checked")) {
                     if (nbChecked >= 2) {
                         $(this).prop('checked', false);
						 $('button[data-toggle="modal"]').trigger('click');
                     } else {
                         nbChecked++;
						 selectedCats.push($(this).attr('value'));

                         if (nbChecked == 2) {
                            $('#startFight').show();
							$('input[name="chaton1"]').attr('value', selectedCats[0]);
							$('input[name="chaton2"]').attr('value', selectedCats[1]);
                         }
                     }
                 } else {
                     nbChecked--;
					 var index = selectedCats.indexOf($(this).attr('value'));
					 if (index > -1) {
						selectedCats.splice(index, 1);
					}

                     $('#startFight').hide();
                 }
            });
        });   
    }
	
	//SAUVEGARDE CASE COCHEE CHATS SI CHANGEMENT PAGE
	function checkCats() {		
		selectedCats.forEach(function(cat) {
			$('input[value="' +cat+ '"]').prop('checked', true);
		});
		
		if (selectedCats.length == 2) {
			$('#startFight').show();
			$('input[name="chaton1"]').attr('value', selectedCats[0]);
			$('input[name="chaton2"]').attr('value', selectedCats[1]);
		}
	}
	
	
	var previousPage = null; 
	var pageSelected = 1;
	var currentPage = null;
	
	function styleActivePage(){
		$('a[data-page="' +pageSelected+ '"]').closest('li').addClass('active');
		
		 // Désactivation des boutons "Précédent" et "suivant" en fonction de la page affichée
		if (pageSelected == 1) {
			$("a[data-page='previous']").closest('.page-item').addClass('disabled');    
			$("a[data-page='next']").closest('.page-item').removeClass('disabled');
		} else if (pageSelected == $('.pagination').attr('data-count')) { 
			$("a[data-page='next']").closest('.page-item').addClass('disabled'); 
			$("a[data-page='previous']").closest('.page-item').removeClass('disabled');  
		} else { 
			$("a[data-page='previous']").closest('.page-item').removeClass('disabled'); 
			$("a[data-page='next']").closest('.page-item').removeClass('disabled');  
		}
	}
    
    function activateChangePage(mode){

        $('.page-link').click(function() {
			
			console.log($('.pagination').attr('data-count'));
            
            if (mode == "once") {
				$("a[data-page='previous']").closest('.page-item').addClass('disabled');
                previousPage = $("a[data-page='1']").closest('.page-item'); 
            }
            
            pageSelected = $(this).attr('data-page');
            currentPage = $(this).closest('.page-item');

            // Fonctionnement des boutons "suivant" et "précédent"
            if (pageSelected == 'next') {
                pageSelected = parseInt(previousPage.find('a').attr('data-page')) + 1 ;
                currentPage = $("a[data-page='" + pageSelected + "']").closest('.page-item');
                $("a[data-page='previous']").closest('.page-item').removeClass('disabled');
				
            } else if (pageSelected == 'previous') {
                pageSelected = parseInt(previousPage.find('a').attr('data-page')) - 1 ;  
                currentPage = $("a[data-page='" + pageSelected + "']").closest('.page-item'); 
                $("a[data-page='next']").closest('.page-item').removeClass('disabled');
            } 

           previousPage=currentPage;    
			
			
			//AFFICHAGE des x chats de la page sélectionnée 
			$.ajax({
				type: 'POST',
				url: 'parts/all_chaton.php',
				data : {
					page: pageSelected,
					catName: $('input[name="catName"]').val(),
					creationDate: $('input[name="creationDate"]').val(),
					power_from: $('input[name="power_from"]').val(),
					power_to: $('input[name="power_to"]').val(),
					cuteness_from: $('input[name="cuteness_from"]').val(),
					cuteness_to: $('input[name="cuteness_to"]').val(),
					sortResults: $('select[name="sortResults"]').val(),
					nbPerPage: $('input[name="nbPerPage"]:checked').val()
				},
				success: function(data) {
					$('#list-cat').html(data); 
					hoverKitten();
					fightCheckbox(); 
					checkCats();
					styleActivePage();
					activateChangePage();},
				error: function() {
					alert('La requête n\'a pas abouti'); }
			});   
        });
    }
	

	//Mise en surbrillance de la page active
	function menuActivePage() {
		var pathname = window.location.pathname; 
		$('.nav-item').each(function() {
			var link = $(this).find('a').attr('href');
			var n = pathname.search(link);
			if (n>0) {
				$(this).addClass('active');
			}	
		});
	}

	menuActivePage();
    
	
	
	//////////////////////
	// RECHERCHE.PHP (+recherche rapide index.php)
	/////////////////////
	
    //Affichage par défaut de la page 1 des chats
    $('#list-cat').load('parts/all_chaton.php', {page: 1}, function() {
        hoverKitten();
        fightCheckbox();  
		styleActivePage();
        activateChangePage("once");
        

        $('select[name="sortResults"]').change(function(){       
            $.ajax({
                type: 'POST',
                url: 'parts/all_chaton.php',
                data : {
                    page: 1,
					catName: $('input[name="catName"]').val(),
					creationDate: $('input[name="creationDate"]').val(),
					power_from: $('input[name="power_from"]').val(),
					power_to: $('input[name="power_to"]').val(),
					cuteness_from: $('input[name="cuteness_from"]').val(),
					cuteness_to: $('input[name="cuteness_to"]').val(),
					nbPerPage: $('input[name="nbPerPage"]').val(),
                    sortResults: $(this).val()
                },
				success: function(data) {
					$('#list-cat').html(data); 
					hoverKitten();
					fightCheckbox(); 
					checkCats();
					activateChangePage("once");
					pageSelected=1;
					styleActivePage();},
                error: function() {
                    alert('La requête n\'a pas abouti'); }
            });   
        });  
		
		$('input[name="nbPerPage"]').change(function(){       
            $.ajax({
                type: 'POST',
                url: 'parts/all_chaton.php',
                data : {
                    page: 1,
					catName: $('input[name="catName"]').val(),
					creationDate: $('input[name="creationDate"]').val(),
					power_from: $('input[name="power_from"]').val(),
					power_to: $('input[name="power_to"]').val(),
					cuteness_from: $('input[name="cuteness_from"]').val(),
					cuteness_to: $('input[name="cuteness_to"]').val(),
					sortResults: $('select[name="sortResults"]').val(),
                    nbPerPage: $(this).val()
                },
				success: function(data) {
					$('#list-cat').html(data); 
					hoverKitten();
					fightCheckbox(); 
					checkCats();
					activateChangePage("once");
					pageSelected=1;
					styleActivePage();},
                error: function() {
                    alert('La requête n\'a pas abouti'); }
            });   
        });   
    });
    

	
	$( "#sliderCuteness" ).slider({
		range: true,
		min: 0,
		max: 100,
		values: [ 0 , 100 ],
		slide: function( event, ui ) {
			$( "#cuteness" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			$('#cuteness_from').val(ui.values[ 0 ]);
			$('#cuteness_to').val(ui.values[ 1 ]);
		}
	});

	$( "#cuteness" ).val(  $( "#sliderCuteness" ).slider( "values", 0 ) +
	" - " + $( "#sliderCuteness" ).slider( "values", 1 ) );


	$( "#sliderPower" ).slider({
		range: true,
		min: 0,
		max: 100,
		values: [ 0 , 100 ],
		slide: function( event, ui ) {
			$( "#power" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			$('#power_from').val(ui.values[ 0 ]);
			$('#power_to').val(ui.values[ 1 ]);
		}
	});

	$( "#power" ).val(  $( "#sliderPower" ).slider( "values", 0 ) +
	" - " + $( "#sliderPower" ).slider( "values", 1 ) );
    
    // Affichage des résultats de la recherche 
    $('#searchBtn').click(function(){
        $.ajax({
            type: 'POST',
            url: 'parts/all_chaton.php',
            data : {
                page: 1,
                catName: $('input[name="catName"]').val(),
                creationDate: $('input[name="creationDate"]').val(),
				power_from: $('input[name="power_from"]').val(),
				power_to: $('input[name="power_to"]').val(),
				cuteness_from: $('input[name="cuteness_from"]').val(),
				cuteness_to: $('input[name="cuteness_to"]').val(),
				sortResults: $('select[name="sortResults"]').val(),
				nbPerPage: $('input[name="nbPerPage"]:checked').val()
            },
            success: function(data) {
                $('#list-cat').html(data); 
			    hoverKitten();
				fightCheckbox(); 
				checkCats();
				activateChangePage("once");
				pageSelected=1;
				styleActivePage();
        		},
            error: function() {
                alert('La requête n\'a pas abouti'); }
        });   
        return false;
    });
    
    
        $('input').keypress(function(e) {
            if(e.which == 13) {
                $('#searchBtn').trigger('click');
            }    
        });
    
    
    $( "#datepicker" ).datepicker( $.datepicker.regional[ "fr" ] );
    

	
    $('.autocomplete').autocomplete({
		source : 'liste.php'	
	});
	
	$( ".autocomplete" ).on( "autocompleteselect", function( event, ui ) {
			
	});
	
	
	//////////////////////
	// START_FIGHT.PHP
	/////////////////////

	$('#showFight').click(function(){
		$('#stepsFight').removeClass('d-none');	
	});
	
	
	//////////////////////
	// ALL_FIGHTS.PHP
	/////////////////////

	//Affichage par défaut de la page 1 de l'historique des combats
    $('#list-fights').load('parts/all_fights.php', {page: 1}, function() {
            
    });
	

		
	
	//////////////////////
	// CREER_CHATON.PHP
	/////////////////////
	
	$('#formRandom').hide();
	
	//Choix du mode de création
	$('input[value="random"]').click(function(){
		$('#formCustom').hide();
		$('#formRandom').show();
	});
	
	$('input[value="custom"]').click(function(){
		$('#formRandom').hide();
		$('#formCustom').show();
	});
	

	$('#formCustom').validate({
		ignore: ".optional",
		
		rules : {
			name : "required",
			cuteness : {
				required : true,
				digits: true,
				range : [0,100]
			},
			power : {
				required : true,
				digits: true,
				range : [0,100]				
			}
		}, 
		messages : {
			name : "Veuillez fournir un prénom composé uniquement de chiffres et de lettres",
			cuteness: {
				required: "Veuillez saisir les points de mignonnitude",
				digits: "Veuillez saisir un nombre entier entre 0 et 100",
				range: "Veuillez saisir un nombre entier entre 0 et 100"
			},
			power: {
				required: "Veuillez saisir les points de mignonnitude",
				digits: "Veuillez saisir un nombre entier entre 0 et 100",
				range: "Veuillez saisir un nombre entier entre 0 et 100"
			}
		},
		errorClass: "invalid"
		  
	});
	
	$.validator.addMethod(
		"name",
		function(value, element) {
			return /^[éàèça-zA-Z0-9 ]+$/.test(value);
		}
	);
	
	$('#custSubmitBtn').click(function(){
		$('.text-muted').hide();	
	});
	
	
	
	//////////////////////
	//     CHAT.PHP
	/////////////////////

	//Lors de la confirmation de la suppression, on envoie l'id du chat à supprimer
	$('#validateDel').click(function() {
		$('#confirmModal').modal('toggle');
		$("#confirmModal").on("hidden.bs.modal", function () {
   			var id = $('#validateDel').attr('data-kitten');
			$('#cat-profile').load('parts/delete_cat.php', {cat: id});
		});
	});
	
	
	//Affichage du formulaire de modification de chat
	$('#editCat-btn').click(function() {
		$('.detailed_stats input').show();
		$('.attr_cats').hide();
	});
	
	$('#cancel_modif').click(function() {
		$('.detailed_stats input').hide();
		$('.attr_cats').show();
	});
	
});