function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

function Redirect_to_game(str)
{
	var user = getUrlVars()["fname"];
    window.location="game.php?q="+user+"&game="+str;
}


function showUser(mode)
{
	
var str = getUrlVars()["fname"];

	
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
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
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","php/getuser.php?q="+str+'&mode='+mode,true);

xmlhttp.send();
}

function invite_user_old(str)
{
	
	document.getElementById(str).outerHTML="<td style=\"background-color:orange; text-align:center;\"> Invited! </td> ";
	
}


function invite_user(str)
{
	
var q = getUrlVars()["fname"];
var mode = "invite";
var receiver = str
	
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
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
    document.getElementById(str).outerHTML="<td style=\"background-color:orange; text-align:center;\"> Invited! </td> ";
    }
  }
xmlhttp.open("GET","php/getuser.php?q="+q+'&mode='+mode+'&receiver='+receiver,true);

xmlhttp.send();
}

function reset_invites()
{
	
var q = getUrlVars()["fname"];
var mode = "reset_invites";
str="abcd";
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
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
    	document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    document.getElementById(str).outerHTML="<td style=\"background-color:orange; text-align:center;\"> Invited! </td> ";
    }
  }
xmlhttp.open("GET","php/getuser.php?q="+q+'&mode='+mode,true);

xmlhttp.send();
}

function decline_or_accept_invite(decision, sent_by)
{
var q = getUrlVars()["fname"];
var mode = decision;
var str="abcd";
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
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
    	if (mode != 'decline_invite'){
    		Redirect_to_game(xmlhttp.responseText);
    	}
    }
  }
xmlhttp.open("GET","php/getuser.php?q="+q+'&mode='+mode+'&sent_by='+sent_by,true);

xmlhttp.send();
}

//Code for constantly checking DB for invitations
function createRequestObject() {
var ro;
var browser = navigator.appName;
if(browser == "Microsoft Internet Explorer"){
ro = new ActiveXObject("Microsoft.XMLHTTP");
}else{
ro = new XMLHttpRequest();
}
return ro;
}

var http = createRequestObject();
var my_response = 'none';
var my_response_old = 'none';


function check4game() {
	clock("game")
	var q = getUrlVars()["fname"];
	http.open('get', 'php/check4game.php?q='+q,true);
	http.onreadystatechange=function()
	  {
	  if (http.readyState==4 && http.status==200)
	    {
	    	document.getElementById("messages4").innerHTML=http.responseText;
	    	tmp_txt = http.responseText;
	    	if (tmp_txt.indexOf('redirect_') > -1){
		    	var redirect_dest = tmp_txt.replace('redirect_','');
		    	Redirect_to_game(redirect_dest);
	    	}
	    }
	  }
	http.send(null);
}

function check4invite(){
	clock("invite");
	var q = getUrlVars()["fname"];
	http.open('get', 'php/invitations_check.php?q='+q,true);
	document.getElementById("messages2").innerHTML="check4invite RUN!"
	http.onreadystatechange	=function(){
		if (http.readyState==4) {//}&& http.status==200){
			my_response = http.responseText;
			document.getElementById("messages2").innerHTML="check4invite RUNNING!"
			if ((my_response != my_response_old) && (my_response != '')){//} || responsecheck != 1) {
				var responsecheck = 1;
				my_response_old = my_response;
				document.getElementById("messages").innerHTML = my_response;
			    var retVal = confirm(my_response+" invited you to play Tic-Tac-Toe! Do you accept the challenge? ?");
			    if( retVal == true ){
			    	document.getElementById("messages2").innerHTML="ACCEPTED";
			    	var decisiona = "accept_invite";
			    	decline_or_accept_invite(decisiona, my_response);
			    	var new_game_id=123;
				   return true;
			    }else{
			    	var decisiond = "decline_invite";
			    	decline_or_accept_invite(decisiond, my_response);
				   return false;
			    }
		 	 }
			
		}
	}
	http.send(null);
	
}

function sndReq2(){
	check4invite();
	setTimeout("check4game()",1000);
	clock("main");
	setTimeout("sndReq2()", 2000); // Recursive JavaScript function calls sndReq() every 2 seconds
	setInterval("session_update()", 5000);
}

function session_update() {
  //$.post("session_update.php"); // Sends request to update.php
  clock("session");
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp2=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  	xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp2.onreadystatechange=function()
  {
  	if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    {
    	document.getElementById("sessionblock").innerHTML=xmlhttp2.responseText;
    }
  }
  xmlhttp2.open("GET","php/session_update.php",true);

  xmlhttp2.send();
}

function checklength(i){  
        if (i<10){  
         i="0"+i;}  
         return i;  
 }  
 function clock(str){  
   var now = new Date();  
   var hours = checklength(now.getHours());  
   var minutes = checklength(now.getMinutes());  
   var seconds = checklength(now.getSeconds());  
   var format = 1;  //0=24 hour format, 1=12 hour format  
   var time;  
  
   if (format == 1){  
     if (hours >= 12){  
       if (hours ==12){  
         hours = 12;  
       }else {  
         hours = hours-12;  
       }  
      time=hours+':'+minutes+':'+seconds+' PM';  
     }else if(hours < 12){  
          if (hours ==0){  
            hours=12;  
          }  
      time=hours+':'+minutes+':'+seconds+' AM';  
     }  
   }  
  if (format == 0){  
     time= hours+':'+minutes+':'+seconds;  
  }  
  document.getElementById("clock"+str).innerHTML=time;   
 }  
