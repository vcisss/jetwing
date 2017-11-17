<?php
$this->load->view('header'); 
$gantikursor = "onkeydown=\"changeCursor(event,'search',this)\"";
?>
<script language="javascript" src="<?=base_url();?>public/js/global.js"></script>
<script>
function cek()
{
  document.getElementById("search").submit();
}
</script>
<body onload="firstLoad('search');">
<br>
<form method='post' name="search" id="search" action='<?=base_url();?>index.php/search/cari'>
<table cellspacing="3" cellpadding="3" align = 'center' border='0'>
<tr>
	<td><input type="text" name="cari" id="cari" size="70" value="<?=$cari?>" <?=$gantikursor?>></td>
</tr>
</table>
<br>
<table align="center">
	<tr align="center">
	<td><input type="button" value="Search" onclick="cek();"></td>
	</tr>
</table>
</form>
<?php
$this->load->view('footer'); ?>