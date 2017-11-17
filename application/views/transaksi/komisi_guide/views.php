<?php 

if(!$btn_excel)
{
	$this->load->view('header'); 

	$modul = "Komisi Tour Guide";
	
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
	if(document.getElementById("v_guide").value=="")
    {
        alert("Guide Harus Dipilih");
        document.getElementById("v_keyword_guide").focus();
        return false;
    }else if(document.getElementById("v_tgl").value=="")
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
			<li><strong><i class="entypo-pencil"></i>Report <?php echo $modul; ?></strong></li>
		</ol>
		
		<form method='post' name="theform" id="theform" action="<?php echo base_url();?>index.php/transaksi/komisi_guide/search_guide">
		
	    <table class="table table-bordered responsive">     
	        
	        <tr>
	            <td class="title_table" width="150">Guide</td>
	            <td> 
				<input type="text" class="form-control-new" size="20" maxlength="10" name="v_keyword_guide" id="v_keyword_guide" placeholder="Cari Guide" onkeyup="cari_guide('<?php echo base_url(); ?>')">
					<select class="form-control-new" name="v_guide" id="v_guide" style="width: 200px;">
	            		<option value="">Pilih Guide</option>
	            		<?php
	            		foreach($tourguide as $val)
	            		{
	            			$selected="";
							if($v_guide==$val["KdTourGuide"])
							{
								$selected='selected="selected"';
							}
							?><option <?php echo $selected; ?> value="<?php echo $val["KdTourGuide"]; ?>"><?php echo $val["NamaTourGuide"]; ?></option><?php
						}
	            		?>
	            	</select>
	            </td>
	        </tr>   
	        
	        
	        <tr>
	            <td class="title_table" width="150">Tanggal</td>
	            <td> 
				<input type="text" class="form-control-new datepicker col-lg-2"  placeholder="dd-mm-yyyy" value="<?=$v_tgl;?>" name="v_tgl" id="v_tgl" style="text-align: left;width:100px;">
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
                                <td colspan="13">PT. JETWINGS</td>   
                            </tr>
                            <tr>
                                <td colspan="13">Komisi Guide</td>   
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
	    				<th width="20"><center>No.</center></th>
	    				<th width="100"><center>No.Struk</center></th>
	    				<th><center>Nama</center></th>
	    				<th width="100"><center>Qty</center></th>
	    				<th width="100"><center>Harga</center></th>
	    				<th width="100"><center>Kom. Guide %</center></th>
	    				<th width="100"><center>Komisi</center></th>
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
							<td align="center"><?php echo $val['NoStruk'] ; ?> <input type="hidden" name="v_struk[]" id="v_struk<?=$no;?>" value="<?=$val['NoStruk'];?>"></td>
							<td align="left"><?php echo $val['Nama']; ?> <input type="hidden" name="v_nama[]" id="v_nama<?=$no;?>" value="<?=$val['Nama'];?>"></td>
							<td align="right"><?php echo $val['Qty']; ?> <input type="hidden" name="v_qty[]" id="v_qty<?=$no;?>" value="<?=$val['Qty'];?>"></td>
							<td align="right"><?php echo number_format($val['Harga']); ?> <input type="hidden" name="v_harga[]" id="v_harga<?=$no;?>" value="<?=$val['Harga'];?>"></td>
							<td align="right"><?php echo $val['komisi_guide']; ?> <input type="hidden" name="v_komisi_guide[]" id="v_komisi_guide<?=$no;?>" value="<?=$val['komisi_guide'];?>"></td>
							<td align="right"><?php echo number_format($val['Komisi']); ?> <input type="hidden" name="v_komisi[]" id="v_komisi<?=$no;?>" value="<?=$val['Komisi'];?>"></td>
						</tr>
					<?php
					$totkomisi+=$val['Komisi'];
					$no++;					
					}
	    			?>
					
					
	    				<tr class="title_table">
							<td align="left" colspan="6">KOMISI GUIDE</td>
							<td align="right"><?php echo number_format($totkomisi); ?> <input type="hidden" name="v_totkomisi" id="v_totkomisi" value="<?=$totkomisi;?>"></td>
						</tr>
						
				</tbody>
    			</table>
    			
    			<button type="submit" class="btn btn-info btn-icon btn-sm icon-left" name="btn_save" id="btn_save" value="Save">Save<i class="entypo-download"></i></button>
		        <button type="button" class="btn btn-danger btn-icon btn-sm icon-left" name="btn_excel" id="btn_excel" value="Excel">Cancel<i class="entypo-download"></i></button>
				
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
					url: url+"index.php/transaksi/komisi_guide/ajax_guide/",
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
</script>

<?php
}
?>
