var mapDetail;
var latitude;
var longitude;
$(document).ready(function() {
  mapDetail = new google.maps.Map(document.getElementById('mapDetail'), {
    center: 			new google.maps.LatLng(46.614190, 2.556114), 	        // Map center
	zoom: 				17, 														// Zoom level, 0 = earth view to higher value
	panControl: 		true, 													// Enable pan Control
	zoomControl: 		true, 													// Enable zoom control
	zoomControlOptions: { style: google.maps.ZoomControlStyle.SMALL }, 			// Zoom control buttons size
	scaleControl: 		true, 													// Enable scale control
	mapTypeId: 			google.maps.MapTypeId.ROADMAP 	
  });
  
  // On affiche le point sur la map
  var gpoint = {lat: latitude, lng: longitude}
   var marker = new google.maps.Marker({position: gpoint, map: mapDetail});

   // On centre la carte autour du markeur
   mapDetail.setCenter(new google.maps.LatLng(latitude, longitude))


});

 function showMarker(lat, lng){
     // On set la valeur a afficher dans des variables globales
 	 latitude = lat;
 	 longitude = lng;
}