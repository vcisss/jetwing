<?php
class printreportlib{
	var $CI;
	function __construct(){
	    $this->CI =& get_instance();
	 	$this->CI->load->library('session');
		$this->CI->load->model('transaksi/print_model');
	}
	function getIP(){
		if ( isset($_SERVER["REMOTE_ADDR"]) )    {
			$ip=$_SERVER["REMOTE_ADDR"];
		} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
			$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
			$ip=$_SERVER["HTTP_CLIENT_IP"];
		}
		return $ip;
	}
	function getNamaPT()
	{
		$pt = $this->CI->print_model->getPT();
		return $pt;
	}
	function getNamaPTDO($kdperusahaan)
	{
		$pt = $this->CI->print_model->getPTDO($kdperusahaan);
		return $pt;
	}
	
	function resetprint() {
		echo chr(27) . '@'.chr(27).chr(120).chr(48);
	}
	function PrintJudul($judul,$command,$fileName,$fontstyle,$spasienter)
	{
		if(empty($getPT)){
			$getPT = $this->getNamaPT();
		}
		if($command=="w")
		{
			$Data = chr(27).chr(64).chr(27).chr(67).chr(33).$fontstyle.chr(27).chr(69).$getPT->Nama."\r\n";
		}
		else
		{
			$Data = $spasienter.chr(27).chr(64).chr(27).chr(67).chr(33).$fontstyle.chr(27).chr(69).$getPT->Nama."\r\n";
		}
        $Data .= "NPWP : ".$getPT->NPWP."\r\n";
		$Data .= $getPT->Alamat1."\r\n";
		$Data .= $getPT->Alamat2."\r\n";
		$Data .= $getPT->Kota."\r\n";
		$Data .= "\t\t\t\t".$judul.chr(27).chr(70)."\r\n";
		$Handle = fopen($fileName, $command);
		fwrite($Handle, $Data);
		fclose($Handle);
	}
	function PrintJudulDO($judul,$command,$fileName,$fontstyle,$spasienter,$pt)
	{
		$lenspasibarisatas = (int)65 - strlen("Yth. ".$pt->NamaPerusahaan) - strlen($pt->Nama);
		$spasibarisatas = "               ";
		$barisatas = "           ".$pt->NamaPerusahaan; //.$spasibarisatas."Yth. ".$pt->Nama;
		if($command=="w")
		{
			$Data = chr(27).chr(64).chr(27).chr(67).chr(33).$fontstyle.chr(27).chr(69).$barisatas."\r\n\r\n";
		}
		else
		{
			$Data = $spasienter.chr(27).chr(64).chr(27).chr(67).chr(33).$fontstyle.chr(27).chr(69).$barisatas."\r\n\r\n";
		}
		//$Data .= "\r\n\r\n";
		//$Data .= $pt->NPWP."\r\n\r\n";
		//$Data .= "\t\t\t\t".$judul.chr(27).chr(70)."\r\n\r\n";
		$Data .= $judul.chr(27).chr(70)."\t\t"."Yth. ".$pt->Nama."\r\n\r\n";
		$Handle = fopen($fileName, $command);
		fwrite($Handle, $Data);
		fclose($Handle);
	}
	function PrintJudulSJLama($judul,$command,$fileName,$fontstyle,$spasienter,$pt)
	{
		$spasibarisatas = "";
		for($s=0;$s<80;$s++)
		{
			$spasibarisatas .= " ";
		}
		$barisatas = $spasibarisatas.$pt->Nama;
		if($command=="w")
		{
			$Data = chr(27).chr(64).chr(27).chr(67).chr(33).$fontstyle.chr(27).chr(69).$spasibarisatas.date("d-m-Y")."\r\n";
			$Data = chr(27).chr(64).chr(27).chr(67).chr(33).$fontstyle.chr(27).chr(69).$barisatas."\r\n";
		}
		else
		{
			$Data = $spasienter.chr(27).chr(64).chr(27).chr(67).chr(33).$fontstyle.chr(27).chr(69).$spasibarisatas.date("d-m-Y")."\r\n";
			$Data = $spasienter.chr(27).chr(64).chr(27).chr(67).chr(33).$fontstyle.chr(27).chr(69).$barisatas."\r\n";
		}
		$Data .= "\r\n\r\n";
		$Data .= "                                ";
		$Handle = fopen($fileName, $command);
		fwrite($Handle, $Data);
		fclose($Handle);
	}
	function subjudultabel($judul1,$nilai1,$judul2,$nilai2){
		if($judul1!=""){
			for($t = 0;$t<count($judul1);$t++){
				$nilai1[$t] = str_replace("\n","<br>&nbsp;&nbsp;",$nilai1[$t]);
				?>
				<tr bordercolor="#FFFFFF">
					<td nowrap="nowrap"  width = "3%" > <font face="Courier New"><?php echo $judul1[$t]; ?></font></td>
					<td nowrap="nowrap"  width = "25%"> <font face="Courier New">: <?php echo $nilai1[$t]; ?> </font></td>
				<?php if(isset($judul2[$t])){
						$nilai2[$t] = str_replace("\n","<br>&nbsp;&nbsp;",$nilai2[$t]);
				?>
					<td nowrap="nowrap"  width = "3%" > <font face="Courier New"><?php echo $judul2[$t]; ?>  </font>	</td>
					<td nowrap="nowrap"  width = "25%"> <font face="Courier New">: <?php echo $nilai2[$t]; ?>	</font> </td>
				<?php } ?>
				</tr>
		<?php
			}
		}
	}
	
	function subjudultabel_print($judul1,$nilai1,$judul2,$nilai2,$fileName){
		$lenjudul1 = 0;
		$lenjudul2 = 0;
		$lennilai1 = 0;
		$lennilai2  = 0;
		$spasi = '';
		for($t = 0;$t<count($judul1);$t++){  //cari paling besar
			$len = strlen($judul1[$t]);
			if($len > $lenjudul1) $lenjudul1 = $len;
			else{
				$lenjudul1 = $lenjudul1;
			}
		}
		for($t = 0;$t<count($judul1);$t++){ //tambahin spasi
			$spasi = '';
			for($i=0;$i<=($lenjudul1 - strlen($judul1[$t]));$i++){
				$spasi = $spasi.' ';
			}
			$judul1[$t] = $judul1[$t].$spasi.':';
			$strjudul[] = $judul1[$t];
		}

		for($t = 0;$t<count($nilai1);$t++){  //cari paling besar nilai
			$len = strlen($nilai1[$t]);
			if($len > $lennilai1) $lennilai1 = $len;
			else{
				$lennilai1 = $lennilai1;
			}
		}

		for($t = 0;$t<count($nilai1);$t++){ //tambahin spasi
			$spasi = '';
			for($i=0;$i<=($lennilai1 - strlen($nilai1[$t]));$i++){
				$spasi = $spasi.' ';
			}
			$nilai1[$t] = $nilai1[$t].$spasi."\t";
			$strjudul[$t] = $strjudul[$t].$nilai1[$t];
		}

		////nilai n judul ke 2
		if(isset($judul2)&&$judul2!=""){
			for($t = 0;$t<count($judul2);$t++){  //cari paling besar
				$len = strlen($judul2[$t]);
				if($len > $lenjudul2) $lenjudul2 = $len;
				else{
					$lenjudul2 = $lenjudul2;
				}
			}
			for($t = 0;$t<count($judul2);$t++){ //tambahin spasi
				$spasi = '';
				for($i=0;$i<=($lenjudul2 - strlen($judul2[$t]));$i++){
					$spasi = $spasi.' ';
				}
				$judul2[$t] = $judul2[$t].$spasi.':';
				$strjudul[$t] = $strjudul[$t].$judul2[$t];
			}

			for($t = 0;$t<count($nilai2);$t++){  //cari paling besar nilai
				$len = strlen($nilai2[$t]);
				if($len > $lennilai2) $lennilai2 = $len;
				else{
					$lennilai2 = $lennilai2;
				}
			}
			for($t = 0;$t<count($nilai2);$t++){ //tambahin spasi
				$spasi = '';
				for($i=0;$i<=($lennilai2 - strlen($nilai2[$t]));$i++){
					$spasi = $spasi.' ';
				}
				$nilai2[$t] = $nilai2[$t].$spasi."\t";

				$strjudul[$t] = $strjudul[$t].$nilai2[$t];
			}
		}

		$Handle = fopen($fileName, 'a');
		for($t = 0;$t<count($strjudul);$t++){
			$Data = $strjudul[$t]."\r\n";
			fwrite($Handle, $Data);
		}
		fclose($Handle);
	}


	function print_judul_detail($judul_detail,$tipe_judul_detail)
	{
	?>
		<tr bordercolor="#FFFFFF">
		<?php
		for($t=0;$t<count($judul_detail);$t++){
			if($tipe_judul_detail[$t]=="normal")
			{
				$align = "left";
			}
			else
			{
				$align = "right";
			}
		?>
			<td nowrap="nowrap" align="<?=$align?>"> <font face="Courier New"><?=$judul_detail[$t]; ?></font></td>
	<?php
		}?>
		</tr>
		<tr>
		<td colspan="<?=count($judul_detail)?>" nowrap><font face="Courier New"><hr size='1' noshade></font></td>
		</tr>
		<?php
	}
	function get_max_field_len($max_field_len,$list_detail)
	{
		for($a=0;$a<count($max_field_len);$a++){
			if($max_field_len[$a]<strlen($list_detail[$a]))
			{
				$max_field_len[$a] = strlen($list_detail[$a]);
			}
		}
		return $max_field_len;
	}
