<?php $this->load->view('header'); 
$userlevel = $this->session->userdata('userlevel');
?>

</head>
<form method="POST"  name="search" action='<?php echo base_url(); ?>index.php/master/groupoptionaltour/search'>
	<input type="hidden" name="btn_search" id="btn_search" value="y"/>
	<div class="row">
		<div class="col-md-10">
			<b>Search</b>&nbsp;
			<input type="text" size="60" maxlength="30" name="search_keyword" id="search_keyword" class="form-control-new" value="<?php if($search_keyword){ echo $search_keyword; } ?>" />
		</div>
		
		<div class="col-md-2" align="right">
			<button type="submit" class="btn btn-info btn-icon btn-sm icon-left" onClick="show_loading_bar(100)">Search<i class="entypo-search"></i></button>
			<?php if($userlevel!='1'){?>
			<a href="<?php echo base_url()."index.php/master/groupoptionaltour/add_new/"; ?>" onClick="show_loading_bar(100)" class="btn btn-info btn-icon btn-sm icon-left" title="" >Tambah<i class="entypo-plus"></i></a>
			<?php } ?>
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
				<th class="col-xs-10"><center>Keterangan</center></th>
				<?php if($userlevel!='1'){?>
				<th class="col-xs-1"><center>Navigasi</center></th>
				<?php } ?>
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
			?>
			<tr style="cursor:pointer; <?php echo $bgcolor; ?>" onmouseover="change_onMouseOver('<?php echo $no; ?>')" onmouseout="change_onMouseOut('<?php echo $no; ?>')" id="<?php echo $no; ?>">
				<td><?php echo $no; ?></td>
                <td align="left"><?php echo $val["Keterangan"]; ?></td>
                <?php if($userlevel!='1'){?>
                <td align="center">
	                <a href="<?php echo base_url();?>index.php/master/groupoptionaltour/edit_form/<?php echo $val["KdGroupOptional"]; ?>" class="btn btn-info btn-sm sm-new tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit" title=""><i class="entypo-pencil"></i></a>
                </td>
                <?php } ?>
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
