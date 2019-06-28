
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
<link rel="stylesheet" type="text/css" href="stylesheet.css"> 
<title>Contribute Data</title>
</head>

<?php
   /* resume current session */
   session_start();
   /*check if inside session */
   if (!isset($_SESSION["email"])){
	  exit("<div id='container'><p>Access prohibited!<br />
	  <a href='login_page.php'>&nbsp;Back to Login</a></p></div>");
   }
?>

<body>
<!-- parts to do with user account -->
<div id="container">
<div id="logout-div">
<a href="login_page.php" class="logout">Log out</a>
<p class="logout">Logged in as: <br>
	<?php echo $_SESSION['email']; ?>
</p>
</div>

<!-- User input section -->
<h2>Enter data about a point of interest</h2>
<h4>Where is it?</h4>    
<!-- Map container -->
<div id="map" style="width: 300px; height: 300px"></div>
<form id="data-form" name="data-form" method="post" action="submit_data.php" enctype="multipart/form-data">
    <div>
        <h4>The coordinates are: </h4>
        <input id="coordsP" name="coords" value="">
    </div>
	<!-- Dropdowns -->
	<?php 
		//populate dropdown with options for landscape and disturbance type
		include("est_connection.php");
		include("populate_dropdowns.php"); 
	?>
    <div class="form-group">
            <h4>When did it happen?</h4>
            <input name="date" type="date" value="<?php echo date("Y-m-d") ?>" />
    </div>
    <div class="form-group">
        <h4>Comment:</h4>
        <input name="comment" type="text" />
    </div>
    <div class="form-group">
        <h4>Upload an image</h4>
		<p>JPG, JPEG, PNG & GIF files are allowed</p>
        <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"/>
    </div>
	<!-- Bottom buttons section -->
    <div id="buttons">
        <button type="submit" name="submit" value="Submit" onclick="return checkInput()">Submit</button>
        <button type="reset" name="reset" value="Reset">Reset</button>
		<button><a href="help_about.php" style="text-decoration: none; color: inherit">Help</a></button>
		<button onclick="goBack()" style='margin: 10px 10px;'>Back</button>
    </div>
</form>

<h4 align='center'><a href="display_map_result.php">See map</a></h4>
</div>
</body>

<!-- JS script to create a map and check user input isn't missing -->
<script>
////* Map section *//////
	//get relevant DOM elements
	var coords = document.getElementById('coordsP');
	var map = document.getElementById('map');
	//display map with credits
	var leafletMap = L.map('map').setView([53.056585, 13.477165], 7);
	var mapLink = 
	'<a href="http://openstreetmap.org">OpenStreetMap</a>';

	L.tileLayer(
	//to use online map tiles from OSM 
	'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
	{
      attribution: '&copy; ' + mapLink + ' Contributors',
      maxZoom: 18,
	  minZoom: 6
    }
	).addTo(leafletMap);
	//add map controls
	var drawnItems;
	L.control.scale().addTo(leafletMap);
	//add drawing utilities
	var drawnItems = new L.FeatureGroup();
	leafletMap.addLayer(drawnItems);
	var drawControl = new L.Control.Draw({draw: {
		polyline: false,
		polygon: false,
		rectangle: false,
		circle: false,
		marker: true
	},
	edit:{
		featureGroup: drawnItems
	}
	});
	leafletMap.addControl(drawControl);
	//when a marker is drawn, display its coordinates
	leafletMap.on('draw:created', function (e) {
		var type = e.layerType,
			layer = e.layer;
		drawnItems.addLayer(layer);
		let latLng = layer.getLatLng();
		//prepare coordinates in the right format
		coords.value = latLng.toString().replace("LatLng(", "").replace(")", ""); 
	});

///////////* Input validation section *//////////////////
	function checkInput(){
		var coords = document.getElementById('coordsP').value,
		landscape = document.getElementById('landscape').value,
		disturbance = document.getElementById('disturbance').value;
		// if input data missing prompt the user
		if (coords == "" || landscape == 0 || disturbance == 0){
			alert('Missing values! Please make sure you enter: coordinates, landscape type and disturbance type.');
			return false;
		}
		else {
		return true;
		}
	}
</script>
</html>