function print_judul_detail_kertas_PO($lebar,$max_field_len,$banyakBarang,$fileName,$judul_detail,$tipe_judul_detail){
		$spasi = "";
		$string = "";
		
		if(strlen($banyakBarang) > strlen('NO'))
		{
			$val = strlen($banyakBarang);
		}
		else { $val = strlen('NO'); }

		for($t=0;$t<$val- strlen('NO');$t++){
			$spasi = $spasi.'  ';
		}
		$string = 'No'.$spasi."  ";
		$judul_atas='No'.$spasi."  ";
		$st= ' ';
		for ($bt=0;$bt< count($judul_detail);$bt++){
			$lenjudul = strlen($judul_detail[$bt])."\r\n";
				if( $lenjudul < $lebar[$bt] ){
					$si = $lebar[$bt] - $lenjudul;
					$sisa_spasi	= $this->spasinya($si);
				}else{
					$sisa_spasi = '';
				}

				$lenjudul = strlen($judul_detail[$bt]);
				$lebarkolom = (int)$lebar[$bt];
				if($lebarkolom > $lenjudul) {
					$limitSpasi = $lebarkolom;
				}
				else {
					$limitSpasi = $lenjudul;
				}
				$sisa = $this->spasinya((int)$limitSpasi - (int)strlen($judul_detail[$bt]));
				
				if($tipe_judul_detail[$bt]=="normal"){
					$string .= $judul_detail[$bt].$sisa." ";
				}
					else
				{
					$string .= $sisa.$judul_detail[$bt]." ";
				}
			
			

					//$judul_atas = $judul_atas.$judul_detail[$bt].$sisa_spasi.$st;
		}

		$line = "";
		if($val<80){$val=80;}
			$val =80; // tambahan garis  --- jko
		for($t = 0;$t<$val;$t++){
			$line = $line.'-';
		}	 
		$cond   = chr(15);
		$ncond  = chr(18);
		$Handle = fopen($fileName, 'a');
		$Data = $line."\r\n";
		fwrite($Handle, $Data);
		fwrite($Handle,$cond.$string."\r\n".$ncond);
		fwrite($Handle, $Data);
		fclose($Handle);
		return $line;
	}



	function print_judul_detail_kertas($max_field_len,$banyakBarang,$fileName,$judul_detail,$tipe_judul_detail){
		$spasi = "";
		$string = "";
		if(strlen($banyakBarang) > strlen('NO'))
		{
			$val = strlen($banyakBarang);
		}
		else { $val = strlen('NO'); }

		for($t=0;$t<$val- strlen('NO');$t++){
			$spasi = $spasi.' ';
		}
		$string = 'No'.$spasi."  ";
		for($t=0;$t<count($judul_detail);$t++){
			$len = $max_field_len[$t];
			$lenjudul = strlen($judul_detail[$t]);
			$spasi = '';
			if($len > strlen($judul_detail[$t])) {
				$val = (int)$val + (int)$len + 1;
				$limitSpasi = $len;
			}
			else {
				$val = (int)$val + (int)$lenjudul + 1;
				$limitSpasi = $lenjudul;
			}
			$sisa_spasi = (int)$limitSpasi - (int)$lenjudul;
			for($c=0;$c<$sisa_spasi;$c++){
				$spasi = $spasi . " ";
			}
			if($tipe_judul_detail[$t]=="normal"){
				$string .= $judul_detail[$t].$spasi."  ";
			}
			else
			{
				$string .= $spasi.$judul_detail[$t]."  ";
			}
		}
		$line = "";
		if($val<80){$val=80;}
		for($t = 0;$t<$val;$t++){
			$line = $line.'-';
		}
		$Handle = fopen($fileName, 'a');
		$Data = $line."\r\n";
		fwrite($Handle, $Data);
		fwrite($Handle, $string."\r\n");
		$Data = $line."\r\n";
		fwrite($Handle, $Data);
		fclose($Handle);
		return $line;
	}

	function print_detail($list_detail,$tipe_judul_detail)
	{
		for($t=0;$t<count($list_detail);$t++){ ?>
		<tr bordercolor="#FFFFFF">
		<?php
			$detail = $list_detail[$t];
			for($c=0;$c<count($detail);$c++)
			{
				if($tipe_judul_detail[$c]=="normal")
				{
					$align = "left";
				}
				else
				{
					$align = "right";
				}
			?>
				<td nowrap align="<?=$align?>"><font face="Courier New"><?=$detail[$c]?></font></td>
			<?php
			}
		?>
		<tr>
		<?php 
		}
	}
	function print_detail_kertas($no,$max_field_len,$banyakBarang,$fileName,$list_detail,$tipe_judul_detail,$judul_detail)
	{
		for($t=0;$t<count($list_detail);$t++){
			$detail = $list_detail[$t];

			$spasi = "";
			$string = "";
			$notemp = $no;
			if(strlen($banyakBarang) > strlen('NO')) {
				$limitSpasi = strlen($banyakBarang);
			}
			else {
				$limitSpasi = strlen('NO');
			}
			if($detail[0]=="&nbsp;")
			{
				$no = "";
			}
			else{
				$no = (int)$no+1;
			}
			$sisa = (int)$limitSpasi - (int)strlen($no);
			for($k = 0;$k<$sisa;$k++){
				$spasi .= " ";
			}
			$string = $no.$spasi."  ";
			
			for($c=0;$c<count($detail);$c++)
			{
				if($detail[$c]=="&nbsp;")
				{
					$detail[$c] = "";
				}
				$spasi = "";
				$lenjudul = strlen($judul_detail[$c]);
				
				if($max_field_len[$c] > $lenjudul) {
					$limitSpasi = $max_field_len[$c];
				}
				else {
					$limitSpasi = $lenjudul;
				}
				$sisa = (int)$limitSpasi - (int)strlen($detail[$c]);
				for($k=0;$k<$sisa;$k++){
					$spasi .= " ";
				}
				if($tipe_judul_detail[$c]=="normal"){
					$string .= $detail[$c].$spasi."  ";
				}
				else
				{
					$string .= $spasi.$detail[$c]."  ";
				}
			}
			$cond   =chr(15);
			$ncond  =chr(18);
			$Handle = fopen($fileName, 'a');
			//fwrite($Handle, $cond.$string."\r\n".$ncond);
			fwrite($Handle, $string."\r\n");
			fclose($Handle);
		}

		return $notemp;
	}

