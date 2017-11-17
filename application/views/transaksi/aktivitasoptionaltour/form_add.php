<?php 

$this->load->view('header'); 

$modul = "Optional Tour";

?>
<script>
$(document).ready(function() {
	$('.date-picker').datepicker();
    
    $('.datepicker').on('changeDate', function(e) {
		$('#theform').bootstrapValidator('revalidateField', 'v_tglmulai');
   		$('#theform').bootstrapValidator('revalidateField', 'v_tglselesai');
 	});
});

function getGroupTour(obj)
{
		base_url = $("#baseurl").val();
		
		objek = obj.id;
		id = parseFloat(objek.substr(14,objek.length-14));
		url = base_url+"index.php/pop/pop_up_grouptour/index/"+id+"/";
		windowOpener(500, 400, 'Cari Group Tour', url, 'Cari Group Tour')
}

function tampil_history()
{
		cari="";
		base_url = $("#baseurl").val();
		KdGroup = $("#KdGroup").val();
		
		document.getElementById("pesan_loading").innerHTML = "Proses Ambil Data ...";
		$('#pleaseWaitDialog').modal('show');
		
		
		$.ajax({
				type: "POST",
				url: base_url + "index.php/transaksi/aktivitasoptionaltour/getList/",
				data: {group:KdGroup,cr:cari},
				success: function(data) {
					document.getElementById("list_history").style.display = "";
					$('#list_history').html(data);
					$('#pleaseWaitDialog').modal('hide');			
				}
			});
}

function getSellNet()
{
		cari="";
		base_url = $("#baseurl").val();
		KdGroup = $("#KdGroup").val();	
		KdTour = $("#v_optionaltour").val();		
		
		$.ajax({
            url: "<?php echo site_url('transaksi/aktivitasoptionaltour/ambil_sell_net') ?>/" + KdGroup+"/"+KdTour,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                $('[name="v_hargajualusd"]').val(data.HargaJualUSD);
                $('[name="v_net"]').val(data.HPP);
				
				sell = parseFloat(data.HargaJualUSD);
				TL = parseFloat(data.HargaJualUSD) * 10/100;
				Net_master = parseFloat(data.HPP);
				persenGuide = $("#v_persentaseGuide").val()/100;
				
				//masuk rumus
				TipeGroup = $("#TipeGroup").val();

				if(TipeGroup=="1"){
					net_rumus = (sell-TL-Net_master)*persenGuide;
				    rumus = net_rumus+Net_master;
				}else if(TipeGroup=="2"){
					net_rumus = (sell-Net_master)*persenGuide;
				    rumus = net_rumus+Net_master; 
				}else if(TipeGroup=="3"){
					net_rumus = (sell-TL-Net_master)*persenGuide;
				    rumus = net_rumus+TL+Net_master; 
				}
				
				$('[name="v_net_rumus"]').val(Math.round(rumus));
            }
            ,
            error: function (textStatus, errorThrown)
            {
                alert('Error get data');
            }
        }
        );
}

function getPax(){
	
			kdgroup = $("#KdGroup").val();
            var	url = $("#baseurl").val();
			
			if(kdgroup!=""){
				$.ajax({
						url : url+"index.php/transaksi/aktivitasgroup/getPax/"+kdgroup+"/",
						type: "GET",
						dataType: "json",
						success: function(data)
						{
							$('[name="v_pax"]').val(data.Pax);

						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							alert('Error get data from ajax');
						}
					});
			}

}

