<?php
$this->load->view('header'); 
$gantikursor = "onkeydown=\"changeCursor(event,'userlevel',this)\"";
if($edit){ $fieldset = "Edit"; }
else{ $fieldset = "View";}?>
<script language="javascript" src="<?=base_url();?>public/js/global.js"></script>
<body onload="firstLoad('userlevel')">
<form method='post' name="userlevel" id="userlevel" action='<?=base_url();?>index.php/master/userlevel/save_userlevel'>
<table align = 'center'>
	<tr>
		<td>
		<fieldset class="fieldsetUmum">
		<legend><b><?=$fieldset?> User Level</b></legend>
			<table align = 'center'>
				<tr>
					<td nowrap>Kode</td>
					<td nowrap>:</td>
					<td nowrap><input type='text' maxlength="2" size="5" readonly name='kode' id='kode' value='<?=$viewuserlevel->UserLevelID;?>' /></td>
				</tr>
				<tr>
					<td nowrap>Nama</td>
					<td nowrap>:</td>
					<td nowrap><input type='text' maxlength="50" size="55" id='nama' name='nama' value='<?=$viewuserlevel->UserLevelName;?>' <?=$gantikursor;?>/></td>
				</tr>
				<tr>
					<td nowrap colspan="3">
					<?php if($edit){ ?>
						<input type='button' value='Save' onclick="cekMaster2('kode','nama','userlevel','Kode User Level','Keterangan')"/>
					<?php } ?>
						<input type="button" value="Back" ONCLICK =parent.location="<?=base_url();?>index.php/master/userlevel/" />
					</td>
				</tr>
			</table>
		</fieldset>
		</td>
	</tr>
</table>
</form>
<?php
$this->load->view('footer'); ?>