function print_detail_kertas_PO($lebar,$no,$max_field_len,$banyakBarang,$fileName,$list_detail,$tipe_judul_detail,$judul_detail,$panjangmax)
	{
		for($t=0;$t<count($list_detail);$t++){
			$detail = $list_detail[$t];

			$spasi = "";
			$string = "";
			$notemp = $no;
			
			$limitSpasi = 4; //limit untuk no;
			
			if($detail[0]=="&nbsp;")
			{
				$no = "";
			}
			else{
				$no = (int)$no+1;
			}
			$sisa = (int)$limitSpasi - (int)strlen($no);
			for($k = 0;$k<$sisa;$k++){
				$spasi .= " ";
			}
			$string = $no.$spasi;

			for($c=0;$c<count($detail);$c++)
			{
				if($detail[$c]=="&nbsp;")
				{
					$detail[$c] = "";
				}
				$spasi = "";
				$lenjudul = strlen($judul_detail[$c]);
				$lebarkolom = (int)$lebar[$c];
				if($lebarkolom > $lenjudul) {
					$limitSpasi = $lebarkolom;
				}
				else {
					$limitSpasi = $lenjudul;
				}
				$sisa = (int)$limitSpasi - (int)strlen($detail[$c]);
				for($k=0;$k<$sisa;$k++){
					$spasi .= " ";
				}
				if($tipe_judul_detail[$c]=="normal"){
					$string .= $detail[$c].$spasi." ";
				}
				else
				{
					$string .= $spasi.$detail[$c]." ";
				}
			}
			$cond   =chr(48);
			$ncond  =chr(50);
			$Handle = fopen($fileName, 'a');
			fwrite($Handle, $cond.$string."\r\n".$ncond);

		}
        $sisabaris = (int)$panjangmax - (int)$banyakBarang;
        for($b=0;$b<$sisabaris;$b++){
            fwrite($Handle,"\r\n");
        }

        fclose($Handle);
		return $notemp;
	}

    function print_footer_cetak_PO($lebar,$notes,$leb_footer,$max_field_len,$fileName,$tipe_judul_detail,$judul_detail,$judul2,$nilai2)
    {
        $ttl_brs 	= "";
        $brs_footer = "";
        $string1		= "";
        $string2		= "";
        $string3		= "";

        for($l=0;$l<count($lebar);$l++){ //hitung baris
            $ttl_brs = $ttl_brs + (int)$lebar[$l];
        }
        for($k=0; $k < count($leb_footer);$k++){ // hitung baris footer
            $brs_footer = $brs_footer + (int)$leb_footer[$k];
        }
        //echo $ttl_brs ."||". $brs_footer."||";
        $brs_kosong = $ttl_brs - $brs_footer;
        $spaceno = $this->spasinya(6);
        $tp = $spaceno.$this->spasinya($brs_kosong);

        $tipe_judul_detail = array("normal","kanan","kanan");

        $strjudul = array();
        for($t=0;$t<count($judul2);$t++){


            $sisa1 = $this->spasinya((int)$leb_footer[0] - (int)strlen($judul2[$t]));
            $string1 = $judul2[$t].$sisa1."  ";
            // ------- :---
            $sisa2 = $this->spasinya((int)$leb_footer[1] - 1);
            $string2 = $sisa2.':'." ";
            // -----
            $sisa3 = $this->spasinya((int)$leb_footer[2] - (int)strlen($nilai2[$t]));
            $string3 = $sisa3.$nilai2[$t]."  ";

            $strjudul[] = $string1.$string2.$string3;
        }

        $cond   = chr(15);
        $ncond  = chr(18);

        $garis = '';
        $panjang = 80;
        for($z=0;$z < $panjang; $z++){
            $garis = $garis.'=';
        }

        $Handle = fopen($fileName, 'a');
        fwrite($Handle,$garis."\r\n");
        for($t = 0;$t<count($strjudul);$t++){
            $Data = $tp.$strjudul[$t]."\r\n";
//			fwrite($Handle, $Data);
            fwrite($Handle, $cond.$Data.$ncond);
        }
        fclose($Handle);
    }

