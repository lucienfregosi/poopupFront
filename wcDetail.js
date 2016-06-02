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

   $("#rateYoGlobal").rateYo({
    rating: $("#rateYoGlobal").data('note'),
    readOnly: true
  });

  $("#rateYoDetail")
    .rateYo({
      rating: 0
    });

  $("#rateYo").rateYo().on("rateyo.set", function (e, data) {
    alert("The rating is set to " + data.rating + "!");
  });

  $('.button-review').click(function(){
    $(".error-message").hide();
    if ($('#comment').val() == '') {
      $(".error-message").fadeIn().delay(5000).fadeOut();
    }else {
      $.ajax({
       url: 'http://54.218.31.103:5555/insertreview',
       type: 'POST',
       dataType: 'json',
       data: {
          'wc_id'   : $('#wc-id').val(),
          'user_id' : $('#user-id').val(),
          'comment' : $('#comment').val(),
          'note': $("#rateYoDetail").rateYo("option", "rating")
       },
       error: function(data) {
         $('.button-review').html("Merci d'avoir noté!").prop('disabled', true);
         getNote($('#wc-id').val());
        //  $("#rateYoGlobal").rateYo({
        //   rating: $(this).data('note')
        //   })
       }
      });
    }

  })
});

function getNote(wc_id) {
  console.log('yo')
  $.ajax({
    url: 'http://54.218.31.103:5555/wcinfo/' + $('#wc-id').val(),
    type: 'GET',
    success: function(response, status, xhr){
      var ct = xhr.getResponseHeader("content-type") || "";
      if (ct.indexOf('html') > -1) {
        console.log('html');
      }
      if (ct.indexOf('json') > -1) {
        console.log('json');
      }
    }
  })
}

 function showMarker(lat, lng){
     // On set la valeur a afficher dans des variables globales
 	 latitude = lat;
 	 longitude = lng;
}
