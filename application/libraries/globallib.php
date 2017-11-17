<?php
class globallib {
	var $CI;
	function __construct(){
	    $this->CI =& get_instance();
	 	$this->CI->load->library('session');
		$this->CI->load->model('Globalmodel');
	}

	function getAllowList($sign){
		$segs = $this->CI->uri->segment_array();
//		print_r($segs);
		$session_level = $this->CI->session->userdata('userlevel');
		IF (count($segs)==1)
		   $arr = "index.php/".$segs[1]."/";
		else
		   $arr = "index.php/".$segs[1]."/".$segs[2]."/";
		$allowed = $this->CI->Globalmodel->getPermission($arr,$session_level);
//        print_r($allowed);
		if($session_level=="")
		{
			$reaction = "T";
		}
		else
		{
			if(!empty($allowed)){
				if($sign=="all")
				{
					if($allowed->view=="Y"||$allowed->add=="Y"||$allowed->edit=="Y"||$allowed->delete=="Y"){
						$reaction = "Y";
					}
					else { $reaction = "T"; }
				}
				if($sign=="view")
				{
					$reaction = $allowed->view;
				}
				if($sign=="add")
				{
					$reaction = $allowed->add;
				}
				if($sign=="del")
				{
					$reaction = $allowed->delete;
				}
				if($sign=="edit")
				{
					$reaction = $allowed->edit;
				}
			}
			else{
				$reaction = "T";
			}
		}
		return $reaction;
	}
	
	function menu_validation($menu){
	
		$session_username = $this->CI->session->userdata('username');
		
		$allowed = $this->CI->Globalmodel->getValidation($menu,$session_username);

		if($session_username=="")
		{
			$reaction = "T";
		}
		else
		{
			if(!empty($allowed)){
				$reaction = "Y";
			}
			else{
				$reaction = "T";
			}
		}
		return $reaction;
	}
	
	function hak_approve_reject($menu){
	
		$session_username = $this->CI->session->userdata('username');
		
		$allowed = $this->CI->Globalmodel->getValidation($menu,$session_username);

		if($session_username=="")
		{
			$reaction = 0;
		}
		else
		{
			if(!empty($allowed)){
				$reaction = $allowed->a;
			}
			else{
				$reaction = 0;
			}
		}
		return $reaction;
	}

	function restrictLink($str){
		$session_level = $this->CI->session->userdata('userlevel');
		$allowed = $this->CI->Globalmodel->getPermission($str,$session_level);
		return $allowed;
	}
	function write_header($str)
	{
		for($a=0;$a<count($str);$a++)
		{
			echo "<th>$str[$a]</th>";
		}
	}

	function option_boostrap ($judul,$nama,$isi_semua,$val,$primary,$nilai,$gantikursor,$action)
    {
        ?>

        <div class="form-group">
            <label class="col-sm-2 control-label"> <?=$judul ?></label>
            <div class="col-sm-2">
                <select class="form-control" size="1" id="<?=$nama;?>" name="<?=$nama;?>" <?=$gantikursor;?> <?=$action;?> >
                    <option value="">--Please Select--</option>
                    <?php
                    for($a = 0;$a<count($isi_semua);$a++){
                        $select = "";
                        if(addslashes(trim($val)) == addslashes(trim($isi_semua[$a][$primary]))){
                            $select = "selected";
                        }
                        ?>
                        <option <?=$select;?> value="<?=stripslashes($isi_semua[$a][$primary])?>"><?=stripslashes($isi_semua[$a][$nilai])?></option>
                    <?php
                    }
                    ?>
                </select>

            </div>
        </div>
	<?php
	}
	
	function option_boostrap_type3 ($judul,$nama,$isi_semua,$val,$primary,$nilai,$gantikursor,$url)
    {
        ?>

        <div class="form-group">
            <label class="col-sm-2 control-label"> <?=$judul ?></label>
            <div class="col-sm-2">
                <select class="form-control" size="1" id="<?=$nama;?>" name="<?=$nama;?>" onchange="cek_tgl_approve_so_type3('<?=$url;?>')" >
                    <option value="">--Please Select--</option>
                    <?php
                    for($a = 0;$a<count($isi_semua);$a++){
                        $select = "";
                        if(addslashes(trim($val)) == addslashes(trim($isi_semua[$a][$primary]))){
                            $select = "selected";
                        }
                        ?>
                        <option <?=$select;?> value="<?=stripslashes($isi_semua[$a][$primary])?>"><?=stripslashes($isi_semua[$a][$nilai])?></option>
                    <?php
                    }
                    ?>
                </select>

            </div>
        </div>
	<?php
	}
	
    function text_boostrap($ket,$name,$value,$size,$max,$readonly,$type,$gantikursor,$colspan)
	{
	?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?=$ket ?></label>
            <div class="col-sm-5">
                <input name="<?=$name?>" type="<?=$type?>" id="<?=$name?>" size="<?=$size?>" value="<?=$value?>" maxlength="<?=$max?>" <?=$readonly?>  <?=$gantikursor?> <?=$colspan?> class="form-control"/>
            </div>
        </div>
	<?php
	}

    function neonwrite_textbox($ket,$name,$value,$size,$max,$readonly,$type,$gantikursor,$colspan)
    {
        if($type <> "hidden"){
            ?>
            <div class="form-group">
                <label class="col-sm-2"> <?=$ket;?> </label>
                <div class="col-sm-3">
                    <input name="<?=$name?>" type="<?=$type?>" class="form-control" id="<?=$name?>" value="<?=$value?>" size="<?=$size?>" maxlength="<?=$max?>" <?=$readonly?>  <?=$gantikursor?> <?=$colspan?>   />
                </div>
            </div>
            <?php
        }else{
            ?>
                <input type="<?=$type;?>" name="<?=$name;?>" id="<?=$name;?>" value="<?=$value;?>"/>
            <?php
        }
    }

    function Number_textbox($ket,$name,$value,$size,$max,$readonly,$type,$gantikursor,$colspan)
    {
        if($type <> "hidden"){
            ?>
            <div class="form-group">
                <label class="col-sm-2"> <?=$ket;?> </label>
                <div class="col-sm-3">
                    <input name="<?=$name?>" type="<?=$type?>" class="form-control" id="<?=$name?>" value="<?=$value?>" size="<?=$size?>" maxlength="<?=$max?>" <?=$readonly?>  <?=$gantikursor?> <?=$colspan?>   class="auto" data-a-sep="." data-a-dec="," />
                </div>
            </div>
            <?php
        }else{
            ?>
                <input type="<?=$type;?>" name="<?=$name;?>" id="<?=$name;?>" value="<?=$value;?>"/>
            <?php
        }
    }

    function write_textbox($ket,$name,$value,$size,$max,$readonly,$type,$gantikursor,$colspan)
	{
	?>
		<tr>
		    <?if($type<>"hidden")
			{?>
			<td><?=$ket;?></td>
			<td nowrap>:</td>
			<?}?>
			<td nowrap colspan="<?=$colspan?>" ><input class="form-control-new" type="<?=$type;?>" maxlength="<?=$max;?>" size="<?=$size;?>" <?=$readonly;?> name="<?=$name;?>" id="<?=$name;?>" value="<?=$value;?>" <?=$gantikursor;?> /></td>
		</tr>
	<?php
	}
	function write_textbox2($ket,$name,$value,$size,$max,$readonly,$type,$gantikursor,$colspan,$close)
	{
	?>
		<tr>
			<td nowrap><?=$ket;?></td>
			<td nowrap>:</td>
			<td nowrap colspan="<?=$colspan?>" >
			<input type="<?=$type;?>" maxlength="<?=$max;?>" size="<?=$size;?>" <?=$readonly;?> name="<?=$name;?>" id="<?=$name;?>" value="<?=$value;?>" <?=$gantikursor;?>/></td>
	<?php
	    if($close=="ya")
		{
			echo "</tr>";
		}
	}
	function write_textbox3($ket,$name,$value,$size,$max,$readonly,$type,$gantikursor,$colspan,$close)
	{
	?>
		<td nowrap colspan="<?=$colspan?>" ><input type="<?=$type;?>" maxlength="<?=$max;?>" size="<?=$size;?>" <?=$readonly;?> name="<?=$name;?>" id="<?=$name;?>" value="<?=$value;?>" <?=$gantikursor;?> /></td>
	<?php
	     if($close=="ya")
		{
			echo "</tr>";
		}
	}
	
	function write_number($ket,$name,$value,$size,$max,$readonly,$type,$gantikursor,$colspan,$action)
	{
		if($type<>"hidden"){
	?>
		<tr>
		   <td><?=$ket;?></td>
			<td nowrap>:</td>
			<td nowrap colspan="<?=$colspan?>" ><input class="form-control-new" type="<?=$type;?>" maxlength="<?=$max;?>" size="<?=$size;?>" <?=$readonly;?> name="<?=$name;?>" id="<?=$name;?>" value="<?=$value;?>" <?=$gantikursor;?> <?=$action;?> class="InputAlignRight" /></td>
		</tr>
	<?php
		}else{ ?>
			<input class="form-control-new" type="<?=$type;?>" maxlength="<?=$max;?>" size="<?=$size;?>" <?=$readonly;?> name="<?=$name;?>" id="<?=$name;?>" value="<?=$value;?>" <?=$gantikursor;?> <?=$action;?> class="InputAlignRight" />
	<?php
		}	
	}
	function write_number2($ket,$name,$value,$size,$max,$readonly,$type,$gantikursor,$colspan,$action)
	{
	?>
		<td nowrap colspan="<?=$colspan?>" ><input type="<?=$type;?>" maxlength="<?=$max;?>" size="<?=$size;?>" <?=$readonly;?> name="<?=$name;?>" id="<?=$name;?>" value="<?=$value;?>" <?=$gantikursor;?> <?=$action;?> class="InputAlignRight"  placeholder="<?=$ket;?>"/></td>
	<?php
	}

    function write_combo($judul,$nama,$isi_semua,$val,$primary,$nilai,$gantikursor,$action,$close)
    {
        ?>
        <tr>
        <td><?=$judul;?></td>
        <td nowrap></td>
        <td nowrap>
            <select class="form-control-new" size="1" id="<?=$nama;?>" name="<?=$nama;?>" <?=$gantikursor;?> <?=$action;?> >
                <option value="">  --  Please Select  --  </option>

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
        <?php
        //echo $val;
        if($close=="ya")
        {
            echo "</tr>";
        }
    }

function neonwrite_combo($judul,$nama,$isi_semua,$val,$primary,$nilai,$gantikursor,$action,$close)
    {
        ?>
        <div class="form-group">
            <label class="col-sm-1 "><?=$judul;?></label>
            <div class="col-sm-5">
                <select class="form-control" id="<?=$nama;?>" name="<?=$nama;?>" <?=$gantikursor;?> <?=$action;?> >
                    <option value="">--Please Select--</option>
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
            </div>
        </div>
       <?php
    }

	function write_combo3($judul,$nama,$isi_semua,$val,$primary,$nilai,$gantikursor,$action,$close)
	{
	 ?>
	 	<tr>
	 	<td nowrap class="title_table"><?=$judul;?></td>
		<td nowrap colspan="2">
		<select size="1" id="<?=$nama;?>" name="<?=$nama;?>" <?=$gantikursor;?> <?=$action;?> class="form-control">
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
	<?php
	    //echo $val;
		if($close=="ya")
		{
			echo "</tr>";
		}
	}
	
	function write_combo4($judul,$nama,$isi_semua,$val,$primary,$nilai,$gantikursor,$action,$close)
	{
	 ?>
	 	<tr>
	 	<td nowrap class="title_table"><?=$judul;?></td>
		<td nowrap colspan="2">
		<select size="1" id="<?=$nama;?>" name="<?=$nama;?>" <?=$gantikursor;?> <?=$action;?> class="form-control" style="width: 25%;">
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
	<?php
	    //echo $val;
		if($close=="ya")
		{
			echo "</tr>";
		}
	}
	
