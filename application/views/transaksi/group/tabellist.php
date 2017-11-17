<?php $this->load->view('header'); ?>

</head>
<form method="POST"  name="search" action='<?php echo base_url(); ?>index.php/transaksi/group/search'>
	<input type="hidden" name="btn_search" id="btn_search" value="y"/>
	<div class="row">
		<div class="col-md-6">
			<b>Search</b>&nbsp;
			<input type="text" size="60" maxlength="30" name="search_keyword" id="search_keyword" class="form-control-new" value="<?php if($search_keyword){ echo $search_keyword; } ?>" />
		</div>
		<div class="col-md-4">
			<b>Tanggal</b>&nbsp;
	       	<input type="text" class="form-control-new datepicker"  placeholder="dd-mm-yyyy" value="" name="v_tgl" id="v_tgl" style="text-align: left;" value="<?php echo $v_tgl;?>"/>
	    </div>
		<div class="col-md-2" align="right">
			<button type="submit" class="btn btn-info btn-icon btn-sm icon-left" onClick="show_loading_bar(100)">Search<i class="entypo-search"></i></button>
			<a href="<?php echo base_url()."index.php/transaksi/group/add_new/"; ?>" onClick="show_loading_bar(100)" class="btn btn-info btn-icon btn-sm icon-left" title="" >Tambah<i class="entypo-plus"></i></a>
		</div>
	</div>
</form>

<hr/>

<?php
if($this->session->flashdata('msg'))
{
  $msg = $this->session->flashdata('msg');
  
  ?><div class="alert alert-<?php echo $msg['class'];?>"><?php echo $msg['message']; ?></div><?php
}
?>
	
<div id="table-2_wrapper" class="dataTables_wrapper form-inline" role="grid">
	<table class="table table-bordered responsive">
        <thead class="title_table">
			<tr>
				<th class="col-xs-1"><center>No</center></th>
				<th class="col-xs-5"><center>Kode Group</center></th>
				<th class="col-xs-1"><center>Adult</center></th>
				<th class="col-xs-1"><center>Child</center></th>
				<th class="col-xs-1"><center>Mulai</center></th>
				<th class="col-xs-1"><center>Selesai</center></th>
				<th class="col-xs-2"><center>Guide</center></th>
				<th class="col-xs-1"><center>Tipe Optional</center></th>
				<th class="col-xs-1"><center>Status</center></th>
				<th class="col-xs-1"><center>Navigasi</center></th>
			</tr>
		</thead>
		<tbody>
		
		<?php
		if(count($data)==0)
		{
			echo "<tr><td colspan='100%' align='center'>Tidak Ada Data</td></tr>";
		}
		
		$no=1;
		foreach($data as $val)
		{
            $bgcolor = "";
            if($no%2==0)
            {
                $bgcolor = "background:#f7f7f7;";
            }
            
            if($val["TipeOptionTour"]=="1"){
				$tipe = "WITH TL";
			}else if($val["TipeOptionTour"]=="2"){
				$tipe = "FIT TL";
			}else {
				$tipe = "NO TL";
			}
            
            
			?>
			<tr style="cursor:pointer; <?php echo $bgcolor; ?>" onmouseover="change_onMouseOver('<?php echo $no; ?>')" onmouseout="change_onMouseOut('<?php echo $no; ?>')" id="<?php echo $no; ?>">
				<td><?php echo $no; ?></td>
                <td align="left"><?php echo $val["NamaGroup"]; ?></td>
                <td align="center"><?php echo $val["Pax_adult"]; ?></td>
                <td align="center"><?php echo $val["Pax_child"]; ?></td>
                <td align="center"><?php echo $val["TanggalMulai"]; ?></td>
                <td align="center"><?php echo $val["TanggalSelesai"]; ?></td>
                <td align="center"><?php echo $val["NamaTourGuide"]." ( ".$val["UserName"]." )"; ?></td>
                <td align="center"><?php echo $tipe; ?></td>
                <td align="center"><?= $val["Status"]==1 ? 'Open' :'Close' ; ?></td>
                <td align="center">
				    <?php if($val["Status"]=="1"){?>
	                <a href="<?php echo base_url();?>index.php/transaksi/group/edit_form/<?php echo $val["KdGroup"]; ?>" class="btn btn-info btn-sm sm-new tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit" title=""><i class="entypo-pencil"></i></a>
					<a href="<?php echo base_url();?>index.php/transaksi/group/lock_form/<?php echo $val["KdGroup"]; ?>" class="btn btn-danger btn-sm sm-new tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Lock" title=""><i class="entypo-lock"></i></a>
					<?php }else{?>
						<button type="button" class="btn btn-danger btn-sm sm-new tooltip-primary"  data-toggle="tooltip" data-placement="top" data-original-title="Lock" title="" onclick="info_lock()" >
                            <i class="entypo-lock"></i>
                        </button>
						<?php if(!empty($otorisasi)){?>
						<a href="<?php echo base_url();?>index.php/transaksi/group/open_lock/<?php echo $val["KdGroup"]; ?>" class="btn btn-success btn-sm sm-new tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Open" title=""><i class="entypo-key"></i></a>
					    <?php } ?>
					<?php }?>
				
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
	

<?php $this->load->view('footer'); ?>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script>
function info_lock(){
	alert("Sudah Di Lock.");
}
</script>
