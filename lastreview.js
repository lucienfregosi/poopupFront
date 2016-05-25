var mapDetail;
var lat_array = [];
var lng_array = [];
var bounds = new google.maps.LatLngBounds();

$(document).ready(function() {
  mapLastReview = new google.maps.Map(document.getElementById('mapLastReview'), {
    center: 			new google.maps.LatLng(46.614190, 2.556114), 	        // Map center
	zoom: 				17, 														// Zoom level, 0 = earth view to higher value
	panControl: 		true, 													// Enable pan Control
	zoomControl: 		true, 													// Enable zoom control
	zoomControlOptions: { style: google.maps.ZoomControlStyle.SMALL }, 			// Zoom control buttons size
	scaleControl: 		true, 													// Enable scale control
	mapTypeId: 			google.maps.MapTypeId.ROADMAP 	
  });
  
  // On boucle sur la liste des longitudes latitudes
  for(var i = 0; i < lat_array.length; i++){
  	var gpoint = {lat: lat_array[i], lng: lng_array[i]}
  	var marker = new google.maps.Marker({position: gpoint, map: mapLastReview});
  	bounds.extend(new google.maps.LatLng(lat_array[i], lng_array[i]));
  }
  

   // On centre la carte autour du markeur
   mapLastReview.fitBounds(bounds);


});

 function showMarker(lat, lng){
     // On set la valeur a afficher dans des variables globales
 	 lat_array[lat_array.length] = lat;
 	 lng_array[lng_array.length] = lng;
}