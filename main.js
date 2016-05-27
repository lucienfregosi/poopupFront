var map;
var lat;
var lng;
var current_info_window;

$(document).ready(function() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: 			new google.maps.LatLng(46.614190, 2.556114), 	        // Map center
	zoom: 				17, 														// Zoom level, 0 = earth view to higher value
	panControl: 		true, 													// Enable pan Control
	zoomControl: 		true, 													// Enable zoom control
	zoomControlOptions: { style: google.maps.ZoomControlStyle.SMALL }, 			// Zoom control buttons size
	scaleControl: 		true, 													// Enable scale control
	mapTypeId: 			google.maps.MapTypeId.ROADMAP 	
  });


 getLocation();

 // on va ajouter un listener sur la carte pour pouvoir créer un nouveau wc
 google.maps.event.addListener(map, 'click', function(event) {
   create_wc(event.latLng);
});

});


function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        console.log("localisation impossible")
    }
}
function showPosition(position) {
    //x.innerHTML = "Latitude: " + position.coords.latitude + 
    //"<br>Longitude: " + position.coords.longitude; 
    lat = position.coords.latitude;
    lng = position.coords.longitude;
    map.setCenter(new google.maps.LatLng(lat, lng));
    // On va afficher une marker de couleur différente la ou l'utilisaateur est localisé. Voir après comment changer en un point bleu plutot
    var gpoint = {lat: lat, lng: lng}
    var marker = new google.maps.Marker({position: gpoint, map: map, icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'});

    // on appele l'api pour charger les wc
    getGooglePlaces();
    getOtherWC();
}

function getGooglePlaces(){
    // Dans l'api il faut lui passer des nombres a virgule comme séparateur
	var lat_coma = lat.toString().replace(".",',');
	var lng_coma = lng.toString().replace(".",',');
	var url = 'http://54.218.31.103:5555/gplaces/'+ lat_coma +'/'+ lng_coma +'';
	$.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function(gplace_list){
            	for(var i =0; i < gplace_list.result.length; i++){
                var gpoint = {lat: gplace_list.result[i].latitude, lng: gplace_list.result[i].longitude}
                var marker = new google.maps.Marker({position: gpoint, map: map, adress: gplace_list.result[i].adress, name: gplace_list.result[i].name, type: gplace_list.result[i].type, src_id : 'gplaces', lat : gplace_list.result[i].latitude, lng : gplace_list.result[i].longitude});

                // On va ajouter un envent au clic sur le marker pour ouvrir une info window
                addListenerGoogle(marker);
            }
            // Tester si on doit rapeller la fonction avec le next token
            if(gplace_list.pagetoken != 'null'){
                setTimeout(function(){
                        getGooglePlacesNextToken(gplace_list.pagetoken);
                }, 2000);
            }
        },
        error : function(err){
            console.log(err);
        }
    });
}

// Fonction appelé quand on a un token pour les 20 résultats suivant
function getGooglePlacesNextToken(nextToken){
    // Dans l'api il faut lui passer des nombres a virgule comme séparateur
    var lat_coma = lat.toString().replace(".",',');
    var lng_coma = lng.toString().replace(".",',');
    var url = 'http://54.218.31.103:5555/gplaces/'+ lat_coma +'/'+ lng_coma +'&pagetoken='+ nextToken +'';
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function(gplace_list){
            for(var i =0; i < gplace_list.result.length; i++){
                // On crée le marker
                var gpoint = {lat: gplace_list.result[i].latitude, lng: gplace_list.result[i].longitude}
                var marker = new google.maps.Marker({position: gpoint, map: map,adress: gplace_list.result[i].adress, name: gplace_list.result[i].name, type: gplace_list.result[i].type, src_id : 'gplaces', lat : gplace_list.result[i].latitude, lng : gplace_list.result[i].longitude });

                addListenerGoogle(marker);
                
            }
            // Tester si on doit rapeller la fonction avec le next token
            if(gplace_list.pagetoken != 'null'){
                setTimeout(function(){
                        getGooglePlacesNextToken(gplace_list.pagetoken);
                }, 2000);
            }
        },
        error : function(err){
            console.log(err);
        }
    });
}


function getOtherWC(){
    var url = 'http://54.218.31.103:5555/wc';
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function(wc_list){
            console.log(wc_list);
            // on affiche tous les WC contenus dans notre BDD
            for(var i =0; i < wc_list.wc.length; i++){
                // A voir comment on peut les adapter au meme format que titre type adresse note et aller chercher la note. Gestion de l'utf8 dans les scripts d'enregistrement
                var gpoint = {lat: parseFloat(wc_list.wc[i].latitude), lng: parseFloat(wc_list.wc[i].longitude)}
                var marker = new google.maps.Marker({position: gpoint, map: map, name : wc_list.wc[i].wc_name, type: wc_list.wc[i].type, src_id : 'internal', zIndex : 10000, id : wc_list.wc[i].WC_id, note :wc_list.wc[i].note});

                addListenerInternal(marker);
            }
        },
        error : function(err){
            console.log(err);
        }
    });
}

