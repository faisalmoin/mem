<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<style type="text/css">
table { font-size:9pt; text-align:center; border-collapse:collapse; font-family: Verdana, arial, helvetica, sans-serif;}
tr, div {border: thin solid; }
.holiday {background-color: #CCFF99; color: #66CC00; border-color: #66CC00;}
.weekend {background-color: #FFFF66; color: #AA9900; border-color: #AA9900;}
.weekday {background-color: #FFFFCC; color: #AA9900; border-color: #AA9900;}
.approved {background-color: #DDDDDD; color: #000000; border-color: #000000;}
.unapproved {background-color: #CC99FF; color: #660099; border-color: #660099;}
.applicant {background-color: #FF9999; color: #CC0033; border-color: #CC0033;}
</style>
</head>
<body>
<table>
	<tr>
		<td>
			<div class="weekday">Monday<br>16/03/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Tuesday<br>17/03/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Wednesday<br>18/03/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Thursday<br>19/03/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Friday<br>20/03/2009<br>&nbsp;</div>
			<div class="applicant">Wolfie</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekend">Saturday<br>21/03/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekend">Sunday<br>22/03/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="weekday">Monday<br>23/03/2009<br>&nbsp;</div>
			<div class="unapproved">Sandy</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Tuesday<br>24/03/2009<br>&nbsp;</div>
			<div class="unapproved">Sandy</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Wednesday<br>25/03/2009<br>&nbsp;</div>
			<div class="unapproved">Sandy</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Thursday<br>26/03/2009<br>&nbsp;</div>
			<div class="approved">John</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="holiday">Friday<br>27/03/2009<br>Good Friday</div>
			<div class="approved">John</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekend">Saturday<br>28/03/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekend">Sunday<br>29/03/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="weekday">Monday<br>30/03/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Tuesday<br>31/03/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Wednesday<br>01/04/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Thursday<br>02/04/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekday">Friday<br>03/04/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekend">Saturday<br>04/04/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
		<td>
			<div class="weekend">Sunday<br>05/04/2009<br>&nbsp;</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td colspan="7">Legend</tr>
	</tr>
		<td class="weekday">Weekday</td>
		<td class="weekend">Weekend</td>
		<td class="holiday">Holiday</td>
		<td class="approved">Approved</td>
		<td class="unapproved">Unapproved</td>
		<td class="applicant">Applicant</td>
		<td>&nbsp;</td>
	<tr>
	</tr>
	<tr>
		<td colspan="7">
			<a href="#" onclick="approve();">Approve</a>
			<a href="#" onclick="reject();">Reject</a>
			<a href="#" onclick="close();">Cancel</a>
		</td>
	</tr>
</body>
</html>