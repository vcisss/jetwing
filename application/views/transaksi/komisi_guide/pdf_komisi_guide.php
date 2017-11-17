<?php
$mylib = new globallib();
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
                            <td width="150"><?= $results[0]['NamaTourGuide']; ?></td>

                        </tr>
                    </table>
                </td>
                <td></td>
            </tr>
            
        </table>
        <br>
        
        <table width="100%" align="center" border="1" cellpadding="0" cellspacing="0" class="border-table" >
                        <tr>
                            <th width="20">No</th>
                            <th width="100">No. Struk</th>
                            <th>Nama</th>
							<th width="100">Qty</th>
							<th width="100">Harga</th>
							<th width="100">Discount</th>
							<th width="100">Komisi Guide %</th>
							<th width="100">Komisi (Rp)</th>
                        </tr>
                        
                        <?php 
                        $no=1;
                        $totkomisi=0;
                        foreach($getDetail AS $val){?>
                        <tr>
                        <td align="center"><?=$no;?></td>
                        <td align="center"><?=$val['NoStruk'];?></td>
                        <td align="left"><?=$val['Nama'];?></td>  
                        <td align="center"><?=$val['Qty'];?></td>  
                        <td align="right"><?=number_format($val['Harga']);?></td> 
                        <td align="right"><?=number_format(($val['Harga']*$val['Disc_Pers']/100)-$val['Disc']);?></td> 
                        <td align="right"><?=$val['komisi_guide'];?></td>
                        <td align="right"><?=number_format($val['Komisi']);?></td>
                        </tr>
                        <?php
                        $totkomisi+=$val['Komisi'];
                        $no++;
                        } ?>
                        
                        <tr>
                        	<td colspan="7"><b>Total Komisi</b></td>
                        	<td align="right"><b><?=number_format($totkomisi);?></b></td>
                        </tr>
                    </table>


</body>
</html>