	function write_combo5($judul,$nama,$isi_semua,$val,$primary,$nilai,$gantikursor,$action,$close)
	{
	 ?>
	 	<tr>
	 	<td nowrap class="title_table"><?=$judul;?></td>
		<td nowrap colspan="2">
		<select size="1" id="<?=$nama;?>" name="<?=$nama;?>" <?=$gantikursor;?> <?=$action;?> class="form-control" style="width: 25%;" DISABLED>
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
	<?php
	    //echo $val;
		if($close=="ya")
		{
			echo "</tr>";
		}
	}

	function write_plain_combo($judul,$nama,$gantikursor,$value,$action,$close)
	{
		
	?>
		<td nowrap><b> <?=$judul;?></b> </td>
		<td nowrap>
			<select size="1" id="<?=$nama;?>" name="<?=$nama;?>" <?=$gantikursor;?> <?=$action;?>>
			<option value="">--Please Select--</option>
			<?=$value;?>
			</select>
		</td>
	<?php
		if($close=="ya")
		{
			echo "</tr>";
		}
	}
	
	
	function write_detailFormula($counter,$pcode,$nama,$qty,$pcodebarang,$nilsatuan,$disabl,$msatuan)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="15" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)"> <img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="45" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap>
			<select <?=$disabl?> size="1" name="satuan[]" id="satuan<?=$counter?>" onchange="storeSatuan(this)" onkeydown="keyShortcut(event,'satuan',this)">
			<?=$msatuan?>
			</select>
		</td>
		<!--<td nowrap><input type="text" id="nilsatuan<?=$counter?>" name="nilsatuan[]" size="5" readonly="readonly" value="<?=$nilsatuan?>"></td>-->
		<td nowrap><input type="text" id="qty<?=$counter?>" name="qty[]" size="5" maxlength="11" value="<?=$qty?>" onkeydown="keyShortcut(event,'qty',this)" class="InputAlignRight">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmpqty<?=$counter?>" name="tmpqty[]" value="<?=$qty?>">
		<input type="hidden" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		<input type="hidden" id="pcodebarang<?=$counter?>" name="pcodebarang[]" value="<?=$pcodebarang?>">
		<input type="hidden" id="satuantmp<?=$counter?>" name="satuantmp[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="nilsatuan<?=$counter?>" name="nilsatuan[]" value="<?=$nilsatuan?>">
		</td>
	</tr>
	<?php
	}
	function write_detailKodeext($counter,$pcode,$nama,$pcodeext,$namaext)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="15" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)"> <img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="45" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap><input type="text" id="pcodeext<?=$counter?>" name="pcodeext[]" size="15" maxlength="15" value="<?=$pcodeext?>" onkeydown="keyShortcut(event,'pcodeext',this)"></td>
		<td nowrap><input type="text" id="namaext<?=$counter?>" name="namaext[]" size="45" value="<?=$namaext?>" onkeydown="keyShortcut(event,'namaext',this)">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		</td>
	</tr>
	<?php
	}
	function write_detailSO($counter,$pcode,$nama,$qty,$totalb,$hargab,$disc1,$disc2,$tmphargab,$pcodebarang,$nilsatuan,$batasharga,$disabl,$msatuan,
	$harga1c,$harga1t,$harga2c,$harga2t,$harga3c,$harga3t,$konv1st,$konv2st,$konv3st,$konversi,$satuanst,$nilsatuan,$nilsatuanst,$kdkategori,$kdbrand)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="15" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)"> <img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="45" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap>
			<select <?=$disabl?> size="1" name="satuan[]" id="satuan<?=$counter?>" onchange="storeSatuan(this)" onkeydown="keyShortcut(event,'satuan',this)">
			<?=$msatuan?>
			</select>
		</td>
		<!--<td nowrap><input type="text" id="nilsatuan<?=$counter?>" name="nilsatuan[]" size="5" readonly="readonly" value="<?=$nilsatuan?>"></td>-->
		<td nowrap><input type="text" id="qty<?=$counter?>" name="qty[]" size="5" maxlength="11" value="<?=$qty?>" onkeydown="keyShortcut(event,'qty',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="hargab<?=$counter?>" name="hargab[]" size="15" value="<?=$hargab?>" onkeydown="keyShortcut(event,'harga',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="disc1<?=$counter?>" name="disc1[]" size="5" value="<?=$disc1?>" onkeydown="keyShortcut(event,'disc1',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="disc2<?=$counter?>" name="disc2[]" size="5" value="<?=$disc2?>" onkeydown="keyShortcut(event,'disc2',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="totalb<?=$counter?>" name="totalb[]" size="15" readonly="readonly"  value="<?=$totalb?>" class="InputAlignRight">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmpqty<?=$counter?>" name="tmpqty[]" value="<?=$qty?>">
		<input type="hidden" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmphargab<?=$counter?>" name="tmphargab[]" value="<?=$tmphargab?>">
		<input type="hidden" id="pcodebarang<?=$counter?>" name="pcodebarang[]" value="<?=$pcodebarang?>">
		<input type="hidden" id="satuantmp<?=$counter?>" name="satuantmp[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="batasharga<?=$counter?>" name="batasharga[]" value="<?=$batasharga?>">
		<input type="hidden" id="harga1c<?=$counter?>" name="harga1c[]" value="<?=$harga1c?>">
		<input type="hidden" id="harga1t<?=$counter?>" name="harga1t[]" value="<?=$harga1t?>">
		<input type="hidden" id="harga2c<?=$counter?>" name="harga2c[]" value="<?=$harga2c?>">
		<input type="hidden" id="harga2t<?=$counter?>" name="harga2t[]" value="<?=$harga2t?>">
		<input type="hidden" id="harga3c<?=$counter?>" name="harga3c[]" value="<?=$harga3c?>">
		<input type="hidden" id="harga3t<?=$counter?>" name="harga3t[]" value="<?=$harga3t?>">
		<input type="hidden" id="konv1st<?=$counter?>" name="konv1st[]" value="<?=$konv1st?>">
		<input type="hidden" id="konv2st<?=$counter?>" name="konv2st[]" value="<?=$konv2st?>">
		<input type="hidden" id="konv3st<?=$counter?>" name="konv3st[]" value="<?=$konv3st?>">
		<input type="hidden" id="konversi<?=$counter?>" name="konversi[]" value="<?=$konversi?>">
		<input type="hidden" id="satuanst<?=$counter?>" name="satuanst[]" value="<?=$satuanst?>">
		<input type="hidden" id="nilsatuan<?=$counter?>" name="nilsatuan[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="nilsatuanst<?=$counter?>" name="nilsatuanst[]" value="<?=$nilsatuanst?>">
		<input type="hidden" id="kdkategori<?=$counter?>" name="kdkategori[]" value="<?=$kdkategori?>">
		<input type="hidden" id="kdbrand<?=$counter?>" name="kdbrand[]" value="<?=$kdbrand?>">
		</td>
	</tr>
	<?php
	}
	function write_detailFJ($counter,$pcode,$nama,$qty,$totalb,$hargab,$disc1,$disc2,$tmphargab,$pcodebarang,$nilsatuan,$batasharga,$disabl,$msatuan,
	$harga1c,$harga1t,$harga2c,$harga2t,$harga3c,$harga3t,$konv1st,$konv2st,$konv3st,$konversi,$satuanst,$nilsatuanst,$kdkategori,$kdbrand,$fromSO,$tersimpan)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="15" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)"> <img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="45" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap>
			<select <?=$disabl?> size="1" name="satuan[]" id="satuan<?=$counter?>" onchange="storeSatuan(this)" onkeydown="keyShortcut(event,'satuan',this)">
			<?=$msatuan?>
			</select>
		</td>
		<!--<td nowrap><input type="text" id="nilsatuan<?=$counter?>" name="nilsatuan[]" size="5" readonly="readonly" value="<?=$nilsatuan?>"></td>-->
		<td nowrap><input type="text" id="qty<?=$counter?>" name="qty[]" size="5" maxlength="11" value="<?=$qty?>" onkeydown="keyShortcut(event,'qty',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="hargab<?=$counter?>" name="hargab[]" size="15" value="<?=$hargab?>" onkeydown="keyShortcut(event,'harga',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="disc1<?=$counter?>" name="disc1[]" size="5" value="<?=$disc1?>" onkeydown="keyShortcut(event,'disc1',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="disc2<?=$counter?>" name="disc2[]" size="5" value="<?=$disc2?>" onkeydown="keyShortcut(event,'disc2',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="totalb<?=$counter?>" name="totalb[]" size="15" readonly="readonly"  value="<?=$totalb?>" class="InputAlignRight">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmpqty<?=$counter?>" name="tmpqty[]" value="<?=$qty?>">
		<input type="text" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmphargab<?=$counter?>" name="tmphargab[]" value="<?=$tmphargab?>">
		<input type="hidden" id="pcodebarang<?=$counter?>" name="pcodebarang[]" value="<?=$pcodebarang?>">
		<input type="hidden" id="satuantmp<?=$counter?>" name="satuantmp[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="batasharga<?=$counter?>" name="batasharga[]" value="<?=$batasharga?>">
		<input type="hidden" id="harga1c<?=$counter?>" name="harga1c[]" value="<?=$harga1c?>">
		<input type="hidden" id="harga1t<?=$counter?>" name="harga1t[]" value="<?=$harga1t?>">
		<input type="hidden" id="harga2c<?=$counter?>" name="harga2c[]" value="<?=$harga2c?>">
		<input type="hidden" id="harga2t<?=$counter?>" name="harga2t[]" value="<?=$harga2t?>">
		<input type="hidden" id="harga3c<?=$counter?>" name="harga3c[]" value="<?=$harga3c?>">
		<input type="hidden" id="harga3t<?=$counter?>" name="harga3t[]" value="<?=$harga3t?>">
		<input type="hidden" id="konv1st<?=$counter?>" name="konv1st[]" value="<?=$konv1st?>">
		<input type="hidden" id="konv2st<?=$counter?>" name="konv2st[]" value="<?=$konv2st?>">
		<input type="hidden" id="konv3st<?=$counter?>" name="konv3st[]" value="<?=$konv3st?>">
		<input type="hidden" id="konversi<?=$counter?>" name="konversi[]" value="<?=$konversi?>">
		<input type="hidden" id="satuanst<?=$counter?>" name="satuanst[]" value="<?=$satuanst?>">
		<input type="hidden" id="nilsatuan<?=$counter?>" name="nilsatuan[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="nilsatuanst<?=$counter?>" name="nilsatuanst[]" value="<?=$nilsatuanst?>">
		<input type="hidden" id="kdkategori<?=$counter?>" name="kdkategori[]" value="<?=$kdkategori?>">
		<input type="hidden" id="kdbrand<?=$counter?>" name="kdbrand[]" value="<?=$kdbrand?>">
		<input type="hidden" id="fromSO<?=$counter?>" name="fromSO[]" value="<?=$fromSO?>">
		<input type="text" id="tersimpan<?=$counter?>" name="tersimpan[]" size="10" readonly="readonly" value="<?=$tersimpan?>">
		</td>
	</tr>
	<?php
	}
	function write_detailPO($counter,$pcode,$nama,$extcode,$qty,$jumlahb,$ppnb,$totalb,$hargab,$disc1,$disc2,$potongan,$tmphargab,$pcodebarang,$nilsatuan,$batasharga,$disabl,$msatuan,
	$harga0b,$harga1b,$harga2b,$harga3b,$konv0st,$konv1st,$konv2st,$konv3st,$konversi,$satuanst,$nilsatuan,$nilsatuanst,$kdkategori,$kdbrand)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="15" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)">
			<img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="45" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap><input type="text" id="extcode<?=$counter?>" name="extcode[]" size="10" readonly="readonly" value="<?=$extcode?>"></td>
		<td nowrap>
			<select <?=$disabl?> size="1" name="satuan[]" id="satuan<?=$counter?>" onchange="storeSatuan(this)" onkeydown="keyShortcut(event,'satuan',this)">
			<?=$msatuan?>
			</select>
		</td>
		<!--<td nowrap><input type="text" id="nilsatuan<?=$counter?>" name="nilsatuan[]" size="5" readonly="readonly" value="<?=$nilsatuan?>"></td>-->
		<td nowrap><input type="text" id="qty<?=$counter?>" name="qty[]" size="5" maxlength="11" value="<?=$qty?>" onkeydown="keyShortcut(event,'qty',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="hargab<?=$counter?>" name="hargab[]" size="15" value="<?=$hargab?>" onkeydown="keyShortcut(event,'harga',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="disc1<?=$counter?>" name="disc1[]" size="5" value="<?=$disc1?>" onkeydown="keyShortcut(event,'disc1',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="disc2<?=$counter?>" name="disc2[]" size="5" value="<?=$disc2?>" onkeydown="keyShortcut(event,'disc2',this)" class="InputAlignRight"></td>
        <td nowrap><input type="text" id="potongan<?=$counter?>" name="potongan[]" size="5" value="<?=$potongan?>" onkeydown="keyShortcut(event,'potongan',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="jumlahb<?=$counter?>" name="jumlahb[]" size="15" readonly="readonly"  value="<?=$jumlahb?>" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="ppnb<?=$counter?>" name="ppnb[]" size="15" value="<?=$ppnb?>" onkeydown="keyShortcut(event,'ppnb',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="totalb<?=$counter?>" name="totalb[]" size="15" readonly="readonly"  value="<?=$totalb?>" class="InputAlignRight">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmpqty<?=$counter?>" name="tmpqty[]" value="<?=$qty?>">
		<input type="hidden" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmphargab<?=$counter?>" name="tmphargab[]" value="<?=$tmphargab?>">
		<input type="hidden" id="pcodebarang<?=$counter?>" name="pcodebarang[]" value="<?=$pcodebarang?>">
		<input type="hidden" id="satuantmp<?=$counter?>" name="satuantmp[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="batasharga<?=$counter?>" name="batasharga[]" value="<?=$batasharga?>">
		<input type="hidden" id="harga0b<?=$counter?>" name="harga0b[]" value="<?=$harga0b?>">
		<input type="hidden" id="harga1b<?=$counter?>" name="harga1b[]" value="<?=$harga1b?>">
		<input type="hidden" id="harga2b<?=$counter?>" name="harga2b[]" value="<?=$harga2b?>">
		<input type="hidden" id="harga3b<?=$counter?>" name="harga3b[]" value="<?=$harga3b?>">
		<input type="hidden" id="konv0st<?=$counter?>" name="konv0st[]" value="<?=$konv0st?>">
		<input type="hidden" id="konv1st<?=$counter?>" name="konv1st[]" value="<?=$konv1st?>">
		<input type="hidden" id="konv2st<?=$counter?>" name="konv2st[]" value="<?=$konv2st?>">
		<input type="hidden" id="konv3st<?=$counter?>" name="konv3st[]" value="<?=$konv3st?>">
		<input type="hidden" id="konversi<?=$counter?>" name="konversi[]" value="<?=$konversi?>">
		<input type="hidden" id="satuanst<?=$counter?>" name="satuanst[]" value="<?=$satuanst?>">
		<input type="hidden" id="nilsatuan<?=$counter?>" name="nilsatuan[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="nilsatuanst<?=$counter?>" name="nilsatuanst[]" value="<?=$nilsatuanst?>">
		<input type="hidden" id="kdkategori<?=$counter?>" name="kdkategori[]" value="<?=$kdkategori?>">
		<input type="hidden" id="kdbrand<?=$counter?>" name="kdbrand[]" value="<?=$kdbrand?>">
		</td>
	</tr>
	<?php
	}
	function write_detailFB($counter,$pcode,$nama,$extcode,$qty,$jumlahb,$ppnb,$totalb,$hargab,$disc1,$disc2,$tmphargab,$pcodebarang,$nilsatuan,$batasharga,$disabl,$msatuan,
	$harga0b,$harga1b,$harga2b,$harga3b,$konv0st,$konv1st,$konv2st,$konv3st,$konversi,$satuanst,$nilsatuanst,$kdkategori,$kdbrand,$fromPO,$tersimpan)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="15" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)"> <img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="45" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap><input type="text" id="extcode<?=$counter?>" name="extcode[]" size="10" readonly="readonly" value="<?=$extcode?>"></td>
		<td nowrap>
			<select <?=$disabl?> size="1" name="satuan[]" id="satuan<?=$counter?>" onchange="storeSatuan(this)" onkeydown="keyShortcut(event,'satuan',this)">
			<?=$msatuan?>
			</select>
		</td>
		<!--<td nowrap><input type="text" id="nilsatuan<?=$counter?>" name="nilsatuan[]" size="5" readonly="readonly" value="<?=$nilsatuan?>"></td>-->
		<td nowrap><input type="text" id="qty<?=$counter?>" name="qty[]" size="5" maxlength="11" value="<?=$qty?>" onkeydown="keyShortcut(event,'qty',this)" class="InputAlignRight"></td>
