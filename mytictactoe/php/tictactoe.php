<?php

function check(){

	$q=$_GET["q"];
	$game=$_GET["game"];
	$turn = '';   /* Whose turn it is */
	$move = "end";  /*number of move*/
	

	
	/*$playera = "Player2";
	$playerb = "Player4";*/
	
	$con = mysqli_connect('localhost','root','t0vf3tIc7D','ajax_demo');
	if (!$con)
	  {
	  die('Could not connect: ' . mysqli_error($con));
	  }
	
	mysqli_select_db($con,"ajax_demo");
	
	$sql0 = "SELECT * FROM games WHERE id = (SELECT gameid FROM tictactoe where id = '".$game."')";
	$result0 = mysqli_query($con,$sql0);
	$row0 = mysqli_fetch_array($result0);	
	$playera = $row0['playera'];
	$playerb = $row0['playerb'];
	
	
	$sql="SELECT * FROM tictactoe WHERE id = '".$game."' LIMIT 0,1";
	$result = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($result);
/*	
	echo "<table border='1'>
	<tr>
	<th>id</th>
	<th>gameid</th>
	<th>opponentid</th>
	<th>pa1</th>
	<th>pb1</th>
	<th>pa2</th>
	<th>pb2</th>
	<th>pa3</th>
	<th>pb3</th>
	<th>pa4</th>
	<th>pb4</th>
	<th>pa5</th>
	<th>winner</th>
	</tr>";
	
	echo "<tr>";
	echo "<td>" . $row['id'] . "</td>";
	echo "<td>" . $row['gameid'] . "</td>";
	echo "<td>" . $row['opponentid'] . "</td>";
	echo "<td>" . $row['pa1'] . "</td>";
	echo "<td>" . $row['pb1'] . "</td>";
	echo "<td>" . $row['pa2'] . "</td>";
	echo "<td>" . $row['pb2'] . "</td>";
	echo "<td>" . $row['pa3'] . "</td>";
	echo "<td>" . $row['pb3'] . "</td>";
	echo "<td>" . $row['pa4'] . "</td>";
	echo "<td>" . $row['pb4'] . "</td>";
	echo "<td>" . $row['pa5'] . "</td>";
	echo "<td>" . $row['winner'] . "</td>";
	echo "</tr>";
	
	echo "</table>";
*/	
	if ($row['pa1'] == NULL){
		$turn=$playera;
		$move = 'pa1';
	}elseif ($row['pb1'] == NULL){
		$turn=$playerb;
		$move = 'pb1';
	}elseif ($row['pa2'] == NULL){
		$turn=$playera;
		$move = 'pa2';
	}elseif ($row['pb2'] == NULL){
		$turn=$playerb;
		$move = 'pb2';
	}elseif ($row['pa3'] == NULL){
		$turn=$playera;
		$move = 'pa3';
	}elseif ($row['pb3'] == NULL){
		$turn=$playerb;
		$move = 'pb3';
	}elseif ($row['pa4'] == NULL){
		$turn=$playera;
		$move = 'pa4';
	}elseif ($row['pb4'] == NULL){
		$turn=$playerb;
		$move = 'pb4';
	}elseif ($row['pa5'] == NULL){
		$turn=$playera;
		$move = 'pa5';
	}
	$winner = $row['winner'];
	if ($winner != null){
		$move = "end";
	}
	
	$a1 = $a2 = $a3 = $b1 = $b2 = $b3 = $c1 = $c2 = $c3 = "onclick=\"myGame(this.id)\"";

	$playera_cells=array($row['pa1'], $row['pa2'], $row['pa3'], $row['pa4'], $row['pa5'] );
	$playerb_cells=array($row['pb1'], $row['pb2'], $row['pb3'], $row['pb4']);
	$both_players_cells = array($playera_cells, $playerb_cells);
	
	foreach ($playera_cells as &$value){
		if ($value != NULL){
			$$value = "background=\"img/x.png\"";
		}	
	}
	
	foreach ($playerb_cells as &$valueb){
		if ($valueb != NULL){
			$$valueb = "background=\"img/o.png\"";
		}	
	}
	
	echo "<div class=\"tictactoe\" > <table border='1' cellpadding='25' cellspacing='3' >";
	//echo "<table id=\"tictactoe\" cellpadding=25 cellspacing=3>";
		echo "<tr>";
			echo "<td id=\"a1\" ".$a1." style=\"background-repeat:no-repeat;background-position:center;color:transparent;\">a1</td>";
			echo "<td id=\"a2\" ".$a2." style=\"background-repeat:no-repeat;background-position:center;color:transparent;\">a2</td>";
			echo "<td id=\"a3\" ".$a3." style=\"background-repeat:no-repeat;background-position:center;color:transparent;\">a3</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td id=\"b1\" ".$b1." style=\"background-repeat:no-repeat;background-position:center;color:transparent;\">b1</td>";
			echo "<td id=\"b2\" ".$b2." style=\"background-repeat:no-repeat;background-position:center;color:transparent;\">b2</td>";
			echo "<td id=\"b3\" ".$b3." style=\"background-repeat:no-repeat;background-position:center;color:transparent;\">b3</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td id=\"c1\" ".$c1." style=\"background-repeat:no-repeat;background-position:center;color:transparent;\">c1</td>";
			echo "<td id=\"c2\" ".$c2." style=\"background-repeat:no-repeat;background-position:center;color:transparent;\">c2</td>";
			echo "<td id=\"c3\" ".$c3." style=\"background-repeat:no-repeat;background-position:center;color:transparent;\">c3</td>";
		echo "</tr>";
	echo "</table> </div>";
	
	if ($winner == null){
		$winner = check_for_winner($both_players_cells);
	}	
	if ($winner == "playera" OR $winner == "playerb"){
		echo "<div id=\"winner\" style=\"text-shadow:2px 2px 11px rgba(0,0,0,0.7);\">Player: ".$$winner." won the game</div>";
		$sql2="UPDATE  `tictactoe` SET  winner =  '".$$winner."' WHERE  id='".$game."'";
		$result = mysqli_query($con,$sql2);	
		$sql3="UPDATE games set winner = '".$$winner."' WHERE id = (SELECT gameid FROM tictactoe where id = '".$game."')";
		$result3 = mysqli_query($con,$sql3);
		$move="end";
	}elseif ($move=="end" and $winner != null and $winner != "no_winner" and $winner != "Tie"){
		echo "<div id=\"winner\" style=\"text-shadow:2px 2px 11px rgba(0,0,0,0.7);\">Player: ".$winner." won the game</div";	
	}elseif ($move=="end"){
		echo "<div id=\"winner\" style=\"text-shadow:2px 2px 11px rgba(0,0,0,0.7);\">It's a Tie!</div";
		$sql2="UPDATE  `tictactoe` SET  winner =  'Tie' WHERE  id='".$game."'";
		$result2 = mysqli_query($con,$sql2);	
		$sql3="UPDATE games set winner = 'Tie' WHERE id = (SELECT gameid FROM tictactoe where id = '".$game."')";
		$result3 = mysqli_query($con,$sql3);	
	}else{
		echo "<div id=\"winner\" style=\"text-shadow:2px 2px 11px rgba(0,0,0,0.7);\">It's the turn of: ".$turn."!</div";
	}
	mysqli_close($con);
	return array($turn, $move);
}

