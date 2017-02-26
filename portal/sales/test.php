<?php require_once("header.php"); ?>

<script>
$(document).ready(function() {
$(".yr12 td").hide();

$('#selectYr').change(function () {
    var val = $(this).val();
    if (val == "yr12") {
         $('.yr12 td').show();
         $('.yr13 td').hide();
    } else {
        $('.yr12 td').hide();
         $('.yr13 td').show();
    }
    });
});
</script>

<div class="container">
<select id="selectYr">
    <option value="yr13">2013</option>
     <option value="yr12">2012</option>
   </select>
<br><br>

<table width="40%">
<tr>
<th>Date</th>
<th>Description</th>
</tr>
<tr class="yr13">
<td>February 2013 </td>
<td>Description 1</td>
</tr>
<tr class="yr13">
<td>January 2013</td>
<td>Description 2</td>
</tr>
<tr class="yr12">
<td>November 2012</td>
<td>Description 3</td>
</tr>
<tr class="yr12">
<td>December 2012</td>
<td>Description 4</td>
</tr>
</table>
</div>
<?php require_once("../footer.php"); ?>