function save(){
	
	if($("#NamaGroup").val()==""){
		alert("Group Tour Belum Di Isi.");
		return false
	}else if($("#v_tgl").val()==""){
		alert("Tanggal Belum Di Isi.");
		$("#v_tgl").focus();
		return false
	}else if($("#v_optionaltour").val()==""){
		alert("Aktivitas Belum Di Pilih.");
		return false
	}else if($("#v_pax").val()==""){
		alert("Pax Belum Di Isi.");
		return false
	}else if($("#v_hargajualusd").val()==""){
		alert("Harga Jual USD Belum Di Isi.");
		return false
	}else if($("#v_net").val()==""){
		alert("NET Belum Di Isi.");
		return false
	}
	
	document.getElementById("pesan_loading").innerHTML = "Proses Simpan Data ...";
	$('#pleaseWaitDialog').modal('show');
    
       url = "<?php echo site_url('transaksi/aktivitasoptionaltour/ajax_save_data') ?>";
        

        $.ajax({
            url: url,
            type: "POST",
            data: $('#theform').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                if (data.status)
                {
                   $('#pleaseWaitDialog').modal('hide');
                   alert("Simpan Data Berhasil");
                   reset_data();                  
                   tampil_history();
                   
                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');

            }
        });
	
}

function edit(kdgroup,optionaltour){
		
		document.getElementById("pesan_loading").innerHTML = "Proses Edit Data ...";
	    $('#pleaseWaitDialog').modal('show');
        $.ajax({
            url: "<?php echo site_url('transaksi/aktivitasoptionaltour/ajax_edit') ?>/" + kdgroup+"/"+optionaltour,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
            	$('[name="v_flag"]').val("Edit");
                $('[name="v_tgl"]').val(data.Tanggal);
                $('[name="v_optionaltour"]').val(data.KdTour);
                $('[name="v_pax"]').val(data.Pax);
                $('[name="v_hargajualusd"]').val(data.HargaJualUSD);
                $('[name="v_net"]').val(data.HPP);
				$('[name="v_net_rumus"]').val(data.Net);
                
                //$('#btnSave').attr('hidden',false);
                document.getElementById("save_add").style.display = "none";
                document.getElementById("save_edit").style.display = "";
        		$('#pleaseWaitDialog').modal('hide');
            }
            ,
            error: function (textStatus, errorThrown)
            {
                alert('Error get data');
            }
        }
        );
}

function reset_data(){
	               $("#v_tgl").val("");
                   $("#v_optionaltour").val("");
                   $("#v_pax").val("");
                   $("#v_hargajualusd").val("0");
                   $("#v_net").val("0");
				   $("#v_net_rumus").val("0");
                   $("#v_flag").val("Add");
                     
                document.getElementById("save_add").style.display = "";
                document.getElementById("save_edit").style.display = "none";
}

function refresh_data(){
				reset_data();
                tampil_history();   
}

function cek_optionaltour(){
	
			kdgroup = $("#KdGroup").val();
			optionaltour = $("#v_optionaltour").val();
            var	url = $("#baseurl").val();
            
        		$.ajax({
					url: url+"index.php/transaksi/aktivitasoptionaltour/cek_duplicate_optionaltour/",
					data: {group:kdgroup,opt:optionaltour},
					type: "POST",
					dataType: "json",
			        success: function(data)
					{
						if(data.status)
						{
							alert("Aktivitas ini sudah ada");
							
							document.getElementById("pesan_loading").innerHTML = "Proses Cari Data Yang Sama ...";
							$('#pleaseWaitDialog').modal('show');
							$.ajax({
								type: "POST",
								url: base_url + "index.php/transaksi/aktivitasoptionaltour/getListCari/",
								data: {group:KdGroup,opt:optionaltour},
								success: function(data) {
									document.getElementById("list_history").style.display = "";
									$('#list_history').html(data);
$('#v_hargajualusd').val(0);
$('#v_net_rumus').val(0);
									$('#pleaseWaitDialog').modal('hide');			
								}
							});
							
							return false;
						}						
					} 
				});	
				
}

