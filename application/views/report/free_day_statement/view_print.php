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
	    				<td width="40%" style="text-align: center;"><h5><font color="red"><?php echo $template->title."FREE DAY STATEMENT";?></font></h5></td>
	    				<td width="30%" style="text-align: center;">&nbsp;</td>
	    			</tr>
	    			<!--<tr>
	    				<td colspan="70%"><?php echo $template->header."<hr>";?></td>
	    			</tr>
	    			<tr>
	    				<td colspan="70%"><?php echo $template->isi;?></td>
	    			</tr>
	    			<tr>
	    				<td colspan="70%"><hr></td>
	    			</tr>-->
	    			
    			</table>
				
				<?php
				$pisah = explode("/",base_url());
				$url = "http://".$pisah[2]."/claim_tour_API/img/form/freeDay/";
				?>
				<table style="border:1;border-collapse: collapse;" >
					<tr height="80" style="border:1;border-collapse: collapse;">
						<td colspan="3" style="border:1;border-collapse: collapse;">&nbsp;&nbsp;<?=$no;?>&nbsp;&nbsp;GUEST SIGN</td>
						<td colspan="3" style="border:1;border-collapse: collapse;"><img src="<?=$url.$guest;?>" width="120" alt=""/></td>
					</tr>
					<tr height="80" style="border:1;border-collapse: collapse;">
						<td colspan="3" style="border:1;border-collapse: collapse;">&nbsp;&nbsp;<?=$no;?>&nbsp;&nbsp;TL SIGN</td>
						<td colspan="3" style="border:1;border-collapse: collapse;"><img src="<?=$url.$tl;?>" width="120" alt=""/></td>
					</tr>
					<tr height="80" style="border:1;border-collapse: collapse;">
						<td colspan="3" style="border:1;border-collapse: collapse;">&nbsp;&nbsp;<?=$no;?>&nbsp;&nbsp;GUIDE SIGN</td>
						<td colspan="3" style="border:1;border-collapse: collapse;"><img src="<?=$url.$guide;?>" width="120" alt=""/></td>
					</tr>
				</table>

</body>
</html>
