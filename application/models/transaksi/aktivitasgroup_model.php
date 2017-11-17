<?php
class Aktivitasgroup_model extends CI_Model {
	
    function __construct(){
        parent::__construct();
        $this->load->library('globallib');
    }
	
    function getTabelList($limit,$offset,$arrSearch)
	{
        $mylib = new globallib();
        
	 	if($offset !=''){
			$offset = $offset;
		}            
        else{
        	$offset = 0;
        }
        
        $where_keyword="";
        if(count($arrSearch)*1>0)
        {
        	$nama = $arrSearch["keyword"];
        	$tanggal = $arrSearch["tanggal"];
        	if($nama!=''){
				$where_keyword .= " and NamaGroup like '%$nama%' ";
			}
        	if($tanggal!='0000-00-00'){
				$where_keyword .= " and Tanggal<='$tanggal' and TanggalSelesai>='$tanggal' ";
			}
		}
        
    	$sql = "SELECT g.KdGroup, g.NamaGroup, DATE_FORMAT(g.Tanggal,'%d-%m-%Y') as TanggalMulai,  DATE_FORMAT(g.TanggalSelesai,'%d-%m-%Y') as TanggalSelesai, g.Status, t.NamaTourGuide FROM group_tour g inner join tourguide t on g.KdTourGuide=t.KdTourGuide 
    	Where 1 $where_keyword LIMIT $offset,$limit";
    	
    	//echo $sql;
        
		return $this->getArrayResult($sql);
    }
    
    function num_tabel_row($arrSearch)
    {
         $mylib = new globallib();
        
        
        $where_keyword="";
        if(count($arrSearch)*1>0)
        {
			if($arrSearch["keyword"]!="")
			{
		    	$nama = $arrSearch["keyword"][0];
        		$tanggal = $arrSearch["keyword"][1];
	        	if($nama!=''){
					$where_keyword .= " and NamaGroup like '%$nama%' ";
				}
	        	if($tanggal!=''){
					$where_keyword .= " and Tanggal<='$tanggal' and TanggalSelesai>='$tanggal' ";
				}
			}
		}
        
    	$sql = "SELECT * FROM group_tour Where 1 $where_keyword";
        
		                  
        return $this->NumResult($sql);
	}	
	
	function getdata($id){
		$sql = "SELECT KdGroup, NamaGroup, DATE_FORMAT(Tanggal,'%d-%m-%Y') as TanggalMulai, DATE_FORMAT(TanggalSelesai,'%d-%m-%Y') as TanggalSelesai,
				 Pax, KdTourGuide, PersentaseGuide, Status, AddUser, AddDate, EditUser, EditDate FROM group_tour Where KdGroup='$id'";
		return $this->getArrayResult($sql);
	}
	
	function getAktivitas(){
		$sql = "SELECT * FROM aktivitas ORDER BY NamaAktivitas ASC";
		return $this->getArrayResult($sql);
	}
	
	function getlistdata($kdgroup, $cari){
		
		if($cari==""){
			$where_cari="";
		}else{
			$where_cari=" AND b.NamaAktivitas LIKE '%$cari%'";
		}
		
		$sql = "
				SELECT 
				  a.KdGroup,
				  a.Tanggal,
				  b.KdAktivitas,
				  b.NamaAktivitas,
				  a.Pax,
				  a.IDR,
				  a.USD,
				  a.RMB,
				  '0' AS Status,
				  '1' AS id 
				FROM
				  `aktivitasgroup` a 
				  INNER JOIN `aktivitas` b 
				    ON a.`KdAktivitas` = b.`KdAktivitas` 
				  INNER JOIN `group_tour` c
				  ON a.`KdGroup` = c.`KdGroup`
				WHERE a.`KdGroup` = '$kdgroup' 
				$where_cari
				ORDER BY a.`Tanggal` DESC ;
				";
		return $this->getArrayResult($sql);
	}
	
	function getlistdataCari($kdgroup, $aktivitas){
		
		$sql = "
				SELECT 
				  a.KdGroup,
				  a.Tanggal,
				  b.KdAktivitas,
				  b.NamaAktivitas,
				  a.Pax,
				  a.IDR,
				  a.USD,
				  a.RMB,
				  '0' AS Status,
				  '1' AS id 
				FROM
				  `aktivitasgroup` a 
				  INNER JOIN `aktivitas` b 
				    ON a.`KdAktivitas` = b.`KdAktivitas` 
				  INNER JOIN `group_tour` c
				  ON a.`KdGroup` = c.`KdGroup`
				WHERE a.`KdGroup` = '$kdgroup' 
				AND a.KdAktivitas='$aktivitas'
				ORDER BY a.`Tanggal` DESC ;
				";
		return $this->getArrayResult($sql);
	}
	
	function getlistDetaildata($kdgroup,$kdaktivitas){
		$sql = "
				SELECT 
				  a.KdGroup,
				  DATE_FORMAT(a.Tanggal, '%d-%m-%Y') AS Tanggal,
				  b.KdAktivitas,
				  b.NamaAktivitas,
				  a.Pax,
				  a.IDR,
				  a.USD,
				  a.RMB
				FROM
				  `aktivitasgroup` a 
				  INNER JOIN `aktivitas` b 
				    ON a.`KdAktivitas` = b.`KdAktivitas` 
				  INNER JOIN `group_tour` c
				  ON a.`KdGroup` = c.`KdGroup`
				WHERE a.`KdGroup` = '$kdgroup' AND a.KdAktivitas='$kdaktivitas';
				";
		return $this->getRow($sql);
	}
	
	function cekGandaAktivitas($kdgroup,$kdaktivitas){
		$sql = "
				SELECT 
				*
				FROM
				  `aktivitasgroup` a
				WHERE a.`KdGroup` = '$kdgroup' AND a.KdAktivitas='$kdaktivitas';
				";
		return $this->getRow($sql);
	}
	
	function get_Pax($kdgroup){
		$sql = "
				SELECT * FROM `group_tour` a WHERE a.`KdGroup`='$kdgroup';
				";
		return $this->getRow($sql);
	}
	
	function get_Harga($aktivitas){
		$sql = "
				SELECT * FROM  `aktivitas` a WHERE a.`KdAktivitas`='$aktivitas';
				";
		return $this->getRow($sql);
	}
	
	function save($kdgroup, $tgl, $activity, $pax, $idr, $usd, $rmb,  $user){
		$mylib = new globallib();
		$this->locktables('aktivitasgroup');
		$data= array('KdGroup' => $kdgroup,
					 'Tanggal' => $mylib->ubah_tanggal($tgl),
					 'KdAktivitas' => $activity,
					 'Pax' => $pax,
					 'IDR' => $idr,
					 'USD'=> $usd,
					 'RMB'=> $rmb,
					 'AddUser' => $user,
					 'AddDate' => date('Y-m-d')
					);
		$this->db->insert('aktivitasgroup', $data);
		$insertid= $this->db->insert_id();
		$this->unlocktables();
		return $insertid;
	}
	
	function update($kdgroup, $tgl, $activity, $pax, $idr, $usd, $rmb,  $user){
		$mylib = new globallib();
		$tgl_dok= $mylib->ubah_tanggal($tgl);
		
		$this->locktables('aktivitasgroup');
		$date = date('Y-m-d');
					
		$sql="UPDATE aktivitasgroup SET Tanggal='$tgl_dok',Pax='$pax',IDR='$idr',USD='$usd',RMB='$rmb',EditUser='$user', EditDate='$date'
		     WHERE KdGroup='$kdgroup' AND KdAktivitas='$activity'";
		$qry = $this->db->query($sql);
		$this->unlocktables();
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
