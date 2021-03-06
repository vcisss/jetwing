<?php
class Optional_tour_agreement_model extends CI_Model {
	
    function __construct(){
        parent::__construct();
        $this->load->library('globallib');
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
    		SELECT * FROM group_tour;
		";
		
		return $this->getArrayResult($sql);
	}
	
	function getTour($kdgroup)
    {
    	$sql = "
    		SELECT 
			  * 
			FROM
			  opt_header a INNER JOIN group_tour c 
			    ON a.`group_code` = c.`KdGroup` 
			WHERE a.`group_code` = '$kdgroup' ;
		";
		
		return $this->getArrayResult($sql);
	}
	
	function getTemplate($jenis)
    {
    	$sql = "
    		SELECT 
			  * 
			FROM
			  template 
			WHERE 1 AND template.jenis='$jenis'
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

    function getArrayHeaderJenis1($kdtour)
    {
    	$mylib = new globallib();
        
		$sql="
		SELECT 
		  a.`KdGroup`,
		  a.`KdAktivitas`,
		  b.`NamaGroup`,
		  c.`NamaAktivitas`,
		  a.`Pax`,
		  a.`IDR`,
		  a.`USD`,
		  a.`RMB`,
		  c.`Jenis`
		FROM
		  `aktivitasgroup` a 
		  INNER JOIN `group_tour` b 
			ON a.`KdGroup` = b.`KdGroup` 
		  INNER JOIN `aktivitas` c 
			ON a.`KdAktivitas` = c.`KdAktivitas` 
		WHERE a.`KdGroup` = '$kdtour' 
		  AND c.`Jenis` = '1' ;
		";
		return $this->getArrayResult($sql);	
	}
	
	 function getGroup($group)
	{
    	$sql = "SELECT * FROM group_tour WHERE NamaGroup LIKE '%".$group."%' ORDER BY NamaGroup ASC";
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }
	
	function getArrayHeaderJenis2($kdtour)
    {
    	$mylib = new globallib();
        
		$sql="
		SELECT 
		  a.`KdGroup`,
		  a.`KdAktivitas`,
		  b.`NamaGroup`,
		  c.`NamaAktivitas`,
		  a.`Pax`,
		  a.`IDR`,
		  a.`USD`,
		  a.`RMB`,
		  c.`Jenis` 
		FROM
		  `aktivitasgroup` a 
		  INNER JOIN `group_tour` b 
			ON a.`KdGroup` = b.`KdGroup` 
		  INNER JOIN `aktivitas` c 
			ON a.`KdAktivitas` = c.`KdAktivitas` 
		WHERE a.`KdGroup` = '$kdtour' 
		  AND c.`Jenis` = '2' ;
		";
		return $this->getArrayResult($sql);	
	}
	
	function getArrayHeaderOptional($kdtour)
    {
    	$mylib = new globallib();
        
		$sql="
		SELECT 
		  a.`KdGroup`,
		  a.`KdTour`,
		  b.`NamaTour`,
		  a.`Pax`,
		  a.Net,
		  a.`HargaJualUSD`,
		  a.`Net` AS HPP,
		  (a.HargaJualUSD * a.Net)* a.Pax AS Total
		FROM
		  `aktivitasoptionaltour` a 
		  INNER JOIN `optionaltour` b 
			ON a.`KdTour` = b.`KdTour` 
		  INNER JOIN `groupoptionaltour` c 
			ON b.`KdGroupOptional` = c.`KdGroupOptional` 
		WHERE a.`KdGroup` ='$kdtour';
		";
		return $this->getArrayResult($sql);	
	}
	
	function getArrayHeaderSumOptional($kdtour)
    {
    	$sql="
		SELECT SUM(a.`Pax`*a.Net) AS Optional_fee FROM `aktivitasoptionaltour` a WHERE a.`KdGroup`='$kdtour';
		";
		return $this->getRow($sql);	
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