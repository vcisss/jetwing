<?php
class Aktivitasoptionaltour_model extends CI_Model {
	
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
	
	function getOptionalTour(){
		$sql = "SELECT * FROM optionaltour ORDER BY NamaTour ASC";
		return $this->getArrayResult($sql);
	}
	
	function getlistdata($kdgroup, $cari){
		
		if($cari==""){
			$where_cari="";
		}else{
			$where_cari=" AND b.NamaTour LIKE '%$cari%'";
		}
		
		$sql = "
				SELECT 
				  a.KdGroup,
				  DATE_FORMAT(a.Tanggal, '%d-%m-%Y') AS Tanggal,
				  a.`KdTour`,
				  b.`NamaTour`,
				  d.`Keterangan`,
				  a.`Pax`,
				  a.`HargaJualUSD`,
				  a.`Net` AS HPP 
				FROM
				  `aktivitasoptionaltour` a 
				  INNER JOIN `optionaltour` b 
				    ON a.`KdTour` = b.`KdTour` 
				  INNER JOIN `group_tour` c 
				    ON a.`KdGroup` = c.`KdGroup`
				  INNER JOIN `groupoptionaltour` d
				  ON b.`KdGroupOptional` = d.`KdGroupOptional`
				WHERE a.`KdGroup` = '$kdgroup' $where_cari
				ORDER BY a.`Tanggal` DESC  ;
				";
		return $this->getArrayResult($sql);
	}
	
	function getlistdataCari($KdGroup, $optionaltour){
		
		$sql = "
				SELECT 
				  a.KdGroup,
				  DATE_FORMAT(a.Tanggal, '%d-%m-%Y') AS Tanggal,
				  a.`KdTour`,
				  b.`NamaTour`,
				  d.`Keterangan`,
				  a.`Pax`,
				  a.`HargaJualUSD`,
				  a.`Net` AS HPP  
				FROM
				  `aktivitasoptionaltour` a 
				  INNER JOIN `optionaltour` b 
				    ON a.`KdTour` = b.`KdTour` 
				  INNER JOIN `group_tour` c 
				    ON a.`KdGroup` = c.`KdGroup`
				  INNER JOIN `groupoptionaltour` d
				  ON b.`KdGroupOptional` = d.`KdGroupOptional`
				WHERE a.`KdGroup` = '$KdGroup'
				AND a.KdTour = '$optionaltour'
				ORDER BY a.`Tanggal` DESC ;
				";
		return $this->getArrayResult($sql);
	}
	
	function getlistDetaildata($KdGroup,$optionaltour){
		$sql = "
				SELECT 
				  a.KdGroup,
				  DATE_FORMAT(a.Tanggal, '%d-%m-%Y') AS Tanggal,
				  a.`KdTour`,
				  b.`NamaTour`,
				  d.`Keterangan`,
				  a.`Pax`,
				  a.`HargaJualUSD`,
				  a.`HPP`,
				  a.Net
				FROM
				  `aktivitasoptionaltour` a 
				  INNER JOIN `optionaltour` b 
				    ON a.`KdTour` = b.`KdTour` 
				  INNER JOIN `group_tour` c 
				    ON a.`KdGroup` = c.`KdGroup`
				  INNER JOIN `groupoptionaltour` d
				  ON b.`KdGroupOptional` = d.`KdGroupOptional`
				WHERE a.`KdGroup` = '$KdGroup'
				AND a.KdTour = '$optionaltour' ;
				";
		return $this->getRow($sql);
	}
	
	function getSellNet($KdGroup,$optionaltour){
		$sql = "
				SELECT 
				  * FROM optionaltour a where a.KdTour='$optionaltour' ;
				";
		return $this->getRow($sql);
	}
	
	function cekGandaOptioanlTour($kdgroup,$optionaltour){
		$sql = "
				SELECT 
				*
				FROM
				  `aktivitasoptionaltour` a
				WHERE a.`KdGroup` = '$kdgroup' AND a.KdTour='$optionaltour';
				";
		return $this->getRow($sql);
	}
	
	function save($kdgroup, $tgl, $optionaltour, $pax, $hargajualusd, $net, $net_rumus, $user){
		$mylib = new globallib();
		$this->locktables('aktivitasoptionaltour');
		$data= array('KdGroup' => $kdgroup,
					 'Tanggal' => $mylib->ubah_tanggal($tgl),
					 'KdTour' => $optionaltour,
					 'Pax' => $pax,
					 'HargaJualUSD' => $hargajualusd,
					 'HPP'=> $net,
					 'Net'=>$net_rumus,
					 'AddUser' => $user,
					 'AddDate' => date('Y-m-d')
					);
		$this->db->insert('aktivitasoptionaltour', $data);
		$insertid= $this->db->insert_id();
		$this->unlocktables();
		return $insertid;
	}
	
	function update($kdgroup, $tgl, $optionaltour, $pax, $hargajualusd, $net, $net_rumus, $user){
		$mylib = new globallib();
		$tgl_dok= $mylib->ubah_tanggal($tgl);
		
		$this->locktables('aktivitasoptionaltour');
		$date = date('Y-m-d');
					
		$sql="UPDATE aktivitasoptionaltour SET Tanggal='$tgl_dok',Pax='$pax',HargaJualUSD='$hargajualusd',HPP='$net',Net='$net_rumus',EditUser='$user', EditDate='$date'
		     WHERE KdGroup='$kdgroup' AND KdTour='$optionaltour'";
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
