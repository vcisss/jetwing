<?php
$this->load->view('header'); ?>

<form method="POST"  name="search" action="">
	<div class="row">
		<div class="col-md-10">
			Search&nbsp;
			<input type="text" size="30" maxlength="30" name="stSearchingKey" id="stSearchingKey" class="form-control-new" value="" />
			&nbsp;
			<select class="form-control-new" name="searchby" id="searchby">
				<option value="UserName">Nama User</option>
				<option value="Id">Kode User</option>
			</select>
			
		</div>
		
		<div class="col-md-2">
			<button type="submit" class="btn btn-info btn-icon btn-sm icon-left" onClick="show_loading_bar(100)">Search<i class="entypo-search"></i></button>
			<a href="<?=base_url();?>index.php/master/user/add_new/" class="btn btn-info btn-icon btn-sm icon-left" onClick="show_loading_bar(100)">Tambah<i class="entypo-plus"></i></a>
		</div>
	</div>
</form>
	
<hr/>

<div id="table-2_wrapper" class="dataTables_wrapper form-inline" role="grid">
	<table class="table table-bordered responsive">
		<thead>
			<tr>
				<th width="100"><center>Kode User</center></th>
				<th><center>Name</center></th>
				<th><center>UserName</center></th>
				<th width="200"><center>User Level</center></th>
				<th width="50"><center>Aktif</center></th>
				<?php
				if($link->view=="Y"||$link->edit=="Y"||$link->delete=="Y")
				{
					?>
					<th width="100"><center>Navigasi</center></th>
					<?php					
				}
				?>
			</tr>
		</thead>
		
		<tbody>
		<?php
		if(count($userdata)==0)
		{
			echo "<tr><td colspan='100%' align='center'>Tidak Ada Data</td></tr>";
		}
		
		for($a = 0;$a<count($userdata);$a++)
		{
            $bgcolor = "";
            if($userdata[$a]['Id']%2==0)
            {
                $bgcolor = "background:#f7f7f7;";
            }
            
			?>
			<tr title="<?=$userdata[$a]['UserName'];?>" style="cursor:pointer; <?php echo $bgcolor; ?>" onmouseover="change_onMouseOver('<?php echo $userdata[$a]['Id']; ?>')" onmouseout="change_onMouseOut('<?php echo $userdata[$a]['Id']; ?>')" id="<?php echo $userdata[$a]['Id']; ?>">
				<td><?=$userdata[$a]['Id'];?></td>
				<td><?=$userdata[$a]['Name'];?></td>
				<td><?=$userdata[$a]['UserName'];?></td>
				<td><?=$userdata[$a]['UserLevelName'];?></td>
				<td align="center"><?=$userdata[$a]['Active'];?></td>
				
				<?php
				if($link->view=="Y"||$link->edit=="Y"||$link->delete=="Y")
				{
					echo "<td align='center'>";
					
					if($link->view=="Y")
					{
						?>
						<a 	href="<?=base_url();?>index.php/master/user/view_user/<?=$userdata[$a]['Id'];?>"><img src='<?=base_url();?>public/images/zoom.png' border = '0' title = 'View'/></a>		
						<?php
					}	
					
					if($link->edit=="Y")
					{
						?>
						<a 	href="<?=base_url();?>index.php/master/user/edit_user/<?=$userdata[$a]['Id'];?>"><img src='<?=base_url();?>public/images/pencil.png' border = '0' title = 'Edit'/></a>
						<?php
					}	
					
					if($link->delete=="Y")
					{
						?>
						<a 	href="<?=base_url();?>index.php/master/user/delete_user/<?=$userdata[$a]['Id'];?>"><img src='<?=base_url();?>public/images/cancel.png' border = '0' title = 'Delete'/></a>
						<?php
					}	
					
					echo "</td>";		
				}
				?>
			
			</tr>
			<?php
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
				<?php echo $this->pagination->create_links(); ?>
			</div>
		</div>
	</div>	
	
</div>

<?php $this->load->view('footer'); ?>