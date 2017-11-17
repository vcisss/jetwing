<?php 

$this->load->view('header'); 

$modul = "Tour";

?>
<script>
/*$(document).ready(function() {
    $('#theform').bootstrapValidator({
        container: '#messages',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            v_namagroup: {
                validators: {
                    notEmpty: {
                        message: 'Nama group harus diisi.'
                    }
                }
            },
            v_tglmulai: {
                validators: {
                	notEmpty: {
                        message: 'Tanggal Mulai harus diiisi.'
                    }
                }
			},
            v_tglselesai: {
                validators: {
                	notEmpty: {
                        message: 'Tanggal Selesai harus diisi.'
                    }
                }
			},
            v_pax: {
                validators: {
                    notEmpty: {
                        message: 'Pax harus diisi.'
                    },
                    integer: {
                        message: 'Pax Harus angka.'
                    }
                }
            },
            v_persentaseguide: {
                validators: {
                    notEmpty: {
                        message: 'Persentase Guide harus diisi.'
                    },
                    numeric: {
                        message: 'Guide Harus angka.'
                    }
                }
            },
            v_tipeoptiontour: {
                validators: {
                    notEmpty: {
                        message: 'Pilih Tipe Option Tour.'
                    }
                }
            }
        }
    });
});*/

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
		
		<form method='post' class="form-horizontal" name="theform" id="theform" action='<?=base_url();?>index.php/transaksi/group/save_data'>
		
	    	<div class="form-group"> 
	    		<label class="col-md-2">ID</label>
    			<div class="col-md-6">
        			<input type="text" class="form-control-new col-lg-2" name="v_kdgroup" value="<?=$header[0]['KdGroup'];?>" readonly/>
        			<input type="hidden" class="form-control-new col-lg-2" name="v_flag" value="<?=$flag;?>"/>
    			</div>
    		</div>
	        
	        <div class="form-group"> 
	        	<label class="col-md-2">Kode Group<font color="red"><b>(*)</b></font></label>
	        	<div class="col-md-6">
	        		<input type="text" class="form-control-new col-lg-12" value="<?=$header[0]['NamaGroup'];?>" name="v_namagroup" id="v_namagroup">
	        	</div>
	        </div>
	        
	        <div class="form-group"> 
	            <label class="col-md-2">Tanggal Mulai<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6">
	            	<input type="text" class="form-control-new datepicker col-lg-2"  placeholder="dd-mm-yyyy" value="<?=$header[0]['TanggalMulai'];?>" name="v_tglmulai" id="v_tglmulai" style="text-align: left;">
	            </div>
	        </div>
	        <div class="form-group"> 
	            <label class="col-md-2">Tanggal Selesai<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6"> 
	            	<input type="text" class="form-control-new datepicker col-lg-2"  placeholder="dd-mm-yyyy" value="<?=$header[0]['TanggalSelesai'];?>" name="v_tglselesai" id="v_tglselesai" style="text-align: left;">
	            </div>
	        </div>
	        <div class="form-group"> 
	            <label class="col-md-2">Pax Adult<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6"> 
	            	<input type="text" class="form-control-new col-lg-2" value="<?=$header[0]['Pax_adult'];?>" name="v_pax_adl" id="v_pax_adl" style="text-align: right;">
	            </div>
	        </div>	        
	        <div class="form-group"> 
	            <label class="col-md-2">Pax Child<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6"> 
	            	<input type="text" class="form-control-new col-lg-2" value="<?=$header[0]['Pax_child'];?>" name="v_pax_chl" id="v_pax_chl" style="text-align: right;">
	            </div>
	        </div>
	        
	        <div class="form-group"> 
	            <label class="col-md-2">Tour Guide<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6"> 
	            	<select class="form-control-new col-lg-5" name="v_kdtourguide" id="v_kdtourguide">
	            		<?php
	            		foreach($tourguide as $rec){
	            		?>
							<option value="<?=$rec['KdTourGuide'];?>" <?php if($header[0]['KdTourGuide']==$rec['KdTourGuide']){ echo "selected='selected'"; } ?>><?=$rec['NamaTourGuide'];?></option>	
						<?
						}
						?>
	            	</select>
	            </div>
	        </div>
	        <div class="form-group"> 
	            <label class="col-md-2">Guide %<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6"> 
	            	<input type="text" class="form-control-new col-lg-2" value="<?=$header[0]['PersentaseGuide'];?>" name="v_persentaseguide" id="v_persentaseguide" style="text-align: right;">
	            </div>
	        </div> 
	        
	        <div class="form-group"> 
	            <label class="col-md-2">Tipe Option Tour<font color="red"><b>(*)</b></font></label>
	            <div class="col-md-6"> 
	            	<select class="form-control-new col-lg-2" name="v_tipeoptiontour" id="v_tipeoptiontour">
	            	    <option value=""> -- Pilih -- </option>
	            		<option value="1" <?php if($header[0]['TipeOptionTour']=='1'){ echo "selected='selected'"; } ?>>WITH TL</option>
	            		<option value="2" <?php if($header[0]['TipeOptionTour']=='2'){ echo "selected='selected'"; } ?>>FIT TL</option>
	            		<option value="3" <?php if($header[0]['TipeOptionTour']=='3'){ echo "selected='selected'"; } ?>>NO TL</option>
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
		            <button type="button" class="btn btn-blue btn-icon btn-sm icon-left"  name="btn_cancel" id="btn_cancel" value="Kembali" onclick="window.location='<?=base_url();?>index.php/transaksi/group/'">Kembali<i class="entypo-check"></i></button>
		        </div>
		    </div> 
		    <?php
		    if($header[0]['KdGroup']!='Auto Generate')
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
