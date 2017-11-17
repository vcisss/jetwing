<?php 
$this->load->view('header');
$mylib = new globallib();
 ?>
<head>
</head>
<!--<script language="javascript" src="<?= base_url(); ?>public/js/uang_muka_beo33.js"></script>-->


<form method="POST"  name="search" action='<?php echo base_url(); ?>index.php/transaksi/voucher_beo/search'>
    <input type="hidden" name="btn_search" id="btn_search" value="y"/>
    <input type='hidden' value='<?= base_url() ?>' id="baseurl" name="baseurl">
    <input type='hidden' value='<?= $offset ?>' id="offset" name="offset">
    <div class="row">
        <div class="col-md-8">
            <b>Search</b>&nbsp;
            <input type="text" size="20" maxlength="30" name="search_keyword" id="search_keyword" class="form-control-new" value="<?php
            if ($search_keyword) {
                echo $search_keyword;
            }
            ?>" /> 
            &nbsp;
            <b>Status</b>&nbsp;
            <select class="form-control-new" name="search_status" id="search_status">
                <option value="">All</option>
				<option <?php if($search_status=="0"){ echo 'selected="selected"'; } ?> value="0">Pending</option>
                <option <?php if($search_status=="1"){ echo 'selected="selected"'; } ?> value="1">Close</option>
                <option <?php if($search_status=="2"){ echo 'selected="selected"'; } ?> value="2">Void</option>
            </select>  
            &nbsp;
        </div>

        <div class="col-md-4" align="right">
            <button type="button" class="btn btn-success btn-sm icon-left" onClick="refresh()">Refresh</button>
            <button type="button" class="btn btn-info btn-icon btn-sm icon-left" onClick="cari_data()">Search<i class="entypo-search"></i></button>
            <!--<a href="<?php echo base_url() . "index.php/transaksi/uang_muka_beo/add_new/"; ?>" class="btn btn-info btn-icon btn-sm icon-left" title="" >Tambah<i class="entypo-plus"></i></a>-->
            <button type="button" class="btn btn-info btn-icon btn-sm icon-left" onClick="add_new()">Add<i class="entypo-plus"></i></button>
        </div>
    </div>
</form>

<hr/>

<?php
if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
    ?><div class="alert alert-<?php echo $msg['class']; ?>"><?php echo $msg['message']; ?></div><?php
}
?>

<div id="table-2_wrapper" class="dataTables_wrapper form-inline" role="grid">
   <div id="getList"></div>
</div>


			<div id="pleaseWaitDialog" class="modal" data-keyboard="false" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.2);">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Loading...</h3>
                        </div>
                        <div class="modal-body">
                            <div class="progress progress-striped active">
                                <div class="progress-bar" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


