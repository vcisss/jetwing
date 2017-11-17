<?php
$this->load->view('header'); ?>

<form method="POST"  name="search" action="">
<table align='center'>
	<tr>
		<td><input type='text' size'20' name='stSearchingKey' id='stSearchingKey'></td>
		<td>
			<select size="1" height="1" name ="searchby" id ="searchby">
				<option value="UserLevelID">Kode User Level</option>
				<option value="UserLevelName">Keterangan</option>
			</select>
		</td>
		<td><input type="submit" value="Search (*)"></td>
	</tr>
</table>
</form>

<br>

<table align = 'center' border='1' class='table_class_list'>
	<tr>
	<?php
		if($link->view=="Y"||$link->edit=="Y"||$link->delete=="Y")
		{
		?>
		<th></th>
	<?php } ?>
		<th>Kode User Level</th>
		<th>Keterangan</th>
	</tr>
<?php
	if(count($userleveldata)==0)
	{ 
?>
	<td nowrap colspan="3" align="center">Tidak Ada Data</td>
<?php		
	}
for($a = 0;$a<count($userleveldata);$a++)
{
?>
	<tr>
<?php
	if($link->view=="Y"||$link->edit=="Y"||$link->delete=="Y"||$permit->view=="Y"||$permit->edit=="Y"||$permit->delete=="Y"||$permit->add=="Y")
	{
?>
			<td nowrap>
		<?php
			if($link->view=="Y")
			{
		?>
		<a 	href="<?=base_url();?>index.php/master/userlevel/view_userlevel/<?=$userleveldata[$a]['UserLevelID'];?>"><img src='<?=base_url();?>public/images/zoom.png' border = '0' title = 'View'/></a>
		<?php
			}
			if($link->edit=="Y")
			{
		?>
		<a 	href="<?=base_url();?>index.php/master/userlevel/edit_userlevel/<?=$userleveldata[$a]['UserLevelID'];?>"><img src='<?=base_url();?>public/images/pencil.png' border = '0' title = 'Edit'/></a>
		<?php
			}
			if($link->delete=="Y")
			{
		?>
		<a 	href="<?=base_url();?>index.php/master/userlevel/delete_userlevel/<?=$userleveldata[$a]['UserLevelID'];?>"><img src='<?=base_url();?>public/images/cancel.png' border = '0' title = 'Delete'/></a>		
		<?php
			}
			
		?>
		<a 	href="#"><img src='<?=base_url();?>public/images/detail.png' border = '0' title = 'Set Permissions'/></a>
	  <?php ?>
		</td>
<?php } ?>
		<td nowrap><?=$userleveldata[$a]['UserLevelID'];?></td>
		<td nowrap><?=$userleveldata[$a]['UserLevelName'];?></td>
	<tr>
<?php
}
?>
</table>
<table align = 'center'  >
	<tr>
	<td>
	<?php echo $this->pagination->create_links(); ?>
	</td>
	</tr>
<?php
	if($link->add=="Y")
	{
?>
	<tr>
	<td nowrap colspan="3">
		<a 	href="<?=base_url();?>index.php/master/userlevel/add_new/"><img src='<?=base_url();?>public/images/add.png' border = '0' title = 'Add'/></a>
	</td>
<?php } ?>
</table>
<?php
$this->load->view('footer'); ?>