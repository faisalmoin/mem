var systime;
var hours;
var minutes;
var seconds;
var servtime;
var server_msg = 'The server is currently unavailable, login/logout is disabled';
var msg_font_size;

function ReloadTime() {
   var url = "servertime";
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
	var sd;
	var txt;
    smsg = document.getElementById('serverdown');
    txt = document.getElementById('txtcode');
    if (req.readyState == 4) {
        if (req.status == 200) {
            servtime = req.responseText;
			txt.disabled = false;
			txt.focus();
			smsg.style.visibility = 'hidden';
        } else {
			smsg.style.visibility = 'visible';
			smsg.className = 'serverdown';
			smsg.innerHTML = server_msg;
			txt.disabled = true;
		}
    } else {
		smsg.style.visibility = 'visible';
		smsg.style.fontSize = msg_font_size;
		txt.disabled = true;
	}
}

function Timer() {
	systime = document.getElementById('systime').value;
	servtime = systime;
	hours = systime.charAt(0) + systime.charAt(1);
	minutes = systime.charAt(3) + systime.charAt(4);
	seconds = systime.charAt(6) + systime.charAt(7);
	setInterval('HideMessage()',3000);
	setInterval('UpdateTime()',1000);
	setInterval('ReloadTime()',60000);
	var smsg = document.getElementById('serverdown'); 
	if (smsg.innerHTML == '') {
		smsg.style.visibility = 'hidden';
		} else {
		smsg.style.visibility = 'visible';
		msg_font_size = smsg.style.fontSize;
		smsg.style.fontSize = 'x-large';
		}
	}

function HideMessage() {
	var smsg = document.getElementById('serverdown'); 
	smsg.style.visibility = 'hidden';
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
	// this next section is necessary to get the time to appear in the normal hh:mm:ss format
	// the multiplication with 1 forces the time figure to be converted into a numerical and then there is
	// no more ambiguity about the number of digits
	if (hours < 10) { timestring = '0'+(hours * 1); } else { timestring = hours; }
	if (minutes < 10) { timestring += ':0'+ (minutes * 1); } else { timestring += ':'+minutes; }
	if (seconds < 10) { timestring += ':0'+ (seconds * 1); } else { timestring += ':'+seconds; }
	document.getElementById('timestamp').innerHTML = timestring;
}