<div id="modal_payment_method" class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Voucher</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" name="v_date_pendaftaran" id="v_date_pendaftaran" value="<?=date('d-m-Y');?>">
                            </div>
                        </div>
                                                
                        <div class="form-body">
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">No. Pendaftaran</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="" name="v_no_pendaftaran" id="v_no_pendaftaran" readonly>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label class="control-label col-md-3">Tour Leader</label>
                            <div class="col-md-6">
                  			<select class="form-control-new" name="v_tourleader" id="v_tourleader" style="width: 100%;">
			            		<option value="">- Pilih Tour Leader -</option>
			            		<?php
			            		foreach($leader as $val)
			            		{
									?><option value="<?php echo $val["Leader_id"]; ?>"><?php echo $val["Nama"]; ?></option><?php
								}
			            		?>
			            	</select>
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Tour Guide</label>
                            <div class="col-md-6">
                  			<select class="form-control-new" name="v_tourguide" id="v_tourguide" style="width: 100%;">
			            		<option value="">- Pilih Tour Guide -</option>
			            		<?php
			            		foreach($guide as $val)
			            		{
									?><option value="<?php echo $val["Guide_id"]; ?>"><?php echo $val["Nama"]; ?></option><?php
								}
			            		?>
			            	</select>
                            </div>
                            
                        </div>
                            
                        <div class="form-group">
                            <label class="control-label col-md-3">Tour Travel</label>
                            <div class="col-md-6">
                  			<select class="form-control-new" name="v_tourtravel" id="v_tourtravel" style="width: 100%;">
			            		<option value="">- Pilih Tour Travel -</option>
			            		<?php
			            		foreach($tour as $val)
			            		{
									?><option value="<?php echo $val["Tour_id"]; ?>"><?php echo $val["Nama"]; ?></option><?php
								}
			            		?>
			            	</select>
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Propinsi</label>
                            <div class="col-md-6">
                  			<select class="form-control-new" name="v_propinsi" id="v_propinsi" style="width: 100%;">
			            		<option value="">- Pilih Tour Propinsi -</option>
			            		<?php
			            		foreach($propinsi as $val)
			            		{
									?><option value="<?php echo $val["id_propinsi"]; ?>"><?php echo $val["Nama"]; ?></option><?php
								}
			            		?>
			            	</select>
                            </div>
                            
                        </div>                         
                                                 
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">PAX Adult</label>
                            <div class="col-md-6">
                                <input style="text-align: right;" size="10" name="pax_adult" id="pax_adult" class="form-control" type="text" value="0" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">PAX Child</label>
                            <div class="col-md-6">
                                <input style="text-align: right;" size="10" name="pax_child" id="pax_child" class="form-control" type="text" value="0" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="" name="v_ket" id="v_ket" >
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-info btn-icon btn-sm icon-left">Save<i class="entypo-check"></i></button>
                <button type="button" class="btn btn-danger btn-icon btn-sm icon-left" data-dismiss="modal">Cancel<i class="entypo-cancel"></i></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<?php $this->load->view('footer'); ?>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>

