<?php
$this->load->view('header');
$gantikursor = "onkeydown=\"changeCursor(event,'user',this)\"";

$modul = "Ganti Password";

?>

<script>
	function cekTheform()
	{
		document.getElementById("theform").submit();				
	}
</script>

<script language="javascript" src="<?= base_url(); ?>public/js/global.js"></script>
<script language="javascript" src="<?= base_url(); ?>public/js/cek.js"></script>
 
 
 <div class="row">
    <div class="col-md-12" align="left">
    
    	<ol class="breadcrumb">
			<li><strong><i class="entypo-pencil"></i><?php echo $modul; ?></strong></li>
		</ol>
		
		<?php
		if($this->session->flashdata('msg'))
		{
		  $msg = $this->session->flashdata('msg');
		  
		  ?><div class="alert alert-<?php echo $msg['class'];?>"><?php echo $msg['message']; ?></div><?php
		}
		?>
		
		<form method='post' name="theform" id="theform" action='<?=base_url();?>index.php/master/gantipassword/save_data'>
		<input type="hidden" name="v_username" id="v_username" value="<?php echo $username; ?>" />
	    <table class="table table-bordered responsive">   
	        
	        <tr>
	            <td class="title_table" style="width: 200px;">Username</td>
	            <td class="title_table"><?php echo $username ; ?></td>
	        </tr>
	        
	        <tr>
	            <td class="title_table">Password Lama <font color="red"><b>(*)</b></font></td>
	            <td><input type="password" class="form-control-new" value="" name="v_password_lama" id="v_password_lama" maxlength="255" size="50"></td>
	        </tr>
	        
	        <tr>
	            <td class="title_table">Password Baru <font color="red"><b>(*)</b></font></td>
	            <td><input type="password" class="form-control-new" value="" name="v_password_baru" id="v_password_baru" maxlength="255" size="50"></td>
	        </tr>
	        
	        <tr>
	            <td class="title_table">Ulangi Password Baru <font color="red"><b>(*)</b></font></td>
	            <td><input type="password" class="form-control-new" value="" name="v_ulang_password_baru" id="v_ulang_password_baru" maxlength="255" size="50"></td>
	        </tr>
	        
	        <tr>
	        	<td>&nbsp;</td>
	            <td>
					<input type='hidden' name="flag" id="flag" value="add">
					<input type='hidden' name="base_url" id="base_url" value="<?php echo base_url(); ?>">
	            	<button type="button" class="btn btn-info btn-icon btn-sm icon-left" onclick="cekTheform();" name="btn_save" id="btn_save"  value="Simpan">Simpan<i class="entypo-check"></i></button>
		        </td>
	        </tr>
	        
	    </table>
	    
	    </form> 
        
        <font style="color: red; font-style: italic; font-weight: bold;">(*) Harus diisi.</font>
        
	</div>
</div>

<?php $this->load->view('footer'); ?>