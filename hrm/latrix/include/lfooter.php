<table width="100%" style="margin: 10px;">
	<tr>
		<td colspan=3>
		<?php echo $errorbox->out(); ?>
		</td>
	</tr>
	<tr>
		<td style="width:20%"></td>
		<td style="width:60%; text-align:center">
			<hr class="ruler">
			<a href="http://www.manticore-uk.com">
				<img src="images/manlogo.jpg" alt="Manticore Software"></a><br>
			<span style="font-size:8pt">
			<?php
			$page_load_time = microtime(true)-$page_load_start;
			?>
			LATRIX Attendance Recording powered by Manticore Software<br>
			This page took <?php echo round($page_load_time,4) ?> seconds to build.
			<?php echo $db_conn->getCount() ?> queries executed, Page loaded at <?php echo date('Y-M-d H:i:s') ?><br>
			Version <?php echo la_short_version ?>Copyright &copy; 2006,2009 Manticore Software
			</span>
			</td>
		<td style="width:20%"></td>
	</tr>
</table>
