<div class="row">
	<div class="standard-content col-md-12 text-middle plan-walk">
		<h1>Plan your walk</h1>
		<div id="map" width="600" height="400"></div>
	</div>
</div>

<script>
var geocoder = new google.maps.Geocoder();
var address = "<?php echo $_GET["location"]; ?>";

var map;
if(address == "home") {
	if(!!navigator.geolocation) {
		var mapOptions = {
			zoom: 12,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		map = new google.maps.Map(document.getElementById('map'), mapOptions);
	
		navigator.geolocation.getCurrentPosition(function(position) {
			var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);		
			map.setCenter(geolocate);
			
		});
		
	} else {
		document.getElementById('google_canvas').innerHTML = 'No Geolocation Support.';
	}
} else {
	
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();
			
			map = new GMaps({
				div: '#map',
				zoom: 12,
				lat: latitude,
				lng: longitude,
			});
		}
	});
}

var coords = [];
setTimeout(function() {
	GMaps.on('click', map.map, function(event) {
	var lat = event.latLng.lat();
	var lng = event.latLng.lng();

		coords.push({ lat: lat, lng: lng });
		
		if(coords.length == 1) {
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng( lat, lng),
				map: map.map,
				title: 'Start of the walk'
			});
		} else {
			displayPoints();
		}
	});
}, 1000);

function displayPoints() {
	for(var i = 0; i < coords.length - 1; i++) {
		map.drawRoute({
			origin: [coords[i].lat, coords[i].lng],
			destination: [coords[i+1].lat, coords[i+1].lng],
			waypoints: [],
			travelMode: 'walking',
		});
	}
}

</script>