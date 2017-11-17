<?php 

if(!$btn_excel)
{
	$this->load->view('header'); 

	$modul = "Tour Guide Claim";
	
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
	/*if(document.getElementById("v_start_date").value=="")
    {
        alert("Tanggal Awal harus diisi");
        document.getElementById("v_start_date").focus();
        return false;
    }*/
    
    document.getElementById("theform").submit();	
	
}

function analisa_cari()
{
	/*if(document.getElementById("v_start_date").value=="")
    {
        alert("Tanggal Awal harus diisi");
        document.getElementById("v_start_date").focus();
        return false;
    }*/
    
    document.getElementById("theform").submit();	
	
}
</script>

<div class="row">
    <div class="col-md-12" align="left">
    
    	<ol class="breadcrumb title_table">
			<li><strong><i class="entypo-pencil"></i>Report <?php echo $modul; ?></strong></li>
		</ol>
		
		<form method='post' name="theform" id="theform" action="<?php echo base_url();?>index.php/report/tour_guide_claim/search_report">
		
	    <table class="table table-bordered responsive">     
	        
	        <tr>
	            <td class="title_table" width="150">Group Tour</td>
	            <td> 
				<input type="text" class="form-control-new" size="20" maxlength="10" name="v_keyword_kdgroup" id="v_keyword_kdgroup" placeholder="Cari Group" onkeyup="cari_group('<?php echo base_url(); ?>')">
					<select class="form-control-new" name="v_kdtour" id="v_kdtour" style="width: 200px;" onchange="analisa_cari(),show_loading_bar(100)">
	            		<option value="">Pilih Kode Tour</option>
	            		<?php
	            		foreach($gouptour as $val)
	            		{
	            			$selected="";
							if($v_kdtour==$val["KdGroup"])
							{
								$selected='selected="selected"';
							}
							?><option <?php echo $selected; ?> value="<?php echo $val["KdGroup"]; ?>"><?php echo $val["NamaGroup"]; ?></option><?php
						}
	            		?>
	            	</select>
	            </td>
	        </tr>   
			
			
	                <input type='hidden' name="flag" id="flag" value="analisa">
					<input type='hidden' name="base_url" id="base_url" value="<?php echo base_url(); ?>">
					
					
	        <!--<tr>
	        	 <td class="title_table">&nbsp;</td>
	            <td colspan="100%">
					
	                <button type="button" class="btn btn-info btn-icon btn-sm icon-left" onclick="cekTheform();" name="btn_analisa" id="btn_analisa"  value="Analisa">Analisa<i class="entypo-check"></i></button>
		        </td>
	        </tr>-->  
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
		<button type="submit" class="btn btn-green btn-icon btn-sm icon-left" name="btn_excel" id="btn_excel" value="Excel">Export To Excel<i class="entypo-download"></i></button>
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
                                <td colspan="13">REPORT TOUR GUIDE CLAIM</td>   
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
	    				<th><center>Description</center></th>
	    				<th width="100"><center>Pax</center></th>
	    				<th width="100"><center>IDR</center></th>
	    				<th width="100"><center>USD</center></th>
	    				<th width="100"><center>RMB</center></th>
	    			</tr>
	    		</thead>
	    		<tbody>
				    <tr>
	    				<th colspan="6" style="background:#ffd1aa">COMPANY TO GUIDE</th>
	    			</tr>
	    			<?php
	    			if(count($headerjenis1)==0)
	    			{
						echo "<tr><td colspan='6' align='center'>Tidak Ada Data</td></tr>";
					}
					
					
					$no = 1;
					$idr=0;
					$usd=0;
					$rmb=0;
					foreach($headerjenis1 as  $val)
					{		
					?>
						<tr>
							<td align="center"><?php echo $no ; ?></td>
							<td align="left"><?php echo $val['NamaAktivitas'] ; ?></td>
							<td align="right"><?php echo $val['Pax']; ?></td>
							<td align="right"><?php echo number_format($val['Pax']*$val['IDR']); ?></td>
							<td align="right"><?php echo number_format($val['Pax']*$val['USD']); ?></td>
							<td align="right"><?php echo number_format($val['Pax']*$val['RMB']); ?></td>
						</tr>
					<?php
					$idr+=$val['Pax']*$val['IDR'];
					$usd+=$val['Pax']*$val['USD'];
					$rmb+=$val['Pax']*$val['RMB'];
					$no++;					
					}
	    			?>
					
					
	    				<tr class="title_table">
							<td align="left" colspan="3">SUBTOTAL COMPANY TO GUIDE</td>
							<td align="right"><?php echo number_format($idr); ?></td>
							<td align="right"><?php echo number_format($usd); ?></td>
							<td align="right"><?php echo number_format($rmb); ?></td>
						</tr>
						
				</tbody>
    			</table>
				<hr>
				<?php
				echo "<br>".$table;
			
    	?>
	    		<thead class="title_table">
	    			<tr>
	    				<th width="20"><center>No.</center></th>
	    				<th><center>Description</center></th>
	    				<th width="100"><center>Pax</center></th>
	    				<th width="100"><center>IDR</center></th>
	    				<th width="100"><center>USD</center></th>
	    				<th width="100"><center>RMB</center></th>
	    			</tr>
	    		</thead>
	    		<tbody>
				
	    			
					
					<tr>
	    				<th colspan="6" style="background:#ffd1aa">GUIDE TO COMPANY</th>
	    			</tr>
					
					<?php
					
	    			if(count($headerjenis2)==0)
	    			{
						echo "<tr><td colspan='6' align='center'>Tidak Ada Data</td></tr>";
					}
					?>
					
					<?php if(!empty($sumheaderoptional)){ ?>
				        <tr bgcolor="#f0f0f0">
							<td align="center"><?php echo "1" ; ?></td>
							<td align="left"><?php echo "Optional Tour" ; ?></td>
							<td align="right">0</td>
							<td align="right">0</td>
							<td align="right"><?php echo number_format($sumheaderoptional->Optional_fee); ?></td>
							<td align="right">0</td>
						</tr>
					<?php } ?>	
						
						
					<?php 
					if(!empty($sumheaderoptional)){
					$noy = 2;
					}else{
					$noy = 1;
					}
					$idry=0;
					$usdy=0;
					$rmby=0;
					
					foreach($headerjenis2 as  $valy)
					{
					?>
						<tr>
							<td align="center"><?php echo $noy ; ?></td>
							<td align="left"><?php echo $valy['NamaAktivitas'] ; ?></td>
							<td align="right"><?php echo $valy['Pax']; ?></td>
							<td align="right"><?php echo number_format($valy['Pax']*$valy['IDR']); ?></td>
							<td align="right"><?php echo number_format($valy['Pax']*$valy['USD']); ?></td>
							<td align="right"><?php echo number_format($valy['Pax']*$valy['RMB']); ?></td>
						</tr>
					<?php
					$idry+=$valy['Pax']*$valy['IDR'];
					$usdy+=$valy['Pax']*$valy['USD'];
					$rmby+=$valy['Pax']*$valy['RMB'];
					$noy++;					
					}
	    			?>
					
					    <tr class="title_table">
							<td align="left" colspan="3">SUBTOTAL COMPANY TO GUIDE</td>
							<td align="right"><?php echo number_format($idry); ?></td>
							<td align="right"><?php echo number_format($usdy+$sumheaderoptional->Optional_fee); ?></td>
							<td align="right"><?php echo number_format($rmby); ?></td>
						</tr>
											
	    		</tbody>
    			</table>
				
				<hr>
				
				<?php echo "<br>".$table;?>
				<tr>
	    				<td align="center" style="background:#0061ff"><font color="white"><b>DESCRIPTION</b></font></td>
						<td align="center" style="background:#0061ff" width="100"><font color="white"><b>IDR</b></font></td>
						<td align="center" style="background:#0061ff" width="100"><font color="white"><b>USD</b></font></td>
						<td align="center" style="background:#0061ff" width="100"><font color="white"><b>RMB</b></font></td>
	    			</tr>
				    <tr>
	    				<td align="left" style="background:#7fffd4">FINAL BALANCING</td>
						<td align="right" style="background:#7fffd4"><?=number_format($idry-$idr);?></td>
						<td align="right" style="background:#7fffd4"><?=number_format(($usdy+$sumheaderoptional->Optional_fee)-$usd);?></td>
						<td align="right" style="background:#7fffd4"><?=number_format($rmby-$rmb);?></td>
	    			</tr>
				</table>
				<hr>	
				<?php
				echo "<br>".$table;
			
    	?>
	    		<thead class="title_table">
	    			<tr>
	    				<th width="20"><center>No.</center></th>
	    				<th><center>Description</center></th>
						<th width="100"><center>Pax</center></th>
	    				<th width="100"><center>SELL</center></th>
	    				<th width="100"><center>NET</center></th>
	    				<th width="100"><center>TOTAL</center></th>
	    			</tr>
	    		</thead>
	    		<tbody>
					<tr>
	    				<th colspan="6" style="background:#ffd1aa">DETAIL OPTIONAL TOUR</th>
	    			</tr>
					
	    			<?php
	    			if(count($headeroptional)==0)
	    			{
						echo "<tr><td colspan='6' align='center'>Tidak Ada Data</td></tr>";
					}
					
					
					$nox = 1;
					$paxx=0;
					$hargajualusd=0;
					$hpp=0;
					$totals=0;
					foreach($headeroptional as  $valx)
					{		
					?>
						<tr>
							<td align="center"><?php echo $nox ; ?></td>
							<td align="left"><?php echo $valx['NamaTour'] ; ?></td>
							<td align="right"><?php echo number_format($valx['Pax']); ?></td>
							<td align="right"><?php echo number_format($valx['HargaJualUSD'],2); ?></td>
							<td align="right"><?php echo number_format($valx['HPP'],2); ?></td>
							<td align="right"><?php echo number_format($valx['Pax']*$valx['Net'],2); ?></td>
						</tr>
					<?php
					$paxx+=$valx['Pax'];
					$hargajualusd+=$valx['HarjaJualUSD'];
					$hpp+=$valx['HPP'];
					$totals+=$valx['Pax']*$valx['Net'];
					$nox++;					
					}
	    			?>
					
					
	    				<tr class="title_table">
							<td align="left" colspan="2">TOTAL OPTIONAL</td>
							<td align="right"><?php echo number_format($paxx); ?></td>
							<td align="right"><?php echo number_format($hargajualusd,2); ?></td>
							<td align="right"><?php echo number_format($hpp,2); ?></td>
							<td align="right"><?php echo number_format($totals,2); ?></td>
						</tr>
						
	    		</tbody>
    			</table>
				
				
				
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

function cari_group(url)
		{
			var act=$("#v_keyword_kdgroup").val();
			$.ajax({
					url: url+"index.php/report/tour_guide_claim/ajax_group/",
					data: {id:act},
					type: "POST",
					dataType: 'html',					
					success: function(res)
					{
						
						$('#v_kdtour').html(res);
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
