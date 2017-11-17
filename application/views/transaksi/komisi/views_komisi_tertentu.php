<?php 

	$this->load->view('header'); 

	$modul = "Pembayaran Komisi Tertentu";

	

?>

<script>
	
function cekTheform()
{
	if(document.getElementById("v_tgl").value=="")
    {
        alert("Tanggal harus diisi");
        document.getElementById("v_tgl").focus();
        return false;
    }
    
    document.getElementById("theform").submit();	
	
}

</script>

<div class="row">
    <div class="col-md-12" align="left">
    
    	<ol class="breadcrumb title_table">
			<li><strong><i class="entypo-pencil"></i><?php echo $modul; ?></strong></li>
		</ol>
		
		<form method='post' name="theform" id="theform" action="<?php echo base_url();?>index.php/transaksi/komisi/search_komisi_tertentu">
		
	    <table class="table table-bordered responsive"> 
	    
	    	<tr>
	            <td class="title_table" width="150">Tanggal</td>
	            <td> 
				<input type="text" class="form-control-new datepicker col-lg-2"  placeholder="dd-mm-yyyy" value="<?=date('d-m-Y');?>" name="v_tgl" id="v_tgl" style="text-align: left;width:100px;">
				</td>
	        </tr>
	        
	        <tr>
	            <td class="title_table" width="150">Tipe User</td>
	            <td> 
					<select class="form-control-new" name="v_tipe_user" id="v_tipe_user" style="width: 200px;" onchange="ganti()">
					<option value=""> -- Pilih -- </option>
					<option value="1"> Tour Leader </option>
					<option value="2"> Tour Guide </option>
					<option value="3"> Driver </option>
					</select>
				</td>
	        </tr>
	    	
	    	<tr id="tl" style="display: none" >
	            <td class="title_table" width="150">Nama Tour Leader</td>
	            <td> 
				<input type="text" class="form-control-new" size="20" maxlength="10" name="v_keyword_leader" id="v_keyword_leader" placeholder="Cari Tour Leader" onkeyup="cari_leader('<?php echo base_url(); ?>')">
					<select class="form-control-new" name="v_leader" id="v_leader" style="width: 200px;" onchange="on_travel_leader('<?php echo base_url(); ?>')">
	            		<option value="">Pilih Leader</option>
	            		<?php
	            		 
	            		foreach($tourleader as $val)
	            		{
	            			$selected="";
							if($v_leader==$val["Leader_id"])
							{
								$selected='selected="selected"';
							}
							?><option <?php echo $selected; ?> value="<?php echo $val["Leader_id"]; ?>"><?php echo $val["Nama"]; ?></option><?php
						}
	            		?>
	            	</select>

	            	<span id="span_loading_leader" style=" display: none;"><img src="../../../../public/images/ajax-image.gif"/></span>
	                
	            </td>
	        </tr> 
	        
	        <tr id="tg" style="display: none">
	            <td class="title_table" width="150">Nama Tour Guide</td>
	            <td> 
				<input type="text" class="form-control-new" size="20" maxlength="10" name="v_keyword_guide" id="v_keyword_guide" placeholder="Cari Tour Guide" onkeyup="cari_guide('<?php echo base_url(); ?>')">
					<select class="form-control-new" name="v_guide" id="v_guide" style="width: 200px;" onchange="on_travel_guide('<?php echo base_url(); ?>')">
	            		<option value="">Pilih Guide</option>
	            		<?php
	            		 
	            		foreach($tourguide as $val)
	            		{
	            			$selected="";
							if($v_guide==$val["Guide_id"])
							{
								$selected='selected="selected"';
							}
							?><option <?php echo $selected; ?> value="<?php echo $val["Guide_id"]."#".$val["NamaGuide"]; ?>"><?php echo $val["NamaGuide"]; ?></option><?php
						}
	            		?>
	            	</select>

	            	<span id="span_loading_guide" style=" display: none;"><img src="../../../../public/images/ajax-image.gif"/></span>
	                
	            </td>
	        </tr> 
	        
	        <tr id="dv" style="display: none">
	            <td class="title_table" width="150">Nama Driver</td>
	            <td> 
				<input type="text" class="form-control-new" size="20" maxlength="10" name="v_keyword_driver" id="v_keyword_driver" placeholder="Cari Driver" onkeyup="cari_driver('<?php echo base_url(); ?>')">
					<select class="form-control-new" name="v_driver" id="v_driver" style="width: 200px;" onchange="on_travel_driver('<?php echo base_url(); ?>')">
	            		<option value="">Pilih Driver</option>
	            		<?php
	            		 
	            		foreach($tourdriver as $val)
	            		{
	            			$selected="";
							if($v_driver==$val["Driver_id"])
							{
								$selected='selected="selected"';
							}
							?><option <?php echo $selected; ?> value="<?php echo $val["Driver_id"]; ?>"><?php echo $val["Nama"]; ?></option><?php
						}
	            		?>
	            	</select>

	            	<span id="span_loading_driver" style=" display: none;"><img src="../../../../public/images/ajax-image.gif"/></span>
	                
	            </td>
	        </tr>  
	        
	        <tr id="travel" style="display: none">
	            <td class="title_table" width="150">Travel Agent</td>
	            <td>
	            <input readonly type='hidden' class="form-control-new" size="20" name="tour_travel" id="tour_travel" value="<?php echo $tour_travel; ?>"> 
	            <input readonly type='text' class="form-control-new" size="20" name="nama_tour_travel" id="nama_tour_travel" value="<?php echo $nama_tour_travel; ?>"> 
	            </td>
	        </tr>
	        
	                <input type='hidden' name="flag" id="flag" value="analisa">
					<input type='hidden' name="base_url" id="base_url" value="<?php echo base_url(); ?>">
					
					
	        <tr>
	        	 <td class="title_table">&nbsp;</td>
	            <td colspan="100%">
					
	                <button type="button" class="btn btn-info btn-icon btn-sm icon-left" onclick="cekTheform(),show_loading_bar(100)" name="btn_analisa" id="btn_analisa"  value="Analisa">Analisa<i class="entypo-check"></i></button>
		        </td>
	        </tr> 
	    </table>
            	
    	
    	<?php
    	if($flag=="1"){
			$table = '<table class="table table-bordered responsive">';		
			echo $table;
			
    	?>
	    		<thead class="title_table">
	    			<tr>
	    				<th width="20"><center>No.</center></th>
	    				<th><center>Nama</center></th>
	    				<th width="100"><center>Qty</center></th>
	    				<th width="100"><center>Harga</center></th>
	    				<th width="100"><center>Komisi %</center></th>
	    				<th width="100"><center>Komisi (Rp)</center></th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<?php
	    			if(count($detail_data)==0)
	    			{
						echo "<tr><td colspan='6' align='center'>Tidak Ada Data</td></tr>";
					}
					
					
					$no = 1;
					$totkomisi=0;
					foreach($detail_data as  $val)
					{		
					?>
						<tr>
							<td align="center"><?php echo $no ; ?> <input type="hidden" name="v_penjualanid[]" id="v_penjualanid<?=$no;?>" value="<?=$val['PenjualanID'];?>"></td>
							<td align="left"><?php echo $val['NamaBarang']; ?> <input type="hidden" name="v_nama[]" id="v_nama<?=$no;?>" value="<?=$val['NamaBarang'];?>"></td>
							<td align="right"><?php echo $val['Qty']; ?> <input type="hidden" name="v_qty[]" id="v_qty<?=$no;?>" value="<?=$val['Qty'];?>"></td>
							<td align="right"><?php echo number_format($val['Harga']); ?> <input type="hidden" name="v_harga[]" id="v_harga<?=$no;?>" value="<?=$val['Harga'];?>"></td>
							<td align="right"><?php echo $val['komisi_pers']; ?> <input type="hidden" name="v_komisi_guide[]" id="v_komisi_guide<?=$no;?>" value="<?=$val['komisi_pers'];?>"></td>
							<td align="right"><?php echo number_format($val['tot_komisi']); ?> <input type="hidden" name="v_komisi[]" id="v_komisi<?=$no;?>" value="<?=$val['tot_komisi'];?>"></td>
						</tr>
					<?php
					$totkomisi+=$val['Komisi'];
					$no++;					
					}
	    			?>
					
					
	    				<tr class="title_table">
							<td align="left" colspan="5">Total Komisi</td>
							<td align="right"><?php echo number_format($totkomisi); ?> <input type="hidden" name="v_totkomisi" id="v_totkomisi" value="<?=$totkomisi;?>"></td>
						</tr>
						
				</tbody>
    			</table>
    			
    			<button type="submit" class="btn btn-info btn-icon btn-sm icon-left" name="btn_save" id="btn_save" value="Save">Save<i class="entypo-download"></i></button>
		        <button type="button" class="btn btn-danger btn-icon btn-sm icon-left" name="btn_excel" id="btn_excel" value="Excel">Cancel<i class="entypo-download"></i></button>
		
    	
	    </form> 
	    <?php } ?>
	</div>
