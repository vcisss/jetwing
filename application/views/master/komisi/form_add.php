<?php 

$this->load->view('header'); 

$modul = "Master Komisi";

?>
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
		
		<form method='post' class="form-horizontal" name="theform" id="theform" action='<?=base_url();?>index.php/master/komisi/save_data'>
		
	    	<div class="form-group"> 
	    		<label class="col-md-2">Group ID <font color="red"><b>(*)</b></font></label>
    			<div class="col-md-6">
        			<input type="hidden" class="form-control-new col-lg-2" id="v_groupid" name="v_groupid" value="<?=$header[0]['GroupID'];?>" readonly/>
        			<input type="text" class="form-control-new col-lg-2" id="v_nama_stockid" name="v_nama_stockid" value="<?=$header[0]['Nama'];?>" readonly/>
        			&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" id="get_stockid1" onclick="getstockid(this,'<?=base_url();?>')" class="btn btn-info btn-sm sm-new tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Search" title=""><i class="entypo-search"></i></a>
        			<input type="hidden" class="form-control-new col-lg-2" name="v_flag" value="<?=$flag;?>"/>
    			</div>
    		</div>
	        
	        <div class="form-group"> 
	        	<label class="col-md-2">Komisi Office<font color="red"><b>(*)</b></font></label>
	        	<div class="col-md-3">
	        		<input type="text" class="form-control-new col-md-3" size="10" value="<?=$header[0]['Komisi_Office'];?>" name="v_komisi_office" id="v_komisi_office">
	        	</div>
	        </div>
	        
	        <div class="form-group"> 
	        	<label class="col-md-2">Komisi Driver<font color="red"><b>(*)</b></font></label>
	        	<div class="col-md-3">
	        		<input type="text" class="form-control-new col-md-3" size="10" value="<?=$header[0]['Komisi_Drv'];?>" name="v_komisi_drv" id="v_komisi_drv">
	        	</div>
	        </div>
	        
	        <div class="form-group"> 
	        	<label class="col-md-2">Komisi Tour Leader<font color="red"><b>(*)</b></font></label>
	        	<div class="col-md-3">
	        		<input type="text" class="form-control-new col-md-3" size="10" value="<?=$header[0]['Komisi_TL'];?>" name="v_komisi_tl" id="v_komisi_tl">
	        	</div>
	        </div>
	        
	        <div class="form-group"> 
	        	<label class="col-md-2">Komisi Tour Guide<font color="red"><b>(*)</b></font></label>
	        	<div class="col-md-3">
	        		<input type="text" class="form-control-new col-md-3" size="10" value="<?=$header[0]['Komisi_TG'];?>" name="v_komisi_tg" id="v_komisi_tg">
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
		            <button type="button" class="btn btn-blue btn-icon btn-sm icon-left"  name="btn_cancel" id="btn_cancel" value="Kembali" onclick="window.location='<?=base_url();?>index.php/master/komisi/'">Kembali<i class="entypo-check"></i></button>
		        </div>
		    </div> 
		    
		    <?php
	        if($header[0]['GroupID']!='')
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

<script>
	function getstockid(obj,base_url)
	{
			objek = obj.id;
			id = parseFloat(objek.substr(11,objek.length-11));
			url = base_url+"index.php/pop/pop_up_stock/index/"+id+"/";
			windowOpener(600, 800, 'Cari Stock ID', url, 'Cari Stock ID')
	}
</script>