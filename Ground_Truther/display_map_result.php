<?php
   /* resume current session */
   session_start();
   /*check if inside session */
   if (!isset($_SESSION["email"]))
      exit("<div id='container'><p>Access prohibited!<br />
	  <a href='login_page.php'>&nbsp;Log in</a></p></div>");
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="js_functions.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
crossorigin=""></script>
<link rel="stylesheet" type="text/css" href="stylesheet.css"> 
<title>Map</title>
</head>
<body>
<!-- Part 1 - query the map -->

<!-- Menu - what kind of data to display - user input -->	 
	<div id="container">
		<div id="logout-div">
			<a href="login_page.php">Log out</a>
			<p>Logged in as: <br>
				<?php echo $_SESSION['email']; ?>
			</p>
		</div>
		<h2>What would you like to see?</h2>
		<?php 
		//populate dropdown with options for landscape and disturbance type
			include("est_connection.php");
			include("populate_dropdowns.php");
		?>
		<button type="submit" onclick="makeQuery()">Query</button>
		<button onclick="goBack()">Back</button>
		<p id="noResultP" style='color:#ba2b14'></p>
	</div>
	
<!-- Part 2 - display map with points -->

<div id='container'>
	<div id="map" style="height: 300px;width: 300px;"></div>
</div>
</body>

<!--  this script deals with: sending a request to get an object with all points matching the query,  
creating a map and putting points on it with popups with text and an image  -->
<script>
//create a map
    var leafletMap = L.map('map', {drawControl: true}).setView([53.056585, 13.477165], 7);
    var mapLink = 
  '<a href="http://openstreetmap.org">OpenStreetMap</a>';

  L.tileLayer('map_tiles/{z}/{x}/{y}.png',
		{
      attribution: '&copy; ' + mapLink + ' Contributors',
      maxZoom: 18,
	  	minZoom: 6
    }
		).addTo(leafletMap);
    //add map controls
  L.control.scale().addTo(leafletMap);
  
//////* send query for points of interest to the server *////////////
var x;
function makeQuery(){
	//create a request 
	var xmlhttp = new XMLHttpRequest();
	//get user input and create space for error message
	var landscape = document.getElementById('landscape').value,
		disturbance = document.getElementById('disturbance').value,
		noResultP = document.getElementById('noResultP');

	//create objects of landscape type and disturbance type using html dropdowns
	var landscapesAll = document.getElementById('landscape'),
		disturbancesAll = document.getElementById('disturbance');
	//check user entered values for landscape and disturbance	types, if not prompt them
	if (landscape == 0 || disturbance == 0){
		alert("Please select values from both dropdown menus.");
	} else {
		//otherwise prepare and send a request
		xmlhttp.onreadystatechange = function() {
		//if request is successful store the response in poiCollection
		if (this.readyState == 4 && this.status == 200) {
			noResultP.innerHTML = "";
			var poiCollection = JSON.parse(this.responseText);
				if (poiCollection.length > 0){
					for (var i = 0; i < poiCollection.length; i++){
						//put the point on the map
						//coords is a string so transform it to an array of 2 floats
						var latlng = poiCollection[i].coords.split(','),
							lat = parseFloat(latlng[0]),
							lng = parseFloat(latlng[1]),
							marker = new L.marker([lat, lng]);
						marker.addTo(leafletMap);
						//add a popup to the point - define its elements
						var popupImage = "<img alt='No Image for this point' style='width:70px;height:70px;' src='" + poiCollection[i].img_name + "' />",
							indexLandscape = poiCollection[i].id_land +1,
							nameLandscape = landscapesAll[indexLandscape].innerHTML,
							indexDisturbance = poiCollection[i].id_disturbance+1,
							nameDisturbance = disturbancesAll[indexDisturbance].innerHTML;
						var popupContent = "<b>Landscape type:</b>&nbsp" + nameLandscape + "<br><b>Disturbance:</b>&nbsp" + 
							nameDisturbance + "<br><b>Date observed:&nbsp</b>" + poiCollection[i].date_obs + "<br><b>Comment:</b>&nbsp" +
							poiCollection[i].comment + "<br>" + popupImage;
						marker.bindPopup(popupContent).addTo(leafletMap);
					}
			  } else {
					//if the response from the server is empty, notify the user
					noResultP.innerHTML = "Sorry, nothing in the database matches your query.";
			  }
		  }
		};
	//send a request to the server including values for landscape type and disturbance in paramsStr
	var params = {"id_land": landscape,"id_disturbance": disturbance},
		paramsStr = JSON.stringify(params);
	xmlhttp.open("GET", "query_pois.php?x="+paramsStr, true);
	xmlhttp.send();
	}
}	
</script>
</html>