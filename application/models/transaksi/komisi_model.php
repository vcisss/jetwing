<?php
class Komisi_model extends CI_Model {
	
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
	
	function getTourLeader()
    {
    	$sql = "SELECT * FROM tourleader";
		
		return $this->getArrayResult($sql);
	}
	
	function getGroupTour()
    {
    	$sql = "
		    		SELECT 
					  a.`Guide_id`,
					  a.`Nama` AS NamaGuide,
					  a.`Tour_id`,
					  b.`Nama` AS NamaTour 
					FROM
					  guide a 
					  INNER JOIN tour b 
					    ON a.`Tour_id` = b.`Tour_id` 
					WHERE 1;
		        ";
		
		return $this->getArrayResult($sql);
	}
	
	function getTourDriver()
    {
    	$sql = "SELECT * FROM driver ;";
		
		return $this->getArrayResult($sql);
	}
	
	function getData($search)
    {
    	//echo $search;die;
    	$sql = "
    		SELECT 
			  a.`Tanggal`,
			  a.`NoTransaksi`,
			  c.`Tour_id`,
			  b.`Nama` AS NamaTour,
			  a.`Guide_id`,
			  c.`Nama` AS NamaGuide,
			  a.`Total_Komisi`,
			  a.Type 
			FROM
			  `komisiguide_header` a 
			  INNER JOIN `guide` c 
			    ON a.`Guide_id` = c.`Guide_id` 
			  INNER JOIN tour b
			  ON c.`Tour_id` = b.`Tour_id`
			WHERE 1 ;
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

    function getDataKomisiGuide($guide, $tour, $tgl)
    {
    	$mylib = new globallib();
    	
    	//cek apakah penjualanID tersebut sudah ada di Tanggal Tersebut
		/*$cek = $this->globalmodel->getQuery("
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
		}*/
		//echo $where_in;die;
        
		/*$sql="
		SELECT 
		  b.`PenjualanID`,
		  b.`Tanggal`,
		  c.`Nama` AS NamaBarang,
		  b.`Qty`,
		  b.`Harga`,
		  b.`Qty` * b.Harga AS Total,
		  b.`Disc_Pers`,
		  b.Disc,
		  e.`Komisi_TG` AS komisi_pers,
		  ROUND(
		    (
		      (b.`Harga` * b.Qty) - (
		        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
		      ) - b.`Disc`
		    ) * e.`Komisi_TG` / 100
		  ) AS tot_komisi 
		FROM
		  `penjualan_header` a 
		  INNER JOIN `penjualan_detail` b 
		    ON a.`PenjualanID` = b.`PenjualanID` 
		  INNER JOIN `stock` c 
		    ON b.`StockID` = c.`StockID` 
		  INNER JOIN `groupstock` d 
		    ON c.`Group_stkid` = d.`Group_stkid` 
		  INNER JOIN `komisi` e 
		    ON d.`Group_stkid` = e.`Group_stkid` 
		WHERE a.Guide_id = '$guide' 
		  AND a.`Tanggal` = '$tgl' 
		  AND e.Tour_id = '$tour' ;
		";*/
		
		$sql="  SELECT b.`PenjualanID`,
				  b.`Tanggal`,
				  c.`Nama` AS NamaBarang,
				  b.`Qty`,
				  b.`Harga`,
				  b.`Qty` * b.Harga AS Total,
				  b.`Disc_Pers`,
				  b.Disc,
				  e.`Komisi_TG` AS komisitg,
				  e.`Komisi_TL` AS komisitl,
				  e.`Komisi_DRV` AS komisidrv,
				 ROUND(
				    (
				      (b.`Harga` * b.Qty) - (
				        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
				      ) - b.`Disc`
				    ) * e.`Komisi_TG` / 100
				  ) AS tot_komisi_tg,
				   ROUND(
				    (
				      (b.`Harga` * b.Qty) - (
				        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
				      ) - b.`Disc`
				    ) * e.`Komisi_TL` / 100
				  ) AS tot_komisi_tl,
				  ROUND(
				    (
				      (b.`Harga` * b.Qty) - (
				        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
				      ) - b.`Disc`
				    ) * e.`Komisi_DRV` / 100
				  ) AS tot_komisi_drv 
				FROM
				  `penjualan_header` a 
				  INNER JOIN `penjualan_detail` b 
				    ON a.`PenjualanID` = b.`PenjualanID` 
				  INNER JOIN `stock` c 
				    ON b.`StockID` = c.`StockID` 
				  INNER JOIN `groupstock` d 
				    ON c.`Group_stkid` = d.`Group_stkid` 
				  INNER JOIN `komisi` e 
				    ON d.`Group_stkid` = e.`Group_stkid` 
				WHERE a.Guide_id = '$guide' 
					  AND a.`Tanggal` = '$tgl' 
					  AND e.Tour_id = '$tour' ;

				";
		//echo $sql;
		return $this->getArrayResult($sql);	
	}
	
	function getDataKomisiLeader($leader, $tour, $tgl)
    {
    	$mylib = new globallib();
    	$sql="  SELECT 
				  b.`PenjualanID`,
				  b.`Tanggal`,
				  c.`Nama` AS NamaBarang,
				  b.`Qty`,
				  b.`Harga`,
				  b.`Qty` * b.Harga AS Total,
				  b.`Disc_Pers`,
				  b.Disc,
				  e.`Komisi_TG` AS komisitg,
				  e.`Komisi_TL` AS komisitl,
				  e.`Komisi_DRV` AS komisidrv,
				  ROUND(
				    (
				      (b.`Harga` * b.Qty) - (
				        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
				      ) - b.`Disc`
				    ) * e.`Komisi_TG` / 100
				  ) AS tot_komisi_tg,
				  ROUND(
				    (
				      (b.`Harga` * b.Qty) - (
				        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
				      ) - b.`Disc`
				    ) * e.`Komisi_TL` / 100
				  ) AS tot_komisi_tl,
				  ROUND(
				    (
				      (b.`Harga` * b.Qty) - (
				        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
				      ) - b.`Disc`
				    ) * e.`Komisi_DRV` / 100
				  ) AS tot_komisi_drv 
				FROM
				  `penjualan_header` a 
				  INNER JOIN `penjualan_detail` b 
				    ON a.`PenjualanID` = b.`PenjualanID` 
				  INNER JOIN guide z
				    ON a.Guide_id = z.Guide_id
				  INNER JOIN tourleader j
				    ON z.Tour_id = j.Tour_id
				  INNER JOIN `stock` c 
				    ON b.`StockID` = c.`StockID` 
				  INNER JOIN `groupstock` d 
				    ON c.`Group_stkid` = d.`Group_stkid` 
				  INNER JOIN `komisi` e 
				    ON d.`Group_stkid` = e.`Group_stkid` 
				WHERE j.Leader_id = '$leader' 
				  AND a.`Tanggal` = '$tgl' 
				  AND e.Tour_id = '$tour' ;

				";
		//echo $sql;
		return $this->getArrayResult($sql);	
	}
	
	function getDataKomisiDriver($driver, $tour, $tgl)
    {
    	$mylib = new globallib();
    	$sql="  SELECT 
				  b.`PenjualanID`,
				  b.`Tanggal`,
				  c.`Nama` AS NamaBarang,
				  b.`Qty`,
				  b.`Harga`,
				  b.`Qty` * b.Harga AS Total,
				  b.`Disc_Pers`,
				  b.Disc,
				  e.`Komisi_TG` AS komisitg,
				  e.`Komisi_TL` AS komisitl,
				  e.`Komisi_DRV` AS komisidrv,
				  ROUND(
				    (
				      (b.`Harga` * b.Qty) - (
				        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
				      ) - b.`Disc`
				    ) * e.`Komisi_TG` / 100
				  ) AS tot_komisi_tg,
				  ROUND(
				    (
				      (b.`Harga` * b.Qty) - (
				        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
				      ) - b.`Disc`
				    ) * e.`Komisi_TL` / 100
				  ) AS tot_komisi_tl,
				  ROUND(
				    (
				      (b.`Harga` * b.Qty) - (
				        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
				      ) - b.`Disc`
				    ) * e.`Komisi_DRV` / 100
				  ) AS tot_komisi_drv 
				FROM
				  `penjualan_header` a 
				  INNER JOIN `penjualan_detail` b 
				    ON a.`PenjualanID` = b.`PenjualanID` 
				  INNER JOIN guide z
				    ON a.Guide_id = z.Guide_id
				  INNER JOIN driver j
				    ON z.Tour_id = j.Tour_id
				  INNER JOIN `stock` c 
				    ON b.`StockID` = c.`StockID` 
				  INNER JOIN `groupstock` d 
				    ON c.`Group_stkid` = d.`Group_stkid` 
				  INNER JOIN `komisi` e 
				    ON d.`Group_stkid` = e.`Group_stkid` 
				WHERE j.Driver_id = '$driver' 
				  AND a.`Tanggal` = '$tgl' 
				  AND e.Tour_id = '$tour' ;

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
    	$sql = "SELECT * FROM guide WHERE Nama LIKE '%".$guide."%' ORDER BY Nama ASC";
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }
    
    function getTravel_guide($type)
	{
    	$sql = "SELECT 
				  a.`Guide_id`,
				  a.`Nama` AS NamaGuide,
				  a.`Tour_id`,
				  b.`Nama` AS NamaTour 
				FROM
				  guide a 
				  INNER JOIN tour b 
				    ON a.`Tour_id` = b.`Tour_id` 
				WHERE a.`Guide_id`='$type' ;
				";
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }
    
    function getTravel_driver($jenis)
	{
    	$sql = "SELECT 
				  a.`Driver_id`,
				  a.`Nama` AS NamaDriver,
				  b.`Tour_id`,
				  b.`Nama` AS NamaTour 
				FROM
				  driver a 
				  INNER JOIN tour b 
				    ON a.`Tour_id` = b.`Tour_id` 
				WHERE a.`Driver_id` = '$jenis' ;
				";
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }
    
    function getTravel_leader($leader)
	{
    	$sql = "SELECT 
				  a.`Leader_id`,
				  a.`Nama` AS NamaLeader,
				  b.`Tour_id`,
				  b.`Nama` AS NamaTour 
				FROM
				  tourleader a 
				  INNER JOIN tour b 
				    ON a.`Tour_id` = b.`Tour_id` 
				WHERE a.`Leader_id` = '$leader' ;
				";
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
			SELECT * FROM komisiguide_header a INNER JOIN guide b ON a.Guide_id = b.Guide_id WHERE a.NoTransaksi='$NoTransaksi'";
        //echo $sql;die;
        return $this->getArrayResult($sql);
        //return $this->getRow($sql);
    }
    
    function cekHeader($NoTransaksi) {
        $sql = "
			SELECT * FROM komisiguide_header a WHERE a.NoTransaksi='$NoTransaksi'";
        
        return $this->getRow($sql);
    }
    
    function getDetailKomisi($NoTransaksi) {
        /*$sql = "
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
			   ";*/
			   
			   $sql="SELECT 
					  b.`PenjualanID`,
					  b.`Tanggal`,
					  c.`Nama` AS NamaBarang,
					  b.`Qty`,
					  b.`Harga`,
					  b.`Qty` * b.Harga AS Total,
					  b.`Disc_Pers`,
					  b.Disc,
					  e.`Komisi_TG` AS komisitg,
					  e.`Komisi_TL` AS komisitl,
					  e.`Komisi_DRV` AS komisidrv,
					  ROUND(
					    (
					      (b.`Harga` * b.Qty) - (
					        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
					      ) - b.`Disc`
					    ) * e.`Komisi_TG` / 100
					  ) AS tot_komisi_tg,
					   ROUND(
					    (
					      (b.`Harga` * b.Qty) - (
					        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
					      ) - b.`Disc`
					    ) * e.`Komisi_TL` / 100
					  ) AS tot_komisi_tl,
					  ROUND(
					    (
					      (b.`Harga` * b.Qty) - (
					        (b.`Harga` * b.Qty) * b.`Disc_Pers` / 100
					      ) - b.`Disc`
					    ) * e.`Komisi_DRV` / 100
					  ) AS tot_komisi_drv
					FROM
					  `penjualan_header` a 
					  INNER JOIN `penjualan_detail` b 
					    ON a.`PenjualanID` = b.`PenjualanID` 
					  INNER JOIN `stock` c 
					    ON b.`StockID` = c.`StockID` 
					  INNER JOIN `groupstock` d 
					    ON c.`Group_stkid` = d.`Group_stkid` 
					  INNER JOIN `komisi` e 
					    ON d.`Group_stkid` = e.`Group_stkid` 
					  INNER JOIN `komisiguide_detail` f 
					    ON f.PenjualanID = a.PenjualanID
					  INNER JOIN `komisiguide_header` g
					  ON g.NoTransaksi = f.NoTrans
					  WHERE f.NoTrans = '$NoTransaksi'
					   GROUP BY b.id;";
        return $this->getArrayResult($sql);
        //return $this->getRow($sql);
    }
    
    function getNamaLeader($id){
		$sql = "
			   SELECT * FROM tourleader a where a.Leader_id='$id'";
        return $this->getRow($sql);
	}
	
	function getNamaGuide($id){
		$sql = "
			   SELECT * FROM guide a where a.Guide_id='$id'";
        return $this->getRow($sql);
	}
	
	function getNamaDriver($id){
		$sql = "
			   SELECT * FROM driver a where a.Driver_id='$id'";
        return $this->getRow($sql);
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