function hapus(){
	
			kdgroup = $("#KdGroup").val();
			optionaltour = $("#v_optionaltour").val();
            var	url = $("#baseurl").val();
            
            document.getElementById("pesan_loading").innerHTML = "Proses Hapus Data ...";
            
            $('#pleaseWaitDialog').modal('show');
        		$.ajax({
					url: url+"index.php/transaksi/aktivitasoptionaltour/delete_data/",
					data: {group:kdgroup,opt:optionaltour},
					type: "POST",
					dataType: "json",
			        success: function(data)
					{
						if(data.status)
						{
							$('#pleaseWaitDialog').modal('hide');
			                   alert("Hapus Data Berhasil");
			                   reset_data();                  
			                   tampil_history();
						}						
					} 
				});	
				
}

function search_data(){
		cari = $("#search_keyword").val();
		base_url = $("#baseurl").val();
		KdGroup = $("#KdGroup").val();
		
		document.getElementById("pesan_loading").innerHTML = "Proses Cari "+cari+" ...";
		
		$('#pleaseWaitDialog').modal('show');
		
		$.ajax({
				type: "POST",
				url: base_url + "index.php/transaksi/aktivitasoptionaltour/getList/",
				data: {group:KdGroup,cr:cari},
				success: function(data) {
					document.getElementById("list_history").style.display = "";
					$('#list_history').html(data);
					$('#pleaseWaitDialog').modal('hide');			
				}
			});
}

