<?php 

if(!$btn_excel)
{
	$this->load->view('header'); 

	$modul = "Komisi List";
	
}

if($btn_excel)
{
	$file_name = "Report_komisi_list.xls";
	        
	header("Content-Disposition".": "."attachment;filename=$file_name");
	header("Content-type: application/vnd.ms-excel");
}

if(!$btn_excel)
{
	

?>

<div class="row">
    <div class="col-md-12" align="left">
    
    	<ol class="breadcrumb title_table">
			<li><strong><i class="entypo-pencil"></i>Report <?php echo $modul; ?></strong></li>
		</ol>
		
		<form method='post' name="theform" id="theform" action="<?php echo base_url();?>index.php/report/komisi_list/search_report">
		        
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
		<button type="submit" class="btn btn-green btn-icon btn-sm icon-left pull-right" name="btn_excel" id="btn_excel" value="Excel">Export To Excel<i class="entypo-download"></i></button>
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
                                <td colspan="13">REPORT KOMISI LIST</td>   
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
	    				<th width="100"><center>Stock ID</center></th>
	    				<th width="100"><center>Vendor ID</center></th>
	    				<th><center>Nama</center></th>
	    				<th width="100"><center>Komisi</center></th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<?php
	    			if(count($komisilist)==0)
	    			{
						echo "<tr><td colspan='6' align='center'>Tidak Ada Data</td></tr>";
					}
					
					
					$no = 1;
					foreach($komisilist as  $val)
					{		
					if ($val['Komisi']==""){
						$color = "yellow";
					}else{
						$color = "";
					}
					?>
						<tr bgcolor="<?=$color;?>">
							<td align="center"><?php echo $no ; ?></td>
							<td align="center"><?php echo $val['StockID'] ; ?></td>
							<td align="center"><?php echo $val['VendorID']; ?></td>
							<td align="left"><?php echo $val['Nama']; ?></td>
							<td align="right"><?php echo $val['Komisi']; ?></td>
						</tr>
					<?php					
					$no++;					
					}
	    			?>
						
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


<?php
}
?>
