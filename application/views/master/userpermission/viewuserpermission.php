<?php
    $this->load->view('header');
?>
<script language="javascript" src="<?=base_url();?>public/js/cek.js"></script>
<script language="javascript" src="<?=base_url();?>public/js/global.js"></script>
<form method="post" id="permisssion" name="permisssion" action="<?=base_url()?>index.php/master/userpermission/save_permission">
<table align = 'center' border='0'>
	<tr>
		<td>
		<fieldset class="fieldsetUmum">
		<legend><b>User Level Permission</b></legend>
			<table align = 'center'border='0' class='table_class_list'>
				<tr>
					<th>Menu</th>
					<th>Add <input type="checkbox" name="addAll" id="addAll" <?=$cekaddAll;?> onclick="SetChecked('addAll', 'add[]')"></th>
					<th>Edit <input type="checkbox" name="editAll" id="editAll" <?=$cekeditAll;?> onclick="SetChecked('editAll', 'edit[]')"></th>
					<th>Delete <input type="checkbox" name="delAll" id="delAll" <?=$cekdelAll;?> onclick="SetChecked('delAll', 'del[]')"></th>
					<th>View <input type="checkbox" name="viewAll" id="viewAll" <?=$cekviewAll;?> onclick="SetChecked('viewAll', 'view[]')"></th>
				</tr>
			<?php
			for($a = 0;$a<count($userpermissiondata);$a++)
			{
				$cekadd="";
				$cekedit="";
				$cekdel="";
				$cekview="";
				if($userpermissiondata[$a]['add']=="Y"){$cekadd="checked"; }
				if($userpermissiondata[$a]['edit']=="Y"){$cekedit="checked"; }
				if($userpermissiondata[$a]['delete']=="Y"){$cekdel="checked"; }
				if($userpermissiondata[$a]['view']=="Y"){$cekview="checked"; }
			?>
				<tr>
					<td nowrap><?=$userpermissiondata[$a]['tablename'];?></td>
					<td align="center"><input type="checkbox" name="add[]" id="add<?=$a;?>" value="<?=$userpermissiondata[$a]['tablename']?>" <?php echo $cekadd; ?> /></td>
					<td align="center"><input type="checkbox" name="edit[]" id="edit<?=$a;?>" value="<?=$userpermissiondata[$a]['tablename']?>" <?php echo $cekedit; ?> /></td>
					<td align="center"><input type="checkbox" name="del[]" id="del<?=$a;?>" value="<?=$userpermissiondata[$a]['tablename']?>" <?php echo $cekdel; ?>/></td>
					<td align="center"><input type="checkbox" name="view[]" id="view<?=$a;?>" value="<?=$userpermissiondata[$a]['tablename']?>" <?php echo $cekview; ?> />
				</tr>
			<?php
			}
			?>
			<input type="hidden" name="id" id="id" value="<?=$id;?>"/></td>
			</table>
		</fieldset>
		</td>
	</tr>
</table>
<table align = 'center'>
	<tr>
	<td colspan="4" align="right">
	<input type="button" value="Save" name="save" onclick="setpermission()"; />
	<input type="button" value="Back" name="back" onclick=parent.location="<?=base_url();?>index.php/master/userlevel/" />
	</td>
	</tr>
</table>
</form>
<p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
<?php
$this->load->view('footer'); ?>