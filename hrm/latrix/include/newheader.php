		<div class="banner-left">
			<a href="http://www.latrix.org.uk"><img src="images/LATRIX-logo-1.png" alt="clock"></a>
		</div>
		<div class="banner-center"><h1 class="pagetitle"><?php echo $pagetitle ?></h1></div>
		<div class="banner-right">
			<?php 
			if ($config->config['user_name'] == 'nobody') {
				echo("&nbsp;");
			} else {
				echo($config->config['user_name'].' :: '.$config->getLocationName()."<br>");
				echo('<a href="home.php">Home</a>&nbsp;::&nbsp;'."\n");
				echo('<a href="'.$help_url.'">Help</a>&nbsp;::&nbsp;');
				echo('<a href="logout.php">Log out</a><br>'."\n");
				echo('Version '.la_short_version);
			}
			?>
		</div>
