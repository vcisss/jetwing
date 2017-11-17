<?php

$this->load->view('header');
$gantikursor = "onkeydown=\"changeCursor(event,'user',this)\"";
if($edit){ $fieldset = "Edit"; }
else{ $fieldset = "View";}

$modul = "Master User";


?>

<script language="javascript" src="<?=base_url();?>public/js/global.js"></script>

<div class="row">
    <div class="col-md-12" align="left">
    
    	<ol class="breadcrumb">
			<li><strong><i class="entypo-pencil"></i>Edit <?php echo $modul; ?></strong></li>
			<span style="float: right; display: none;" id="show_image_ajax_form"><img src="images/ajax-image.gif" /></span>
		</ol>
		
		<form method='post' name="user" id="user" action="<?=base_url();?>index.php/master/user/save_user">
			<input type="hidden" name="v_userlevel" id="v_userlevel" value="<?=$viewuser->UserLevel;?>"/>
		    <table class="table table-bordered responsive">
		        <tr>
		            <td class="title_table" width="150">Kode</td>
		            <td> 
		            	<input type="text" class="form-control-new" value="<?=$viewuser->Id;?>" name="kode" id="kode" size="10" maxlength="10" readonly>
		            </td>
		        </tr>
		        
		        <!--<tr>
		            <td class="title_table" width="150">NIK</td>
		            <td> 
		            	<select class="form-control-new" name="v_employee_nik" id="v_employee_nik" <?=$gantikursor;?>>
		            		<option value="">Pilih NIK</option>
		            		<?php
		            		foreach($mnik as $val)
		            		{
								$selected="";
								if($val["employee_nik"]==$viewuser->employee_nik)
								{
									$selected='selected="selected"';	
								}	
								
								?>
								<option <?php echo $selected; ?> value= "<?php echo $val["employee_nik"]; ?>"><?php echo $val["employee_nik"]." :: ".$val["employee_name"]; ?></option>
								<?php
							}
		            		?>
		            	</select>
		            </td>
		        </tr>-->
		        
		        <tr>
		            <td class="title_table" width="150">Nama</td>
		            <td>
		            	<input type="text" class="form-control-new" value="<?=$viewuser->UserName;?>" name="nama" id="nama" size="30" maxlength="20" readonly>
		            </td>
		        </tr>
		        
		        <!--<tr>
		            <td class="title_table" width="150">Main Page</td>
		            <td> 
		            	<select class="form-control-new" name="mainpage" id="mainpage" <?=$gantikursor;?>>
		            		<?php
		            		foreach($page as $val)
		            		{
		            			$selected="";
								if($viewuser->MainPage==$val['nama'])
								{
									$selected = "selected";
								}
								
								?>
								<option <?php echo $selected; ?> value= "<?php echo $val["nama"] ;?>"><?php echo $val["nama"] ;?></option>
								<?php	
							}
		            		?>
		            	</select>
		            </td>
		        </tr>-->
		        
		        <tr>
		            <td class="title_table" width="150">Aktif User</td>
		            <td> 
						<select class="form-control-new" id="statactive" name="statactive" <?=$gantikursor;?>>
							<option <?php if($viewuser->active=="Y") echo "selected";?> value="Y">Ya</option>
							<option <?php if($viewuser->active=="N") echo "selected";?> value="N">Tidak</option>
						</select>
		            </td>
		        </tr>
	        
		        <tr>
		            <td>&nbsp;</td>
		            <td>
		            	<?php 
		            	if($edit)
		            	{ 
		            		?>
		            		<button type="submit" class="btn btn-info btn-icon btn-sm icon-left" name="btn_save" id="btn_save"  value="Save">Save<i class="entypo-check"></i></button>
							<?php 
						} 
						?>
						
						<button type="button" class="btn btn-info btn-icon btn-sm icon-left" onclick=parent.location="<?=base_url();?>index.php/master/user/" name="btn_close" id="btn_close"  value="Back">Back<i class="entypo-cancel"></i></button>
		            </td>
		        </tr>
		        
		    </table>
	    </form>
	</div>
</div>

<?php $this->load->view('footer'); ?>
