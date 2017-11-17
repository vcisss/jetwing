<?php 

$this->load->view('header'); 

$modul = "Aktivitas";

?>
<script>
$(document).ready(function() {
    $('#theform').bootstrapValidator({
        container: '#messages',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            v_namaaktivitas: {
                validators: {
                    notEmpty: {
                        message: 'Nama aktivitas harus diisi.'
                    }
                }
            },
            v_idr: {
                validators: {
                    notEmpty: {
                        message: 'IDR harus diiisi.'
                    }
                }
            },
            v_usd: {
                validators: {
                    notEmpty: {
                        message: 'USD harus diisi.'
                    }
                }
            },
            v_rmb: {
                validators: {
                    notEmpty: {
                        message: 'RMB harus diisi'
                    }
                }
            }
        }
    });
});
</script>

<div class="row">
    <div class="col-md-12" align="left">
    	<?php
    	if($this->session->flashdata('msg'))
		{
		  $msg = $this->session->flashdata('msg');
		  ?><div class="alert alert-<?php echo $msg['class'];?>"><?php echo $msg['message']; ?></div><?php
		}
		?>
    	<ol class="breadcrumb title_table">
			<li><strong><i class="entypo-pencil"></i>Add <?php echo $modul; ?></strong></li>
		</ol>
		
		<form method='post' class="form-horizontal" name="theform" id="theform" action='<?=base_url();?>index.php/master/aktivitas/save_data'>
		
	    	<div class="form-group"> 
	    		<label class="col-md-1">ID</label>
    			<div class="col-md-6">
        			<input type="text" class="form-control-new col-lg-2" name="v_kdaktivitas" value="<?=$header[0]['KdAktivitas'];?>" readonly/>
        			<input type="hidden" class="form-control-new col-lg-2" name="v_flag" value="<?=$flag;?>"/>
    			</div>
    		</div>
	        
	        <div class="form-group"> 
	        	<label class="col-md-1">Aktivitas<font color="red"><b>(*)</b></font></label>
	        	<div class="col-md-6">
	        		<input type="text" class="form-control-new col-lg-12" value="<?=$header[0]['NamaAktivitas'];?>" name="v_namaaktivitas" id="v_namaaktivitas">
	        	</div>
	        </div>
	        
	        <div class="form-group"> 
	        	<label class="col-md-1">Jenis<font color="red"><b>(*)</b></font></label>
	        	<div class="col-md-6">
	            	<select class="form-control-new col-lg-3" name="v_jenis" id="v_jenis">
	            		<option value="1" <?php if($header[0]['Jenis']=='1'){ echo "selected='selected'"; } ?>>Company To Guide</option>
	            		<option value="2" <?php if($header[0]['Jenis']=='2'){ echo "selected='selected'"; } ?>>Guide To Company</option>
	            	</select>
	            </div>
	        </div>  
	        
	        <div class="form-group"> 
	            <label class="col-md-1">IDR<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6">
	            	<input type="text" class="form-control-new col-lg-2" value="<?=$header[0]['IDR'];?>" name="v_idr" id="v_idr" style="text-align: right;">
	            </div>
	        </div>
	        <div class="form-group"> 
	            <label class="col-md-1">USD<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6"> 
	            	<input type="text" class="form-control-new col-lg-2" value="<?=$header[0]['USD'];?>" name="v_usd" id="v_usd" style="text-align: right;">
	            </div>
	        </div>
	        <div class="form-group"> 
	            <label class="col-md-1">RMB<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6"> 
	            	<input type="text" class="form-control-new col-lg-2" value="<?=$header[0]['RMB'];?>" name="v_rmb" id="v_rmb" style="text-align: right;">
	            </div>
	        </div>
	        
	        <div class="form-group"> 
	            <label class="col-md-1">Is Edit<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6"> 
	            	<select class="form-control-new col-lg-2" name="v_isedit" id="v_isedit">
	            		<option value="Y" <?php if($header[0]['isEdit']=='Y'){ echo "selected='selected'"; } ?>>Yes</option>
	            		<option value="T" <?php if($header[0]['isEdit']=='T'){ echo "selected='selected'"; } ?>>No</option>
	            	</select>
	            </div>
	        </div>
	        
	        <div class="form-group"> 
	            <label class="col-md-1">Status<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6"> 
	            	<select class="form-control-new col-lg-2" name="v_status" id="v_status">
	            		<option value="Y" <?php if($header[0]['Aktif']=='Y'){ echo "selected='selected'"; } ?>>Aktif</option>
	            		<option value="T" <?php if($header[0]['Aktif']=='T'){ echo "selected='selected'"; } ?>>Tidak</option>
	            	</select>
	            </div>
	        </div> 
	        <!-- #messages is where the messages are placed inside -->
		    <div class="form-group">
		        <div class="col-md-9 col-md-offset-3">
		            <div id="messages"></div>
		        </div>
		    </div>
		    <div class="form-group">
		        <div class="col-md-9 col-md-offset-3">
		            <button  type="submit" class="btn btn-green btn-icon btn-sm icon-left"  name="btn_save" id="btn_save" value="Simpan">Simpan<i class="entypo-check"></i></button>
		            <button type="button" class="btn btn-blue btn-icon btn-sm icon-left"  name="btn_cancel" id="btn_cancel" value="Kembali" onclick="window.location='<?=base_url();?>index.php/master/aktivitas/'">Kembali<i class="entypo-check"></i></button>
		        </div>
		    </div> 
		    <?php
		    if($header[0]['KdAktivitas']!='Auto Generate')
        	{
        	?>
   			<ol class="breadcrumb title_table">
				<li><i class="entypo-vcard"></i>Information data</li>
			</ol>
			
	         <div class="form-group">
	            <label class="col-md-10">Author : <?php echo $header[0]['AddUser']." :: ".$header[0]['AddDate']; ?></label>
	        </div>
	        <div class="form-group">
	            <label class="col-md-10">Edited : <?php echo $header[0]['EditUser']." :: ".$header[0]['EditDate']; ?></label>
	        </div>
        <?php 
      	}
        ?>
	    </form> 
        
        <font style="color: red; font-style: italic; font-weight: bold;">(*) Harus diisi.</font>
        
	</div>
</div>
    	
<?php $this->load->view('footer'); ?>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>