function print_footer_cetak_keuangan($lebar,$leb_footer,$max_field_len,$fileName,$tipe_judul_detail,$judul_detail,$judul2,$nilai2)
	{
		$ttl_brs 	= "";
		$brs_footer = "";
		$string1		= "";
		$string2		= "";
		$string3		= "";

		for($l=0;$l<count($lebar);$l++){ //hitung baris 
			$ttl_brs = $ttl_brs + (int)$lebar[$l];
		}
		for($k=0; $k < count($leb_footer);$k++){ // hitung baris footer
			$brs_footer = $brs_footer + (int)$leb_footer[$k];
		}

		$brs_kosong = $ttl_brs - $brs_footer;
		$spaceno = $this->spasinya(6);
		$tp = $spaceno.$this->spasinya($brs_kosong);
		
		$tipe_judul_detail = array("normal","kanan","kanan");
		
		$strjudul = array();
		for($t=0;$t<count($judul2);$t++){

			$sisa1 = $this->spasinya((int)$leb_footer[0] - (int)strlen($judul2[$t]));
			$string1 = $judul2[$t].$sisa1."  "; // ------- :---
			$sisa2 = $this->spasinya((int)$leb_footer[1] - 1);
			$string2 = $sisa2.':'." ";
			$sisa3 = $this->spasinya((int)$leb_footer[2] - (int)strlen($nilai2[$t]));
			$string3 = $sisa3.$nilai2[$t]."  ";
			
			$strjudul[] = $string1.$string2.$string3;
		}

		$cond   = chr(15);
		$ncond  = chr(18);
		
		$garis = '';
		$panjang = 80;
		for($z=0;$z < $panjang; $z++){
			$garis = $garis.'=';
		}	
		
		$Handle = fopen($fileName, 'a');
		fwrite($Handle,"\r\n".$garis."\r\n");
		for($t = 0;$t<count($strjudul);$t++){
			$Data = $tp.$strjudul[$t]."\r\n";
			fwrite($Handle, $cond.$Data.$ncond);
		}
		fclose($Handle);
	}

