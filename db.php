<?php
$connection = mysqli_connect("veh.nettech.ga","nettech_sasi","XMQ5ROD_MNYq","nettech_vehicle");
    if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  $base_url = "http://veh.nettech.ga/mailverify/";
	die();
	}
?>
