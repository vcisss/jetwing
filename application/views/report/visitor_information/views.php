<?php 

if(!$btn_excel)
{
	$this->load->view('header'); 

	$modul = "Visitor Information";
	
}

if($btn_excel)
{
	$file_name = "Visitor_information.xls";
	        
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

function PopUpToPDF(baseurl, tour)
    {
    	url = "index.php/report/visitor_information/viewPrint/"+tour;
        window.open(baseurl + url, 'popuppage', 'scrollbars=yes, width=900,height=500,top=50,left=50');
    }
</script>

<div class="row">
    <div class="col-md-12" align="left">
    
    	<ol class="breadcrumb title_table">
			<li><strong><i class="entypo-pencil"></i>Report <?php echo $modul; ?></strong></li>
		</ol>
		
		<form method='post' name="theform" id="theform" action="<?php echo base_url();?>index.php/report/visitor_information/search_report">
		
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
		<button type="button" class="btn btn-orange btn-icon btn-sm icon-left" name="btn_excel" id="btn_excel" onclick="PopUpToPDF('<?= base_url(); ?>','<?= $tour[0]['group_code']; ?>')" value="Excel">Export To PDF<i class="entypo-download"></i></button>
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
    	
    	<center>
    	<?php
    	if($btn_excel)
    	{
			$table = '<table border="1" cellpadding="0" cellspacing="0" width="100%">';
		}
		else
		{
			$table = '<table border="0" width="60%">';	
		}
		
			echo $table;
			if($tour['TipeOptionTour']==1){
				$tipe = 'With TL';
			}elseif($tour['TipeOptionTour']==2){
				$tipe = 'Fit TL';
			}else{
				$tipe = 'Non TL';
			}
			
    	?>
    			
    			
	    		
				    <tr>
	    				<td><img src="<?= base_url();?>public/images/jetwings.png" width="120" alt="" /></td>
	    				<td width="40%" style="text-align: center;"><h1><font color="red"><?php echo $template->title;?></font></h1></td>
	    				<td width="30%" style="text-align: center;">&nbsp;</td>
	    			</tr>
	    			<tr>
	    				<td colspan="100%"><?php echo $template->header."<hr>";?></td>
	    			</tr>
	    			<tr>
	    				<td colspan="100%"><?php echo $template->isi;?></td>
	    			</tr>
	    			<tr>
	    				<td colspan="100%"><hr></td>
	    			</tr>
	    			
    			</table>
				
				<?php
				$pisah = explode("/",base_url());
				$url = "http://".$pisah[2]."/claim_tour_API/img/form/visitor/";
				?>
				<table border="1" width="60%" >
					<tr height="30">
						<td colspan="2">&nbsp;&nbsp;Agent Name&nbsp;&nbsp;:&nbsp;&nbsp;<?=$tour[0]['agent_name'];?> </td>
						<td colspan="2">&nbsp;&nbsp;Date Arrival/Departure&nbsp;&nbsp;:</td>
						<td colspan="2">&nbsp;&nbsp;Total PAX&nbsp;&nbsp;:&nbsp;&nbsp;<?=$tour[0]['pax'];?></td>
					</tr>
					<tr height="30">
						<td colspan="2">&nbsp;&nbsp;Tour Leader&nbsp;&nbsp;:&nbsp;&nbsp;<?=$tour[0]['leader_name'];?></td>
						<td colspan="4">&nbsp;&nbsp;Guide&nbsp;&nbsp;:&nbsp;&nbsp;<?=$tour[0]['guide'];?></td>
					</tr>
					<?php $no=1;foreach($tour AS $val){?>
					<tr height="80">
						<td colspan="3">&nbsp;&nbsp;<?=$no;?>&nbsp;&nbsp;<?=$val['name'];?></td>
						<td colspan="3"><img src="<?=$url.$val['image_name'];?>" width="120" alt=""/></td>
					</tr>
					<?php $no++;} ?>
				</table>
		</center>		
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
					url: url+"index.php/report/visitor_information/ajax_group/",
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