</div>
    	
<?php $this->load->view('footer'); ?>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>

<script>
function get_choose(nodokumen,type)
{
		base_url = $("#base_url").val();
		if(type=="Non PB"){
		url = base_url+"index.php/transaksi/purchase_request/pop_edit_form/"+nodokumen+"/0";
		}else{
		url = base_url+"index.php/transaksi/purchase_request/pop_edit_form/"+nodokumen+"/1";
		}
		windowOpener(1000, 1200, 'Detail Purchase Request', url, 'Detail Purchase Request')
	
}

        function cari_guide(url)
		{
			var act=$("#v_keyword_guide").val();
			$.ajax({
					url: url+"index.php/transaksi/komisi/ajax_guide/",
					data: {id:act},
					type: "POST",
					dataType: 'html',					
					success: function(res)
					{
						
						$('#v_guide').html(res);
					},
					error: function(e) 
					{
						alert(e);
					} 
				}); 
			
			   	
   		}		
		
		function on_travel_leader(url){
			leader =  $('#v_leader').val();
			$("#span_loading_leader").css("display","");
			$.ajax({
					url: url+"index.php/transaksi/komisi/ajax_travel/1",
					data: {jns:leader},
					type: "POST",
					dataType: 'html',					
					success: function(res)
					{
						$("#span_loading_leader").css("display","none");
						$('#travel').html(res);
					},
					error: function(e) 
					{
						alert(e);
					} 
				});
		}
		
		function on_travel_guide(url){
			guide =  $('#v_guide').val();
			$("#span_loading_guide").css("display","");
			$.ajax({
					url: url+"index.php/transaksi/komisi/ajax_travel/2",
					data: {jns:guide},
					type: "POST",
					dataType: 'html',					
					success: function(res)
					{
						$("#span_loading_guide").css("display","none");
						$('#travel').html(res);
					},
					error: function(e) 
					{
						alert(e);
					} 
				});
		}
		
		function on_travel_driver(url){
			driver =  $('#v_driver').val();
			$("#span_loading_driver").css("display","");
			$.ajax({
					url: url+"index.php/transaksi/komisi/ajax_travel/3",
					data: {jns:driver},
					type: "POST",
					dataType: 'html',					
					success: function(res)
					{
						$("#span_loading_driver").css("display","none");
						$('#travel').html(res);
					},
					error: function(e) 
					{
						alert(e);
					} 
				});
		}
		
		function ganti(){
			tipe =  $('#v_tipe_user').val();
			
			if(tipe==""){
				alert(" Silahkan Pilih menu terblebih dahulu");
				return false;
			}else if(tipe=="1"){
				$("#travel").css("display","");
				$("#tl").css("display","");
				$("#tg").css("display","none");
				$("#dv").css("display","none");
			}else if(tipe=="2"){
				$("#travel").css("display","");
				$("#tl").css("display","none");
				$("#tg").css("display","");
				$("#dv").css("display","none");
			}else if(tipe=="3"){
				$("#travel").css("display","");
				$("#tl").css("display","none");
				$("#tg").css("display","none");
				$("#dv").css("display","");
			}
			
			
			$.ajax({
					url: url+"index.php/transaksi/komisi/ajax_travel/3",
					data: {jns:driver},
					type: "POST",
					dataType: 'html',					
					success: function(res)
					{
						$("#span_loading_driver").css("display","none");
						$('#travel').html(res);
					},
					error: function(e) 
					{
						alert(e);
					} 
				});
		}
		
		
   		
</script>

