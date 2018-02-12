<?php 

$this->load->view('header'); 

$modul = " Visitor Information";

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

CKEDITOR.replace('isi');
CKEDITOR.disableAutoInLine = true;
CKEDITOR.inline('isi');
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
		
        <form method="post" class="form-horizontal" name="theform" id="theform" action="<?=base_url();?>index.php/master/visitor_information/save_data">
        	
        		Tipe Dokumen &nbsp;&nbsp;&nbsp;
        		        <select class="form-control-new" name="v_status" id="v_status" style="width: 200px;">
		            		<option value="VI">Visitor Information</option>
		            		<option value="FDS">Free Day Statement</option>
		            		<option value="OAS">Optional Agreement Statement</option>
		            		<option value="SCI">Statement Cancel Itenanry</option>
		            		<option value="QST">Questioner</option>
		            	</select>
        	     		<br><br>
    
        	Title<br>
        	<input  style="width: 50%;" class="form-control" type="text" id="title" name="title" value=""/>
        	<br><br>Header<br>
        	<textarea id="header" name="header" style="height: 100px;width: 100%;"></textarea>
        	<br><br>Content<br>
        	<textarea id="isi" name="isi" style="height: 400px;width: 100%;"></textarea>
        	<br><br>
          <div class="form-group">
		        <div class="col-md-12">
		            <button  type="submit" class="btn btn-green btn-icon btn-sm icon-left"  name="btn_save" id="btn_save" value="Simpan">Simpan<i class="entypo-check"></i></button>
		            <button type="button" class="btn btn-blue btn-icon btn-sm icon-left"  name="btn_cancel" id="btn_cancel" value="Kembali" onclick="window.location='<?=base_url();?>index.php/master/aktivitas/'">Kembali<i class="entypo-check"></i></button>
		        </div>
		    </div>	
        </form>
    	
        
	</div>
</div>
    	
<?php $this->load->view('footer'); ?>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>