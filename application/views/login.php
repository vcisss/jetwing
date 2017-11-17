<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Neon Admin Panel"/>
    <meta name="author" content=""/>

    <title>JETWINGS BALI</title>
    <link rel="shortcut icon" href="<?= base_url();?>public/images/jetwings.png" >

    <link rel="stylesheet" href="<?= base_url(); ?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/font-icons/entypo/css/entypo.css">
    <!--  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">-->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/neon-core.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/neon-theme.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/neon-forms.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom.css">

    <script src="<?= base_url(); ?>assets/js/jquery-1.11.0.min.js"></script>

    <!--[if lt IE 9]>
    <script src="<?=base_url();?>assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body class="page-body login-page login-form-fall" data-url="http://neon.dev">


<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
    var baseurl = '';
</script>

		
<div class="login-container">
<br><br>	
<center>


        
<table border="0" width="50%" height="30%">
<tr>
<td colspan="100%">
<img src="<?= base_url(); ?>public/images/header.png" width="100%" height="40px">
</td>
</tr>
<tr>
<td rowspan="2" width="30%" style="background-color: #FFF;">
    
<div class="login-content">	
			<img src="<?= base_url(); ?>public/images/holidays.png" width="250" alt=""/><br><br>
			<img src="<?= base_url(); ?>public/images/lines.png" width="300" height="20px"><br>
			<font color="#fe0a0a"><b>WEB BASE APLICATION SYSTEM</b></font>
			 </div>
</td>
<td width="3%" style="background-color: #F5f5f5;">
</td>
         <td style="background-color: #F5F5F5; margin:10px; padding: 100; width: 40%;">
			<br><font color="#fe0a0a" size="5"><b>PT. JETWING BALI</b></font><br>
			<font color="#fe0a0a" size="2"><b>Tour Travel In Bali, Indonesia </b></font>
			<div class="login-form">
            <form action="<?= base_url(); ?>welcome/verified" method="post">
                <div class="form-group">

                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="entypo-user"></i>
                        </div>
                        <input type="text" name='kode' id='kode' class="form-control" placeholder="Username">
                    </div>

                </div>

                <div class="form-group">

                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="entypo-key"></i>
                        </div>
                        <input type="password" id='nama' name='nama' class="form-control" placeholder="Password">
                    </div>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-orange pull-right">
                        LOGIN
                    </button><br><br>
                </div>
				
            </form>
</div>
        
	
</td>
<td width="3%" style="background-color: #F5F5F5;">
</td>
</tr>
<tr>
<td width="3" height="100" style="background-color: #FFFFFF;"></td>
<td width="50" height="100" style="background-color: #FFFFFF;" align="right">
                <div class="copyright">
				<span><b>Copyright &copy; <?=date('Y')?></b></span>
				</div></td>
<td width="3" height="100" style="background-color: #FFFFFF;"></td>
</tr>
</table>


   
</center>

</div>


<!-- Bottom Scripts -->
<script src="<?= base_url(); ?>assets/js/gsap/main-gsap.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap.js"></script>
<script src="<?= base_url(); ?>assets/js/joinable.js"></script>
<script src="<?= base_url(); ?>assets/js/resizeable.js"></script>
<script src="<?= base_url(); ?>assets/js/neon-api.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="<?= base_url(); ?>assets/js/neon-login.js"></script>
<script src="<?= base_url(); ?>assets/js/neon-custom.js"></script>
<script src="<?= base_url(); ?>assets/js/neon-demo.js"></script>

</body>
</html>