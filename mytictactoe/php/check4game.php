<?php

$player=$_GET["q"];
if ($mode="check"){
	$con = mysqli_connect('localhost','root','t0vf3tIc7D','ajax_demo');
	if (!$con)
	  {
	  die('Could not connect: ' . mysqli_error($con));
	  }
	
	mysqli_select_db($con,"ajax_demo");
	
	
	$sql="SELECT * FROM invitations WHERE sender = '".$player."' AND accepted='yes' LIMIT 0, 1";
	$result = mysqli_query($con,$sql);
	if (!$result ) {
		return FALSE;
		//break;
	}else{
		if (is_object($result)){
			$row = mysqli_fetch_array($result); 
			$num_results = mysqli_num_rows($result); 
			if ($num_results > 0){
				$sql2="SELECT * from games WHERE playera = '".$player."' AND playerb = '".$row['receiver']."' AND WINNER IS NULL LIMIT 0, 1";
				$result2=mysqli_query($con,$sql2);
				$num_result2 = mysqli_num_rows($result2);
				if ($num_result2 >0){
					$row2 = mysqli_fetch_array($result2);
					$sql3 = "SELECT * from tictactoe WHERE gameid = '".$row2["id"]."' LIMIT 0, 1";
					$result3=mysqli_query($con,$sql3);
					$num_result3 = mysqli_num_rows($result3);
					if ($num_result3 > 0){
						$row3 = mysqli_fetch_array($result3);
						echo "redirect_".$row3["id"];
					}
				}
			}else{
				return FALSE;
				//break; 
			}
		}
	}
} 
mysqli_close($con);
?>