function hitung_net(){
	usd = $('#v_hargajualusd').val();
	HPP = $("#v_net").val();
	
	            sell = parseFloat(usd);
				TL = sell * 10/100;
				Net_master = parseFloat(HPP);
				persenGuide = $("#v_persentaseGuide").val()/100;
				//masuk rumus
				net_rumus = (sell-TL-Net_master)*persenGuide;
				rumus = net_rumus+Net_master+TL;
				$('[name="v_net_rumus"]').val(Math.round(rumus));
}
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
			<li>Add <?php echo $modul; ?></strong></li>
		</ol>
		
		<form method='post' class="form-horizontal" name="theform" id="theform" action="<?=base_url();?>index.php/transaksi/aktivitasoptionaltour/save_data">
		<input type='hidden' value='<?= base_url() ?>' id="baseurl" name="baseurl">
		<input type='hidden' value='' id="KdGroup" name="KdGroup" onblur="tampil_history()">
		<input type='hidden' value='' id="v_net_master" name="v_net_master">
		<input type='hidden' value='' id="v_persentaseGuide" name="v_persentaseGuide">
		<input type='hidden' value='Add' id="v_flag" name="v_flag">
		
		<table class="table table-bordered responsive"> 
			
			<tr>
	            <td class="title_table">Tour Group <font color="red"><b>(*)</b></font></td>
	            <td colspan="3"><input type="text" class="form-control-new" value="" name="NamaGroup" id="NamaGroup" maxlength="255" size="100">
	            	<a href="javascript:void(0)" id="get_group_name1" onclick="getGroupTour(this)" class="btn btn-info btn-sm sm-new tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Search" title=""><i class="entypo-search"></i></a>
	            </td>
	        </tr>
	        
	        <tr style="display: none">
	            <td class="title_table">Tipe Tour Group <font color="red"><b>(*)</b></font></td>
	            <td colspan="3">
	                <input readonly="readonly" type="text" class="form-control-new" value="" name="TipeGroup" id="TipeGroup" maxlength="255" style="text-align: right;width:100px;">
	            </td>
	        </tr>
			
			<tr>
	            <td class="title_table" width="150">Tanggal <font color="red"><b>(*)</b></font></td>
	            <td colspan="3"> 
	            	<input type="text" class="form-control-new datepicker col-lg-2"  placeholder="dd-mm-yyyy" value="" name="v_tgl" id="v_tgl" style="text-align: left;width:100px;">
	            </td>
	         </tr>
	        
	        <tr>
	            <td class="title_table">Optional Tour <font color="red"><b>(*)</b></font></td>
	            <td width="400"> 
	            	<select class="form-control-new" name="v_optionaltour" id="v_optionaltour" style="width: 200px;" onchange="cek_optionaltour(),getSellNet(),getPax()">
	            		<option value="">Pilih Optional Tour</option>
	            		<?php
	            		foreach($optionaltour as $val)
	            		{
							?><option value="<?php echo $val["KdTour"]; ?>"><?php echo $val["NamaTour"]; ?></option><?php
						}
	            		?>
	            	</select>   
	            </td>
	            
	            <td class="title_table" width="150">Harga Jual USD <font color="red"><b>(*)</b></font></td>
	            <td><input type="text" class="form-control-new" value="0" name="v_hargajualusd" id="v_hargajualusd" maxlength="255" size="100" style="text-align: right;width:100px;" onkeyup="hitung_net()"></td>
	       
	        </tr>
	        
	        <tr>
	            <td class="title_table">Pax <font color="red"><b>(*)</b></font></td>
	            <td><input type="text" class="form-control-new col-lg-2" value="" name="v_pax" id="v_pax" style="text-align: right;width:100px;"></td>
	        
	            <td class="title_table">NET <font color="red"><b>(*)</b></font></td>
	            <td>
				<!-- Net Hasil Rumus Ditampilkan -->
				<input type="text" class="form-control-new" value="0" name="v_net_rumus" id="v_net_rumus" maxlength="255" size="100" style="text-align: right;width:100px;" readonly>
				<!-- end Net Hasil Rumus Ditampilkan -->
				
				<!-- Net dari tabel_master optionaltour -->
				<input type="hidden" class="form-control-new" value="0" name="v_net" id="v_net" maxlength="255" size="100" style="text-align: right;width:100px;">
				<!-- Net dari tabel_master optionaltour -->
				
				</td>
	        
	        </tr>
	        
		</table>
		
		    <div id="save_add" class="form-group">
		        <div class="col-md-12" align="left">
		            <button  type="button" class="btn btn-green btn-icon btn-sm icon-left"  name="btnSave" id="btnSave" onclick="save()" value="Simpan">Simpan<i class="entypo-check"></i></button>
		            <button  type="button" class="btn btn-warning btn-icon btn-sm icon-left"  name="btnReset" id="btnReset" onclick="reset_data()" value="Simpan">Reset<i class="entypo-check"></i></button>
		            <!--<button type="button" class="btn btn-blue btn-icon btn-sm icon-left"  name="btnCancel" id="btnCancel" value="Kembali" onclick="window.location='<?=base_url();?>index.php/transaksi/aktivitasgroup/'">Kembali<i class="entypo-check"></i></button>-->
		        </div>
		    </div> 
		    
		    <div id="save_edit" class="form-group" style="display:none;">
		        <div class="col-md-12" align="left">
		            <button  type="button" class="btn btn-success btn-icon btn-sm icon-left"  name="btnSave" id="btnSave" onclick="save()" value="Simpan">Simpan<i class="entypo-check"></i></button>
		            <button  type="button" class="btn btn-danger btn-icon btn-sm icon-left"  name="btnEdit" id="btnEdit" onclick="hapus()" value="Hapus">Hapus<i class="entypo-trash"></i></button>
		            <button  type="button" class="btn btn-warning btn-icon btn-sm icon-left"  name="btnReset" id="btnReset" onclick="reset_data()" value="Simpan">Reset<i class="entypo-check"></i></button>
		            <!--<button type="button" class="btn btn-blue btn-icon btn-sm icon-left"  name="btnCancel" id="btnCancel" value="Kembali" onclick="window.location='<?=base_url();?>index.php/transaksi/aktivitasgroup/'">Kembali<i class="entypo-check"></i></button>-->
		        </div>
		    </div> 
		    
		    
		   
	    <div id="list_history" style="display:none;">
	    
	    </div>
	    
	    </form> 
        
        
	</div>
</div>


          <div id="pleaseWaitDialog" class="modal" data-keyboard="false" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3><div id="pesan_loading">Loading...</div></h3>
                        </div>
                        <div class="modal-body">
                            <div class="progress progress-striped active">
                                <div class="progress-bar" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	
<?php $this->load->view('footer'); ?>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>

