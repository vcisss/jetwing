<?php
$mylib = new globallib();
$this->load->helper('terbilang');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cetak Reservasi</title>
    </head>
	<style>
		.border-table{
			border: 1px solid #191919;
			font-family: serif;
			border-collapse: collapse;
			font-size: 7.5pt;
		}
		
		.non-border-table{
			font-family: serif;
			border-collapse: collapse;
			font-size: 7.5pt;
		}
		
	</style>
    <body>
        <table  width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="non-border-table">
            <tr>
                <td colspan="5" align="center"><img src="<?= base_url(); ?>public/images/holidays.png" width="120" alt="Jetwings"/></td>
            </tr>
            <tr>
                <td colspan="5" align="center"><b><hr></b></td>
            </tr>
            <tr>
                <td width="300" align="center" colspan="5"></td>
            </tr>
            <br><br>
            <tr>
                <td colspan="2">
                    <table width="50%" align="center" border="0" cellpadding="0" cellspacing="0" >
                    <tr>
                            <td width="100"><b>KOMISI TOUR GUIDE</b></td>
                            <td width="1"></td>
                            <td width="150"></td>

                        </tr>
                                                
                        <tr>
                            <td width="100">No. Transaksi</td>
                            <td width="1">:</td>
                            <td width="150"><?= $results[0]['NoTransaksi']; ?></td>

                        </tr>
                        
                        <tr>
                            <td width="100">Tanggal</td>
                            <td width="1">:</td>
                            <td width="150"><?= $mylib->ubah_tanggal($results[0]['Tanggal']); ?></td>

                        </tr>
                        
                        <tr>
                            <td width="100">Nama Guide</td>
                            <td width="1">:</td>
                            <td width="150"><?= $results[0]['Nama']; ?></td>

                        </tr>
                    </table>
                </td>
                <td></td>
            </tr>
            
        </table>
        <br>
        
        <table width="100%" align="center" border="1" cellpadding="0" cellspacing="0" class="border-table" >
                        <tr>
                            <th rowspan="2" width="20">No</th>
                            <th rowspan="2">Nama</th>
							<th rowspan="2" width="20">Qty</th>
							<th rowspan="2" width="80">Harga</th>
							<!--<th rowspan="2" width="80">Total</th>-->
							<th colspan="2">Diskon</th>
							<th colspan="3">Komisi %</th>
							<th colspan="3">Komisi (Rp)</th>
                        </tr>
                        
                        <tr>
                            <th width="30">Rp</th>
                            <th width="30">%</th>
                            <th width="30">TG</th>
                            <th width="30">TL</th>
                            <th width="30">DRV</th>
                            <th width="80">TG</th>
                            <th width="80">TL</th>
                            <th width="80">DRV</th>
                        </tr>
                        
                        
                        <?php 
                        $no=1;
                        $totkomisitg=0;
                        $totkomisitl=0;
                        $totkomisidrv=0;
                        foreach($getDetail AS $val){?>
                        <tr>
                        <td align="center"><?=$no;?></td>
                        <td align="left"><?=$val['NamaBarang'];?></td>  
                        <td align="center"><?=$val['Qty'];?></td>  
                        <td align="right"><?=number_format($val['Harga']);?></td> 
                        <!--<td align="right"><?=number_format($val['Harga']*$val['Qty']);?></td>--> 
                        
                        <td align="right"><?=number_format($val['Disc_Pers']);?></td> 
                        <td align="right"><?=number_format($val['Disc']);?></td>
                        
                        <td align="right"><?=$val['komisitg'];?></td>
                        <td align="right"><?=$val['komisitl'];?></td>
                        <td align="right"><?=$val['komisidrv'];?></td>
                        
                        <td align="right"><?=number_format($val['tot_komisi_tg']);?></td> 
                        <td align="right"><?=number_format($val['tot_komisi_tl']);?></td> 
                        <td align="right"><?=number_format($val['tot_komisi_drv']);?></td> 
                        
                        </tr>
                        <?php
                        $totkomisitg+=$val['tot_komisi_tg'];
                        $totkomisitl+=$val['tot_komisi_tl'];
                        $totkomisidrv+=$val['tot_komisi_drv'];
                        $no++;
                        } ?>
                        
                        <tr>
                        	<td colspan="9"><b>Total Komisi</b></td>
                        	<td align="right"><b><?=number_format($totkomisitg);?></b></td>
                        	<td align="right"><b><?=number_format($totkomisitl);?></b></td>
                        	<td align="right"><b><?=number_format($totkomisidrv);?></b></td>
                        </tr>
                        <!--<tr>
                        	<td colspan="11"><b>Terbilang &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo terbilang($totkomisi)." Rupiah"; ?></b></td>
                        </tr>-->
                    </table>


</body>
</html>