<?php 
$mylib = new globallib();
 ?>
<div id="table-2_wrapper" class="dataTables_wrapper form-inline" role="grid">

<table class="table table-bordered responsive">
        <thead class="title_table">
            <tr>
                <th width="30"><center>No</center></th>
		        <th width="120"><center>ID Pendaftaran</center></th>
		        <th width="80"><center>Tanggal</center></th>
		        <th width="150"><center>Tour Leader</center></th>
		        <th width="150"><center>Tour Guide</center></th>
		        <th width="150"><center>Tour Travel</center></th>
		        <th width="150"><center>Propinsi</center></th>
		        <th width="50"><center>PAX Adult</center></th>
		        <th width="50"><center>PAX Child</center></th>
		        <th width="200"><center>Keterangan</center></th>
		        <th width="100"><center>Status</center></th>
                <th width="100"><center>Action</center></th>
        	</tr>
            
        </thead>
        <tbody>

            <?php
            if (count($data) == 0) {
                echo "<tr><td colspan='100%' align='center'>Tidak Ada Data</td></tr>";
            }

            $no = $startnum;
            foreach ($data as $val) {
                $bgcolor = "";
                if ($no % 2 == 0) {
                    $bgcolor = "background:#f7f7f7;";
                }

                if ($val["Status"] == 0) {
                    $echo_status = "<font style='color:#000000'><b>Pending</b></font>";
                } else if ($val["Status"] == 1) {
                    $echo_status = "<font style='color:#ff1c1c'><b>Close</b></font>";
                } else if ($val["Status"] == 2) {
                    $echo_status = "<font style='color:#ff1c1c;'><b>Void</b></font>";
                }
                
                ?>
                <tr title="<?php echo $text." - ".$val["no_voucher"]; ?>" style="cursor:pointer; <?php echo $bgcolor; ?>" onmouseover="change_onMouseOver('<?php echo $no; ?>')" onmouseout="change_onMouseOut('<?php echo $no; ?>')" id="<?php echo $no; ?>">
                    <td bgcolor="<?=$color;?>"><?php echo $no; ?></td>
                    <td align="center"><?php echo $val["id_pendaftaran"]; ?></td>
                    <td align="center"><?php echo $mylib->ubah_tanggal($val["Tanggal"]); ?></td>
                    <td align="left"><?php echo $val["NamaLeader"]; ?></td>                    
                    <td align="left"><?php echo $val["NamaGuide"]; ?></td>
                    <td align="left"><?php echo $val["NamaTour"];?></td>
                    <td align="left"><?php echo $val["NamaPropinsi"];?></td>
                    <td align="center"><?php echo $val["PAX_adult"]; ?></td>
                    <td align="center"><?php echo $val["PAX_child"]; ?></td>
                    <td align="left"><?php echo $val["Keterangan"]; ?></td> 
                    <td align="center"><?php echo $echo_status; ?></td>                                       
                    <td align="center">

                        <?php
                        if ($val["Status"] == 0) {
                            ?>
                            <!--<a href="<?php echo base_url(); ?>index.php/transaksi/uang_muka_beo/edit_uang_muka_beo/<?php echo $val["id"]; ?>"  class="btn btn-info btn-sm sm-new tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit" title=""><i class="entypo-pencil"></i></a>-->

                            <button type="button" class="btn btn-success btn-sm sm-new tooltip-primary"  data-toggle="tooltip" data-placement="top" data-original-title="Edit Bayar" title="" onclick="edit_pendaftaran('<?php echo $val["id_pendaftaran"]; ?>')" >
                                <i class="entypo-pencil"></i>
                            </button>
                            
                            <button type="button" class="btn btn-danger btn-sm sm-new tooltip-primary"  data-toggle="tooltip" data-placement="top" data-original-title="Close" title="" onclick="lock('<?php echo $val["id_pendaftaran"]; ?>', '<?php echo base_url(); ?>');" >
                                <i class="entypo-key"></i>
                            </button>
                            <?php
                        }

                        if ($val["Status"] == 1) {
                            ?>
                            
                            <button type="button" class="btn btn-info btn-sm sm-new tooltip-primary"  data-toggle="tooltip" data-placement="top" data-original-title="Edit Bayar" title="" onclick="view_bayar('<?php echo $val["id_pendaftaran"]; ?>')" >
                                <i class="entypo-eye"></i>
                            </button>
                           
                            <a href="#"  class="btn btn-orange btn-sm sm-new tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Print" title=""><i class="entypo-print"></i></a>
							<!-- <?php echo base_url(); ?>index.php/transaksi/pendaftaran_tamu/doPrint/<?php echo $val["id"]; ?> -->
                            
                            <?php
                        }

                        ?>

                    </td>
                </tr>
                <?php
                $no++;
            }
            ?>

        </tbody>
    </table>

    <div class="row">
        <div class="col-xs-6 col-left">
            <div id="table-2_info" class="dataTables_info">&nbsp;</div>
        </div>
        <div class="col-xs-6 col-right">
            <div class="dataTables_paginate paging_bootstrap">
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>
    
</div>	
