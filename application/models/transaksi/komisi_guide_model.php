<?php
class Komisi_guide_model extends CI_Model {
	
    function __construct(){
        parent::__construct();
        $this->load->library('globallib');
        $this->load->model('globalmodel');
    }
    
    function getArrayGudang($arrdata)
    {
    	$where = "";
    	if(count($arrdata)*1>0)
    	{
			$where= $arrdata;	
		}
		
    	$sql = "
    		SELECT 
			  gudang.KdGudang,
			  gudang.Keterangan 
			FROM
			  gudang 
			WHERE 
			  1
			  ".$where." 
			ORDER BY 
			  gudang.Keterangan ASC
		";
		
		return $this->getArrayResult($sql);
	}
	
	function getGroupTour()
    {
    	$sql = "
    		SELECT * FROM tourguide;
		";
		
		return $this->getArrayResult($sql);
	}
	
	function getData()
    {
    	$sql = "
    		SELECT 
			  a.`Tanggal`,
			  a.`NoTransaksi`,
			  a.`PelangganID`,
			  c.`NamaTourGuide`,
			  a.`Total_Komisi` 
			FROM
			  `komisiguide_header` a 
			  INNER JOIN `tourguide` c 
			    ON a.`PelangganID` = c.`KdTourGuide` 
			WHERE 1;
		";
		
		return $this->getArrayResult($sql);
	}
	
	function getdataheader($id)
    {
    	$sql = "
    		SELECT * FROM komisiguide_header a INNER JOIN tourguide b ON a.PelangganID = b.KdTourGuide
    		WHERE a.NoTransaksi='$id';
		";
		
		return $this->getRow($sql);
	}
	
	function getArrayCurrency()
    {
    	$sql = "
    		SELECT 
			  mata_uang.Kd_Uang, 
			  mata_uang.Keterangan 
			FROM
			  mata_uang 
			WHERE 1 
			ORDER BY mata_uang.id ASC
		";
		
		return $this->getArrayResult($sql);
	}