function new_action($game, $player, $move, $action){
	
	$con = mysqli_connect('localhost','root','t0vf3tIc7D','ajax_demo');
	if (!$con)
	  {
	  die('Could not connect: ' . mysqli_error($con));
	  }
	
	mysqli_select_db($con,"ajax_demo");
	
	$sql="UPDATE  `tictactoe` SET  ".$move." =  '".$action."' WHERE  id='".$game."'";
	$result = mysqli_query($con,$sql);	
	
}


function check_for_winner($both_players_cells){
	
	/*Winning Combinations*/
	$combo1 = array("a1", "a2", "a3");
	$combo2 = array("b1", "b2", "b3");
	$combo3 = array("c1", "c2", "c3");
	$combo4 = array("a1", "b1", "c1");
	$combo5 = array("a2", "b2", "c2");
	$combo6 = array("a3", "b3", "c3");
	$combo7 = array("a1", "b2", "c3");
	$combo8 = array("a3", "b2", "c1");
	$combos = array($combo1, $combo2, $combo3, $combo4, $combo5, $combo6, $combo7, $combo8,);

		
	for ($i = 0; $i <= 1; $i++) {
		for ($j = 0; $j <= 7; $j++) {
	    	$hits = count(array_intersect($both_players_cells[$i], $combos[$j]));
			if ($hits == 3){
				if ($i==0){
					return ("playera");
				}else{
					return ("playerb");
				}
					
			}
		}

	}	
	return ("no_winner");
}

