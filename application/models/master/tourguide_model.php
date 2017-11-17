<?php
class TourGuide_model extends CI_Model {
	
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
		        $arr_keyword[0] = "NamaTourGuide";
		        
				$search_keyword = $mylib->search_keyword($arrSearch["keyword"], $arr_keyword);
				$where_keyword = $search_keyword;
			}
		}
        
    	$sql = "SELECT * FROM tourguide Where 1 $where_keyword LIMIT $offset,$limit";
        
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
		$sql = "SELECT * FROM tourguide Where KdTourGuide='$id'";
		return $this->getArrayResult($sql);
	}
	
	function dropdown(){
		$sql = "SELECT KdTourGuide, NamaTourGuide FROM tourguide order by NamaTourGuide";
		return $this->getArrayResult($sql);
	}
	
	function save($namatourguide, $username, $user){
		$this->locktables('tourguide');
		$data= array('NamaTourGuide' => $namatourguide,
					 'UserName' => $username,
					 'AddUser' => $user,
					 'AddDate' => date('Y-m-d')
					);
		$this->db->insert('tourguide', $data);
		$insertid= $this->db->insert_id();
		$this->unlocktables();
		return $insertid;
	}
	
	function update($namatourguide, $username, $user, $id){
		$this->locktables('tourguide');
		$date = date('Y-m-d');
		$sql = "Update tourguide 
					set NamaTourGuide='$namatourguide', UserName='$username', EditUser='$user', EditDate='$date' 
					where KdTourGuide='$id'";
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