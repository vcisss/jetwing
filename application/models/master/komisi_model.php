<?php
class Komisi_model extends CI_Model {
	
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
			if($arrSearch["keyword"]!="")
			{
		    	unset($arr_keyword);
		        $arr_keyword[0] = "Nama";
		        
				$search_keyword = $mylib->search_keyword($arrSearch["keyword"], $arr_keyword);
				$where_keyword = $search_keyword;
			}
		}
        
    	$sql = "SELECT * FROM komisi a INNER JOIN stock b ON a.`GroupID` = b.`GroupID` WHERE 1 $where_keyword LIMIT $offset,$limit";
       
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
		    	unset($arr_keyword);
		        $arr_keyword[0] = "NamaTourGuide";
		        
				$search_keyword = $mylib->search_keyword($arrSearch["keyword"], $arr_keyword);
				$where_keyword = $search_keyword;
			}
		}
        
    	$sql = "SELECT * FROM tourguide Where 1 $where_keyword";
        
		                  
        return $this->NumResult($sql);
	}	
	
	function getdata($id){
		$sql = "SELECT * FROM komisi a INNER JOIN stock b ON a.GroupID = b.GroupID Where a.GroupID='$id'";
	
		return $this->getArrayResult($sql);
	}
	
	function dropdown(){
		$sql = "SELECT KdTourGuide, NamaTourGuide FROM tourguide order by NamaTourGuide";
		return $this->getArrayResult($sql);
	}
	
	function save($groupid, $komisi_office, $komisi_drv, $komisi_tl, $komisi_tg, $user){
		$this->locktables('komisi');
		$data= array('GroupID' => $groupid,
					 'Komisi_Office' => $komisi_office,
					 'Komisi_TL' => $komisi_tl,
					 'Komisi_TG' => $komisi_tg,
					 'Komisi_Drv' => $komisi_drv,
					 'AddUser' => $user,
					 'AddDate' => date('Y-m-d')
					);
		$this->db->insert('komisi', $data);
		$insertid= $this->db->insert_id();
		$this->unlocktables();
		return $insertid;
	}
	
	function update($groupid, $komisi_office, $komisi_drv, $komisi_tl, $komisi_tg, $user){
		$this->locktables('komisi');
		$date = date('Y-m-d');
		$sql = "Update komisi 
					set Komisi_Office='$komisi_office',Komisi_TG='$komisi_tg',Komisi_TL='$komisi_tl',Komisi_Drv='$komisi_drv', EditUser='$user', EditDate='$date' 
					where GroupID='$groupid'";
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