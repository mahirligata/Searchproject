<!DOCTYPE html>
<head>
<title>Search</title>
<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>

<form method="post">
	<div class="form-group">
		<input type="text" name="search" placeholder="Search towns">

		<select  method="post" name="kilometar">
			<option value="1">+1 km</option>
			<option value="2">+2 km</option>
			<option value="5">+5 km</option>
			<option value="10">+10 km</option>
			<option value="20">+20 km</option>
			<option value="30">+30 km</option>
			<option value="40">+40 km</option>
			<option value="50" selected>+50 km</option>
		</select>
	</div>
	<div class="form-group">
		<input id="submit" type="submit" name="submit"></input>
	</div>
	
</form>


</body>

</html>

<?php




$dbser = "localhost";
$user = "root";
$pass = "";
$db = "korisnici";

$conn = mysqli_connect($dbser,$user,$pass,$db);

if(mysqli_connect_errno()){
	echo "Failed to connect";
	exit();
}else{


	if (isset($_POST["submit"])){
	$str = $_POST["search"];
	$ran = $_POST["kilometar"];
	$query = "SELECT clanovi.name, clanovi.lastname, clanovi.latitude, clanovi.longitude, gradovi.nazivGrada FROM clanovi INNER JOIN gradovi ON clanovi.city=gradovi.id WHERE gradovi.nazivGrada= '$str'";
	$result = mysqli_query($conn,$query);
	while($row=mysqli_fetch_array($result)){

		$lat = 50.123963;
		$lon = 8.648775;

		$R = 6371;
		$Lat = $lat - $row["latitude"];
		$Long = $lon - $row["longitude"];

		$dLat1 = deg2rad($Lat);
		$dLot1 = deg2rad($Long);

		$a = sin($dLat1/2) * sin($dLat1/2) + cos(deg2rad($lat)) * cos(deg2rad($row["latitude"])) * sin($dLot1/2) * sin($dLot1/2);

		$c = 2 * atan2(sqrt($a), sqrt(1-$a));
		$Distance = $R * $c;
		$round = round($Distance,2);
		
		if($round < $ran){

			echo "<font>".$row["name"]." ".$row["lastname"]." ".$row["latitude"]." ".$row["longitude"]."</font> <br> ".$round." ";
		}else{
			echo "nema niko u blizini ";
		}

	}
	}
	
}


?>