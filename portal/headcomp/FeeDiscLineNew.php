<?php
	require_once("SetupLeft.php");
	
	
	?>
<script>

	// Ajax for City & Country on PIN Code
	var ajax = getHTTPObject();

	function getHTTPObject()
	{
		var xmlhttp;
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		} else {
			//alert("Your browser does not support XMLHTTP!");
		}
		return xmlhttp;
	}
	
	//Communication Post Code
	function getData()
	{
		if (ajax)
		{
			var zipValue = document.getElementById("DiscCode").value;
			if(zipValue)
			{
				var url1 = "get_disc_head.php";
				var param1 = "?id=" + escape(zipValue)+"&cmp=" +<?php echo $CompName?>;

				ajax.open("GET", url1 + param1, true);
				ajax.onreadystatechange = handleAjax;
				ajax.send(null);
			}
			
			var name=document.getElementById( "DiscCode" ).value;
			if(name)
			{
				$.ajax({
					type: 'post',
					url: 'get_fee_code.php',
					data: {
						sid:name,
						cmp:<?php echo $CompName?>,
					},
					success: function (response) {

					// We get the element having id of display_info and put the response inside it*/
					$( '#display_info' ).html(response);

					}
				});

			}
			else
			{
				$( '#display_info' ).html("Please select Discount Code");
			}

			
		}
	}

	function handleAjax()
	{
		if (ajax.readyState == 4)
		{
			citystatearr = ajax.responseText.split(", ");

			var city = document.getElementById('desc');
			var state = document.getElementById('acad');
			var country = document.getElementById('curr');
			var cls = document.getElementById('cls');

			city.value = citystatearr[0];
			state.value = citystatearr[1];
			country.value = citystatearr[2];
			cls.value = citystatearr[3];
		}
	}
	
	
	

</script>


<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Discount Fee Structure </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form action="FeeDiscLineAdd.php" method="post">
<table class="table table-responsive">
	<tr>
		<td>Discount Code</td>
		<td>Description</td>
		<td>Academic Year</td>
		<td>Curriculum</td>
		<td>Class</td>
	</tr>
	<tr>
		<td>
			<select name="DiscCode" id="DiscCode" class="form-control" required onchange="getData()">
				<option value=""></option>
				<?php
					$DiscCode = odbc_exec($conn, "SELECT [No_] FROM [Discount Fee Header] WHERE [Company name]='$CompName'");
					while(odbc_fetch_array($DiscCode)){
						echo "<option value='".odbc_result($DiscCode, "No_")."'>".odbc_result($DiscCode, "No_")."</option>";
					}
				?>
			</select>
		</td>		
		<td><input type="text" class="form-control" id="desc" name="desc" readonly></td>		
		<td><input type="text" class="form-control" id="acad" name="acad" readonly style="width: 100px;"></td>
		<td><input type="text" class="form-control" id="curr" name="curr" readonly style="width: 100px;"></td>
		<td><input type="text" class="form-control" id="cls" name="class" readonly style="width: 100px;"></td>
	</tr>
</table>
<div id="display_info" >

</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>
<?php require_once("SelectRight.php"); ?>