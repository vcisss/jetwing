<?php 

$this->load->view('header'); 

$modul = "Group Optional Tour";

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
            v_keterangan: {
                validators: {
                    notEmpty: {
                        message: 'Nama aktivitas harus diisi.'
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
		
		<form method='post' class="form-horizontal" name="theform" id="theform" action='<?=base_url();?>index.php/master/groupoptionaltour/save_data'>
		
	    	<div class="form-group"> 
	    		<label class="col-md-1">ID</label>
    			<div class="col-md-6">
        			<input type="text" class="form-control-new col-lg-2" name="v_kdgroupoptional" value="<?=$header[0]['KdGroupOptional'];?>" readonly/>
        			<input type="hidden" class="form-control-new col-lg-2" name="v_flag" value="<?=$flag;?>"/>
    			</div>
    		</div>
	        
	        <div class="form-group"> 
	        	<label class="col-md-1">Keterangan<font color="red"><b>(*)</b></font></label>
	        	<div class="col-md-6">
	        		<input type="text" class="form-control-new col-lg-12" value="<?=$header[0]['Keterangan'];?>" name="v_keterangan" id="v_keterangan">
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
		            <button type="button" class="btn btn-blue btn-icon btn-sm icon-left"  name="btn_cancel" id="btn_cancel" value="Kembali" onclick="window.location='<?=base_url();?>index.php/master/groupoptionaltour/'">Kembali<i class="entypo-check"></i></button>
		        </div>
		    </div> 
		    
		    <?php
        if($header[0]['KdGroupOptional']!='Auto Generate')
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