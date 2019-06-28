<?php 
 	if (!isset($_SESSION["email"])){
		exit("<div id='container'><p>Access prohibited!<br />
		<a href='login_page.php'>&nbsp;Log in</a></p></div>");
	} 
	
    //make queries to populate dropdowns with disturbance and landscape types
    $sql_disturbance = "select * from tbl_disturbance";
    $sql_land = "select * from tbl_landscape";
    $result_disturbance = mysqli_query($db_connection, $sql_disturbance);
    $result_land = mysqli_query($db_connection, $sql_land);
	?>
    <!-- dropdown disturbance -->
    <div class='form-group'>
        <h4>Disturbance:</h4>
        <select name='disturbance' id='disturbance'>
            <option value=0 name="">Select a disturbance type</option>
			<option value=99>All</option>
            <!-- get values from the database to populate the landscape type dropdown -->
			<?php
            while($result_row = mysqli_fetch_row($result_disturbance)){
				$id = $result_row[0];
				$name = $result_row[1];
				echo "<option value=$id name=$name>$name</option>";
            }
			?>
        </select>
    </div>
    <!-- dropdown landscape -->
	<div class='form-group'>
		<h4>Type of landscape:</h4>
		<select name='landscape' id='landscape'>
			<option value=0 name="">Select a landscape type</option>
			<option value=99>All</option>
		<!-- get values from the database to populate the landscape type dropdown -->
		<?php
			while($result_row = mysqli_fetch_row($result_land)){
				$id = $result_row[0];
				$name = $result_row[1];
				echo "<option value=$id name=$name>$name</option>";
			}
		//once obtained from server keep dropdown elements for this session
		$_SESSION["dropdown_landscape"] = $result_land;
		$_SESSION["dropdown_disturbance"] = $result_disturbance;
		//close connection 
		mysqli_close($db_connection);
		?>
		</select>
</div>