    function getDataKomisi($guide, $tgl)
    {
    	$mylib = new globallib();
    	
    	//cek apakah penjualanID tersebut sudah ada dengan PelangganID dan Tanggal Tersebut
		$cek = $this->globalmodel->getQuery("
												  a.`PelangganID`,
												  a.`Tanggal`,
												  b.`PenjualanID` 
												FROM
												  `komisiguide_header` a 
												  INNER JOIN `komisiguide_detail` b 
												    ON a.`NoTransaksi` = b.`NoTrans` 
												WHERE a.`PelangganID` = '$guide' 
												  AND a.`Tanggal` = '$tgl' ;
											");
			
		$in="";
		if(count($cek)>0){
			for($x=0 ; $x < count($cek) ; $x++){
				if(($x+1)==count($cek)){
				$koma="";	
				}else{
				$koma=",";		
				}
				$in.="'".$cek[$x]['PenjualanID']."'".$koma;
			}
			$where_in = " AND b.`PenjualanID` NOT IN ($in)";
		}else{
		$where_in = "";	
		}
		//echo $where_in;die;
        
		$sql="
		SELECT 
		  b.`PenjualanID`,
		  b.`Tanggal`,
		  a.`NoStruk`,
		  c.`Nama`,
		  b.`Qty`,
		  b.`Harga`,
		  b.`Disc_Pers`,
		  b.Disc,
		  d.Komisi AS komisi_guide,
		  ROUND(
		    (
		      b.`Harga` - (b.`Harga` * b.`Disc_Pers` / 100) - b.`Disc`
		    ) * d.`Komisi` / 100
		  ) AS Komisi 
		FROM
		  `penjualan_header` a 
		  INNER JOIN `penjualan_detail` b 
		    ON a.`PenjualanID` = b.`PenjualanID` 
		  INNER JOIN `stock` c 
		    ON b.`StockID` = c.`StockID` 
		  INNER JOIN komisi d 
		    ON c.`StockID` = d.`StockID` 
		WHERE a.`PelangganID` = '$guide' 
		  AND a.`Tanggal` = '$tgl' 
		   $where_in;
		";
		
		//echo $sql;
		return $this->getArrayResult($sql);	
	}
	
	function getCekTransaksi($guide, $tgl)
    {
    	$mylib = new globallib();
        
		$sql="
		SELECT 
			  a.`PelangganID`,
			  a.`Tanggal`,
			  b.`PenjualanID` 
			FROM
			  `komisiguide_header` a 
			  INNER JOIN `komisiguide_detail` b 
			    ON a.`NoTransaksi` = b.`NoTrans` 
			WHERE a.`PelangganID` = '$guide' 
			  AND a.`Tanggal` = '".$mylib->ubah_tanggal($tgl)."' ;
		";
		return $this->getArrayResult($sql);	
	}
	
	 function getGuide($guide)
	{
    	$sql = "SELECT * FROM tourguide WHERE NamaTourGuide LIKE '%".$guide."%' ORDER BY NamaTourGuide ASC";
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }
	
	function getArrayDetail($arrdata)
	{
		$where = "";
		if($arrdata)
		{
			$where = $arrdata;
		}
		
		$sql = "
			SELECT 
			  trans_order_barang_detail.*,
			  masterbarang.NamaLengkap as nama_barang
			FROM
			  trans_order_barang_detail 
			  INNER JOIN masterbarang 
			    ON trans_order_barang_detail.PCode = masterbarang.PCode 
			WHERE 
			  1 
			  ".$where."
			ORDER BY trans_order_barang_detail.Sid DESC
		";
		
		return $this->getArrayResult($sql);	
	}
	
	function getHeader($NoTransaksi) {
        $sql = "
			SELECT * FROM komisiguide_header a INNER JOIN tourguide b ON a.PelangganID = b.KdTourGuide WHERE a.NoTransaksi='$NoTransaksi'";
        return $this->getArrayResult($sql);
        //return $this->getRow($sql);
    }
    
    function getDetailKomisi($NoTransaksi) {
        $sql = "
					SELECT 
					  b.`PenjualanID`,
					  b.`Tanggal`,
					  a.`NoStruk`,
					  c.`Nama`,
					  b.`Qty`,
					  b.`Harga`,
					  b.`Disc_Pers`,
					  b.Disc,
					  d.Komisi AS komisi_guide,
					  ROUND(
					    (
					      b.`Harga` - (b.`Harga` * b.`Disc_Pers` / 100) - b.`Disc`
					    ) * d.`Komisi` / 100
					  ) AS Komisi 
					FROM
					  `penjualan_header` a 
					  INNER JOIN `penjualan_detail` b 
					    ON a.`PenjualanID` = b.`PenjualanID` 
					  INNER JOIN `stock` c 
					    ON b.`StockID` = c.`StockID` 
					  INNER JOIN komisi d 
					    ON c.`StockID` = d.`StockID` 
					  INNER JOIN komisiguide_detail e 
					    ON a.`PenjualanID` = e.`PenjualanID`
					  INNER JOIN komisiguide_header f 
					  ON e.`NoTrans` = f.`NoTransaksi`
					WHERE e.NoTrans='$NoTransaksi' GROUP BY b.id;
			   ";
        return $this->getArrayResult($sql);
        //return $this->getRow($sql);
    }
    
	function locktables($table)
	{
		$this->db->simple_query("LOCK TABLES $table");
	}

	function unlocktables()
	{
		$this->db->simple_query("UNLOCK TABLES");
	}
	
	function getRow($sql)
	{
		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
	
	function getArrayResult($sql)
	{
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
	}
	
	function NumResult($sql)
	{
		$qry = $this->db->query($sql);
        $num = $qry->num_rows();
        $qry->free_result();
        return $num;
	}
}
?>