<?php
class Pendaftaran_tamu_model extends CI_Model {
	
    function __construct(){
        parent::__construct();
        $this->load->library('globallib');
    } 
    
    
    
    function getBeo()
	{
		$sql = "
				SELECT * FROM pendaftaran;
			   ";
    	return $this->getArrayResult($sql);
    }
    
    function getTourtravel()
	{
		$sql = "SELECT * FROM tour ORDER BY Nama";
    	return $this->getArrayResult($sql);
    }
    
    function getPropinsi()
	{
		$sql = "SELECT * FROM propinsi ORDER BY Nama";
    	return $this->getArrayResult($sql);
    }
    
    function getTourguide()
	{
		$sql = "SELECT * FROM guide ORDER BY Nama";
    	return $this->getArrayResult($sql);
    }
    
    function getTourleader()
	{
		$sql = "SELECT * FROM tourleader ORDER BY Nama";
    	return $this->getArrayResult($sql);
    }
    
    function getKodeBank($kd){

    	$sql = "SELECT KdRekening, KdPenerimaan, KdSubDivisi FROM `kasbank` WHERE KdKasBank='$kd'";

        return $this->getRow($sql);

    }
    
    
    function getNewNo($tgl)
	{
	    $tahun = substr($tgl,0,4);
		$bulan = substr($tgl,5,2);
		$sql = "Update counter set NoReceipt=NoReceipt+1 where Tahun='$tahun' and Bulan='$bulan'";
		$this->db->query($sql);
		$sql = "SELECT NoReceipt FROM counter where Tahun='$tahun' and Bulan='$bulan'";
		return $this->getRow($sql);
	}
	
	function getPendaftaranList($key,$stat,$offset,$limit)
	{
       $mylib = new globallib();
       
        if($offset !=''){
			$offset = $offset;
		}            
        else{
        	$offset = 0;
        }
        
	 	$where_keyword="";
        $where_status="";
        
			if($key!="" OR $key!="0")
			{
		    	unset($arr_keyword);
		        $arr_keyword[0] = "b.`Nama`";
				$arr_keyword[1] = "c.`Nama`";
				$arr_keyword[2] = "d.`Nama`";
				$arr_keyword[3] = "a.`id_pendaftaran`";
				$arr_keyword[4] = "a.`Keterangan`";
				$arr_keyword[5] = "e.`Nama`";
		        
				$search_keyword = $mylib->search_keyword($key, $arr_keyword);
				$where_keyword = $search_keyword;
			}
						
			if($stat!="")
			{
				$where_status = " AND a.Status = '".$stat."'";	
			}
        
    	/*$sql = "  
                                              
	           SELECT 
				  * 
			   FROM
				  `voucher_beo` a 
				  inner join `tourtravel` b 
				    on a.`tourtravel` = b.`KdTravel`
				WHERE 1
				".$where_keyword."
				".$where_status."
				 ORDER BY a.id DESC
	            Limit 
              $offset,$limit
        ";*/
         $sql = "  
                                              
	           SELECT 
				  a.`Tanggal`,
  				  a.`id_pendaftaran`,
  				  e.`Nama` AS NamaLeader,
				  b.`Nama` AS NamaGuide,
				  c.`Nama` AS NamaTour,
				  d.`Nama` AS NamaPropinsi,
				  a.`PAX_adult`,
				  a.`PAX_child`,
				  a.`Keterangan`,
				  a.`Status`
				FROM
				  `pendaftaran` a 
				  INNER JOIN `guide` b 
				    ON a.`Guide_id` = b.`Guide_id` 
				  INNER JOIN `tour` c 
				    ON a.`Tour_id` = c.`Tour_id` 
				  INNER JOIN propinsi d 
				    ON a.`Propinsi_id` = d.`id_propinsi`
				  INNER JOIN tourleader e 
				    ON a.Leader_id = e.Leader_id 
				    WHERE 1
				".$where_keyword."
				".$where_status." 				  
        ";             
        //echo $sql;
        //echo "<hr/>";
		return $this->getArrayResult($sql); 
    }
	
	public function get_by_id($id) {
        $sql = "
				  SELECT 
				  DATE_FORMAT(a.`Tanggal`, '%d-%m-%Y') AS Tanggal,
				  a.`id_pendaftaran`,
				  e.`Leader_id`,
				  e.`Nama` AS NamaLeader,
				  b.`Guide_id`,
				  b.`Nama` AS NamaGuide,
				  c.`Tour_id`,
				  c.`Nama` AS NamaTour,
				  d.`id_propinsi`,
				  d.`Nama` AS NamaPropinsi,
				  a.`PAX_adult`,
				  a.`PAX_child`,
				  a.`Keterangan`,
				  a.`Status`
				FROM
				  `pendaftaran` a 
				  INNER JOIN `guide` b 
				    ON a.`Guide_id` = b.`Guide_id` 
				  INNER JOIN `tour` c 
				    ON a.`Tour_id` = c.`Tour_id` 
				  INNER JOIN propinsi d 
				    ON a.`Propinsi_id` = d.`id_propinsi`
				  INNER JOIN tourleader e
				    ON a.Leader_id = e.Leader_id 
				WHERE a.id_pendaftaran = '$id' 
        		";
        //echo $sql;die;
        return $this->getRow($sql);
    }
    
    function getHeader($id)
	{
		$sql = "
			SELECT * FROM `voucher_beo` a INNER JOIN `tourtravel` b ON a.`tourtravel` = b.`KdTravel` WHERE a.`id`='$id';
        ";
		//echo $sql;die;
        return $this->getRow($sql);
	}
	
	function getDetail_cetak($id)
	{
		$sql = "
			SELECT * FROM `voucher_beo` a INNER JOIN `tourtravel` b ON a.`tourtravel` = b.`KdTravel` WHERE a.`id`='$id';
		";
		
        return $this->getArrayResult($sql);
	}
    
    
    function num_pendaftaran_row()
    {
        $mylib = new globallib();
        
		
		$sql = "
            SELECT * FROM pendaftaran a;       
		";
		                  
        return $this->NumResult($sql);
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