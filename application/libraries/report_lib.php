<?php
class report_lib {
	var $CI;
	function __construct(){
	    $this->CI =& get_instance();
	 	$this->CI->load->library('session');
	}
	function write_textbox($ket,$name,$value,$size,$max,$readonly,$type,$gantikursor,$colspan)
	{
	?>
		<tr>
		    <?if($type<>"hidden")
			{?>
			<td nowrap><?=$ket;?></td>
			<td nowrap>:</td>
			<?}?>
			<td nowrap colspan="<?=$colspan?>" ><input type="<?=$type;?>" maxlength="<?=$max;?>" size="<?=$size;?>" <?=$readonly;?> name="<?=$name;?>" id="<?=$name;?>" value="<?=$value;?>" <?=$gantikursor;?> /></td>
		</tr>
	<?php
	}
	function write_textbox_combo($ket,$nama1,$nama2,$nil1,$nil2,$size,$max,$readonly)
	{
	?>
		<tr bordercolor="#FFFFFF">
			<td nowrap><?=$ket?></td>
			<td nowrap>:</td>
			<td nowrap><input type="text" size="<?=$size?>" <?=$readonly;?> maxlength = "<?=$max?>" name="<?=$nama1?>" id="<?=$nama1?>" value="<?=$nil1?>"> s/d
			<input type="text" size="<?=$size?>" <?=$readonly;?> maxlength = "<?=$max?>" name="<?=$nama2?>" id="<?=$nama2?>" value="<?=$nil2?>"></td>
		</tr>
	<?php
	}
	function write_textbox_barang($ket,$nama1,$nama2,$nil1,$nil2,$size,$max,$readonly,$action1,$action2)
	{
	?>
		<tr bordercolor="#FFFFFF">
			<td nowrap><?=$ket?></td>
			<td nowrap>:</td>
			<td nowrap><input type="text" size="<?=$size?>" <?=$readonly;?> maxlength = "<?=$max?>" name="<?=$nama1?>" id="<?=$nama1?>" value="<?=$nil1?>">&nbsp;<input type="button" name="choice" <?=$action1;?> value="..." ></td>
			<td nowrap><b>s/d</b> &nbsp;</td>
			<td nowrap><input type="text" size="<?=$size?>" <?=$readonly;?> maxlength = "<?=$max?>" name="<?=$nama2?>" id="<?=$nama2?>" value="<?=$nil2?>">&nbsp;<input type="button" name="choice" <?=$action2;?> value="..." ></td>
		</tr>
	<?php
	}
	function write_double_combo($judul,$nama1,$nama2,$isi_semua,$val1,$val2,$primary,$nilai)
	{
	 ?>
	 	<tr>
	 	<td nowrap><?=$judul;?></td>
		<td nowrap>:</td>
		<td nowrap>
		<select size="1" id="<?=$nama1;?>" name="<?=$nama1;?>">
		<option value="">Semua</option>
		<?php
		for($a = 0;$a<count($isi_semua);$a++){
		 	$select = "";
		 	if($val1==$isi_semua[$a][$primary]){
				$select = "selected";
			}
		?>
		<option <?=$select;?> value= "<?=stripslashes($isi_semua[$a][$primary])?>"><?=stripslashes($isi_semua[$a][$nilai])?></option>
		<?php
		}
		?>
		</select>
		</td>
		<td nowrap><b>s/d</b> &nbsp;</td>
		<td nowrap>
		<select size="1" id="<?=$nama2;?>" name="<?=$nama2;?>">
		<option value="">Semua</option>
		<?php
		for($a = 0;$a<count($isi_semua);$a++){
		 	$select = "";
		 	if($val2==$isi_semua[$a][$primary]){
				$select = "selected";
			}
		?>
		<option <?=$select;?> value= "<?=stripslashes($isi_semua[$a][$primary])?>"><?=stripslashes($isi_semua[$a][$nilai])?></option>
		<?php
		}
		?>
		</select>
		</td>
		</tr>
	<?php
	}
       
        function write_plain_combo($judul,$nama,$isi_semua,$val,$primary,$nilai,$colspan)
	{
	?>
		<tr>
	 	<td nowrap><?=$judul;?></td>
		<td nowrap>:</td>
		<td nowrap colspan="<?=$colspan?>">
		<select size="1" id="<?=$nama;?>" name="<?=$nama;?>">
		<option value="">Semua</option>
		<?php
		for($a = 0;$a<count($isi_semua);$a++){
		 	$select = "";
		 	if($val==$isi_semua[$a][$primary]){
				$select = "selected";
			}
		?>
		<option <?=$select;?> value= "<?=stripslashes($isi_semua[$a][$primary])?>"><?=stripslashes($isi_semua[$a][$nilai])?></option>
		<?php
		}
		?>
		</select>
		</td>
		</tr>
	<?php
	}
	
	function write_plain_combo_report_mutasi($judul,$nama,$nm,$isi_semua,$val,$primary,$nilai,$colspan)
	{
	?>
		<tr id="<?=$nm;?>">
	 	<td nowrap><b><?=$judul;?></b></td>
		<td nowrap>:</td>
		<td nowrap colspan="<?=$colspan?>">
		<select class="form-control-new" size="1" id="<?=$nama;?>" name="<?=$nama;?>">
		<option value="">Semua</option>
		<?php
		for($a = 0;$a<count($isi_semua);$a++){
		 	$select = "";
		 	if($val==$isi_semua[$a][$primary]){
				$select = "selected";
			}
		?>
		<option <?=$select;?> value= "<?=stripslashes($isi_semua[$a][$primary])?>"><?=stripslashes($isi_semua[$a][$nilai])?></option>
		<?php
		}
		?>
		</select>
		</td>
		</tr>
	<?php
	}

	function write_lokasi_combo($judul,$nama,$isi_semua,$val,$primary,$nilai,$colspan)
	{
	?>
		<select size="1" id="<?=$nama;?>" name="<?=$nama;?>">
		<option value="">Semua</option>
		<?php
		for($a = 0;$a<count($isi_semua);$a++){
		 	$select = "";
		 	if($val==$isi_semua[$a][$primary]){
				$select = "selected";
			}
		?>
		<option <?=$select;?> value= "<?=stripslashes($isi_semua[$a][$primary])?>"><?=stripslashes($isi_semua[$a][$nilai])?></option>
		<?php
		}
		?>
		</select>
		</td>
		</tr>
	<?php
	}
}
?>