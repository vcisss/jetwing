<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<style>
		table{
			width: 100%;
			border: 0;
			
			font-family: TimesNewRoman,Times New Roman,Times,Baskerville,Georgia,serif;
			font-size: 14px;
			font-style: normal;
			font-variant: normal;
			font-weight: 400;
			line-height: 20px;
		}
		
		.btn_print img{
			opacity: 0.4;
    		filter: alpha(opacity=40); /* For IE8 and earlier */
			cursor: pointer;	
		}
		
		.btn_print img:hover{
			opacity: 1.0;
    		filter: alpha(opacity=100); /* For IE8 and earlier */
		}
		
		.garis_putus{
			border-bottom: 1px dotted;	
			margin: 10px 0px;
		}
 
	</style>

	<script>
		function doPrint()
		{
			document.getElementById("theform").submit();		
		}
	</script>
</head>

<body>
					
					<?php $mylib = new globallib();?>
					<table border="0" width="100%">
                    <tr>
	    				<td><img src="<?= base_url();?>public/images/jetwings.png" width="120" alt="" /></td>
	    				<td width="40%" style="text-align: center;"><h1><font color="red"><?php echo STATEMENT."<br>文章的作者是寫";?></font></h1></td>
	    				<td width="30%" style="text-align: center;">&nbsp;</td>
	    			</tr>
	    			<tr>
	    				<td colspan="2"><h4><b><?php echo "GROUP CODE :".$tour[0]['NamaGroup'];?></b></h4></td>
	    				<td colspan="1"><h4><b><?php echo "DATE : ".$tour[0]['Tanggal'];?></b></h4></td>
	    			</tr>
	    			<tr>
	    				<td colspan="100%"><h4><b><?php echo "(Herewith, I/We Agree to revise or cancel Schedule as below)<br>文章的作者是寫<br>".$tour[0]['revise_text'];?></b></h4></td>
	    			</tr>
	    			<tr>
	    				<td colspan="100%"><h4><b><?php echo "(Therefore, I\We will have no complain/any refund)<br>文章的作者是寫, 文章的作者是寫.<br>".$tour[0]['complain_text'];?></b></h4></td>
	    			</tr>
	    			<tr>
	    				<td colspan="100%"><hr></td>
	    			</tr>
	    			
    			</table>
				
				<?php
				$pisah = explode("/",base_url());
				$url = "http://".$pisah[2]."/claim_tour_API/img/form/cancel/";
				?>
				
				<table border="0" width="60%" >
					<?php foreach($tour AS $val){?>
					<tr height="80">
						<td colspan="3">&nbsp;&nbsp;<?=$no;?>&nbsp;&nbsp;<h4><b>Client's Name</b></h4></td>
						<td colspan="3"><img src="<?=$url.$val['image_name'];?>" width="120" alt=""/></td>
					</tr>
					<?php } ?>
				</table>

</body>
</html>
