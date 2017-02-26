<?php require_once("header.php");

  ?>
      <div class="container">
       <h2 class="text-primary">Term Fee List</h2>
      <table class="table table-responsive">
		<thead>
			<tr>
				<th>SN</th>
				<th>Customer No</th>
				<th>Invoice Date</th>
				<th>Invoice No</th>
				<th>Description</th>
				<th>Amount</th>
				<th>Month</th>
				<th>Financial year</th>
				
			</tr>
		   </thead>
		   <tbody>
		   
		   <?php 
			$i = 1;
			
				$query = "select * from [ledger Credit]where [Company Name]='$ms' AND [Description]='Term Fee' ";
				$rs = odbc_exec($conn, $query) or die(odbc_errormsg($conn));
				while(odbc_fetch_array($rs)){
		   ?>
		   <tr>
			<td><?php echo $i?></td>
			<td><?php echo odbc_result($rs, "Customer No");?></td>
			<td><?php echo date('d/M/Y', odbc_result($rs, "Invoice Date"))?></td>
			<td><?php echo odbc_result($rs, "Invoice No");?></td>
			<td><?php echo odbc_result($rs, "Description");?></td>
			<td><?php echo odbc_result($rs, "Credit Amount");?></td>
			<td><?php echo odbc_result($rs, "Month");?></td>
		    <td><?php echo odbc_result($rs, "FinYr");?></td>
			
		  
		  </tr>
		  <?php 
					$i++;
				}
			
		  ?>
		</tbody>
	    </table>
	    <button class="btn btn-primary">Submit</button>
	    </form>
	    </div>
	<?php require_once("../footer.php"); ?>