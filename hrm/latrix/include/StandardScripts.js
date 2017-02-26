/*----------------------------------------------------------------------------/
' Manticore Software LATimer Attendance Recorder
' Wolfgang Schulze-Zachau
' Version 0.1
' 02/04/2006
'
' Module : StandardScripts.js
'
'This file contains the standard javascript (client side) functions
'---------------------------------------------------------------------------*/

var	cb_Col, cb_Record, cb_Subject, cb_Button;
var	bNew;
var	data;
data	= new Array();
bNew	= false;

function gI(name) { return document.getElementById(name); }
function gN(name) { return document.getElementsByName(name); }

function ChangeImage(IFile,IPath, CID) {
	window.open("include/image.asp?Img=" + IFile +"&Path=" + IPath + "&CID=" + CID, null, "height=350,width=600,status=no,toolbar=no,menubar=no,resizable=yes,location=no,scrollbars=yes", false);
}

function ChangeFile(IFile,IPath, CID) {
	window.open("include/file.asp?File=" + IFile +"&Path=" + IPath + "&CID=" + CID, null, "height=350,width=600,status=no,toolbar=no,menubar=no,location=no,scrollbars=yes", false);
}

function SubmitForm(subject,action) {
//	if (bNew) {
//		action = 'add';
//	}
	gI('txtsubject').value = subject;
	gI('txtaction').value = action;
//	if (action == 'show') {
//		if ((subject == 'att') || (subject == 'leave')) {
//			gI('TxtRID').value = document.getElementById('txtid').value;
//		} else {
//		gI('TxtRID').value = 0;
//		}
//	} else {
//		gI('TxtRID').value = document.getElementById('seldata').selectedIndex;
//	}
//	alert('About to submit: '+subject+','+action);
	gI('btnsubmit').click();
}

function SelectSubject(subject,action) {
	if (subject != 'Reports') {
		gI('latform').action = 'admin.php';
	}
	gI('txtsubject').value = subject;
	gI('txtaction').value = action;
	gI('txtsubsubject').value = 'None';
	gI('txtsubrecord').value = 0;
	gI('txtcolumn').value = 'name';
	gI('txtorder').value = 'ASC';
	gI('txtpage').value = 1;
//	alert('New subject: '+subject+', new action: '+action);
	gI('btnsubmit').click();
}

function SelectSubSubject(subject,action, title) {
	gI('txtsubsubject').value = gI('txtsubject').value;
	gI('txtsubrecord').value = gI('txtrecord').value;
	gI('txtsubject').value = subject;
	gI('txtaction').value = action;
	gI('txtrecord').value = 0;
	gI('txttitle').value = title;
	gI('txtcolumn').value = 'name';
	gI('txtorder').value = 'ASC';
	gI('txtpage').value = 1;
	gI('btnsubmit').click();
}

function BackToSubject() {
	gI('txtaction').value = 'show';
	gI('btnsubmit').click();
}

function RestoreSubject() {
	gI('txtsubject').value = gI('txtsubsubject').value;
	gI('txtrecord').value = gI('txtsubrecord').value;
	gI('txtsubsubject').value = 'None';
	gI('txtsubrecord').value = 0;
	gI('txtaction').value = 'view';
	gI('txtcolumn').value = 'name';
	gI('txtorder').value = 'ASC';
	gI('txtpage').value = 1;
	gI('btnsubmit').click();
}

function SetOrder(column, order) {
	gI('txtcolumn').value = column;
	gI('txtorder').value = order;
	gI('btnsubmit').click();
}

function SetPage(newpage, action) {
	gI('txtpage').value = newpage;
	gI('txtaction').value = action;
	gI('btnsubmit').click();
}

function GoToPage() {
	gI('txtpage').value = gI('newpage').value;
	gI('btnsubmit').click();
}

function SetAction(record, display, action) {
	gI('txtrecord').value = record;
	gI('txtdisplay').value = display;
	gI('txtaction').value = action;
	gI('btnsubmit').click();
}

function ReadItems(){
	var cnt, raw;
	raw = new Array();
	// All the data we need is already in the textarea called dataarea. 
	// We need to retrieve it and place it into an internal array.
	raw = gI('dataarea').value.split('\n');
	for (cnt = 0; cnt < raw.length; cnt++) {
		data[cnt] = raw[cnt].split(',');
		}
}


function MouseOnCtrl(obj,Tip) {
//	obj.style.color = 'red';
	MouseOnImg(obj,Tip);
}

function MouseOffCtrl(obj) {
//	obj.style.color = 'black';
	MouseOffImg(obj);
}

function MouseOnImg(obj,Tip) {
	obj.style.cursor = 'hand';
	overlib(Tip);
	return true;
}

function MouseOffImg(obj) {
	obj.style.cursor = 'auto';
	nd();
	return true;
}

function showPW(idx) {
	window.open("include/password.asp?idx=" + idx, null, "height=90,width=400,status=no,toolbar=no,menubar=no,location=no,scrollbars=no", false);
}