function addListenerInternal(marker){

    marker.addListener('click', function(event) {
            // Si le nom est pareil que le type on en affiche qu'un
            if(this.name ==  null){
              var name = this.type;
              var type = "";
            }
            else{
              var name = this.name;
              var type = this.type;
            }
           var info_window_html = '<div id="content">'+
                        '<h1 id="firstHeading" class="firstHeading">' + name +'</h1>'+
                        '<div id="bodyContent"><p>'+ type +'</p>'+
                        '<p>Note :'+ this.note +'</p>'+
                        '<form action="wc.detail.php" method="POST">' +
                        '<input type="hidden" name="id" value="'+ this.id +'" ></input>' +
                        '<input type="hidden" name = "src_id" value="'+ this.src_id +'" ></input>' +
                        '<input type="submit" value="voir"/>' +
                        '</form></div>'+
                        '</div>';

          // Il faudrat envoyer dans le post de voir de l'info window nom, type, et éditer prix, nombre toilette

          var info_window = new google.maps.InfoWindow({ content : info_window_html });
          info_window.setPosition(event.latLng);
          // Puis on lui demande de s'ouvrir sur notre carte
          info_window.open(map);
    
    });

}

function addListenerGoogle(marker){

    marker.addListener('click', function(event) {
        // A voir comment tu veux l'afficher biatch de front end
        // on vient de l'api google on a donc pas de notes
        var note = 'undef';
        console.log(this);

        // On veut construire une "pop up" avec les informations qu'on a. Par défaut on met une note à 0 ou inconnu et si l'utilisateur le note, on l'enregistre dans notre base
        // il faut construire un submit avec les différentes informartions pour pouvoir soit l'enregistrer si cela vient de gplaces, ou le modifier si c'est notre api interne
        var info_window_html = '<div id="content">'+
                        '<h1 id="firstHeading" class="firstHeading">' + this.name +'</h1>'+
                        '<div id="bodyContent"><p>'+ this.type +'</p>'+
                        '<p>Note :'+ note +'</p>'+
                        '<form action="wc.detail.php" method="POST">' +
                        '<input type="hidden" name="name" value="'+ this.name +'" ></input>' +
                        '<input type="hidden" name= "type" value="'+ this.type +'" ></input>' +
                        '<input type="hidden" name = "src_id" value="'+ this.src_id +'" ></input>' +
                        '<input type="hidden" name = "lat" value="'+ this.lat +'" ></input>' +
                        '<input type="hidden" name = "lng" value="'+ this.lng +'" ></input>' +
                        '<input type="hidden" name = "adress" value="'+ this.adress +'" ></input>' +
                        '<input type="submit" value="voir"/>' +
                        '</form></div>'+
                        '</div>';


        // Il faudrat envoyer dans le post de voir de l'info window nom, type, et éditer prix, nombre toilette

        var info_window = new google.maps.InfoWindow({ content : info_window_html });
        info_window.setPosition(event.latLng);
        // Puis on lui demande de s'ouvrir sur notre carte
        info_window.open(map);


    });

}

function create_wc(location) {

    if(current_info_window !== undefined){
        current_info_window.close();
        console.log("closing");
    }

    // Faudrait le décaler pour pas que l'info window passe juste au dessus du marker
    var marker = new google.maps.Marker({
        position: location, 
        map: map
    });


    var html = '<div id="content"> '+
          '<form method="POST" action="wc.create.php">' +
         '<label> Voulez vous créer un nouveau wc ? </label>' +
         '<input type="submit" value="yes"/>' +
         '<input type="hidden" value="' + location.lat() +'" name="latitude" />' +
          '<input type="hidden" value="' + location.lng() +'" name="longitude" />' +
         '</form>' +
         '<a id="myLink" href="#" onclick="close_info_window();">No</a>'+
         '</div>';

    // On set une info window pour demander la création de toilette ou non
    var info_window2 = new google.maps.InfoWindow({ content : html });
    info_window2.setPosition(location);
    // Puis on lui demande de s'ouvrir sur notre carte
    info_window2.open(map);

    current_info_window = info_window2;

    console.log(location.lat());

}

function close_info_window(){

    // On ferme l'info window
    current_info_window.close();
}