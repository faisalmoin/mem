/*
    LATimer - attendance tracking and reporting
    Copyright (C) 2006,7 Manticore Software

	 For contact details or details of the license refer to index.php

*/

var systime;
var hours;
var minutes;
var seconds;
var servtime;

function ReloadTime() {
   var url = "servertime.php";
   if (typeof XMLHttpRequest != "undefined") {
       req = new XMLHttpRequest();
   } else if (window.ActiveXObject) {
       req = new ActiveXObject("Microsoft.XMLHTTP");
   }
   req.open("GET", url, true);
   req.onreadystatechange = ServerTimer;
   req.send(null);
}

function ServerTimer(){
    if (req.readyState == 4) {
        if (req.status == 200) {
            servtime = req.responseText;
			document.getElementById('txtcode').disabled = false;
			document.getElementById('txtcode').focus();
			//document.getElementById('serverdown').innerHTML = 'Server connection is available';
			document.getElementById('serverdown').style.visibility = 'hidden';
        } else {
			document.getElementById('serverdown').style.visibility = 'visible';
			document.getElementById('txtcode').disabled = true;
		}
    } else {
		document.getElementById('serverdown').style.visibility = 'visible';
		document.getElementById('txtcode').disabled = true;
	}
}

function Timer() {
	systime = document.getElementById('systime').value;
	servtime = systime;
	hours = (systime.charAt(0) + systime.charAt(1))/1;
	minutes = (systime.charAt(3) + systime.charAt(4)/1);
	seconds = (systime.charAt(6) + systime.charAt(7))/1;
	setInterval('UpdateTime()',1000);
	setInterval('ReloadTime()',60000);
}

function UpdateTime() {
	if (++seconds == 60) {
		seconds = 0;
		if (++minutes == 60) {
			minutes = 0;
			if (++hours == 24) {
				hours = 0;
			}
		}
	}
	if (hours < 10 && hours.toString().length < 2) { timestring = '0'+hours; } else { timestring = hours; }
	if (minutes < 10 && minutes.toString().length < 2) { timestring += ':0'+minutes; } else { timestring += ':'+minutes; }
	if (seconds < 10 && seconds.toString().length < 2) { timestring += ':0'+seconds; } else { timestring += ':'+seconds; }
	document.getElementById('timestamp').innerHTML = timestring;
}
