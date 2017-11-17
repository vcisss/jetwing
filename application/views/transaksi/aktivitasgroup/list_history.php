<?php
$mylib = new globallib();
?>

<div class="row">
		<div class="col-md-6">
			<b>Search</b>&nbsp;
			<input type="text" size="60" maxlength="30" name="search_keyword" id="search_keyword" class="form-control-new" value="" />
		</div>
		<div class="col-md-6" align="right">
			<button type="button" class="btn btn-info btn-icon btn-sm icon-left" onClick="search_data(),show_loading_bar(100)">Search<i class="entypo-search"></i></button>
			<button type="button" class="btn btn-success btn-icon btn-sm icon-left" onClick="refresh_data(),show_loading_bar(100)">Refresh<i class="entypo-search"></i></button>
		</div>
	</div>
	
	<br>

<div id="col-search" class="row" style="overflow:auto;height:500px;">
<div id="table-2_wrapper" class="dataTables_wrapper form-inline" role="grid">
<table class="table table-bordered responsive">
        <thead class="title_table">
            <tr>
                <th width="30"><center>No</center></th>
		        <th width="100"><center>Tanggal</center></th>
		        <th width="500"><center>Nama Aktivitas</center></th>
		        <th><center>Keterangan</center></th>
		        <th width="100"><center>Pax</center></th>
		        <th width="100"><center>IDR</center></th>		        
		        <th width="100"><center>USD</center></th>
		        <th width="100"><center>RMB</center></th>
        	</tr>
            
        </thead>
        <tbody>
            <?php

            if (count($data) == 0) {
                echo "<tr><td colspan='100%' align='center'>Tidak Ada Data</td></tr>";
            }

            $no = 1;
            foreach ($data as $val) {
                $bgcolor = "";
                if ($no % 2 == 0) {
                    $bgcolor = "background:#f7f7f7;";
                }
                ?>
                <tr title="<?php echo $val["NamaAktivitas"]; ?>" onclick="edit('<?php echo $val["KdGroup"]; ?>','<?php echo $val["KdAktivitas"]; ?>')" style="cursor:pointer; <?php echo $bgcolor; ?>" onmouseover="change_onMouseOver('<?php echo $no; ?>')" onmouseout="change_onMouseOut('<?php echo $no; ?>')" id="<?php echo $no; ?>">
                    <td><?php echo $no; ?></td>
                    <td align="center"><?php echo $mylib->ubah_tanggal($val["Tanggal"]); ?></td>
                    <td align="left"><?php echo $val["NamaAktivitas"]; ?></td>
                    <td align="left"><?php echo $val["Keterangan"]; ?></td>
                    <td align="right"><?php echo number_format($val["Pax"]); ?></td>
                    <td align="right"><?php echo number_format($val["IDR"]); ?></td>
                    <td align="right"><?php echo number_format($val["USD"]); ?></td> 
                    <td align="right"><?php echo number_format($val["RMB"]); ?></td>                                      
                    
                    </td>
                </tr>
                <?php
                $no++;
            }
            ?>

        </tbody>
    </table>

    <!--<div class="row">
        <div class="col-xs-6 col-left">
            <div id="table-2_info" class="dataTables_info">&nbsp;</div>
        </div>
        <div class="col-xs-6 col-right">
            <div class="dataTables_paginate paging_bootstrap">
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>-->

</div>
</div>