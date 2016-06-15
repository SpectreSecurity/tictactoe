<?php
$player=$_GET["q"];
$con = mysqli_connect('localhost','root','t0vf3tIc7D','ajax_demo');
if (!$con)
  {
  die('Could not connect: ' . mysqli_error($con));
  }

mysqli_select_db($con,"ajax_demo");


$sql="SELECT * FROM invitations WHERE receiver = '".$player."' AND accepted IS NULL LIMIT 0, 1";
$result = mysqli_query($con,$sql);



while($row = mysqli_fetch_array($result))
	echo $row['sender'];

mysqli_close($con);
?>