<!-- hidden -->	
		<input type="hidden" id="hargab<?=$counter?>" name="hargab[]" size="15" value="<?=$hargab?>" onkeydown="keyShortcut(event,'harga',this)" class="InputAlignRight">
		<input type="hidden" id="disc1<?=$counter?>" name="disc1[]" size="5" value="<?=$disc1?>" onkeydown="keyShortcut(event,'disc1',this)" class="InputAlignRight">
		<input type="hidden" id="disc2<?=$counter?>" name="disc2[]" size="5" value="<?=$disc2?>" onkeydown="keyShortcut(event,'disc2',this)" class="InputAlignRight">
		<input type="hidden" id="jumlahb<?=$counter?>" name="jumlahb[]" size="15" readonly="readonly"  value="<?=$jumlahb?>" class="InputAlignRight">
		<input type="hidden" id="ppnb<?=$counter?>" name="ppnb[]" size="15" readonly="readonly"  value="<?=$ppnb?>" class="InputAlignRight"></td>
		<input type="hidden" id="totalb<?=$counter?>" name="totalb[]" size="15" readonly="readonly"  value="<?=$totalb?>" class="InputAlignRight">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmpqty<?=$counter?>" name="tmpqty[]" value="<?=$qty?>">
		<input type="hidden" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmphargab<?=$counter?>" name="tmphargab[]" value="<?=$tmphargab?>">
		<input type="hidden" id="pcodebarang<?=$counter?>" name="pcodebarang[]" value="<?=$pcodebarang?>">
		<input type="hidden" id="satuantmp<?=$counter?>" name="satuantmp[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="batasharga<?=$counter?>" name="batasharga[]" value="<?=$batasharga?>">
		<input type="hidden" id="harga0b<?=$counter?>" name="harga0b[]" value="<?=$harga0b?>">
		<input type="hidden" id="harga1b<?=$counter?>" name="harga1b[]" value="<?=$harga1b?>">
		<input type="hidden" id="harga2b<?=$counter?>" name="harga2b[]" value="<?=$harga2b?>">
		<input type="hidden" id="harga3b<?=$counter?>" name="harga3b[]" value="<?=$harga3b?>">
		<input type="hidden" id="konv0st<?=$counter?>" name="konv0st[]" value="<?=$konv0st?>">
		<input type="hidden" id="konv1st<?=$counter?>" name="konv1st[]" value="<?=$konv1st?>">
		<input type="hidden" id="konv2st<?=$counter?>" name="konv2st[]" value="<?=$konv2st?>">
		<input type="hidden" id="konv3st<?=$counter?>" name="konv3st[]" value="<?=$konv3st?>">
		<input type="hidden" id="konversi<?=$counter?>" name="konversi[]" value="<?=$konversi?>">
		<input type="hidden" id="satuanst<?=$counter?>" name="satuanst[]" value="<?=$satuanst?>">
		<input type="hidden" id="nilsatuan<?=$counter?>" name="nilsatuan[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="nilsatuanst<?=$counter?>" name="nilsatuanst[]" value="<?=$nilsatuanst?>">
		<input type="hidden" id="kdkategori<?=$counter?>" name="kdkategori[]" value="<?=$kdkategori?>">
		<input type="hidden" id="kdbrand<?=$counter?>" name="kdbrand[]" value="<?=$kdbrand?>">
		<input type="hidden" id="fromPO<?=$counter?>" name="fromPO[]" value="<?=$fromPO?>">
		<input type="hidden" id="tersimpan<?=$counter?>" name="tersimpan[]" size="10" readonly="readonly" value="<?=$tersimpan?>">
		
