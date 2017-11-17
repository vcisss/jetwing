<?php 
	$modul = "Search Stock";
	
	$v_nilai = $this->uri->segment(4);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />
                                                
    <title><?php echo $modul; ?> - Sumber Herbal</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>public/images/Logosg.png" >
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/NotoSans.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-core.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-theme.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-forms.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/skins/black.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/my.css">

    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/js.js"></script>

    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script>
		function start_page()
		{
			document.getElementById("search_keyword").focus();	
		}
        
        function get_choose(tour,nama)
        {
            window.opener.document.forms["theform"]["v_tour_id"].value = tour;
            window.opener.document.forms["theform"]["v_tour_nama"].value = nama;
            self.close() ;
            return; 
        }
	</script>
</head>

<body class="page-body skin-black" onload="start_page()">

<div class="page-container sidebar-collapsed" style="padding-left: 0px;">
    
    <div class="main-content">
		
		<form method="POST"  name="search" action='<?=base_url();?>index.php/pop/pop_up_stock/search'>
			<input type="hidden" name="v_nilai" id="v_nilai" value="<?php echo $v_nilai; ?>"/>
			<input type="hidden" name="search_kd_grouptravel" id="search_kd_grouptravel" value=""/>
			<input type="hidden" name="search_nm_grouptravel" id="search_nm_grouptravel" value=""/>
			<div class="row">
				<div class="col-md-12">
					<b>Keyword</b>&nbsp;
	               	<input type="text" name="search_keyword" id="search_keyword" class="form-control-new" value="<?php if($search_keyword){ echo $search_keyword; } ?>" size="20">
	               	&nbsp;
					<span style="float: right;">
						<button type="submit" class="btn btn-info btn-icon btn-sm icon-left" onClick="show_loading_bar(100)">Search<i class="entypo-search"></i></button>
					</span>
				
				</div>
			</div>
		</form>
		
		<hr/>
		
		<div id="table-2_wrapper" class="dataTables_wrapper form-inline" role="grid">
			
			<table class="table table-bordered responsive">
	        	<thead>
					<tr>
						<th width="80">Tour ID</th>
		                <th>Nama</th>
		        	</tr>
				</thead>
				<tbody>
				
				<?php
				if(count($tour)==0)
				{
					echo "<tr><td colspan='100%'><center>Tidak Ada Data</center></td></tr>";
				}
				
				$i=1;
				foreach($tour as $val)
				{
					$bgcolor = "";
                    if($i%2==0)
                    {
                        $bgcolor = "background:#E7E7E7;";
                    }
                    
					?>
					<tr onclick="get_choose('<?php echo $val["Tour_id"]; ?>','<?php echo $val["Nama"]; ?>')">
						<td><?php echo $val["Tour_id"] ?></td>
						<td><?php echo $val["Nama"]; ?></td>
					</tr>
					<?php
					$i++;
				}
				?>
             
				</tbody>
			</table> 

			<div class="row">
				<div class="col-xs-6 col-left">
					<div id="table-2_info" class="dataTables_info">&nbsp;</div>
				</div>
				<div class="col-xs-6 col-right">
					<div class="dataTables_paginate paging_bootstrap">
						<?php echo $pagination; ?>
					</div>
				</div>
			</div>	
		
		</div>
		
	</div>
</div>
</body>
</html>