<script>

	$(document).ready(function()
		{
			getData();				
		});
		
	
	function getData(){
		base_url = $("#baseurl").val();
		offset = $("#offset").val();
			
			$('#pleaseWaitDialog').modal('show');
			
	    	$.ajax({
				type: "POST",
				url: base_url + "index.php/transaksi/pendaftaran_tamu/getList/"+offset,
				success: function(data) {
					$('#getList').html(data);
					
						$('#pleaseWaitDialog').modal('hide');
					
			
				}
			});
	}

	function add_new()
    {
     save_method = 'add';
     
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        
         $.ajax({
            url: "<?php echo site_url('transaksi/pendaftaran_tamu/generate_number_voucher') ?>/",
            type: "GET",
            dataType: "JSON",
            success: function (data)
                       //alert(data);
            {
                $('[name="v_no_pendaftaran"]').val(data.v_no_pendaftaran);
                
                $('#modal_payment_method').modal('show');
                $('#btnSave').attr('disabled',false);
                $('.modal-title').text('Pendaftaran Tamu');
                //document.getElementById('v_no_bukti').focus();
        		
            }
            ,
            error: function (textStatus, errorThrown)
            {
                alert('Error get data');
            }
        }
        );
                
    }
    
    function edit_pendaftaran(id)
    {
     
     	save_method = 'edit';
     	
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        nodok = id.replace(/\//g, "-");
        $.ajax({
            url: "<?php echo site_url('transaksi/pendaftaran_tamu/ajax_edit_pendaftaran') ?>/" + nodok,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                //alert(res);
                $('[name="v_no_pendaftaran"]').val(data.id_pendaftaran);
                $('[name="v_date_pendaftaran"]').val(data.Tanggal);
                $('[name="v_tourleader"]').val(data.Leader_id);
                $('[name="v_tourtravel"]').val(data.Tour_id);
                $('[name="v_tourguide"]').val(data.Guide_id);
                $('[name="v_propinsi"]').val(data.id_propinsi);
                $('[name="pax_adult"]').val(data.PAX_adult);
                $('[name="pax_child"]').val(data.PAX_child);
                $('[name="v_ket"]').val(data.Keterangan);
                
                $('#modal_payment_method').modal('show');
                $('#btnSave').attr('disabled',false);
                $('.modal-title').text('Pendaftaran');
            }
            ,
            error: function (textStatus, errorThrown)
            {
                alert('Error get data');
            }
        }
        );
              
    }
    
    function view_bayar(id)
    {
     
     	save_method = 'view';
     	
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        nodok = id.replace(/\//g, "-");
        $.ajax({
            url: "<?php echo site_url('transaksi/pendaftaran_tamu/ajax_edit_pendaftaran') ?>/" + nodok,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                //alert(res);
                $('[name="v_no_pendaftaran"]').val(data.id_pendaftaran);
                $('[name="v_date_pendaftaran"]').val(data.Tanggal);
                $('[name="v_tourleader"]').val(data.Leader_id);
                $('[name="v_tourtravel"]').val(data.Tour_id);
                $('[name="v_tourguide"]').val(data.Guide_id);
                $('[name="v_propinsi"]').val(data.id_propinsi);
                $('[name="pax_adult"]').val(data.PAX_adult);
                $('[name="pax_child"]').val(data.PAX_child);
                $('[name="v_ket"]').val(data.Keterangan);
                
                $('#modal_payment_method').modal('show');
                $('#btnSave').attr('disabled',true);
                $('.modal-title').text('Pendaftaran');
        		
            }
            ,
            error: function (textStatus, errorThrown)
            {
                alert('Error get data');
            }
        }
        );
              
    }
    
    function save()
    {
        $('#btnSave').text('saving...');
        $('#btnSave').attr('disabled', true);
        var url;

        if (save_method == 'add') {
            url = "<?php echo site_url('transaksi/pendaftaran_tamu/ajax_add') ?>";
        } else {
            url = "<?php echo site_url('transaksi/pendaftaran_tamu/ajax_update') ?>";
        }

        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                if (data.status)
                {
                    id= data.NoDokumen;
                    $('#modal_payment_method').modal('hide');
                    getData();
                    //window.location.reload(true);
                   
                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                    }
                }
                $('#btnSave').text('save');
               // $('#btnSave').attr('disabled', false);

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                //alert('Error adding / update data');
                $('#modal_payment_method').modal('hide');
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);

            }
        });
    }
    	
function lock(nodok,url)
{
	var r=confirm("Apakah Pendaftaran ini akan di Lock?")
	if (r==true)
	{		
		$.ajax({
            url: "<?php echo site_url('transaksi/pendaftaran_tamu/lock') ?>/" + nodok,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                  if(data){
				  	getData();
				  }      		
            }
            ,
            error: function (textStatus, errorThrown)
            {
                alert('Error get data');
            }
        }
        );	
	}
	else
	{
  		return false;
	}
}

function cari_data()
{
	    keyword = $('#search_keyword').val();
	    status = $('#search_status').val();
	    offset = "0";
	    if(keyword==""){
			key=0;
		}else{
			key = keyword;
		}
		
		$('#pleaseWaitDialog').modal('show');
		
		$.ajax({
            url: "<?php echo site_url('transaksi/pendaftaran_tamu/getList') ?>/" +offset+"/"+ key+"/"+status,
            type: "GET",
            dataType: "html",
            success: function (data)
            {
               $('#getList').html(data);
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

function refresh()
{
	    
		
		$('#pleaseWaitDialog').modal('show');
		
		$.ajax({
            url: "<?php echo site_url('transaksi/pendaftaran_tamu/getList') ?>/0/",
            type: "GET",
            dataType: "html",
            success: function (data)
            {
               $('#getList').html(data);
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

function cek_type(){
	 type = $('#v_type_beo').val();
	 if(type=="1"){
	 	document.getElementById("tampil_beo").style.display = "";
	 }else{
	 	document.getElementById("tampil_beo").style.display = "none";
	 }
	
}

	
</script>
