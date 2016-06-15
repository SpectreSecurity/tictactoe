<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/mycss.css" />
		
		<script>
		
		//global variables
		var old_winner_txt = '1622fufhfASFHJGASDJ86186&*^&@*#!&^@#%AHDFAJFDS';
		var winner_txt = '';
		var timer_switch = false;
		var countdown;
		var countdown_number;
		
		function getUrlVars() {
		    var vars = {};
		    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		        vars[key] = value;
		    });
		    return vars;
		}
		
		function redirect_to_search()
		{
			var user = getUrlVars()["q"];
			var status = "available";
			change_status(status);
		    window.location="search_game.php?fname="+user;
		    
		}
		
		
		function countdown_init(player) {
		    countdown_number = 31;
		    countdown_trigger(player);
		}
		
		function countdown_trigger(player) {
		    if(countdown_number > 0) {
		        countdown_number--;
		        txt=document.getElementById("winner").innerHTML;
		        if (txt.indexOf(player) != -1 && txt.indexOf('won') == -1){
		        	document.getElementById('timer').innerHTML = 'You have '+countdown_number+' secs left for your move';
		        	document.getElementById("my_status").innerHTML='Playing';
		        }else{
		        	document.getElementById('timer').innerHTML = '';
		        	document.getElementById("my_status").innerHTML='Waiting for other player to make his move';
		        }
		        if(countdown_number > 0) {
		            countdown = setTimeout('countdown_trigger(\''+player+'\')', 1000);
		        }else{
		        	myGame('time');
		        	document.getElementById('timer').innerHTML = "Time is up!";
		        }
		    }
		}
		
		function countdown_clear() {
		    clearTimeout(countdown);
		}
		
		
		function game_start(){
			change_status("playing");
			myGame("check");
		}
		
		function change_status(my_status)
		{
			var game = getUrlVars()["game"];
			var str = getUrlVars()["q"];
			if (str.length==0)
			  {
			  
			  return;
			  }
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp2=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
			  }

			xmlhttp2.open("GET","php/tictactoe.php?q="+str+'&game='+game+'&action='+my_status,true);
			xmlhttp2.send();
		
		}
		
		
		function myGame(action)
		{
			var game = getUrlVars()["game"];
			var str = getUrlVars()["q"];
			if (str.length==0)
			  {
			  document.getElementById("txtHint2").innerHTML="";
			  return;
			  }
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    	var game_end = "no";
			    	var txt = xmlhttp.responseText
			    	if (txt.indexOf("won") != -1){
			    		game_end = "yes";
			    	}
			    	if (txt.indexOf("Tie") != -1){
			    		game_end = "yes";
			    	}
					if (game_end == "yes"){
						document.getElementById("surrender").innerHTML="Return to previous screen";
					}
					
			    	document.getElementById("txtHint2").innerHTML=xmlhttp.responseText;
			    	if (document.getElementById("winner")){
			    		
			    		
			    		
			    		
			    		if (txt.indexOf(old_winner_txt) != -1){
		
			    			timer_switch = true;
			    		}else{	    			
			    			if (timer_switch){
								countdown_clear();
								countdown_init(str);
							}	
			    		}
			    		
			    		var tmp_str = document.getElementById("winner").innerHTML;
			    		old_winner_txt = tmp_str
			    	}
			    }
			  }
			xmlhttp.open("GET","php/tictactoe.php?q="+str+'&game='+game+'&action='+action,true);
			xmlhttp.send();
			
			setTimeout("myGame('check')", 2000);
		}
		
		
		
		</script>

	</head>

	<body onload="game_start()">

		<div id="header"><h1>Good Luck <?php echo $_GET["q"]; ?></h1></div>		

		<div id="container">
			
			<div id="menu">	
				Player Status: <span id="my_status">Playing</span>				
				<br>

				<p><span id="timer"></span></p>
				
				<br>
								
				<form> 
					<button id="surrender" type="submit" onclick="redirect_to_search(); return false;">Surrender</button>
				</form>
				
				<br>			
			</div>
			
			<div id="content">
								
				<div id="txtHint2"><b>.</b></div>
				<br>

				
			</div>


		</div>
	
	</body>
</html>