var map;
var lat;
var lng;
var current_info_window;
var marker_create_wc;

$(document).ready(function() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: 			new google.maps.LatLng(46.614190, 2.556114), 	        // Map center
	zoom: 				18, 														// Zoom level, 0 = earth view to higher value
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
    var marker = new google.maps.Marker({
      position: gpoint,
      map: map,
      animation: google.maps.Animation.DROP,
      icon: 'img/poop.png'
    });

    // on appele l'api pour charger les wc


    getGooglePlaces();
    $('.spinner-container').fadeOut();
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
                var marker = new google.maps.Marker({
                  position: gpoint,
                  map: map,
                  adress: gplace_list.result[i].adress,
                  name: gplace_list.result[i].name,
                  type: gplace_list.result[i].type,
                  src_id : 'gplaces',
                  animation: google.maps.Animation.DROP,
                  icon: 'img/toilet.png',
                  lat : gplace_list.result[i].latitude,
                  lng : gplace_list.result[i].longitude,
                  zIndex : 0
                });

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
          console.log(gplace_list);
            for(var i =0; i < gplace_list.result.length; i++){
                // On crée le marker
                var gpoint = {lat: gplace_list.result[i].latitude, lng: gplace_list.result[i].longitude}
                var marker = new google.maps.Marker({
                  position: gpoint,
                  map: map,adress: gplace_list.result[i].adress,
                  name: gplace_list.result[i].name,
                  type: gplace_list.result[i].type,
                  src_id : 'gplaces',
                  animation: google.maps.Animation.DROP,
                  icon: 'img/toilet.png',
                  lat : gplace_list.result[i].latitude,
                  lng : gplace_list.result[i].longitude,
                  zIndex : 0
                });

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
            // on affiche tous les WC contenus dans notre BDD
            for(var i =0; i < wc_list.wc.length; i++){
                // A voir comment on peut les adapter au meme format que titre type adresse note et aller chercher la note. Gestion de l'utf8 dans les scripts d'enregistrement
                var gpoint = {lat: parseFloat(wc_list.wc[i].latitude), lng: parseFloat(wc_list.wc[i].longitude)}
                var marker = new google.maps.Marker({
                  position: gpoint,
                  map: map,
                  name : wc_list.wc[i].wc_name,
                  type: wc_list.wc[i].type,
                  src_id : 'internal',
                  zIndex : 10000,
                  animation: google.maps.Animation.DROP,
                  icon: 'img/toilet.png',
                  id : wc_list.wc[i].WC_id,
                  note :wc_list.wc[i].note
                });

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
            console.log('internal');
            if(this.name ==  null){
              var name = this.type;
              var type = "";
            }
            else{
              var name = this.name;
              var type = this.type;
            }

            var note = (this.note != 'undef' ? this.note : 0);

            var info_window_html = '<div id="iw-container">'+
                            '<div class="iw-title">' + this.name +'</div>' +
                            '<div class="iw-content">' +
                            '<div class="iw-subTitle">Type: '+ this.type +'</div>' +
                            '<div id="rateYoMap' + this.name.replace(/\s+/g, '').toLowerCase() + '" data-note="' + note +'"></div>' +
                            '<form class="button" action="wc.detail.php" method="POST">' +
                            '<input type="hidden" name="name" value="'+ this.name +'" ></input>' +
                            '<input type="hidden" name= "type" value="'+ this.type +'" ></input>' +
                            '<input type="hidden" name = "src_id" value="'+ this.src_id +'" ></input>' +
                            '<input type="hidden" name = "lat" value="'+ this.lat +'" ></input>' +
                            '<input type="hidden" name = "lng" value="'+ this.lng +'" ></input>' +
                            '<input type="hidden" name = "adress" value="'+ this.adress +'" ></input>' +
                            '<input type="hidden" name = "id" value="'+ this.id +'" ></input>' +
                            '<input class="button" type="submit" value="voir"/>' +
                            '</form></div>'+
                            '</div>';

          // Il faudrat envoyer dans le post de voir de l'info window nom, type, et éditer prix, nombre toilette

          var info_window = new google.maps.InfoWindow({ content : info_window_html });
          info_window.setPosition(event.latLng);
          // Puis on lui demande de s'ouvrir sur notre carte
          info_window.open(map);

          console.log($("#rateYoMap" + this.name.replace(/\s+/g, '').toLowerCase()).rateYo({
           rating: $("#rateYoMap" + this.name.replace(/\s+/g, '').toLowerCase()).data('note'),
           readOnly: true
         }))

    });

}

function addListenerGoogle(marker){

    marker.addListener('click', function(event) {
        console.log('google');
        // A voir comment tu veux l'afficher biatch de front end
        // on vient de l'api google on a donc pas de notes
        var note = (this.note != 'undefined' ? 0 : this.note);
        console.log("passe");

        // On veut construire une "pop up" avec les informations qu'on a. Par défaut on met une note à 0 ou inconnu et si l'utilisateur le note, on l'enregistre dans notre base
        // il faut construire un submit avec les différentes informartions pour pouvoir soit l'enregistrer si cela vient de gplaces, ou le modifier si c'est notre api interne
        var info_window_html = '<div id="content">'+
                        '<div id="iw-container">'+
                        '<div class="iw-title">' + this.name +'</div>' +
                        '<div class="iw-content">' +
                        '<div class="iw-subTitle">Type: '+ this.type +'</div>' +
                        '<div id="rateYoMap' + this.name.replace(/\s+/g, '').toLowerCase() + '" data-note="' + note +'"></div>' +
                        '<p><form action="wc.detail.php" method="POST">' +
                        '<input type="hidden" name="name" value="'+ this.name +'" ></input>' +
                        '<input type="hidden" name= "type" value="'+ this.type +'" ></input>' +
                        '<input type="hidden" name = "src_id" value="'+ this.src_id +'" ></input>' +
                        '<input type="hidden" name = "lat" value="'+ this.lat +'" ></input>' +
                        '<input type="hidden" name = "lng" value="'+ this.lng +'" ></input>' +
                        '<input type="hidden" name = "adress" value="'+ this.adress +'" ></input>' +
                        '<input class="button" type="submit" value="voir"/>' +
                        '</form><p></div>'+
                        '</div></div>';


        // Il faudrat envoyer dans le post de voir de l'info window nom, type, et éditer prix, nombre toilette

        var info_window = new google.maps.InfoWindow({ content : info_window_html });
        info_window.setPosition(event.latLng);
        // Puis on lui demande de s'ouvrir sur notre carte
        info_window.open(map);

        console.log($("#rateYoMap" + this.name.replace(/\s+/g, '').toLowerCase()).rateYo({
         rating: $("#rateYoMap" + this.name.replace(/\s+/g, '').toLowerCase()).data('note'),
         readOnly: true
       }))
    });

}

function create_wc(location) {

    if(current_info_window !== undefined){
        current_info_window.close();
        console.log("closing");
    }


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
    marker_create_wc.setMap(null);

}