function print_footer($tot_hal,$footer1,$footer2,$colspan1)
	{
		$tot_hal1 = "";
		for($s=0;$s<3-strlen($tot_hal);$s++)
		{
			$tot_hal1 .= "0";
		}
		$tot_hal = $tot_hal1.$tot_hal;
	?>
		<tr><td colspan="<?=$colspan1;?>"><hr size='1' noshade></td></tr>
	<?php
		if($footer1!=""){
			for($t = 0;$t<count($footer1);$t++){ ?>
				
				<tr bordercolor="#000" style='font-weight:bold;'>
					<td colspan="<?=$colspan1-3;?>"></td>
					<td nowrap="nowrap"  width = "3%" align='left'>
						<font face="Calibri" size="3"><?php echo $footer1[$t]; ?></font>
					</td>
					<td colspan >:</td>
					<td nowrap="nowrap"  align="right" width = "25%">
						<font face="Calibri" size="3"> <?php echo $footer2[$t]; ?> </font>
					</td>
				</tr>
		<?php
			}
		}
	}
	


	function print_footer_lama($colspan,$hal,$tot_hal)
	{
		$hal1 = "";
		for($s=0;$s<3-strlen($hal);$s++)
		{
			$hal1 .= "0";
		}
		$hal = $hal1.$hal;
		$tot_hal1 = "";
		for($s=0;$s<3-strlen($tot_hal);$s++)
		{
			$tot_hal1 .= "0";
		}
		$tot_hal = $tot_hal1.$tot_hal;
	?>
	<tr>
	<td colspan="<?=$colspan?>" nowrap>
		<font face="Courier New"><hr size='1' noshade>
		</font>
	</td>
	</tr>
<!--	<tr>
	<td colspan="<?=$colspan?>" nowrap>
		<font face="Courier New">Hal : <?=$hal."/".$tot_hal."-" .date("dmY-His");?>
		</font>
	</td>
	</tr> -->
	<?php
	}
	
	function print_footer_cetak($line,$fileName,$hal,$tot_hal,$nfontstyle)
	{
			$hal1 = "";
			for($s=0;$s<3-strlen($hal);$s++)
			{
				$hal1 .= "0";
			}
			$hal = $hal1.$hal;
			$tot_hal1 = "";
			for($s=0;$s<3-strlen($tot_hal);$s++)
			{
				$tot_hal1 .= "0";
			}
			$tot_hal = $tot_hal1.$tot_hal;
			$Handle = fopen($fileName, 'a');
			$cond   =chr(15);
			$ncond  =chr(18);
			//fwrite($Handle,$cond.$line.$nfontstyle.$ncond);
			fwrite($Handle,$line.$nfontstyle);
	}

	function spasiBanyak($b){ // lenght
		$spasi	= '';
		for($a=0; $a < strlen($b);$a++){
			$spasi = $spasi.' ';
		}
		return $spasi;
	}
	function spasinya($b){
		$spasi	= '';
		for($a=0; $a < $b;$a++){
			$spasi = $spasi.' ';
		}
		return $spasi;
	}
	function print_footer_cetakPO($judul1,$nilai1,$line,$fileName,$hal,$tot_hal,$judul2,$nilai2,$nfontstyle)
	{
		$lenjudul1 = 0;
		$lenjudul2 = 0;
		$lennilai1 = 0;
		$lennilai2 = 0;
		$spasi = '';
		for($t = 0;$t<count($judul1);$t++){  //cari paling besar
			$len = strlen($judul1[$t]);
			if($len > $lenjudul1) $lenjudul1 = $len;
			else{
				$lenjudul1 = $lenjudul1;
			}
		}
		for($t = 0;$t<count($judul1);$t++){ //tambahin spasi
			$spasi = '';
			for($i=0;$i<=($lenjudul1 - strlen($judul1[$t]));$i++){
				$spasi = $spasi.' ';
			}
			//$judul1[$t] = $judul1[$t].$spasi.':';
			$judul1[$t] = $this->spasiBanyak($judul1[$t]).$spasi.' ';
			$strjudul[] = $judul1[$t];
		}


		for($t = 0;$t<count($nilai1);$t++){  //cari paling besar nilai
			$len = strlen($nilai1[$t]);
			if($len > $lennilai1) $lennilai1 = $len;
			else{
				$lennilai1 = $lennilai1;
			}
		}

		for($t = 0;$t<count($nilai1);$t++){ //tambahin spasi
			$spasi = '';
			for($i=0;$i<=($lennilai1 - strlen($nilai1[$t]));$i++){
				$spasi = $spasi.' ';
			}
			$nilai1[$t] = $nilai1[$t].$spasi."\t";
			//$strjudul[$t] = $strjudul[$t].$nilai1[$t];
			$strjudul[$t] = $strjudul[$t].$this->spasiBanyak($nilai1[$t]);
		}

		////nilai n judul ke 2
		if(isset($judul2)&&$judul2!=""){
			for($t = 0;$t<count($judul2);$t++){  //cari paling besar
				$len = strlen($judul2[$t]);
				if($len > $lenjudul2) $lenjudul2 = $len;
				else{
					$lenjudul2 = $lenjudul2;
					}
			}
			for($t = 0;$t<count($judul2);$t++){ //tambahin spasi
				$spasi = '';
				for($i=0;$i<=($lenjudul2 - strlen($judul2[$t]));$i++){
					$spasi = $spasi.' ';
				}
				$judul2[$t] = $judul2[$t].$spasi.':';
				$strjudul[$t] = $strjudul[$t].$judul2[$t];
			}



			for($t = 0;$t<count($nilai2);$t++){  //cari paling besar nilai
				$len = strlen($nilai2[$t]);
				if($len > $lennilai2) $lennilai2 = $len;
				else{
					$lennilai2 = $lennilai2;
				}
			}
			for($t = 0;$t<count($nilai2);$t++){ //tambahin spasi
				$spasi = '';
				for($i=0;$i<=($lennilai2 - strlen($nilai2[$t]));$i++){
					$spasi = $spasi.' ';
				}
				$nilai2[$t] = $nilai2[$t].$spasi."\t";

				$strjudul[$t] = $strjudul[$t].$nilai2[$t];
			}
		}
		$garis = '';
		$panjang = 80;
		for($z=0;$z < $panjang; $z++){
			$garis = $garis.'=';
		}	
		$cond   = chr(15);
		$ncond  = chr(18);
		$Data = $line."\r\n";
		$Handle = fopen($fileName, 'a');
		fwrite($Handle,$cond.$garis."\r\n".$ncond);
		//fwrite($Handle, $Data);
		
		for($t = 0;$t<count($strjudul);$t++){
			$Data = $cond.$strjudul[$t]."\r\n".$ncond;
			fwrite($Handle, $Data);
		}
		fclose($Handle);
	}

	function persetujuan($string,$string2,$FileName){
		$Handle = fopen($FileName, 'a');
		$Data = "\r\n\r\n".$string;
		fwrite($Handle, $Data);

		$Data = "\r\n\r\n\r\n\r\n\r\n".$string2;
		fwrite($Handle, $Data);
		fclose($Handle);
	}
	function persetujuan_sj($string,$string2,$string3,$FileName){
		$Handle = fopen($FileName, 'a');
		$Data = "\r\n\r\n".$string;
		fwrite($Handle, $Data);
		$Data = "\r\n".$string2;
		fwrite($Handle, $Data);
		$Data  = "\r\n                             ".chr(15)."   tidak dapat ditukar/dikembalikan.".chr(18);
		$Data .= "\r\n                             ".chr(15)."2. Klaim hanya dilayani dalam waktu 3(tiga) hari".chr(18);
		$Data .= "\r\n                             ".chr(15)."   setelah barang diterima.".chr(18);
		$Data .= "\r\n                             ".chr(15)."3. Ongkos kuli dibayar oleh penerima barang".chr(18);
		$Data .="\r\n\r\n".$string3;
		fwrite($Handle, $Data);
		fclose($Handle);
	}

	function persetujuanPO($string1,$string2,$string3,$note1,$note2,$keterangan,$fileName,$spasienter){
		$spasi05=chr(27)."3".chr(16);
		$spasi1 =chr(27)."3".chr(24);
		$Handle = fopen($fileName, 'a');
		$Data = "\r\n\r\n".$string1.$spasi05.$string2.$spasienter;
		fwrite($Handle, $Data);
		$Data = "\r\n".$string3.$spasi05.$string3;
		fwrite($Handle, $Data);
		$Data  = "\r\n   ".chr(15)."nb :" .chr(18);
		$Data  = "\r\n   ".chr(15).$note1.chr(18);
		$Data .= "\r\n   ".chr(15).$note2.chr(18);	
		fwrite($Handle, $Data);
		fclose($Handle);
	}
	function findSatuanQtyCetak($qty,$konverbk,$konvertk,$satb,$satt,$satk)
	{
		$jmlhbesar = 0;
		$jmlhtengah = 0;
		$jmlhkecil = $qty;
		$konvlain = (int)$konverbk / (int)$konvertk;
		if($jmlhkecil >= $konverbk ){
			$jmlhbesar =  (int)$jmlhbesar + (int)floor((int)$jmlhkecil / (int)$konverbk);
			$sisa = (int)$jmlhkecil % (int)$konverbk;
			if($sisa >= $konvertk){
				$jmlhtengah = (int)$jmlhtengah + floor((int)$sisa / (int)$konvertk);
				$jmlhkecil = (int)$sisa % (int)$konvertk;
			}
			else{
				$jmlhkecil =  $sisa;
			}
		}
		if($jmlhkecil >= $konvertk){
			$jmlhtengah = (int)$jmlhtengah + floor((int)$jmlhkecil / (int)$konvertk);
			$jmlhkecil = (int)$jmlhkecil % (int)$konvertk;
		}
		if($jmlhtengah >= $konvlain){
			$jmlhbesar = (int)$jmlhbesar + floor((int)$jmlhtengah / (int)$konvlain);
			$jmlhtengah = (int)$jmlhtengah % (int)$konvlain;
		}
		$hasil = "";
		if($jmlhbesar>0)
		{
			$hasil .= $jmlhbesar." ".$satb;
		}
		if($jmlhtengah>0)
		{
			if(isset($hasil)&&$hasil!="")
			{
				$hasil .= " ";
			}
			$hasil .= $jmlhtengah." ".$satt;
		}
		if($jmlhkecil>0)
		{
			if(isset($hasil)&&$hasil!="")
			{
				$hasil .= " ";
			}
			$hasil .= $jmlhkecil." ".$satk;
		}
		return $hasil;
	}
	function findQtyJual($pcode,$qty,$konverjk,$konverbk,$konvertk,$satuan)
	{
		if($satuan=="B")
		{
			$qty = (int)$konverbk * (int)$qty;
		}
		else if($satuan=="T")
		{
			$qty = (int)$konvertk * (int)$qty;
		}
		else if($satuan=="K")
		{
			$qty = $qty;
		}
		if($konverjk==1)
		{
			$nilai = $qty.".0";
		}
		else
		{
			if((int)$qty>=(int)$konverjk)
			{
				$karton = floor((int)$qty / (int)$konverjk);
				$sisa = (int)$qty % (int)$konverjk;
				$nilai = $karton.".".$sisa;
			}
			else
			{
				$nilai = "0.".$qty;
			}
		}
		return $nilai;
	}
        
        //update by urwanto on mei 16
        
        function PrintJudul_new($judul, $command, $fileName, $fontstyle, $spasienter) {
            if (empty($getPT)) {
                $getPT = $this->getNamaPT();
            }
            if ($command == "w") {
                $Data = chr(27) . chr(64) . chr(27) . chr(67) . chr(33) . $fontstyle . chr(27) . chr(69) . $getPT->Nama . "\r\n";
            } else {
                $Data = $spasienter . chr(27) . chr(64) . chr(27) . chr(67) . chr(33) . $fontstyle . chr(27) . chr(69) . $getPT->Nama . "\r\n";
            }
            $Data .= "NPWP : " . $getPT->NPWP . "\r\n";
            $Data .= $getPT->Alamat1 . "\r\n";
            $Data .= $getPT->Alamat2 . "\r\n";
            $Data .= $getPT->Kota . "\r\n";
            //$Data .= "\t\t\t\t" . $judul . chr(27) . chr(70) . "\r\n";
            $Data .= chr(27).chr(69)."\t\t\t\t\t\t\t".$judul.chr(27).chr(70)."\r\n";
            $Handle = fopen($fileName, $command);
            fwrite($Handle, $Data);
            fclose($Handle);
    }

    function subjudultabel_print_new($judul1, $nilai1, $judul2, $nilai2, $fileName) {
        $lenjudul1 = 0;
        $lenjudul2 = 0;
        $lennilai1 = 0;
        $lennilai2 = 0;
        $spasi = '';
        for ($t = 0; $t < count($judul1); $t++) {  //cari paling besar
            $len = strlen($judul1[$t]);
            if ($len > $lenjudul1)
                $lenjudul1 = $len;
            else {
                $lenjudul1 = $lenjudul1;
            }
        }
        for ($t = 0; $t < count($judul1); $t++) { //tambahin spasi
            $spasi = '';
            for ($i = 0; $i <= ($lenjudul1 - strlen($judul1[$t])); $i++) {
                $spasi = $spasi . ' ';
            }
            $judul1[$t] = $judul1[$t] . $spasi . ':';
            $strjudul[] = $judul1[$t];
        }

        for ($t = 0; $t < count($nilai1); $t++) {  //cari paling besar nilai
            $len = strlen($nilai1[$t]);
            if ($len > $lennilai1)
                $lennilai1 = $len;
            else {
                $lennilai1 = $lennilai1;
            }
        }

        for ($t = 0; $t < count($nilai1); $t++) { //tambahin spasi
            $spasi = '';
            for ($i = 0; $i <= ($lennilai1 - strlen($nilai1[$t])); $i++) {
                $spasi = $spasi . ' ';
            }
            $nilai1[$t] = $nilai1[$t] . $spasi . "\t\t\t\t\t";
            $strjudul[$t] = $strjudul[$t] . $nilai1[$t];
        }

        ////nilai n judul ke 2
        if (isset($judul2) && $judul2 != "") {
            for ($t = 0; $t < count($judul2); $t++) {  //cari paling besar
                $len = strlen($judul2[$t]);
                if ($len > $lenjudul2)
                    $lenjudul2 = $len;
                else {
                    $lenjudul2 = $lenjudul2;
                }
            }
            for ($t = 0; $t < count($judul2); $t++) { //tambahin spasi
                $spasi = '';
                for ($i = 0; $i <= ($lenjudul2 - strlen($judul2[$t])); $i++) {
                    $spasi = $spasi . ' ';
                }
                $judul2[$t] = $judul2[$t] . $spasi . ':';
                $strjudul[$t] = $strjudul[$t] . $judul2[$t];
            }

            for ($t = 0; $t < count($nilai2); $t++) {  //cari paling besar nilai
                $len = strlen($nilai2[$t]);
                if ($len > $lennilai2)
                    $lennilai2 = $len;
                else {
                    $lennilai2 = $lennilai2;
                }
            }
            for ($t = 0; $t < count($nilai2); $t++) { //tambahin spasi
                $spasi = '';
                for ($i = 0; $i <= ($lennilai2 - strlen($nilai2[$t])); $i++) {
                    $spasi = $spasi . ' ';
                }
                $nilai2[$t] = $nilai2[$t] . $spasi . "\t\t\t\t\t";

                $strjudul[$t] = $strjudul[$t] . $nilai2[$t];
            }
        }

        $Handle = fopen($fileName, 'a');
        for ($t = 0; $t < count($strjudul); $t++) {
            $Data = chr(27).chr(69).$strjudul[$t] . "\r\n";
            fwrite($Handle, $Data);
        }
        fclose($Handle);
    }

    function print_judul_detail_kertas_new($max_field_len, $banyakBarang, $fileName, $judul_detail, $tipe_judul_detail) {
        $spasi = "";
        $string = "";
        if (strlen($banyakBarang) > strlen('NO')) {
            $val = strlen($banyakBarang);
        } else {
            $val = strlen('NO');
        }

        for ($t = 0; $t < $val - strlen('NO'); $t++) {
            $spasi = $spasi . ' ';
        }
        $string = 'No' . $spasi . "  ";
        for ($t = 0; $t < count($judul_detail); $t++) {
            $len = $max_field_len[$t];
            $lenjudul = strlen($judul_detail[$t]);
            $spasi = '';
            if ($len > strlen($judul_detail[$t])) {
                $val = (int) $val + (int) $len + 1;
                $limitSpasi = $len;
            } else {
                $val = (int) $val + (int) $lenjudul + 1;
                $limitSpasi = $lenjudul;
            }
            $sisa_spasi = (int) $limitSpasi - (int) $lenjudul;
            for ($c = 0; $c < $sisa_spasi; $c++) {
                $spasi = $spasi . " ";
            }
            if ($tipe_judul_detail[$t] == "normal") {
                $string .= $judul_detail[$t] . $spasi . "  ";
            } else {
                $string .= $spasi . $judul_detail[$t] . "  ";
            }
        }
//        $line = "";
//        if ($val < 80) {
//            $val = 80;
//        }
//        $val = 80; // tambahan garis  --- jko
//        for ($t = 0; $t < $val; $t++) {
//            $line = $line . '-';
//        }
//        $Handle = fopen($fileName, 'a');
//        $Data = $line . "\r\n";
//        fwrite($Handle, $Data);
//        fwrite($Handle, $string . "\r\n");
//        $Data = $line . "\r\n";
//        fwrite($Handle, $Data);
//        fclose($Handle);
//        return $line;
        
        $line = "";
        if ($val < 110) {
            $val = 110;
        }
        $val = 110; // tambahan garis  --- jko
        for ($t = 0; $t < $val; $t++) {
            $line = $line . '-';
        }
        $cond = chr(15);
        $ncond = chr(18);
        $Handle = fopen($fileName, 'a');
        $Data = $line . "\r\n";
        fwrite($Handle, $Data);
        //fwrite($Handle, $cond . $string . "\r\n" . $ncond);
        fwrite($Handle, $string . "\r\n");
        fwrite($Handle, $Data);
        fclose($Handle);
        return $line;
    }

    function print_detail_kertas_new($no, $max_field_len, $banyakBarang, $fileName, $list_detail, $tipe_judul_detail, $judul_detail) {
        for ($t = 0; $t < count($list_detail); $t++) {
            $detail = $list_detail[$t];

            $spasi = "";
            $string = "";
            $notemp = $no;
            if (strlen($banyakBarang) > strlen('NO')) {
                $limitSpasi = strlen($banyakBarang);
            } else {
                $limitSpasi = strlen('NO');
            }
            if ($detail[0] == "&nbsp;") {
                $no = "";
            } else {
                $no = (int) $no + 1;
            }
            $sisa = (int) $limitSpasi - (int) strlen($no);
            for ($k = 0; $k < $sisa; $k++) {
                $spasi .= " ";
            }
            $string = $no . $spasi . "  ";

            for ($c = 0; $c < count($detail); $c++) {
                if ($detail[$c] == "&nbsp;") {
                    $detail[$c] = "";
                }
                $spasi = "";
                $lenjudul = strlen($judul_detail[$c]);

                if ($max_field_len[$c] > $lenjudul) {
                    $limitSpasi = $max_field_len[$c];
                } else {
                    $limitSpasi = $lenjudul;
                }
                $sisa = (int) $limitSpasi - (int) strlen($detail[$c]);
                for ($k = 0; $k < $sisa; $k++) {
                    $spasi .= " ";
                }
                if ($tipe_judul_detail[$c] == "normal") {
                    $string .= $detail[$c] . $spasi . "  ";
                } else {
                    $string .= $spasi . $detail[$c] . "  ";
                }
            }
            $cond = chr(15);
            $ncond = chr(18);
            $Handle = fopen($fileName, 'a');
            //fwrite($Handle, $cond.$string."\r\n".$ncond);
            fwrite($Handle, $string . "\r\n");
            fclose($Handle);
            
        }

        return $notemp;
    }

}
?>