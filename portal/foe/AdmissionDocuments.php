<div class="container">
    <table class="table table-responsive">
        
        <tr>
            <td>SN</td>
            <td>Code</td>
            <td>Description</td>
            <td>Receiving Status</td>
            <td>Date of Receipt</td>
        </tr>
        <?php
            $cr = 1;
            $CertificateQuery = odbc_exec($conn, "SELECT [Code], [Description] FROM [Certificate] WHERE [Company Name]='$ms' ORDER BY [Description]") or die(odbc_errormsg($conn));
            while(odbc_fetch_array($CertificateQuery)){
        ?>
        <tr>
            <td><?php echo $cr?></td>
            <td><?php echo odbc_result($CertificateQuery, "Code")?><input type="hidden" name="CertiCode<?php echo $cr?>" value="<?php echo odbc_result($CertificateQuery, "Code")?>"></td>
            <td><?php echo odbc_result($CertificateQuery, "Description")?></td>
            <td>
                <select name="CertiStatus<?php echo $cr?>" class="form-control" onchange="if(this.value)>0){document.getElementByID('certidate<?php echo $cr;?>').value='abcd'}">
                    <option value="0"></option>
                    <option value="1" selected>Received</option>
                    <option value="2">Received Later</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" id="certidate<?php echo $cr;?>" name="CertiDate<?php echo $cr;?>" value="<?php echo date('d/M/Y')?>" readonly>
            </td>
        </tr>
        <?php
                $cr++;
            }
        ?>
        <script>
            $(function(){
                <?php
                    for($k=0; $k<=$cr; $k++){
                ?>
                    $("#certidate<?php echo $k?>").datepicker({ minDate: -7, maxDate: 0});
                <?php
                }
                ?>
            });
        </script>
        <input type="hidden" name="count" value="<?php echo $cr;?>" />
    </table>
</div>