<!-- end hidden -->
</td>
	</tr>
	<?php
	}
	function write_detailFB1($counter,$pcode,$nama,$extcode,$qty,$jumlahb,$ppnb,$totalb,$hargab,$disc1,$disc2,$potongan,$tmphargab,$pcodebarang,$nilsatuan,$batasharga,$disabl,$msatuan,
	$harga0b,$harga1b,$harga2b,$harga3b,$konv0st,$konv1st,$konv2st,$konv3st,$konversi,$satuanst,$nilsatuanst,$kdkategori,$kdbrand,$fromPO,$tersimpan)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="15" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)"> <img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(<?=$counter?>)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="45" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap><input type="text" id="extcode<?=$counter?>" name="extcode[]" size="10" readonly="readonly" value="<?=$extcode?>"></td>
		
		<td nowrap>
			<select <?=$disabl?> size="1" name="satuan[]" id="satuan<?=$counter?>" onchange="storeSatuan(this)" onkeydown="keyShortcut(event,'satuan',this)">
			<?=$msatuan?>
			</select>
		</td>
		<!--<td nowrap><input type="text" id="nilsatuan<?=$counter?>" name="nilsatuan[]" size="5" readonly="readonly" value="<?=$nilsatuan?>"></td>-->
		<td nowrap><input type="text" id="qty<?=$counter?>" name="qty[]" size="5" maxlength="11" value="<?=$qty?>" onkeydown="keyShortcut(event,'qty',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="hargab<?=$counter?>" name="hargab[]" size="15" value="<?=$hargab?>" onkeydown="keyShortcut(event,'harga',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="disc1<?=$counter?>" name="disc1[]" size="5" value="<?=$disc1?>" onkeydown="keyShortcut(event,'disc1',this)" class="InputAlignRight"></td>
        <td nowrap><input type="text" id="disc2<?=$counter?>" name="disc2[]" size="5" value="<?=$disc2?>" onkeydown="keyShortcut(event,'disc2',this)" class="InputAlignRight"></td>
        <td nowrap><input type="text" id="potongan<?=$counter?>" name="potongan[]" size="15" readonly="readonly"  value="<?=$potongan?>" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="jumlahb<?=$counter?>" name="jumlahb[]" size="15" readonly="readonly"  value="<?=$jumlahb?>" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="ppnb<?=$counter?>" name="ppnb[]" size="15" value="<?=$ppnb?>" onkeydown="keyShortcut(event,'ppnb',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="totalb<?=$counter?>" name="totalb[]" size="15" readonly="readonly"  value="<?=$totalb?>" class="InputAlignRight">
		
		<input type="hidden" id="extcode<?=$counter?>" name="extcode[]" size="10" readonly="readonly" value="<?=$extcode?>">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmpqty<?=$counter?>" name="tmpqty[]" value="<?=$qty?>">
		<input type="hidden" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmphargab<?=$counter?>" name="tmphargab[]" value="<?=$tmphargab?>">
		<input type="hidden" id="pcodebarang<?=$counter?>" name="pcodebarang[]" value="<?=$pcodebarang?>">
		<input type="hidden" id="satuantmp<?=$counter?>" name="satuantmp[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="batasharga<?=$counter?>" name="batasharga[]" value="<?=$batasharga?>">
		<input type="hidden" id="harga0b<?=$counter?>" name="harga0b[]" value="<?=$harga0b?>">
		<input type="hidden" id="harga1b<?=$counter?>" name="harga1b[]" value="<?=$harga1b?>">
		<input type="hidden" id="harga2b<?=$counter?>" name="harga2b[]" value="<?=$harga2b?>">
		<input type="hidden" id="harga3b<?=$counter?>" name="harga3b[]" value="<?=$harga3b?>">
		<input type="hidden" id="konv0st<?=$counter?>" name="konv0st[]" value="<?=$konv0st?>">
		<input type="hidden" id="konv1st<?=$counter?>" name="konv1st[]" value="<?=$konv1st?>">
		<input type="hidden" id="konv2st<?=$counter?>" name="konv2st[]" value="<?=$konv2st?>">
		<input type="hidden" id="konv3st<?=$counter?>" name="konv3st[]" value="<?=$konv3st?>">
		<input type="hidden" id="konversi<?=$counter?>" name="konversi[]" value="<?=$konversi?>">
		<input type="hidden" id="satuanst<?=$counter?>" name="satuanst[]" value="<?=$satuanst?>">
		<input type="hidden" id="nilsatuan<?=$counter?>" name="nilsatuan[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="nilsatuanst<?=$counter?>" name="nilsatuanst[]" value="<?=$nilsatuanst?>">
		<input type="hidden" id="kdkategori<?=$counter?>" name="kdkategori[]" value="<?=$kdkategori?>">
		<input type="hidden" id="kdbrand<?=$counter?>" name="kdbrand[]" value="<?=$kdbrand?>">
		<input type="hidden" id="fromPO<?=$counter?>" name="fromPO[]" value="<?=$fromPO?>">
		<input type="hidden" id="tersimpan<?=$counter?>" name="tersimpan[]" size="10" readonly="readonly" value="<?=$tersimpan?>">
		</td>
	</tr>
	<?php
	}
	function write_detailPB($counter,$pcode,$nama,$qty,$totalb,$hargab,$disc1,$disc2,$tmphargab,$pcodebarang,$nilsatuan,$namasatuan,$batasharga,$disabl,$msatuan,
	$harga0b,$harga1b,$harga2b,$harga3b,$konv0st,$konv1st,$konv2st,$konv3st,$konversi,$satuanst,$nilsatuanst,$kdkategori,$kdbrand,$fromPO,$tersimpan)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="15" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)"> <img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="45" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap>
			<select <?=$disabl?> size="1" name="satuan[]" id="satuan<?=$counter?>" onchange="storeSatuan(this)" onkeydown="keyShortcut(event,'satuan',this)">
			<?=$msatuan?>
			</select>
		</td>
		<!--<td nowrap><input type="text" id="nilsatuan<?=$counter?>" name="nilsatuan[]" size="5" readonly="readonly" value="<?=$nilsatuan?>"></td>-->
		<td nowrap><input type="text" id="qty<?=$counter?>" name="qty[]" size="5" maxlength="11" value="<?=$qty?>" onkeydown="keyShortcut(event,'qty',this)" class="InputAlignRight"></td>
		<td nowrap><input type="hidden" id="hargab<?=$counter?>" name="hargab[]" size="15" value="<?=$hargab?>" onkeydown="keyShortcut(event,'harga',this)" class="InputAlignRight"></td>
		<td nowrap><input type="hidden" id="disc1<?=$counter?>" name="disc1[]" size="5" value="<?=$disc1?>" onkeydown="keyShortcut(event,'disc1',this)" class="InputAlignRight"></td>
		<td nowrap><input type="hidden" id="disc2<?=$counter?>" name="disc2[]" size="5" value="<?=$disc2?>" onkeydown="keyShortcut(event,'disc2',this)" class="InputAlignRight"></td>
		<td nowrap><input type="hidden" id="totalb<?=$counter?>" name="totalb[]" size="15" readonly="readonly"  value="<?=$totalb?>" class="InputAlignRight">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmpqty<?=$counter?>" name="tmpqty[]" value="<?=$qty?>">
		<input type="hidden" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmphargab<?=$counter?>" name="tmphargab[]" value="<?=$tmphargab?>">
		<input type="hidden" id="pcodebarang<?=$counter?>" name="pcodebarang[]" value="<?=$pcodebarang?>">
		<input type="hidden" id="satuantmp<?=$counter?>" name="satuantmp[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="batasharga<?=$counter?>" name="batasharga[]" value="<?=$batasharga?>">
		<input type="hidden" id="harga0b<?=$counter?>" name="harga0b[]" value="<?=$harga0b?>">
		<input type="hidden" id="harga1b<?=$counter?>" name="harga1b[]" value="<?=$harga1b?>">
		<input type="hidden" id="harga2b<?=$counter?>" name="harga2b[]" value="<?=$harga2b?>">
		<input type="hidden" id="harga3b<?=$counter?>" name="harga3b[]" value="<?=$harga3b?>">
		<input type="hidden" id="konv0st<?=$counter?>" name="konv0st[]" value="<?=$konv0st?>">
		<input type="hidden" id="konv1st<?=$counter?>" name="konv1st[]" value="<?=$konv1st?>">
		<input type="hidden" id="konv2st<?=$counter?>" name="konv2st[]" value="<?=$konv2st?>">
		<input type="hidden" id="konv3st<?=$counter?>" name="konv3st[]" value="<?=$konv3st?>">
		<input type="hidden" id="konversi<?=$counter?>" name="konversi[]" value="<?=$konversi?>">
		<input type="hidden" id="satuanst<?=$counter?>" name="satuanst[]" value="<?=$satuanst?>">
		<input type="hidden" id="nilsatuan<?=$counter?>" name="nilsatuan[]" value="<?=$namasatuan?>">
		<input type="hidden" id="nilsatuanst<?=$counter?>" name="nilsatuanst[]" value="<?=$nilsatuanst?>">
		<input type="hidden" id="kdkategori<?=$counter?>" name="kdkategori[]" value="<?=$kdkategori?>">
		<input type="hidden" id="kdbrand<?=$counter?>" name="kdbrand[]" value="<?=$kdbrand?>">
		<input type="hidden" id="fromPO<?=$counter?>" name="fromPO[]" value="<?=$fromPO?>">
		<input type="hidden" id="tersimpan<?=$counter?>" name="tersimpan[]" size="10" readonly="readonly" value="<?=$tersimpan?>">
		</td>
	</tr>
	<?php
	}
	function write_detailOpname($counter,$pcode,$nama,$qty,$qtykomp,$qtyselisih,$hppkomp,$nilaiselisih,$totalb,$hargab,$disc1,$disc2,$tmphargab,$pcodebarang,$nilsatuan,$batasharga,$disabl,$msatuan,
	$harga0b,$harga1b,$harga2b,$harga3b,$konv0st,$konv1st,$konv2st,$konv3st,$konversi,$satuanst,$nilsatuanst,$kdkategori,$kdbrand,$fromPO,$tersimpan)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="15" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="45" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap>
			<select <?=$disabl?> size="1" name="satuan[]" id="satuan<?=$counter?>" onchange="storeSatuan(this)" onkeydown="keyShortcut(event,'satuan',this)">
			<?=$msatuan?>
			</select>
		</td>
		<!--<td nowrap><input type="text" id="nilsatuan<?=$counter?>" name="nilsatuan[]" size="5" readonly="readonly" value="<?=$nilsatuan?>"></td>-->
		<td nowrap><input type="text" id="qty<?=$counter?>" name="qty[]" size="5" maxlength="11" value="<?=$qty?>" onkeydown="keyShortcut(event,'qty',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="qtykomp<?=$counter?>" name="qtykomp[]" size="5" maxlength="11" value="<?=$qtykomp?>" onkeydown="keyShortcut(event,'qtykomp',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="qtyselisih<?=$counter?>" name="qtyselisih[]" size="5" maxlength="11" value="<?=$qtyselisih?>" onkeydown="keyShortcut(event,'qtyselisih',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="hppkomp<?=$counter?>" name="hppkomp[]" size="15" value="<?=$hppkomp?>" onkeydown="keyShortcut(event,'hppkomp',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="nilaiselisih<?=$counter?>" name="nilaiselisih[]" size="15" value="<?=$nilaiselisih?>" onkeydown="keyShortcut(event,'nilaiselisih',this)" class="InputAlignRight"></td>
		<td nowrap><input type="hidden" id="hargab<?=$counter?>" name="hargab[]" size="15" value="<?=$hargab?>" onkeydown="keyShortcut(event,'harga',this)" class="InputAlignRight"></td>
		<td nowrap><input type="hidden" id="disc1<?=$counter?>" name="disc1[]" size="5" value="<?=$disc1?>" onkeydown="keyShortcut(event,'disc1',this)" class="InputAlignRight"></td>
		<td nowrap><input type="hidden" id="disc2<?=$counter?>" name="disc2[]" size="5" value="<?=$disc2?>" onkeydown="keyShortcut(event,'disc2',this)" class="InputAlignRight"></td>
		<td nowrap><input type="hidden" id="totalb<?=$counter?>" name="totalb[]" size="15" readonly="readonly"  value="<?=$totalb?>" class="InputAlignRight">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmpqty<?=$counter?>" name="tmpqty[]" value="<?=$qty?>">
		<input type="hidden" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmphargab<?=$counter?>" name="tmphargab[]" value="<?=$tmphargab?>">
		<input type="hidden" id="pcodebarang<?=$counter?>" name="pcodebarang[]" value="<?=$pcodebarang?>">
		<input type="hidden" id="satuantmp<?=$counter?>" name="satuantmp[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="batasharga<?=$counter?>" name="batasharga[]" value="<?=$batasharga?>">
		<input type="hidden" id="harga0b<?=$counter?>" name="harga0b[]" value="<?=$harga0b?>">
		<input type="hidden" id="harga1b<?=$counter?>" name="harga1b[]" value="<?=$harga1b?>">
		<input type="hidden" id="harga2b<?=$counter?>" name="harga2b[]" value="<?=$harga2b?>">
		<input type="hidden" id="harga3b<?=$counter?>" name="harga3b[]" value="<?=$harga3b?>">
		<input type="hidden" id="konv0st<?=$counter?>" name="konv0st[]" value="<?=$konv0st?>">
		<input type="hidden" id="konv1st<?=$counter?>" name="konv1st[]" value="<?=$konv1st?>">
		<input type="hidden" id="konv2st<?=$counter?>" name="konv2st[]" value="<?=$konv2st?>">
		<input type="hidden" id="konv3st<?=$counter?>" name="konv3st[]" value="<?=$konv3st?>">
		<input type="hidden" id="konversi<?=$counter?>" name="konversi[]" value="<?=$konversi?>">
		<input type="hidden" id="satuanst<?=$counter?>" name="satuanst[]" value="<?=$satuanst?>">
		<input type="hidden" id="nilsatuan<?=$counter?>" name="nilsatuan[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="nilsatuanst<?=$counter?>" name="nilsatuanst[]" value="<?=$nilsatuanst?>">
		<input type="hidden" id="kdkategori<?=$counter?>" name="kdkategori[]" value="<?=$kdkategori?>">
		<input type="hidden" id="kdbrand<?=$counter?>" name="kdbrand[]" value="<?=$kdbrand?>">
		<input type="hidden" id="fromPO<?=$counter?>" name="fromPO[]" value="<?=$fromPO?>">
		<input type="hidden" id="tersimpan<?=$counter?>" name="tersimpan[]" size="10" readonly="readonly" value="<?=$tersimpan?>">
		</td>
	</tr>
	<?php
	}
	function write_detailFJ1($counter,$pcode,$nama,$qty,$totalb,$hargab,$disc1,$disc2,$tmphargab,$pcodebarang,$nilsatuan,$batasharga,$disabl,$msatuan)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="15" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)"> <img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="45" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap>
			<select <?=$disabl?> size="1" name="satuan[]" id="satuan<?=$counter?>" onchange="storeSatuan(this)" onkeydown="keyShortcut(event,'satuan',this)">
			<?=$msatuan?>
			</select>
		</td>
		<!--<td nowrap><input type="text" id="nilsatuan<?=$counter?>" name="nilsatuan[]" size="5" readonly="readonly" value="<?=$nilsatuan?>"></td>-->
		<td nowrap><input type="text" id="qty<?=$counter?>" name="qty[]" size="5" maxlength="11" value="<?=$qty?>" onkeydown="keyShortcut(event,'qty',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="hargab<?=$counter?>" name="hargab[]" size="15" value="<?=$hargab?>" onkeydown="keyShortcut(event,'harga',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="disc1<?=$counter?>" name="disc1[]" size="5" value="<?=$disc1?>" onkeydown="keyShortcut(event,'disc1',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="disc2<?=$counter?>" name="disc2[]" size="5" value="<?=$disc2?>" onkeydown="keyShortcut(event,'disc2',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="totalb<?=$counter?>" name="totalb[]" size="15" readonly="readonly"  value="<?=$totalb?>" class="InputAlignRight">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmpqty<?=$counter?>" name="tmpqty[]" value="<?=$qty?>">
		<input type="hidden" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmphargab<?=$counter?>" name="tmphargab[]" value="<?=$tmphargab?>">
		<input type="hidden" id="pcodebarang<?=$counter?>" name="pcodebarang[]" value="<?=$pcodebarang?>">
		<input type="hidden" id="satuantmp<?=$counter?>" name="satuantmp[]" value="<?=$nilsatuan?>">
		<input type="hidden" id="batasharga<?=$counter?>" name="batasharga[]" value="<?=$batasharga?>">
		<input type="hidden" id="harga1c<?=$counter?>" name="harga1c[]" value="0">
		<input type="hidden" id="harga1t<?=$counter?>" name="harga1t[]" value="0">
		<input type="hidden" id="harga2c<?=$counter?>" name="harga2c[]" value="0">
		<input type="hidden" id="harga2t<?=$counter?>" name="harga2t[]" value="0">
		<input type="hidden" id="harga3c<?=$counter?>" name="harga3c[]" value="0">
		<input type="hidden" id="harga3t<?=$counter?>" name="harga3t[]" value="0">
		</td>
	</tr>
	<?php
	}
	function write_detail_payrec($counter,$kdrekening,$namarekening,$jumlah,$subdivisi,$vsubdivisi,$dept,$vdept,$keterangan)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>	
		<td nowrap><input type="text" id="namarekening<?=$counter?>" name="namarekening[]" size="40"  value="<?=$namarekening?>" onkeyup="PilihRekening(this)" onkeydown="keyShortcut(event,'namarekening',this)"></td>	
		
		<td nowrap><input type="text" id="jumlah<?=$counter?>" name="jumlah[]" size="15" value="<?=$jumlah?>" onkeydown="keyShortcut(event,'jumlah',this)" class="InputAlignRight"></td>
        <td nowrap>
            <select size="1" id="subdivisi<?=$counter?>" name="subdivisi[]" onkeydown="keyShortcut(event,'subdivisi',this)">
                <?php
                for($a = 0;$a<count($subdivisi);$a++){
                    $select = "";
                    if($vsubdivisi==$subdivisi[$a]['KdSubDivisi']){
                        $select = "selected";
                    }
                    ?>
                    <option <?=$select;?> value= "<?=stripslashes($subdivisi[$a]['KdSubDivisi'])?>"><?=stripslashes($subdivisi[$a]['NamaSubDivisi'])?></option>
                <?php
                }
                ?>
            </select>
        </td>
        <td nowrap>
            <select size="1" id="dept<?=$counter?>" name="dept[]" onkeydown="keyShortcut(event,'dept',this)">
                <?php
                for($a = 0;$a<count($dept);$a++){
                    $select = "";
                    if($vdept==$dept[$a]['KdDepartemen']){
                        $select = "selected";
                    }
                    ?>
                    <option <?=$select;?> value= "<?=stripslashes($dept[$a]['KdDepartemen'])?>"><?=stripslashes($dept[$a]['NamaDepartemen'])?></option>
                <?php
                }
                ?>
            </select>
        </td>
		<td nowrap><input type="text" id="keterangan<?=$counter?>" name="keterangan[]" size="70" maxlength="150" value="<?=$keterangan?>" onkeydown="keyShortcut(event,'keterangan',this)">
		<td nowrap><input type="hidden" id="kdrekening<?=$counter?>" name="kdrekening[]" value="<?=stripslashes($kdrekening)?>" readonly">
		<input type="hidden" id="tmpkdrekening<?=$counter?>" name="tmpkdrekening[]" value="<?=$kdrekening?>">
		<input type="hidden" id="savekdrekening<?=$counter?>" name="savekdrekening[]" value="<?=$kdrekening?>">
		<input type="hidden" id="tmpjumlah<?=$counter?>" name="tmpjumlah[]" value="<?=$jumlah?>">
		<input type="hidden" id="urutan<?=$counter?>" name="urutan[]" value="<?=$counter?>">
		</td>
	</tr>
	<?php
	}
	
	function write_detail_payrec_2($counter,$kdrekening,$namarekening,$jumlah,$subdivisi,$vsubdivisi,$dept,$vdept,$keterangan,$hasil_cek)
	{
	//echo $jml_baris." = ".$counter;		
	if($hasil_cek=="Y"){
		$read = "readonly";
	}else{
		$read="";
	}
	
	?>
	<tr id="baris<?=$counter?>">
		
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		
		<td nowrap><input <?php echo $read; ?> type="text" id="namarekening<?=$counter?>" name="namarekening[]" size="40" value="<?=$namarekening?>" onkeyup="PilihRekening(this)" onkeydown="keyShortcut(event,'namarekening',this)"></td>	
		<td nowrap><input type="text" id="jumlah<?=$counter?>" name="jumlah[]" size="15" value="<?=$jumlah?>" onkeydown="keyShortcut(event,'jumlah',this)" class="InputAlignRight"></td>
        <td nowrap>
            <select size="1" id="subdivisi<?=$counter?>" name="subdivisi[]" onkeydown="keyShortcut(event,'subdivisi',this)">
                <?php
                for($a = 0;$a<count($subdivisi);$a++){
                    $select = "";
                    if($vsubdivisi==$subdivisi[$a]['KdSubDivisi']){
                        $select = "selected";
                    }
                    ?>
                    <option <?=$select;?> value= "<?=stripslashes($subdivisi[$a]['KdSubDivisi'])?>"><?=stripslashes($subdivisi[$a]['NamaSubDivisi'])?></option>
                <?php
                }
                ?>
            </select>
        </td>
        <td nowrap>
            <select size="1" id="dept<?=$counter?>" name="dept[]" onkeydown="keyShortcut(event,'dept',this)">
                <?php
                for($a = 0;$a<count($dept);$a++){
                    $select = "";
                    if($vdept==$dept[$a]['KdDepartemen']){
                        $select = "selected";
                    }
                    ?>
                    <option <?=$select;?> value= "<?=stripslashes($dept[$a]['KdDepartemen'])?>"><?=stripslashes($dept[$a]['NamaDepartemen'])?></option>
                <?php
                }
                ?>
            </select>
        </td>
		<td nowrap><input <?php echo $read; ?> type="text" id="keterangan<?=$counter?>" name="keterangan[]" size="70" maxlength="150" value="<?=$keterangan?>" onkeydown="keyShortcut(event,'keterangan',this)">
		<input type="hidden" id="tmpkdrekening<?=$counter?>" name="tmpkdrekening[]" value="<?=$kdrekening?>">
		<input type="hidden" id="savekdrekening<?=$counter?>" name="savekdrekening[]" value="<?=$kdrekening?>">
		<input type="hidden" id="tmpjumlah<?=$counter?>" name="tmpjumlah[]" value="<?=$jumlah?>">
		<input type="hidden" id="urutan<?=$counter?>" name="urutan[]" value="<?=$counter?>">
		<input type="hidden" id="cek<?=$counter?>" name="cek[]" value="<?=$hasil_cek?>">
		<input type="hidden" id="kdrekening<?=$counter?>" name="kdrekening[]" value="<?=$kdrekening?>">
		</td>
	</tr>
	<?php
	}
	
	function write_detail_giro($counter,$nogiro,$tglbuka,$tgljto,$jumlah,$tmpnogiro,$tmpjumlah)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="nogiro<?=$counter?>" name="nogiro[]" size="25" maxlength="20" value="<?=stripslashes($nogiro)?>" onkeydown="keyShortcut(event,'nogiro',this)">
		<img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="tglbuka<?=$counter?>" name="tglbuka[]" size="15" readonly="readonly" value="<?=$tglbuka?>"></td>
		<td nowrap><input type="text" id="tgljto<?=$counter?>" name="tgljto[]" size="15" readonly="readonly" value="<?=$tgljto?>"></td>
		<td nowrap><input type="text" id="jumlah<?=$counter?>" name="jumlah[]" size="15" value="<?=$jumlah?>" onkeydown="keyShortcut(event,'jumlah',this)" class="InputAlignRight">
		<input type="hidden" id="tmpnogiro<?=$counter?>" name="tmpnogiro[]" value="<?=$nogiro?>">
		<input type="hidden" id="savenogiro<?=$counter?>" name="savenogiro[]" value="<?=$nogiro?>">
		<input type="hidden" id="tmpjumlah<?=$counter?>" name="tmpjumlah[]" value="<?=$tmpjumlah?>">
		<input type="hidden" id="urutan<?=$counter?>" name="urutan[]" value="<?=$counter?>">
		</td>
	</tr>
	<?php
	}
	function write_detail_jurnal($counter,$kdrekening,$subdivisi,$namarekening,$debit,$kredit,$keterangan)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		<td nowrap><input type="text" id="kdrekening<?=$counter?>" name="kdrekening[]" size="10" maxlength="10" value="<?=stripslashes($kdrekening)?>" onkeydown="keyShortcut(event,'kdrekening',this)">
		<img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap>
            <select size="1" id="subdivisi<?=$counter?>" name="subdivisi[]">
                <option value"">Pilih</option>
                     <option <?php if($subdivisi=='2'){ echo "selected='selected'"; } ?> value=	'2'	>	Beauty Café	</option>
					<option <?php if($subdivisi=='1'){ echo "selected='selected'"; } ?> value=	'1'	>	Oemah Herborist	</option>
					<option <?php if($subdivisi=='3'){ echo "selected='selected'"; } ?> value=	'3'	>	Spa Corner	</option>
					<option <?php if($subdivisi=='4'){ echo "selected='selected'"; } ?> value=	'4'	>	Snack	</option>
					<option <?php if($subdivisi=='5'){ echo "selected='selected'"; } ?> value=	'5'	>	Souvenir	</option>
					<option <?php if($subdivisi=='6'){ echo "selected='selected'"; } ?> value=	'6'	>	Secret Garden	</option>
					<option <?php if($subdivisi=='7'){ echo "selected='selected'"; } ?> value=	'7'	>	Beauty Gourmet	</option>
					<option <?php if($subdivisi=='8'){ echo "selected='selected'"; } ?> value=	'8'	>	Fragrance Bar	</option>
					<option <?php if($subdivisi=='9'){ echo "selected='selected'"; } ?> value=	'9'	>	Djamoe Corner	</option>
					<option <?php if($subdivisi=='10'){ echo "selected='selected'"; } ?> value=	'10'	>	BE Store	</option>
					<option <?php if($subdivisi=='11'){ echo "selected='selected'"; } ?> value=	'11'	>	Black Eyes Coffee Luwak	</option>
					<option <?php if($subdivisi=='12'){ echo "selected='selected'"; } ?> value=	'12'	>	Gift & Acc Coffee 	</option>
					<option <?php if($subdivisi=='13'){ echo "selected='selected'"; } ?> value=	'13'	>	Black Eyes Cafe	</option>
					<option <?php if($subdivisi=='14'){ echo "selected='selected'"; } ?> value=	'14'	>	Patisserries	</option>
					<option <?php if($subdivisi=='15'){ echo "selected='selected'"; } ?> value=	'15'	>	Barista Class	</option>
					<option <?php if($subdivisi=='16'){ echo "selected='selected'"; } ?> value=	'16'	>	Cupping Class	</option>
					<option <?php if($subdivisi=='17'){ echo "selected='selected'"; } ?> value=	'17'	>	Roasting Class	</option>
					<option <?php if($subdivisi=='18'){ echo "selected='selected'"; } ?> value=	'18'	>	Special Class	</option>
					<option <?php if($subdivisi=='19'){ echo "selected='selected'"; } ?> value=	'19'	>	The Luwus Restaurant	</option>
					<option <?php if($subdivisi=='20'){ echo "selected='selected'"; } ?> value=	'20'	>	Rice View Restaurant	</option>
					<option <?php if($subdivisi=='21'){ echo "selected='selected'"; } ?> value=	'21'	>	Wine Bar	</option>
					<option <?php if($subdivisi=='22'){ echo "selected='selected'"; } ?> value=	'22'	>	Event	</option>
					<option <?php if($subdivisi=='23'){ echo "selected='selected'"; } ?> value=	'23'	>	Wedding Package ( Foto/ B	</option>
					<option <?php if($subdivisi=='24'){ echo "selected='selected'"; } ?> value=	'24'	>	Juice Corner	</option>
					<option <?php if($subdivisi=='25'){ echo "selected='selected'"; } ?> value=	'25'	>	Head Office	</option>
					<option <?php if($subdivisi=='26'){ echo "selected='selected'"; } ?> value=	'26'	>	Other	</option>
					<option <?php if($subdivisi=='27'){ echo "selected='selected'"; } ?> value=	'27'	>	Other	</option>
					<option <?php if($subdivisi=='28'){ echo "selected='selected'"; } ?> value=	'28'	>	Other	</option>
					<option <?php if($subdivisi=='30'){ echo "selected='selected'"; } ?> value=	'30'	>	Burger Corner	</option>
					<option <?php if($subdivisi=='29'){ echo "selected='selected'"; } ?> value=	'29'	>	Mini Zoo	</option>
					<option <?php if($subdivisi=='31'){ echo "selected='selected'"; } ?> value=	'31'	>	Gelato	</option>
            </select>
        </td>
		<td nowrap><input type="text" id="namarekening<?=$counter?>" name="namarekening[]" size="35" readonly="readonly" value="<?=$namarekening?>"></td>
		<td nowrap><input type="text" id="debit<?=$counter?>" name="debit[]" size="15" value="<?=$debit?>" onkeydown="keyShortcut(event,'debit',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="kredit<?=$counter?>" name="kredit[]" size="15" value="<?=$kredit?>" onkeydown="keyShortcut(event,'kredit',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="keterangan<?=$counter?>" name="keterangan[]" size="70" maxlength="70" value="<?=$keterangan?>" onkeydown="keyShortcut(event,'keterangan',this)">
		<input type="hidden" id="tmpkdrekening<?=$counter?>" name="tmpkdrekening[]" value="<?=$kdrekening?>">
		<input type="hidden" id="savekdrekening<?=$counter?>" name="savekdrekening[]" value="<?=$kdrekening?>">
		<input type="hidden" id="tmpdebit<?=$counter?>" name="tmpdebit[]" value="<?=$debit?>">
		<input type="hidden" id="tmpkredit<?=$counter?>" name="tmpkredit[]" value="<?=$kredit?>">
		<input type="hidden" id="urutan<?=$counter?>" name="urutan[]" value="<?=$counter?>">
		</td>
	</tr>
	<?php
	}
	function write_detail_pelunasan($counter,$kdrekening,$namarekening,$jumlah,$keterangan,$listjenis,$itemjenis,$nobukti,$nama,$hutang)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>
		
		<td nowrap>
		<select size="1" id="itemjenis<?=$counter;?>" name="itemjenis[]" value="<?=$itemjenis?>">
		<?php
		for($a = 0;$a<count($listjenis);$a++){
		 	$select = "";
		 	if($itemjenis==$listjenis[$a]["Jenis"]){
				$select = "selected";
			}
		?>
		<option <?=$select;?> value= "<?=stripslashes($listjenis[$a]["Jenis"])?>"><?=stripslashes($listjenis[$a]["NamaJenis"])?></option>
		<?php
		}
		?>
		</select>
		</td>
		<td nowrap><input type="text" id="nobukti<?=$counter?>" name="nobukti[]" size="12" maxlength="12" value="<?=stripslashes($nobukti)?>" onkeydown="keyShortcut(event,'nobukti',this)">
		<img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick2<?=$counter?>" border="0" onClick="pick2This(this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="25" readonly="readonly" value="<?=$nama?>"></td>
		<td nowrap><input type="text" id="kdrekening<?=$counter?>" name="kdrekening[]" size="10" maxlength="10" value="<?=stripslashes($kdrekening)?>" onkeydown="keyShortcut(event,'kdrekening',this)">
		<img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="namarekening<?=$counter?>" name="namarekening[]" size="25" readonly="readonly" value="<?=$namarekening?>"></td>
		<td nowrap><input type="text" id="hutang<?=$counter?>" name="hutang[]" size="15" value="<?=$hutang?>" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="jumlah<?=$counter?>" name="jumlah[]" size="15" value="<?=$jumlah?>" onkeydown="keyShortcut(event,'jumlah',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="keterangan<?=$counter?>" name="keterangan[]" size="70" maxlength="70" value="<?=$keterangan?>" onkeydown="keyShortcut(event,'keterangan',this)">
		<input type="hidden" id="tmpnobukti<?=$counter?>" name="tmpnobukti[]" value="<?=$nobukti?>">
		<input type="hidden" id="savenobukti<?=$counter?>" name="savenobukti[]" value="<?=$nobukti?>">
		<input type="hidden" id="tmpkdrekening<?=$counter?>" name="tmpkdrekening[]" value="<?=$kdrekening?>">
		<input type="hidden" id="savekdrekening<?=$counter?>" name="savekdrekening[]" value="<?=$kdrekening?>">
		<input type="hidden" id="tmpjumlah<?=$counter?>" name="tmpjumlah[]" value="<?=$jumlah?>">
		<input type="hidden" id="urutan<?=$counter?>" name="urutan[]" value="<?=$counter?>">
		</td>
	</tr>
	<?php
	}
        function write_detail_lainlain($counter,$pcode,$nama,$qty,$hrg,$nil)
	{
	?>
	<tr id="baris<?=$counter?>">
		<td nowrap><img src="<?=base_url();?>/public/images/del.png" width="16" height="16" id="del<?=$counter?>" border="0" onClick="deleteRow(this)"></td>	
		<td nowrap><input type="text" id="pcode<?=$counter?>" name="pcode[]" size="10" maxlength="10" value="<?=stripslashes($pcode)?>" onkeydown="keyShortcut(event,'pcode',this)">
		<img src="<?=base_url();?>/public/images/pick.png" width="16" height="16" id="pick<?=$counter?>" border="0" onClick="pickThis(this)"> </td>
		<td nowrap><input type="text" id="nama<?=$counter?>" name="nama[]" size="40" readonly="readonly" value="<?=$nama?>"></td>	
                <td nowrap><input type="text" id="qty<?=$counter?>" name="qty[]" size="10" value="<?=$qty?>" onkeyup="InputQty(this);" onkeydown="keyShortcut(event,'qty',this)" class="InputAlignRight"></td>
		<td nowrap><input type="text" id="hrg<?=$counter?>" name="hrg[]" size="15" maxlength="15" value="<?=$hrg?>">
                <td nowrap><input type="text" id="nil<?=$counter?>" name="nil[]" size="15" maxlength="15" value="<?=$nil?>">
		<input type="hidden" id="tmppcode<?=$counter?>" name="tmppcode[]" value="<?=$pcode?>">
		<input type="hidden" id="savepcode<?=$counter?>" name="savepcode[]" value="<?=$pcode?>">
		<input type="hidden" id="tmpjumlah<?=$counter?>" name="tmpjumlah[]" value="<?=$qty?>">
                <input type="hidden" id="qtypcs<?=$counter?>" name="qtypcs[]" >
		<input type="hidden" id="urutan<?=$counter?>" name="urutan[]" value="<?=$counter?>">
		</td>
	</tr>
	<?php
	}
	function ubah_format($harga){
		$s = number_format($harga, 2, ',', '.');
		return $s;
	}
		
	function ubah_format_awal($harga){
		$s = explode(".",$harga);
		$k = implode($s,"");
		$k = explode(",",$k);
		$s = implode($k,".");
		return $s;
	}
	function ubah_tanggal($tanggalan)
	{
		if($tanggalan=="")
		{
			$tgl = "0000-00-00";
		}
		else
		{
			//$a = array("/","-");
			$b = str_replace("/", "-", $tanggalan);

            $arr_tanggal = explode ('-', $b);

//			list ($tanggal, $bulan, $tahun) =
//			$tgl = $tahun."-".$bulan."-".$tanggal;
			$tgl = $arr_tanggal[2]."-".$arr_tanggal[1]."-".$arr_tanggal[0];
		}
		return $tgl;
	}

	function ubah_format_tanggal($tanggalan)
	{
	 list ($tahun, $bulan, $tanggal) = explode ('-', $tanggalan);
	 $tgl = $tanggal."-".$bulan."-".$tahun;
	 return $tgl;
	}
	function print_track()
	{
		$segs = $this->CI->uri->segment_array();
		if(count($segs)>=2){
			$arr = "index.php/".$segs[1]."/".$segs[2]."/";
			return $this->findRoot($arr);
		}
		if(count($segs)==1){
			
			if($segs[1]!="start")
			{
				return ucwords($segs[1]);
			}
		}
	}
	function date_diff(DateTime $date1, DateTime $date2) {
		$diff = new DateInterval();
	 
		if($date1 > $date2) {
		  $tmp = $date1;
		  $date1 = $date2;
		  $date2 = $tmp;
		  $diff->invert = 1;
		} else {
		  $diff->invert = 0;
		}
	 
		$diff->y = ((int) $date2->format('Y')) - ((int) $date1->format('Y'));
		$diff->m = ((int) $date2->format('n')) - ((int) $date1->format('n'));
		if($diff->m < 0) {
		  $diff->y -= 1;
		  $diff->m = $diff->m + 12;
		}
		$diff->d = ((int) $date2->format('j')) - ((int) $date1->format('j'));
		if($diff->d < 0) {
		  $diff->m -= 1;
		  $diff->d = $diff->d + ((int) $date1->format('t'));
		}
		$diff->h = ((int) $date2->format('G')) - ((int) $date1->format('G'));
		if($diff->h < 0) {
		  $diff->d -= 1;
		  $diff->h = $diff->h + 24;
		}
		$diff->i = ((int) $date2->format('i')) - ((int) $date1->format('i'));
		if($diff->i < 0) {
		  $diff->h -= 1;
		  $diff->i = $diff->i + 60;
		}
		$diff->s = ((int) $date2->format('s')) - ((int) $date1->format('s'));
		if($diff->s < 0) {
		  $diff->i -= 1;
		  $diff->s = $diff->s + 60;
		}
	 
		$start_ts   = $date1->format('U');
		$end_ts   = $date2->format('U');
		$days     = $end_ts - $start_ts;
		$diff->days  = round($days / 86400);
	 
		if (($diff->h > 0 || $diff->i > 0 || $diff->s > 0))
		  $diff->days += ((bool) $diff->invert)
			? 1
			: -1;
	 
		return $diff;
	}

    function getUser(){
        $u  = $this->CI->session->userdata('username');
        return $u;
    }
	function findRoot($url)
	{
		$first = $this->CI->Globalmodel->getName($url);
		if(substr($first->root,0,9)!="ddsubmenu")
		{
			$string = "<li class='active'>".$first->root."</li><li class='active'>".$first->nama."</li>";
			$second = $this->CI->Globalmodel->getName2($first->root);
			if(substr($second->root,0,9)=="ddsubmenu")
			{
				$fourth = $this->CI->Globalmodel->getRoot($second->root);
				$string = "<li class='active'>".$fourth->nama."</li><li class='active'>".$string."</li>";
			}
		}
		else{
			$string = "<li class='active'>".$first->nama."</li>";
			$fourth = $this->CI->Globalmodel->getRoot($first->root);
			$string = "<li class='active'>".$fourth->nama."</li><li class='active'>".$string."</li>";
		}
		return $string;
	}
	
	function validasi_password($new_password, $old_password)
	{
	    $return["msg"]    = "";
	    $return["status"] = 0;      
	    
	    $string  = "";
	    $string .= "abcdefghijklmnopqrstuvwxyz";
	    $string .= strtoupper("abcdefghijklmnopqrstuvwxyz");
	     
	    $jml_karakter = strlen($new_password);
	    
	    $sts_angka = 0;
	    for($i=0;$i<$jml_karakter;$i++)
	    {
	        $curr = substr($new_password,$i,1);
	        
	        if(is_numeric($curr))
	        {
	            $sts_angka = 1;
	            break;    
	        }
	    }
	    
	    $sts_string = 0;
	    for($i=0;$i<$jml_karakter;$i++)
	    {
	        $curr = substr($new_password,$i,1);
	        
	        if(strpos($string,$curr))
	        {
	            $sts_string = 1;
	            break;        
	        }
	    }
	    
	    if($new_password==$old_password)
	    {
	        $return["msg"]    = "Password Baru tidak boleh sama dengan Password lama";
	    }
	    else if($jml_karakter < 6)
	    {
	        $return["msg"]    = "Password minimal 6 karakter";
	    }
	    else if($sts_angka==0)
	    {
	        $return["msg"] =  "Password harus mengandung angka (Password harus terdiri dari kombinasi huruf dan angka)";    
	    } 
	    else if($sts_string==0)
	    {
	        $return["msg"] =  "Password harus mengandung huruf (Password harus terdiri dari kombinasi huruf dan angka)";
	    } 
	    else
	    {
	        $return["status"] = 1;
	        $return["msg"] = "Berhasil";
	    }
	    
	    return $return;
	}
	
	function get_code_counter($db_name, $tbl_name, $pk_name, $kode, $mm, $yyyy)
	{
	    global $db;
	    
	    $q = "
	            SELECT
	                SUBSTRING(".$db_name.".".$tbl_name.".".$pk_name.", 3, 5) AS last_counter
	            FROM
	                ".$db_name.".".$tbl_name."
	            WHERE
	                1
	                AND RIGHT(".$db_name.".".$tbl_name.".".$pk_name.",5) = '".$mm."-".substr($yyyy,2,2)."'
	            ORDER BY
	                SUBSTRING(".$db_name.".".$tbl_name.".".$pk_name.", 3, 5)*1 DESC
	            LIMIT
	                0,1
	    ";
	    //echo $q."<hr>";die;
	    $qry = mysql_query($q);
	    $row = mysql_fetch_array($qry);
	    list($last_counter) = $row;
	    
	    $last_counter = ($last_counter*1)+1;
	    
	    // PO00002-05-16
	    $counter = $kode.sprintf("%05s", $last_counter)."-".$mm."-".substr($yyyy,2,2);
	    
	    return $counter;
	}
	
	//3 HURUF DI DEPAN dan 000
	function get_code_counter2($db_name, $tbl_name, $pk_name, $kode, $mm, $yyyy)
	{
	    global $db;
	    
	    $q = "
	            SELECT
	                SUBSTRING(".$db_name.".".$tbl_name.".".$pk_name.", 5, 3) AS last_counter
	            FROM
	                ".$db_name.".".$tbl_name."
	            WHERE
	                1
	                AND RIGHT(".$db_name.".".$tbl_name.".".$pk_name.",5) = '".$mm."-".substr($yyyy,2,2)."'
	            ORDER BY
	                SUBSTRING(".$db_name.".".$tbl_name.".".$pk_name.", 5, 3)*1 DESC
	            LIMIT
	                0,1
	    ";
	    //echo $q."<hr>";
	    $qry = mysql_query($q);
	    $row = mysql_fetch_array($qry);
	    list($last_counter) = $row;
	    
	    $last_counter = ($last_counter*1)+1;
	    
	    // POM-00002-05-16
	    $counter = $kode."-".sprintf("%03s", $last_counter)."-".$mm."-".substr($yyyy,2,2);
	    //echo $counter;die;
	    return $counter;
	}
	
	//3 HURUF DI DEPAN dan 0000
	function get_code_counter3($db_name, $tbl_name, $pk_name, $kode, $mm, $yyyy)
	{
	    global $db;
	    
	    $q = "
	            SELECT
	                SUBSTRING(".$db_name.".".$tbl_name.".".$pk_name.", 5, 4) AS last_counter
	            FROM
	                ".$db_name.".".$tbl_name."
	            WHERE
	                1
	                AND RIGHT(".$db_name.".".$tbl_name.".".$pk_name.",5) = '".$mm."-".substr($yyyy,2,2)."'
	            ORDER BY
	                SUBSTRING(".$db_name.".".$tbl_name.".".$pk_name.", 5, 4)*1 DESC
	            LIMIT
	                0,1
	    ";
	    //echo $q."<hr>";
	    $qry = mysql_query($q);
	    $row = mysql_fetch_array($qry);
	    list($last_counter) = $row;
	    
	    $last_counter = ($last_counter*1)+1;
	    
	    // POM-00002-05-16
	    $counter = $kode."-".sprintf("%04s", $last_counter)."-".$mm."-".substr($yyyy,2,2);
	    //echo $counter;die;
	    return $counter;
	}
    
    
    function get_counter_int($db_name,$tbl_name,$pk,$limit=100)
    {
      $q = "
                SELECT
                    ".$db_name.".".$tbl_name.".".$pk."
                FROM
                    ".$db_name.".".$tbl_name."
                ORDER BY
                    ".$db_name.".".$tbl_name.".".$pk."*1 DESC
                LIMIT 0,".$limit."
        ";
        $qry_id = mysql_query($q);
        $jml_data = mysql_num_rows($qry_id);
        
        $no = true;
        while($r_id = mysql_fetch_object($qry_id))
        {
            if($no)
            {
                $id = $r_id->$pk;
                $no = false;
            }
            
            $arr_data["list_id"][$r_id->$pk] = $r_id->$pk;
        }
        
        $prev_id = 0;
        
        if($jml_data!=0)
        {
            foreach($arr_data["list_id"] as $list_id=>$val)
            {
                if($prev_id*1!=0)
                {
                    if( ($prev_id-1) != $val)
                    {
                        $id = $val;
                        break;
                    }
                }
                $prev_id = $val;
            }
        }
        else
        {
            $id = 0;
        }
        $id = ($id*1) + 1;
        
        return $id;
    } 
	
	
	function get_stock($KdGudang, $TglDokumen, $arr_pcode, $where_pcode, $where_KdBarang)
	{
	    
	    $arr_date = explode("-", $TglDokumen);
		$bulan = $arr_date[1];
		$tahun = $arr_date[0];
			
		$bulan = sprintf("%02s", $bulan);
		$TanggalAwal = $tahun."-".$bulan."-01";
		
		$q = "
				SELECT
					stock.PCode,
					stock.GAwal".$bulan." AS Stock_awal
				FROM
					stock
				WHERE
					1
					".$where_pcode."
					AND stock.Tahun = '".$tahun."'
					AND stock.KdGudang = '".$KdGudang."'
				ORDER BY
					 stock.PCode
		";
		
		$sql=mysql_query($q);
		while($row=mysql_fetch_array($sql))
		{ 
			list(
				$PCode,
				$Stock_awal
			) = $row;
			
			$arr_data["awal"][$PCode] = $Stock_awal; 
		}
		
		$q = "
				SELECT
					mutasi.KodeBarang,
					mutasi.Jenis,
					mutasi.Qty
				FROM
					mutasi
				WHERE
					1
					".$where_KdBarang."
					AND mutasi.Tanggal BETWEEN '".$TanggalAwal."' AND '".$TglDokumen."'
					AND (mutasi.Gudang = '$KdGudang' or mutasi.GudangTujuan='$KdGudang')
				ORDER BY
					 mutasi.KodeBarang
		";
		
		$sql=mysql_query($q);
		while($row=mysql_fetch_array($sql))
		{ 
			list(
				$PCode,
				$Jenis,
				$Qty
			) = $row;
			
			if($Jenis=="I")
			{
				$arr_data["masuk"][$PCode] += $Qty;     
			}
			else if($Jenis=="O")
			{
				$arr_data["keluar"][$PCode] += $Qty;     
			}
		}
		
		foreach($arr_pcode as $key=>$val_pcode)
		{
			$arr_data["akhir"][$val_pcode] = ($arr_data["awal"][$val_pcode] + $arr_data["masuk"][$val_pcode]) - $arr_data["keluar"][$val_pcode];
		}
		//echo "<pre>";print_r($arr_data["akhir"]);echo "</pre>";die();
		//return $arr_data;
		return $arr_data;
		
	}
	
	function format_number($nilai,$decimal=0,$point=".",$thousands=",", $type_data="")
	{
	    if($type_data=="ind")
	    {
	        if($nilai*1!=0)
	        {
	            $return = number_format($nilai, $decimal, ",", ".");
	        }
	        else
	        {
	            $return = "";
	        }     
	    }
	    else
	    {
		    if($nilai*1!=0)
		    {
	    	    $return = number_format($nilai, $decimal, $point, $thousands);
		    }
		    else
		    {
			    $return = "";
		    }       
	    }
	    
	    
	    return $return;
	}
	
	function where_array($list_array, $kolom, $type="in")
	{
		
		
	    $where = "";
	    if($type=="in")
	    {
	    	if(is_array($list_array))
	    	{
		        foreach($list_array as $key=>$val)
		        if($where == "")
		        {
		            $where .= " AND (".$kolom." = '".$val."' ";
		        }    
		        else
		        {
		            $where .= " OR ".$kolom." = '".$val."' ";    
		        }
		        
		        if($where)
		        {
		            $where .= ")";
		        }
			}
	    }
	    else if($type=="not in")
	    {
	    	if(is_array($list_array))
	    	{
		        foreach($list_array as $key=>$val)
		        if($where == "")
		        {
		            $where .= " AND (".$kolom." != '".$val."' ";
		        }    
		        else
		        {
		            $where .= " OR ".$kolom." != '".$val."' ";
		        }
		        
		        if($where)
		        {
		            $where .= ")";
		        }
		    }    
	    }
	    
	    return $where;
	}
	
	function search_keyword($v_keyword, $arr_keyword)
	{
	    $exp_keyword = explode(" ",$v_keyword);
	    $jml_keyword = count($exp_keyword)-1;
	    $jml_kolom   = count($arr_keyword);
	    
	    $where_keyword = "";
	    for($key=0;$key<=$jml_keyword;$key++)
	    {
	        $i = 0;
	        $where_keyword .= " AND ( ";
	        foreach($arr_keyword as $val)
	        {
	            $where_keyword .= $val." LIKE '%".$exp_keyword[$key]."%' OR ";
	            $i++;
	            
	            if($i==$jml_kolom)
	            {
	                $where_keyword = substr($where_keyword,0,-3);
	            }
	        }
	        $where_keyword .= " ) ";
	    }
	    $where_keyword  = substr($where_keyword,0,-4);                                              
	    

	    
	    $where_keyword .= ")";

	    return $where_keyword;
	}
	
	function hapus_karakter($char)
	{
	    $return =  preg_replace("/[^A-Za-z0-9.]/", ' ',$char);
	    
	    return $return;
	}
	
	function save_char($char)
	{
	    $return =  mysql_real_escape_string(trim($char));
	    
	    return $return;
	}

	function save_int($int, $type="")
	{
	    if($type=="")
	    {
	        $first  = trim(str_replace("`", "", $int));
	        $second = str_replace(",", "", $first);
	        
	        $return = $second;    
	    }
	    else if($type=="ind")
	    {
	        $first  = trim(str_replace("`", "", $int));
	        $second = str_replace(".", "", $first);
	        $third  = str_replace(",", ".", $second);
	        
	        $return = $third;
	    }

	    return $return;
	}
	
	function create_txt_report($paths,$filed,$str)
    {
        $strs=chr(27).chr(64).chr(27).chr(67).chr(33).$str;
         $txt=$paths."/".$filed;
        if(file_exists($txt)){
            unlink($txt);
        }
        $open_it=fopen($txt,"a+");
        fwrite($open_it,$strs);
        fclose($open_it);    
    } 
    
    function sintak_epson()
    {
        $arr_data["escNewLine"]      = chr(10);  // New line (LF line feed)
        $arr_data["escUnerlineOn"]   = chr(27).chr(45).chr(1);  // Unerline On
        $arr_data["escUnerlineOnx2"] = chr(27).chr(45).chr(2);  // Unerline On x 2
        $arr_data["escUnerlineOff"]  = chr(27).chr(45).chr(0);  // Unerline Off
        $arr_data["escBoldOn"]       = chr(27).chr(69).chr(1);  // Bold On
        $arr_data["escBoldOff"]      = chr(27).chr(69).chr(0);  // Bold Off
        $arr_data["escNegativeOn"]   = chr(29).chr(66).chr(1);  // White On Black On'
        $arr_data["escNegativeOff"]  = chr(29).chr(66).chr(0);  // White On Black Off
        $arr_data["esc8CpiOn"]       = chr(29).chr(33).chr(16); // Font Size x2 On
        $arr_data["esc8CpiOff"]      = chr(29).chr(33).chr(0);  // Font Size x2 Off
        $arr_data["esc16Cpi"]        = chr(27).chr(77).chr(48); // Font A  -  Normal Font
        $arr_data["esc20Cpi"]        = chr(27).chr(77).chr(49); // Font B - Small Font
        $arr_data["escReset"]        = chr(27).chr(64); //chr(27) + chr(77) + chr(48); // Reset Printer
        $arr_data["escFeedAndCut"]   = chr(29).chr(86).chr(65); // Partial Cut and feed

        $arr_data["escAlignLeft"]    = chr(27).chr(97).chr(48); // Align Text to the Left
        $arr_data["escAlignCenter"]  = chr(27).chr(97).chr(49); // Align Text to the Center
        $arr_data["escAlignRight"]   = chr(27).chr(97).chr(50); // Align Text to the Right
        
        $arr_data["reset"]  =chr(27).'@'; //reset semua pengaturan printer
        $arr_data["plength"]=chr(27).'C'; //tinggi kertas, contoh $plength.chr(33) ==> tinggi 33 baris.
        $arr_data["lmargin"]=chr(27).'l'; //margin kiri, pemakaian sama dengan $plength.
        $arr_data["cond"]   =chr(15);   //condensed
        $arr_data["ncond"]  =chr(18);   //end condensed
        $arr_data["dwidth"] =chr(27).'!'.chr(16);  //tulisan melebar
        $arr_data["ndwidth"]=chr(27).'!'.chr(1);   //end tulisan melebar
        $arr_data["draft"]  =chr(27).'x'.chr(48);  //font draft
        $arr_data["nlq"]    =chr(27).'x'.chr(49);
        $arr_data["bold"]   =chr(27).'E';   //tulisan bold
        $arr_data["nbold"]  =chr(27).'F';   //end tulisan bold
        $arr_data["uline"]  =chr(27).'!'.chr(129); //garis bawah
        $arr_data["nuline"] =chr(27).'!'.chr(1); //end garis bawah
        $arr_data["dstrik"] =chr(27).'G';    //double strike (tulisan lebih tebal, 2 kali strike)
        $arr_data["ndstrik"]=chr(27).'H';    //end double strike (tulisan lebih tebal, 2 kali strike)
        $arr_data["elite"]  =chr(27).'M';    //tulisan elite
        $arr_data["pica"]   =chr(27).'P';    //tulisan pica
        $arr_data["height"] =chr(27).'!'.chr(16); //tulisan tinggi
        $arr_data["nheight"]=chr(27).'!'.chr(1);  //end tulisan tinggi
        $arr_data["spasi05"]=chr(27)."3".chr(16); //spasi 5 char
        $arr_data["spasi1"] =chr(27)."3".chr(24); //spasi 1 char
        $arr_data["fcut"]   =chr(10).chr(10).chr(10).chr(10).chr(10).chr(13).chr(27).'i';    // potong kertas full
        $arr_data["pcut"]   =chr(10).chr(10).chr(10).chr(10).chr(10).chr(13).chr(27).'m';    // potong kertas sebagian
        $arr_data["op_cash"]=chr(27).'p'.chr(0).chr(50).chr(20).chr(20);   //buka cash register
                    
        return $arr_data;                           
    } 
    
    function send_email_multiple($subject, $body, $to, $to_name, $author)
	{
		
	 	$this->CI->load->library('email');
   		$user = $this->CI->session->userdata('username');
   		
   		$rowMail = $this->CI->Globalmodel->getEmail();
   		
   		$arr_to      = explode(";", $to);
	    $arr_to_name = explode(";", $to_name);
	    
	    $this->CI->email->subject($subject);
	    $this->CI->email->from($rowMail->email_address, $rowMail->subject); 
	    
	    //for($i=0;$i<(count($arr_to)-1);$i++)
	    //{
	    //	$this->CI->email->to($arr_to[$i]);
	    //}
        $this->CI->email->to($arr_to);
        $this->CI->email->message($body); 
   
        //Send mail 
        if($this->CI->email->send()) 
        {
        	$msg = $this->CI->session->set_flashdata('msg', array('message' => 'Email sent successfully.', 'class' => 'success'));
        	$results = "Successfull";
        	
		}
        else
        {
        	$msg = $this->CI->session->set_flashdata('msg', array('message' => 'Error in sending Email.', 'class' => 'danger'));
        	$results = "Error message";
         	
         	//print_r($this->CI->email->_debug_msg);	
		} 
		
		$data = array(
            'host' => $rowMail->host,
            'email_from' => $rowMail->email_address,
            'email_to' => $to,
            'subject' => $subject,
            'message' => $body,
            'status' => $results,
            'author' => $user." - ".date('d/m/Y H:i:s'),
            'email_date' => date('Y-m-d H:i:s')
        );

        $this->CI->Globalmodel->queryInsert('email_log', $data);
        
       	return $msg;
	}
	
	
	function send_email_multiple_with_cc($subject, $body, $to, $to_name, $cc, $cc_name, $author)
	{
		
	 	$this->CI->load->library('email');
   		$user = $this->CI->session->userdata('username');
   		
   		$rowMail = $this->CI->Globalmodel->getEmail();
   		
   		$arr_to      = explode(";", $to);
	    $arr_to_name = explode(";", $to_name);
	    
	    $arr_cc     = explode(";", $cc);
	    $arr_cc_name = explode(";", $cc_name);
	    
	    $this->CI->email->subject($subject);
	    $this->CI->email->from($rowMail->email_address, $rowMail->subject); 
	    
        $this->CI->email->to($arr_to);
        $this->CI->email->cc($arr_cc);
        $this->CI->email->message($body); 
   
        //Send mail 
        if($this->CI->email->send()) 
        {
        	$msg = $this->CI->session->set_flashdata('msg', array('message' => 'Email sent successfully.', 'class' => 'success'));
        	$results = "Successfull";
        	
		}
        else
        {
        	$msg = $this->CI->session->set_flashdata('msg', array('message' => 'Error in sending Email.', 'class' => 'danger'));
        	$results = "Error message";
         	
         	//print_r($this->CI->email->_debug_msg);	
		} 
		
		$data = array(
            'host' => $rowMail->host,
            'email_from' => $rowMail->email_address,
            'email_to' => $to,
            'subject' => $subject,
            'message' => $body,
            'status' => $results,
            'author' => $user." - ".date('d/m/Y H:i:s'),
            'email_date' => date('Y-m-d H:i:s')
        );

        $this->CI->Globalmodel->queryInsert('email_log', $data);
        
       	return $msg;
	}
	
	
	function cek_keseluruhan_stock($pcode,$gudang,$tgl)
	{
	    global $db;
	    
	     list($tahun, $bulan, $tanggal) = explode('-',$tgl);
	
		 /*if($bulan=="01"){
		 $bln="12";	
		 }else if($bulan=="12"){
		 $bln="11";	
		 }else if($bulan=="11"){
		 $bln="10";	
		 }else if($bulan=="10"){
		 $bln=$bulan-1;	
		 }else{
		 $bln=$bulan-1;	
		 }
		 $month = $bulan*1;
		 if($month>=10){
		 	$fieldakhir = "GAwal" . $bulan;
		 }else{
		 	$fieldakhir = "GAkhir0" . $bln;
		 }*/
		 
		 $fieldakhir = "GAwal" . $bulan;
		 
		 $tgl_awal = $tahun."-".$bulan."-01";
		 $tgl_trans=$tgl;
	    
	    
	    $sql = "
    			SELECT SUM(cek.Qty)-1 AS Qty_plus FROM ( SELECT 
				  SUM(Qty) AS Qty 
				FROM
				  db_natura.mutasi 
				WHERE Tanggal BETWEEN '".$tgl_awal."' 
				  AND '".$tgl_trans."'
				  AND ( Gudang = '".$gudang."' OR GudangTujuan = '".$gudang."' )
				  AND Jenis = 'I' 
				  AND KodeBarang = '".$pcode."'
				   
				UNION
				 
				SELECT 
				  (".$fieldakhir."+1) AS Qty 
				FROM
				  db_natura.stock 
				WHERE Tahun = '".$tahun."' 
				  AND KdGudang = '".$gudang."' 
				  AND PCode = '".$pcode."' ) AS cek ;
    		   ";
	    //echo $sql."<hr>";
	    $qry = mysql_query($sql);
	    $row = mysql_fetch_array($qry);
	    list($Qty_plus) = $row;
	    
	    $sql2 = "
    			SELECT 
				  SUM(Qty) AS Qty_min 
				FROM
				  mutasi 
				WHERE Tanggal BETWEEN '".$tgl_awal."' 
				  AND '".$tgl_trans."'
				  AND Gudang = '".$gudang."' 
				  AND Jenis = 'O' 
				  AND KodeBarang = '".$pcode."'
    		   ";
	    //echo $sql2."<hr>";die;
	    $qry2 = mysql_query($sql2);
	    $row2 = mysql_fetch_array($qry2);
	    list($Qty_min) = $row2;
	    
	    
	    $counter = $Qty_plus-$Qty_min;
	    //echo $counter." - ". $Qty_plus." - ".$Qty_min;
	    return $counter;
	}

	function parsedate($str) 
	{
	    $return = "";
	    
	    if($str!="")
	    {
	        $exp_str = explode("-",$str);
	    
	        $return = mktime(0,0,0,$exp_str[1],$exp_str[0],$exp_str[2]);
	        return $return;
	    }
	    
	    return $return;
	}   
}
?>
