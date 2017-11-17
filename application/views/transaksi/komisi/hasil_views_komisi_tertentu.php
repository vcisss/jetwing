<?php 

if(!$btn_excel)
{
	$this->load->view('header'); 

	$modul = "Pembayaran Komisi";
	//echo $v_guide;
	//echo "<pre>";print_r($tourguide);echo "</pre>";die;
	//echo $v_tipe_user;die;
}

if($btn_excel)
{
	$file_name = "Report_claim_group_tour.xls";
	        
	header("Content-Disposition".": "."attachment;filename=$file_name");
	header("Content-type: application/vnd.ms-excel");
}

if(!$btn_excel)
{
	

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
		<input readonly type='hidden' class="form-control-new" size="20" name="v_tipe_user" id="v_tipe_user" value="<?php echo $v_tipe_user; ?>">
	    <table class="table table-bordered responsive"> 
	    
	    	<tr>
	            <td class="title_table" width="150">Tanggal</td>
	            <td> 
				<?=$v_tgl;?>
				<input readonly type='hidden' class="form-control-new" size="20" name="v_tgl" id="v_tgl" value="<?php echo $v_tgl; ?>">
				</td>
	        </tr>
	    	<?php if($v_tipe_user=="1"){?>
	    			   <tr id="tl" style="display: ">
				            <td class="title_table" width="150">Nama Tour Leader</td>
				            <td> 
				               <input readonly type='hidden' class="form-control-new" size="20" name="v_id_user" id="v_id_user" value="<?php echo $tourleaders->Leader_id; ?>">
							   <?=$tourleaders->Nama;?>
				            </td>
				        </tr>
	    	<?php }else if($v_tipe_user=="2"){?>
	    	           <tr id="tl" style="display: ">
				            <td class="title_table" width="150">Nama Tour Guide</td>
				            <td> 
				               <input readonly type='hidden' class="form-control-new" size="20" name="v_id_user" id="v_id_user" value="<?php echo $tourguides->Guide_id; ?>">
							   <?=$tourguides->Nama;?>
				            </td>
				        </tr>
	    	<?php }else if($v_tipe_user=="3"){?>
	    				<tr id="tl" style="display: ">
				            <td class="title_table" width="150">Nama Driver</td>
				            <td> 
				               <input readonly type='hidden' class="form-control-new" size="20" name="v_id_user" id="v_id_user" value="<?php echo $drivers->Driver_id; ?>">
							   <?=$drivers->Nama;?>
				            </td>
				        </tr>
	    	<?php }?>
	           
	         
	        
	        <tr id="travel">
	            <td class="title_table" width="150">Travel Agent</td>
	            <td>
	            <input readonly type='hidden' class="form-control-new" size="20" name="tour_travel" id="tour_travel" value="<?php echo $tour_travel; ?>"> 
	            <?php echo $nama_tour_travel; ?>
	            </td>
	        </tr>
	        
	                <input type='hidden' name="flag" id="flag" value="analisa">
					<input type='hidden' name="base_url" id="base_url" value="<?php echo base_url(); ?>">
					
					
	        <tr style="display: none">
	        	 <td class="title_table">&nbsp;</td>
	            <td colspan="100%">
					
	                <button type="button" class="btn btn-info btn-icon btn-sm icon-left" onclick="cekTheform(),show_loading_bar(100)" name="btn_analisa" id="btn_analisa"  value="Analisa">Analisa<i class="entypo-check"></i></button>
		        </td>
	        </tr> 
	    </table>
        
    	<?php
    	
}
    	if($flag || $btn_excel)
    	{
    		$mylib = new globallib();
    	
    	?>
    	
    	
    	<?php
    	if(!$btn_excel)
    	{
		?>
		<!--<button type="submit" class="btn btn-green btn-icon btn-sm icon-left" name="btn_excel" id="btn_excel" value="Excel">Export To Excel<i class="entypo-download"></i></button>
		-->
    	<br><br>
		<?php	
		}
    	?>
    	
    	          <?php if($btn_excel)
                    {
                        ?>
                        <table style="font-weight: bold;">
                            <tr>
                                <td colspan="13">PT. SUMBER HERBAL BALI</td>   
                            </tr>
                            <tr>
                                <td colspan="13">Pembayaran</td>   
                            </tr>
                            
                            <tr>
                                <td colspan="13">&nbsp;</td>   
                            </tr>
                        </table>
                        <?php
                    } ?>
    	
    	<?php
    	if($btn_excel)
    	{
			$table = '<table border="1" cellpadding="0" cellspacing="0" width="100%">';
		}
		else
		{
			$table = '<table class="table table-bordered responsive">';	
		}
		
			echo $table;
			
    	?>
	    		<thead class="title_table">
	    			<tr>
                            <th rowspan="2" width="20" style="vertical-align: middle; text-align: center;">No</th>
                            <th rowspan="2" style="vertical-align: middle; text-align: center;">Nama</th>
							<th rowspan="2" width="20" style="vertical-align: middle; text-align: center;">Qty</th>
							<th rowspan="2" width="80" style="vertical-align: middle; text-align: center;">Harga</th>
							<th rowspan="2" width="80" style="vertical-align: middle; text-align: center;">Total</th>
							<th colspan="2" align="center" style="vertical-align: middle; text-align: center;">Diskon</th>
							<th colspan="1" align="center" style="vertical-align: middle; text-align: center;">Komisi %</th>
							<th colspan="1" align="center" style="vertical-align: middle; text-align: center;">Komisi (Rp)</th>
                        </tr>
                        
                        <tr>
                            <th width="30" align="center">Rp</th>
                            <th width="30" align="center">%</th>
                            
                            <?php if($v_tipe_user=="2"){?>
                            <th width="80" align="center">Tour Guide</th>
                            <?php }else if($v_tipe_user=="1"){?>
                            <th width="80" align="center">Tour Leader</th>
                            <?php }else if($v_tipe_user=="3"){?>
                            <th width="80" align="center">Driver</th>
                            <?php }?>
                            
                            
                            <?php if($v_tipe_user=="2"){?>
                            <th width="80" style="vertical-align: middle; text-align: center;">T.Guide</th>
                            <?php }else if($v_tipe_user=="1"){?>
                            <th width="80" style="vertical-align: middle; text-align: center;">T.Leader</th>
                            <?php }else if($v_tipe_user=="3"){?>
                            <th width="80" style="vertical-align: middle; text-align: center;">Driver</th>
                            <?php }?>
                             
                        </tr>
	    		</thead>
	    		<tbody>
	    			<?php
	    			if(count($detail_data)==0)
	    			{
						echo "<tr><td colspan='4' align='center'>Tidak Ada Data</td></tr>";
					}
					
					
					$no = 1;
					$totkomisitg=0;
					$totkomisitl=0;
					$totkomisidrv=0;
					foreach($detail_data as  $val)
					{		
					?>
						<tr>
							<td align="center"><?php echo $no ; ?> <input type="hidden" name="v_penjualanid[]" id="v_penjualanid<?=$no;?>" value="<?=$val['PenjualanID'];?>"></td>
							<td align="left"><?php echo $val['NamaBarang']; ?> <input type="hidden" name="v_nama[]" id="v_nama<?=$no;?>" value="<?=$val['NamaBarang'];?>"></td>
							<td align="right"><?php echo $val['Qty']; ?> <input type="hidden" name="v_qty[]" id="v_qty<?=$no;?>" value="<?=$val['Qty'];?>"></td>
							<td align="right"><?php echo number_format($val['Harga']); ?> <input type="hidden" name="v_harga[]" id="v_harga<?=$no;?>" value="<?=$val['Harga'];?>"></td>
							<td align="right"><?php echo number_format($val['Total']); ?></td>
							
							<td align="right"><?php echo number_format($val['Disc_pers']); ?></td>
							<td align="right"><?php echo number_format($val['Disc']); ?></td>
							
							<?php if($v_tipe_user=="2"){?>
                            <td align="right"><?php echo number_format($val['komisitg']); ?></td>
                            <?php }else if($v_tipe_user=="1"){?>
                            <td align="right"><?php echo number_format($val['komisitl']); ?></td>
                            <?php }else if($v_tipe_user=="3"){?>
                            <td align="right"><?php echo number_format($val['komisidrv']); ?></td>
                            <?php }?>
                            
                            
                            <?php if($v_tipe_user=="2"){?>
                            <td align="right"><?php echo number_format($val['tot_komisi_tg']); ?></td>
                            <?php }else if($v_tipe_user=="1"){?>
                            <td align="right"><?php echo number_format($val['tot_komisi_tl']); ?></td>
                            <?php }else if($v_tipe_user=="3"){?>
                            <td align="right"><?php echo number_format($val['tot_komisi_drv']); ?></td>
                            <?php }?>
                            
                            <td align="right" style="display: none "><?php echo $val['komisi_pers']; ?> <input type="hidden" name="v_komisi_pers[]" id="v_komisi_pers<?=$no;?>" value="<?=$val['komisi_pers'];?>"></td>
							<td align="right" style="display: none "><?php echo number_format($val['tot_komisi']); ?> <input type="hidden" name="v_komisi[]" id="v_komisi<?=$no;?>" value="<?=$val['tot_komisi'];?>"></td>
						</tr>
					<?php
					$totkomisitg+=$val['tot_komisi_tg'];
					$totkomisitl+=$val['tot_komisi_tl'];
					$totkomisidrv+=$val['tot_komisi_drv'];
					$no++;					
					}
	    			?>
					
					
	    				<tr class="title_table">
							<td align="left" colspan="8">Total Komisi</td>
							
							<?php if($v_tipe_user=="2"){?>
                            <td align="right"><?php echo number_format($totkomisitg); ?> <input type="hidden" name="v_totkomisitg" id="v_totkomisitg" value="<?=$totkomisitg;?>"></td>
                            <?php }else if($v_tipe_user=="1"){?>
                            <td align="right"><?php echo number_format($totkomisitl); ?> <input type="hidden" name="v_totkomisitl" id="v_totkomisitl" value="<?=$totkomisitl;?>"></td>
                            <?php }else if($v_tipe_user=="3"){?>
                            <td align="right"><?php echo number_format($totkomisidrv); ?> <input type="hidden" name="v_totkomisidrv" id="v_totkomisidrv" value="<?=$totkomisidrv;?>"></td>
                            <?php }?>
							
							
							
							
						</tr>
						
				</tbody>
    			</table>
    			
    			<button type="submit" class="btn btn-info btn-icon btn-sm icon-left" name="btn_save" id="btn_save" value="Save">Save<i class="entypo-download"></i></button>
		        <button type="button" class="btn btn-danger btn-icon btn-sm icon-left" name="btn_close" id="btn_close"  value="Keluar" onclick=parent.location="<?php echo base_url()."index.php/transaksi/komisi/"; ?>">Cancel<i class="entypo-check"></i></button>
		       <button type="button" class="btn btn-success btn-icon btn-sm icon-left" name="btn_close" id="btn_close"  value="Keluar" onclick=parent.location="<?php echo base_url()."index.php/transaksi/komisi/add_new_komisi_tertentu/"; ?>">Buat Ulang<i class="entypo-check"></i></button>
				
    	<?php	
			
						
		}
		
		
		
		if(!$btn_excel)
		{
    	?>
    	
    	
    	
	    </form> 
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
   		
   		function pilih_user(){
			user = $('#v_user').val();
			if(user=="1"){
				$("#tl").css("display","");
				$("#tg").css("display","none");
				$("#drv").css("display","none");
				
				$('#tour_travel').val("");
				$('#nama_tour_travel').val("");
				
				$('#v_leader').val("");
				$('#v_guide').val("");
				$('#v_driver').val("");
				
			}else if(user=="2"){
				$("#tl").css("display","none");
				$("#tg").css("display","");
				$("#drv").css("display","none");
				
				$('#tour_travel').val("");
				$('#nama_tour_travel').val("");
				
				$('#v_leader').val("");
				$('#v_guide').val("");
				$('#v_driver').val("");
				
			}else{
				$("#tl").css("display","none");
				$("#tg").css("display","none");
				$("#drv").css("display","");
				
				$('#tour_travel').val("");
				$('#nama_tour_travel').val("");
				
				$('#v_leader').val("");
				$('#v_guide').val("");
				$('#v_driver').val("");
			}
		}
		
		
		function on_travel(url){
			guide =  $('#v_guide').val();
			$("#span_loading").css("display","");
			$.ajax({
					url: url+"index.php/transaksi/komisi/ajax_travel/",
					data: {gd:guide},
					type: "POST",
					dataType: 'html',					
					success: function(res)
					{
						$("#span_loading").css("display","none");
						$('#travel').html(res);
					},
					error: function(e) 
					{
						alert(e);
					} 
				});
		}
		
		
   		
</script>

<?php
}
?>
