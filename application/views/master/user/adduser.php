<?php
$this->load->view('header'); 
$gantikursor = "onkeydown=\"changeCursor(event,'user',this)\"";

$modul = "Master User";

?>


<script language="javascript" src="<?=base_url();?>public/js/global.js"></script>
<script language="javascript" src="<?=base_url();?>public/js/cek.js"></script>

<div class="row">
    <div class="col-md-12" align="left">
    
    	<ol class="breadcrumb">
			<li><strong><i class="entypo-pencil"></i>Add <?php echo $modul; ?></strong></li>
		</ol>
		
		<?php if($msg){ echo $msg;} ?>
		
		<form method='post' name="user" id="user" action='<?=base_url();?>index.php/master/user/save_new_user'>
		    <table class="table table-bordered responsive">
		        <tr style="display : none">
		            <td class="title_table" width="150">Kode</td>
		            <td> 
		            	<input type="text" class="form-control-new" value="" name="kode" id="kode" size="10" maxlength="10" <?=$gantikursor;?> onKeyUp="javascript:dodacheck(document.getElementById('kode'));">
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
								
								?>
								<option value= "<?php $val["employee_nik"]; ?>"><?php echo $val["employee_nik"]." :: ".$val["employee_name"]; ?></option>
								<?php
							}
		            		?>
		            	</select>
		            </td>
		        </tr>-->
		        
		        <tr>
		            <td class="title_table" width="150">Full Name</td>
		            <td> 
		            	<input type="text" class="form-control-new" value="" name="guidename" id="guidename" size="30" maxlength="20" <?=$gantikursor;?>>
		            </td>
		        </tr>
		        
		        <tr>
		            <td class="title_table" width="150">UserName</td>
		            <td> 
		            	<input type="text" class="form-control-new" value="" name="nama" id="nama" size="30" maxlength="20" <?=$gantikursor;?>>
		            </td>
		        </tr>
		        
		        <tr>
		            <td class="title_table" width="150">Password</td>
		            <td> 
		            	<!--<input type="password" class="form-control-new" value="" name="password" id="password" size="30" maxlength="10" <?=$gantikursor;?>>-->
						Password Standart 123456
		            </td>
		        </tr>
		        
		        <!--<tr>
		            <td class="title_table" width="150">Main Page</td>
		            <td> 
		            	<select class="form-control-new" name="mainpage" id="mainpage" <?=$gantikursor;?>>
		            		<?php
		            		for($a = 0;$a<count($master);$a++)
		            		{
								$select = "";
								if($page1=="")
								{
									 $page1="Home";
								}
								if($viewuser->MainPage==$page[$a]['nama'])
								{
									$select = "selected";
								}
								
								?>
								<option <?=$select;?> value= "<?=$page[$a]['nama']?>"><?=$page[$a]['nama']?></option>
								<?php
							}
		            		?>
		            	</select>
		            </td>
		        </tr>-->

			<tr>
		            <td class="title_table" width="150">Pilih Level user</td>
		            <td> 
						<select class="form-control-new" name="leveluser" id="leveluser" <?=$gantikursor;?>>
		            		<?php
		            		for($a = 0;$a<count($master);$a++)
		            		{								
								?>
								<option value= "<?=$master[$a]['UserLevelID']?>"><?=$master[$a]['UserLevelName']?></option>
								<?php
							}
		            		?>
		            	</select>
		            </td>
		        </tr>
		        
		        <tr>
		            <td class="title_table" width="150">Aktif User</td>
		            <td> 
						<select class="form-control-new" id="statactive" name="statactive" <?=$gantikursor;?>>
							<option value="Y">Ya</option>
							<option value="N">Tidak</option>
						</select>
		            </td>
		        </tr>
	        
		        <tr>
		            <td>&nbsp;</td>
		            <td>
		            	<!--<button type="submit" onclick="cekuser();" class="btn btn-info btn-icon btn-sm icon-left" name="btn_save" id="btn_save"  value="Save">Save<i class="entypo-check"></i></button>-->
		            	<button type="submit" class="btn btn-info btn-icon btn-sm icon-left" name="btn_save" id="btn_save"  value="Save">Save<i class="entypo-check"></i></button>
						<button type="button" class="btn btn-info btn-icon btn-sm icon-left" onclick=parent.location="<?=base_url();?>index.php/master/user/" name="btn_close" id="btn_close"  value="Back">Back<i class="entypo-cancel"></i></button>
		            </td>
		        </tr>
		        
		    </table>
	    </form>
	</div>
</div>


<?php $this->load->view('footer'); ?>
