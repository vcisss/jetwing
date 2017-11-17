<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />

    <title>Jetwings</title>
    <link rel="shortcut icon" href="<?= base_url();?>public/images/jetwings.png" >
    
    <link rel="stylesheet" href="<?= base_url();?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/NotoSans.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/neon-core.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/neon-theme.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/neon-forms.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/skins/black.css">
    <link rel="stylesheet" href="<?= base_url();?>public/css/style.css">
    <link rel="stylesheet" href="<?= base_url();?>public/css/my.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/bootstrapvalidator/css/bootstrapvalidator.min.css">
    
    <script src="<?= base_url();?>assets/js/jquery-1.11.0.min.js"></script>
    <script src="<?= base_url();?>assets/bootstrapvalidator/js/bootstrapvalidator.min.js"></script>
    <script src="<?= base_url();?>public/js/js.js"></script>

</head>
<body class="page-body skin-black" >

<div class="page-container sidebar-collapsed">

    <div class="sidebar-menu">


        <header class="logo-env">

            <!-- logo -->
            <div class="logo">
                <a href="index.html">
                    <img src="<?= base_url();?>public/images/jetwings.png" width="120" alt="" />
                </a>
            </div>

            <!-- logo collapse icon -->

            <div class="sidebar-collapse">
                <a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                    <i class="entypo-menu"></i>
                </a>
            </div>



            <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
            <div class="sidebar-mobile-menu visible-xs">
                <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                    <i class="entypo-menu"></i>
                </a>
            </div>

        </header>



        <div class="sidebar-user-info">

            <div class="sui-normal">
                <a href="#" class="user-link">
                    <?php $mylib = new globallib(); ?>
                    <span><?=$mylib->ubah_tanggal($this->session->userdata('Tanggal_Trans'));?></span>
                    <strong><?=$this->session->userdata('username');?></strong>
                </a>
            </div>
        </div>

        <?=$this->load->view('slide_kiri');?>

    </div>

    <div class="main-content">
    
    	<!--<ol class="breadcrumb bc-3">
    		<li>
				<a href="<?php echo base_url(); ?>start">
					<i class="entypo-home"></i>Jetwings Bali
				</a>
			</li>
			
			<?php if(!empty($track)){ echo $track; } ?>
			
		</ol>-->
		<ol class="breadcrumb bc-3">
    		<li>
		<i class="entypo-home"></i>Jetwings Bali
		   </li>
		</ol>
		
		<hr/>
        