function change_status($status){
	$name=$_GET["q"];
	$con = mysqli_connect('localhost','root','t0vf3tIc7D','ajax_demo');
	if (!$con)
	  {
	  die('Could not connect: ' . mysqli_error($con));
	  }	
	mysqli_select_db($con,"ajax_demo");
	$sql="UPDATE players SET Status = '".$status."' WHERE  Nickname='".$name."'";
	$result = mysqli_query($con,$sql);	
}


function time_ended($game){
	
	$con = mysqli_connect('localhost','root','t0vf3tIc7D','ajax_demo');
	if (!$con)
	  {
	  die('Could not connect: ' . mysqli_error($con));
	  }
	
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT * FROM tictactoe WHERE id = '".$game."' LIMIT 0,1";
	$result = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($result);	
	
	$winner = '';
	$pa1 = $row['pa1'];
	$pb1 = $row['pb1'];
	$pa2 = $row['pa2'];
	$pb2 = $row['pb2'];
	$pa3 = $row['pa3'];
	$pb3 = $row['pb3'];
	$pa4 = $row['pa4'];	
	$pb4 = $row['pb4'];
	$pa5 = $row['pa5'];		
	
	
	if ($row['pa1'] == NULL){
		$pa1 = 'x';
		if ($winner ==''){
			$winner = 'playerb';
		}	
	}
	if ($row['pb1'] == NULL){
		$pb1 = 'x';
		if ($winner ==''){
			$winner = 'playera';
		}	
	}
	if ($row['pa2'] == NULL){
		$pa2 = 'x';
		if ($winner ==''){
			$winner = 'playerb';
		}	
	}
	if ($row['pb2'] == NULL){
		$pb2 = 'x';
		if ($winner ==''){
			$winner = 'playera';
		}	
	}
	if ($row['pa3'] == NULL){
		$pa3 = 'x';
		if ($winner ==''){
			$winner = 'playerb';
		}	
	}
	if ($row['pb3'] == NULL){
		$pb3 = 'x';
		if ($winner ==''){
			$winner = 'playera';
		}	
	}
	if ($row['pa4'] == NULL){
		$pa4 = 'x';
		if ($winner ==''){
			$winner = 'playerb';
		}	
	}
	if ($row['pb4'] == NULL){
		$pb4 = 'x';
		if ($winner ==''){
			$winner = 'playera';
		}	
	}
	if ($row['pa5'] == NULL){
		$pa5 = 'x';
		if ($winner ==''){
			$winner = 'playerb';
		}	
	}
	
	$sql0 = "SELECT * FROM games WHERE id = (SELECT gameid FROM tictactoe where id = '".$game."')";
	$result0 = mysqli_query($con,$sql0);
	$row0 = mysqli_fetch_array($result0);	
	$playera = $row0['playera'];
	$playerb = $row0['playerb'];
	
	if ($winner !=''){
		$sql2="UPDATE  `tictactoe` SET  winner = '".$$winner."', pa1 = '".$pa1."', pb1 = '".$pb1."', pa2 = '".$pa2."', pb2 = '".$pb2."', pa3 = '".$pa3."', pb3 = '".$pb3."', pa4 = '".$pa4."', pb4 = '".$pb4."', pa5 = '".$pa5."' WHERE  id='".$game."'";
		$result = mysqli_query($con,$sql2);	
		$sql3="UPDATE games set winner = '".$$winner."' WHERE id = (SELECT gameid FROM tictactoe where id = '".$game."')";
		$result3 = mysqli_query($con,$sql3);		
	}	
}



$action=$_GET["action"];
if (strlen($action)==2){
	$my_check=check(); /* my_check[0]=$turn and my_check[1]=$move*/
	$player=$_GET["q"];
	$game=$_GET["game"];
	if ($my_check[0] == $player && $my_check[1]!="end"){
		new_action($game, $player, $my_check[1], $action);
	}
}elseif ($action == 'playing' OR $action == 'available'){
	change_status($action);	
}elseif ($action == 'time'){	
	$game=$_GET["game"];
	time_ended($game);
	
}else{
	check();
}
?>