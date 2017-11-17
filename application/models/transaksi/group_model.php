<?php
class Group_model extends CI_Model {
	
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
        
    	$sql = "SELECT g.KdGroup, g.NamaGroup, DATE_FORMAT(g.Tanggal,'%d-%m-%Y') as TanggalMulai,  DATE_FORMAT(g.TanggalSelesai,'%d-%m-%Y') as TanggalSelesai, g.Status, t.Name AS NamaTourGuide, t.UserName, g.TipeOptionTour,g.Pax_adult,g.Pax_child FROM group_tour g inner join user t on g.KdTourGuide=t.UserName 
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
				 Pax_adult, Pax_child, KdTourGuide, PersentaseGuide, TipeOptionTour, Status, AddUser, AddDate, EditUser, EditDate FROM group_tour Where KdGroup='$id'";
		return $this->getArrayResult($sql);
	}
	
	function dropdown(){
		$sql = "SELECT a.UserName AS KdTourGuide, a.Name AS NamaTourGuide FROM user a WHERE a.UserLevel='2' ORDER BY Name ASC";
		return $this->getArrayResult($sql);
	}
	
	function save($kdgroup, $namagroup, $tglmulai, $tglselesai, $pax_adl, $pax_chl, $kdtourguide, $tipeoptiontour, $persentaseguide, $user){
		$mylib = new globallib();
		$this->locktables('group_tour');
		$data= array('NamaGroup' => $namagroup,
					 'Tanggal' => $mylib->ubah_tanggal($tglmulai),
					 'TanggalSelesai' => $mylib->ubah_tanggal($tglselesai),
					 'Pax_adult' => $pax_adl,
					 'Pax_child' => $pax_chl,
					 'KdTourGuide' => $kdtourguide,
					 'PersentaseGuide'=> $persentaseguide,
					 'TipeOptionTour'=>$tipeoptiontour,
					 'AddUser' => $user,
					 'AddDate' => date('Y-m-d')
					);
		$this->db->insert('group_tour', $data);
		$insertid= $this->db->insert_id();
		$this->unlocktables();
		return $insertid;
	}
	
	function update($kdgroup, $namagroup, $tglmulai, $tglselesai, $pax_adl, $pax_chl, $kdtourguide, $tipeoptiontour , $persentaseguide, $user){
		$mylib = new globallib();
		$tglmulai = $mylib->ubah_tanggal($tglmulai);
		$tglselesai = $mylib->ubah_tanggal($tglselesai);
		
		$this->locktables('group_tour');
		$date = date('Y-m-d');
		$sql = "Update group_tour 
					set NamaGroup='$namagroup', Tanggal='$tglmulai', TanggalSelesai='$tglselesai', Pax_adult='$pax_adl', Pax_child='$pax_chl', KdTourGuide='$kdtourguide', PersentaseGuide='$persentaseguide', TipeOptionTour='$tipeoptiontour',
					EditUser='$user', EditDate='$date' 
					where KdGroup='$kdgroup'";
		$qry = $this->db->query($sql);
		$this->unlocktables();
	}
	
	function getOtorisasi($tipe, $user){
		$sql = "SELECT * FROM otorisasi_user WHERE Tipe='$tipe' AND UserName='$user'";
	
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