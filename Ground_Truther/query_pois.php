<?php
header("Content-Type: application/json; charset=UTF-8");
//receive parameters from display_map_results.php from user input
$params = json_decode($_GET["x"]);
//open db connection
include('est_connection.php');
//depending on the user's query obtain information about points of interest
if ($params->{'id_disturbance'} == 99 and $params->{'id_land'} == 99){
	$sql = "SELECT coords, id_disturbance, id_land, comment, date_obs, img_name FROM tbl_obs";
	$stmt = $db_connection->prepare($sql);
}
else if ($params->{'id_land'} == 99){
	//$sql = "CREATE VIEW pois AS SELECT coords, tbl_obs.id_disturbance, tbl_obs.id_land, comment, date_obs, img_name, name_landscape, name_disturbance FROM tbl_obs, tbl_landscape, tbl_disturbance WHERE tbl_obs.id_disturbance= ? and tbl_obs.id_disturbance=tbl_disturbance.id_disturbance and tbl_obs.id_land=tbl_landscape.id_land";
	$sql = "SELECT coords, id_disturbance, id_land, comment, date_obs, img_name FROM tbl_obs WHERE id_disturbance= ?";
	$stmt = $db_connection->prepare($sql);
	$stmt->bind_param("i", $params->id_disturbance);
}
else if($params->{'id_disturbance'} == 99){
	$sql = "SELECT coords, id_disturbance, id_land, comment, date_obs, img_name FROM tbl_obs WHERE id_land= ?";
	$stmt = $db_connection->prepare($sql);
	$stmt->bind_param("i", $params->id_land);
}
else{
	$sql = "SELECT coords, id_disturbance, id_land, comment, date_obs, img_name FROM tbl_obs WHERE id_land= ? and id_disturbance= ?";
	$stmt = $db_connection->prepare($sql);
	$stmt->bind_param("ii", $params->id_land, $params->id_disturbance);
}

$stmt->execute();
//get result and send it to display_map_results.php
$result = $stmt->get_result();
	if ($result){
		$outp = $result->fetch_all(MYSQLI_ASSOC);
		echo json_encode($outp);
	} else {
		echo "Nothing like that in the database!";
	}
//free resources and close connection
mysqli_free_result($result);
mysqli_close($db_connection);
?>
