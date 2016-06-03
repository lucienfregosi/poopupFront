var mapCreate;
var latitude;
var longitude;
$(document).ready(function() {
  mapCreate = new google.maps.Map(document.getElementById('mapCreate'), {
    center: 			new google.maps.LatLng(46.614190, 2.556114), 	        // Map center
	zoom: 				17, 														// Zoom level, 0 = earth view to higher value
	panControl: 		true, 													// Enable pan Control
	zoomControl: 		true, 													// Enable zoom control
	zoomControlOptions: { style: google.maps.ZoomControlStyle.SMALL }, 			// Zoom control buttons size
	scaleControl: 		true, 													// Enable scale control
	mapTypeId: 			google.maps.MapTypeId.ROADMAP
  });

  // On affiche le point sur la  map
  var gpoint = {lat: parseFloat(latitude), lng: parseFloat(longitude)}
  var marker = new google.maps.Marker({
    position: gpoint,
    map: mapCreate,
    animation: google.maps.Animation.DROP
  });

   // On centre la carte autour du markeur
   mapCreate.setCenter(new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude)))


});

 function showMarker(lat, lng){
     // On set la valeur a afficher dans des variables globales
 	 latitude = lat;
 	 longitude = lng;


}
