<br />
<script type="text/javascript">
	$(document).ready(function()
	{
		$('#search').keyup(function()
		{
			searchTable($(this).val());
		});
	});
	
	function searchTable(inputVal)
	{
		var table = $('#tblData');
		table.find('tr').each(function(index, row)
		{
			var allCells = $(row).find('td');
			if(allCells.length > 0)
			{
				var found = false;
				allCells.each(function(index, td)
				{
					var regExp = new RegExp(inputVal, 'i');
					if(regExp.test($(td).text()))
					{
						found = true;
						return false;
					}
				});
			if(found == true)$(row).show();else $(row).hide();
			}
		});
	}

    
</script>

	<footer class="footer" style="background-color: #D5DBDB;height: 60px;width: 100%;">
		<div class="container">
			<p class="text-muted">Millennium Education Management Pvt. Ltd.. <small>Alpha 1 ver 2015.09 1652 12</small></p>
		</div>
	</footer>
	
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<!--script src="bs/js/ie10-viewport-bug-workaround.js"></script-->
</body>
</html>