<?php
$this->load->view('header');
if($datalain==0){?>
<form name = "tabel" method="post" action="<?=base_url();?>index.php/master/userlevel/delete_This">
<table align = 'center'>
	<tr>
		<td>
		<fieldset class="fieldsetUmum">
		<legend><b>Delete User Level</b></legend>
			<table align = 'center'>
			<tr>
				<th nowrap colspan="3">Hapus Data Berikut ? </th>
			</tr>
			<tr>
				<td nowrap>Kode</td>
				<td nowrap>:</td>
				<td nowrap><?=$viewuserlevel->UserLevelID;?></td>
					<input type='hidden' readonly name='kode' id='kode' value='<?=$viewuserlevel->UserLevelID;?>' />
			</tr>
			<tr>
				<td nowrap>Nama</td>
				<td nowrap>:</td>
				<td nowrap><?=$viewuserlevel->UserLevelName;?></td>
			</tr>
			<tr>
				<td nowrap colspan="3">
					<input type='submit' value = "Yes"/>
					<input type="button" value="No" ONCLICK =parent.location="<?=base_url();?>index.php/master/userlevel/" />
				</td>
			</tr>
		</table>
		</fieldset>
		</td>
	</tr>
</table>
</form>
<?php
}
else
{
?>
<table align = 'center'>
	<tr>
		<td>
		<fieldset class="fieldsetUmum">
		<legend><b>Delete User Level</b></legend>
		<table align = 'center'>
		<tr>
			<th nowrap colspan="3">Data Tidak Dapat Dihapus Karena Sudah Terpakai</th>
		</tr>
		<tr>
			<td nowrap colspan="3">
				<input type="button" value="Back" ONCLICK =parent.location="<?=base_url();?>index.php/master/userlevel/" />
			</td>
		</tr>
		</table>
		</fieldset>
		</td>
	</tr>
</table>
<?php
}
$this->load->view('footer'); ?>