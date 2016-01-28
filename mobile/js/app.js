var apiHost = "127.0.0.1";
var apiPort = 3000;
var loggedInUser = {};
var walkLocation = "";
var walkDate = "";
var walkHour = "";
var geocoder = new google.maps.Geocoder();
var map;
var coords = [];
var selectedMovie = {};

function openRegistration() {
	$("#divLogin").hide();
	$("#divRegister").show();
	$("#txtRegisterEmail").focus();
}

function openLogin() {
	$("#divLogin").show();
	$("#divRegister").hide();
	$("#txtLoginUsername").focus();
}

function register() {
	if($("#txtRegisterEmail").val() == "")	{
		alert("Please enter a valid email");
	} else if($("#txtRegisterUsername").val() == "")	{
		alert("Please enter a valid username");
	} else if($("#txtRegisterPassword1").val() == "")	{
		alert("Please enter a valid password");
	} else if($("#txtRegisterPassword1").val() != $("#txtRegisterPassword2").val())	{
		alert("Please make sure the passwords match");
	} else {
		$.post( "http://" + apiHost + ":" + apiPort + "/users", { 
			username: $("#txtRegisterUsername").val(),
			display_name: $("#txtRegisterUsername").val(),
			email: $("#txtRegisterEmail").val(),
			password: $("#txtRegisterPassword1").val()
		})
		  .done(function( data ) {
			$("#divRegister").hide();
			$("#txtLoginMessage").html("Account successfully registered<br/><br />")
			$("#divLogin").show();
			$("#txtLoginUsername").focus();
		  })
		  .error(function( data ) {
			alert(data.responseJSON.message);
		  });
	}
}

function login() {
	if($("#txtLoginUsername").val() == "")	{
		alert("Please enter a valid username");
	} else if($("#txtLoginPassword").val() == "")	{
		alert("Please enter a valid password");
	} else {
		$.post( "http://" + apiHost + ":" + apiPort + "/users/login", { 
			username: $("#txtLoginUsername").val(),
			password: $("#txtLoginPassword").val()
		})
		  .done(function( data ) {
			loggedInUser = data.user;
			$("#divLogin").hide();
			$("#divStep1").show();
			$("#txtLocation").focus();
		  })
		 .error(function( data ) {
			alert(data.responseJSON.message);
		  });
	}
}

function step1Next() {
	if($("#txtLocation").val() == "")	{
		alert("Please enter a valid location");
		$("#txtLocation").focus();
	} else {
		walkLocation = $("#txtLocation").val();
		$("#divStep1").hide();
		$("#divStep2").show();
		$("#txtDate").focus();
	}
}

function step1AroundHome() {
	walkLocation = "home";
	$("#divStep1").hide();
	$("#divStep2").show();
	$("#txtDate").focus();
}

function step2Next() {
	if($("#txtDate").val() == "")	{
		alert("Please enter a valid date");
		$("#txtDate").focus();
	} else if($("#txtStartingHour").val() == "")	{
		alert("Please enter a valid starting hour");
		$("#txtStartingHour").focus();
	} else {
		walkDate = $("#txtDate").val();
		walkHour = $("#txtStartingHour").val();
		$("#divStep2").hide();
		
		$.get( "http://" + apiHost + ":" + apiPort + "/weather/forecast", { 
			location: walkLocation,
			date: walkDate,
			hour: walkHour
		})
		  .done(function( data ) {
			var weather = data.result.weather.description;
			var iconUrl = data.result.weather.icon;
			$("#spnForecast").html(weather);
			$("#imgForecastIcon").attr("src","http://openweathermap.org/img/w/" + iconUrl + ".png");
			  
			$("#divStep3").show();
		  })
		 .error(function( data ) {
			alert(data.responseJSON.message);
		  });
	}
}

function checkAlternatives() {
	$("#divStep3").hide();
	
	$.get( "http://" + apiHost + ":" + apiPort + "/imdb/popular", { 
		location: walkLocation,
		date: walkDate,
		hour: walkHour
	})
	  .done(function( data ) {
		for(var i = 0; i < Math.min(25, data.result.length); i++) {
			var movie = data.result[i];
			var tblMovie = '<table onclick="showMovie(' + movie.id + ')" class="tblMovie center"><tr><td><img src="' + movie.image + '"/></td><td align="left"><b>' + movie.title + '</b><br /><br />' + movie.rating + '</td></tr></table>';
			$("#divMovies").append(tblMovie);
		}
		$("#divAlternative").show();
	  })
	 .error(function( data ) {
		alert(data.responseJSON.message);
	  });
}

function showMovie(id) {
	$("#divAlternative").hide();
	
	$.get( "http://" + apiHost + ":" + apiPort + "/imdb/" + id, { })
	  .done(function( data ) {
		var movie = data.result;
		$("#spnMovieTitle").html(movie.title);
		$("#spnMovieDesc").html(movie.desc);
		$("#imgMovieImage").attr("src",movie.image);
		$("#spnMovieDirector").html(movie.directors.join(", "));
		$("#spnMovieWriters").html(movie.writers.join(", "));
		$("#spnMovieStars").html(movie.stars.join(", "));
		
		selectedMovie = { id: movie.id, title: movie.title };
		
		$("#divShowMovie").show();
	  })
	 .error(function( data ) {
		alert(data.responseJSON.message);
	  });
}

function backToMovies() {
	$("#divShowMovie").hide();
	$("#divAlternative").show();
}

function planWalk() {
	$("#divStep3").hide();
	$("#divPlanWalk").show();
	
	if(walkLocation == "home") {
		if(!!navigator.geolocation) {
			var mapOptions = {
				zoom: 14,
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
		geocoder.geocode( { 'address': walkLocation}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
				
				map = new GMaps({
					div: '#map',
					zoom: 14,
					lat: latitude,
					lng: longitude,
				});
			}
		});
	}

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
}

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

function buyMovie() {
	$.post( "http://" + apiHost + ":" + apiPort + "/users/transaction", { 
		description: selectedMovie.id,
		amount: 9.95,
		user_id: loggedInUser._id
	})
	  .done(function( data ) {
		$("#buyResult").html("Bedankt voor de aankoop van " + selectedMovie.title)
		$("#divShowMovie").hide();
		$("#divBuyMovie").show();
	  })
	 .error(function( data ) {
		alert(data.responseJSON.message);
	  });
}