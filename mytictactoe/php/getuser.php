<?php
$q=$_GET["q"];
$mode=$_GET["mode"];
$con = mysqli_connect('localhost','root','t0vf3tIc7D','ajax_demo');
if (!$con)
  {
  die('Could not connect: ' . mysqli_error($con));
  }

mysqli_select_db($con,"ajax_demo");
if ($mode=='playing')
{
$sql="SELECT * FROM players WHERE Status = '".$mode."'";
$result = mysqli_query($con,$sql);


echo "<div class=\"search_table\" > <table border='1'>
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
echo "</table> </div>";
}



if ($mode=='available')
{
$sql="SELECT * FROM players WHERE Status = '".$mode."'";
$sql2="SELECT * FROM invitations WHERE sender = '".$q."'";
$sql0="SELECT Nickname FROM `players` JOIN logged_in ON players.Nickname=logged_in.userid WHERE status = 'available'";
$result = mysqli_query($con,$sql);
$result2 = mysqli_query($con,$sql2);
$result0 = mysqli_query($con,$sql0);
//$logged_in = mysqli_fetch_array($result0);
$logged_im = array();
while($row0 = mysqli_fetch_array($result0)){
	$logged_in[] = $row0['Nickname'];
}


$invited_users = array();
while($row2 = mysqli_fetch_array($result2)){
	$invited_users[] = $row2['receiver'];
}

echo "<div class=\"search_table\" > <table border='1'>
<tr>
<th>Nickname</th>
<th>Status</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  	if (in_array($row['Nickname'], $logged_in)){
	  if ($row['Nickname'] != $q)
	  	{
		  echo "<tr>";
		  echo "<td>" . $row['Nickname'] . "</td>";
		  if (in_array($row['Nickname'], $invited_users))
			  {
			  	echo "<td style=\"background-color:orange; text-align:center;\"> Invited! ";
			  }
		  else 
			  {  
			  	echo "<td>" . $row['Status'] . "</td>";
			  	echo "<td id='".$row['Nickname']."'> <button type=\"button\" onclick=\"invite_user('".$row['Nickname']."'); return false;\">Invite </td>";
			  }
		  echo "</tr>";
		}
	}	
  }	
echo "</table> </div>";
}
	  
if ($mode=='history')
{
	
$sql="SELECT * FROM `games` WHERE playera='".$q."' UNION ALL SELECT * FROM `games` WHERE playerb='".$q."'";

$result = mysqli_query($con,$sql);

echo "<div class=\"search_table\" > <table border='1'>
<tr>
<th>Player A</th>
<th>Player B</th>
<th>Winner</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  $color="rgb(238,92,66)";
  $game_result="LOSS";	
  if ($row['winner']==$q)
  {
  	$color="rgb(192,255,62)";
    $game_result="WIN";
  }else if ($row['winner']=="Tie"){
  	$color="rgb(237,181,18)";
    $game_result="TIE";  	
  }
  echo "<tr>";
  echo "<td>" . $row['playera'] . "</td>";
  echo "<td>" . $row['playerb'] . "</td>";

  echo "<td style=\"background-color:".$color.";\">" . $game_result." </td>";
  echo "</tr>";
  }
echo "</table> </div>";
}


if ($mode=='invite')
{
$receiver=$_GET["receiver"];	
$sql="INSERT INTO `ajax_demo`.`invitations` (`id`, `sender`, `receiver`, `accepted`) VALUES (NULL, '".$q."', '".$receiver."', NULL);";
$result = mysqli_query($con,$sql);	
}


if ($mode=='reset_invites')
{
$sql3="SELECT * FROM players WHERE Nickname='".$q."'";
$result3=mysqli_query($con,$sql3);
$num_result3 = mysqli_num_rows($result3);
if ($num_result3 == 0){
	$sql4="INSERT `players` (Nickname, Status) VALUES ('".$q."', 'available')";
	$result4=mysqli_query($con,$sql4);
}						
$sql="DELETE FROM `invitations` WHERE sender='".$q."'";
$result = mysqli_query($con,$sql); 
$sql2="DELETE FROM `invitations` WHERE receiver='".$q."'";
$result2 = mysqli_query($con,$sql2); 
$sql0="UPDATE players SET Status = 'available' WHERE  Nickname='".$q."'";
$result0 = mysqli_query($con,$sql0);


}

if ($mode=='decline_invite')
{
	$sent_by=$_GET["sent_by"];	
	$sql="UPDATE  `invitations` SET  `accepted` =  'no' WHERE  `sender`='".$sent_by."' AND `receiver`='".$q."'";
	$result = mysqli_query($con,$sql); 
}

if ($mode=='accept_invite')
{
	$receiver=$_GET["q"];
	$sender=$_GET["sent_by"];
	$sql="UPDATE  `invitations` SET  `accepted` =  'yes' WHERE  `sender`='".$sender."' AND `receiver`='".$receiver."'";
	$result = mysqli_query($con,$sql); 
	$sql2="INSERT `games` (playera, playerb) VALUES ('".$sender."', '".$receiver."')";
	mysqli_query($con,$sql2); 
	$game_id = mysqli_insert_id($con);
	$sql3="INSERT `tictactoe` (gameid) VALUES ('".$game_id."')";
	$result3 = mysqli_query($con,$sql3);
	$new_game_id = mysqli_insert_id($con);
	echo $new_game_id;
}


mysqli_close($con);
?>