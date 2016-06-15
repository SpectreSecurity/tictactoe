<?php

session_start();

echo "ok";
if (isset($_SESSION["user"])){
	$_SESSION["lastActiveTime"] = time();
	echo $_SESSION["user"];
	echo "TEST";
  
  
	$con = mysqli_connect('localhost','root','t0vf3tIc7D','ajax_demo');
	if (!$con)
	  {
	  die('Could not connect: ' . mysqli_error($con));
	  }
	
	mysqli_select_db($con,"ajax_demo");
	$now = time();
	
	$sql0="DELETE FROM logged_in WHERE last_seen < (".$now." - 120)";
	echo $sql0;
	$result0 = mysqli_query($con,$sql0);
	
	$sql="SELECT * FROM logged_in WHERE userid = '".$_SESSION["user"]."'";
	$result = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($result);
	

	if ($row == NULL){
		$sql2 = "INSERT INTO `ajax_demo`.`logged_in` (`userid`, `last_seen`) VALUES ('".$_SESSION["user"]."', '".$now."')";
		$result2 = mysqli_query($con,$sql2);
	}else{
		$sql2="UPDATE  logged_in SET  last_seen =  '".$now."' WHERE  userid ='".$_SESSION["user"]."'";
		$result2 = mysqli_query($con,$sql2);
		echo $sql2;
	}
	
/*	
	if ($result != 0){
		$row = mysqli_fetch_array($result);
		echo $row['userid'];
		$sql2="UPDATE  logged_in SET  last_seen =  '".time()."' WHERE  userid ='".$_SESSION["user"]."'";
		$result2 = mysqli_query($con,$sql2);
	}else{
		$now = time();
		$sql2 = "INSERT INTO `ajax_demo`.`logged_in` (`userid`, `last_seen`) VALUES ('".$_SESSION["user"]."', '".$now."')";
		echo $sql2;
		$result2 = mysqli_query($con,$sql2);
		echo "empty";
	}*/

/*	
	if ($mode=='playing')
	{
	$sql="SELECT * FROM players WHERE Status = '".$mode."'";
	$result = mysqli_query($con,$sql);
	
	
	echo "<table border='1'>
	<tr>
	<th>Nickname</th>
	<th>Status</th>
	</tr>";
	
	while($row = mysqli_fetch_array($result))
	  {
	  echo "<tr>";
	  echo "<td>" . $row['Nickname'] . "</td>";
	  echo "<td>" . $row['Status'] . "</td>";
	  echo "</tr>";
	  }
	echo "</table>";
	}  */
  
}  
?>