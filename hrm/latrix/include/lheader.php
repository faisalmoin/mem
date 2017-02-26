		<table>
			<tr>
				<td class="td-left" style="background: url('images/orange-bar-low.jpg')" width="70px">
					<a href="/index.php">
						<img src="images/clock-left.jpg" alt="clock" noresize ></a></td>
				<td class="td-left" style="background: url('images/orange-bar-low.jpg') repeat-x">
					<a href="/index.php">
						<img src="images/latrix-word-small-tp.gif" alt="LATRIX" style="border-style: none">
						<br>Attendance Tracker <?php echo la_short_version ?></a>
					</td>
				<td style="background: url('images/orange-bar-low.jpg') repeat-x" width="33%">&nbsp;<h1><?php echo $pagetitle ?></h1>&nbsp;</td>
				<td class="td-right" style="background: url('images/orange-bar-low.jpg') repeat-x" width="33%">
				<?php 
				if ($config->config['user_name'] == 'nobody') {
					echo("&nbsp;");
				} else {
					echo($config->config['user_name'].' :: '.$config->getLocationName()."<br>");
					echo("<a href=\"home.php\">Home</a>&nbsp::&nbsp\n");
					echo("<a href=\"DOCS/LATRIX%20User%20Guide.pdf\">Help</a>&nbsp::&nbsp");
					echo("<a href=\"logout.php\">Log out</a>\n");
				}
				?>
				</td>
			</tr>		
		</table>
