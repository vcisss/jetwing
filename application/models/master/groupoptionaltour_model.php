<?php
class GroupOptionalTour_model extends CI_Model {
	
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
		        $arr_keyword[0] = "Keterangan";
		        
				$search_keyword = $mylib->search_keyword($arrSearch["keyword"], $arr_keyword);
				$where_keyword = $search_keyword;
			}
		}
        
    	$sql = "SELECT * FROM groupoptionaltour Where 1 $where_keyword LIMIT $offset,$limit";
        
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
		        $arr_keyword[0] = "Keterangan";
		        
				$search_keyword = $mylib->search_keyword($arrSearch["keyword"], $arr_keyword);
				$where_keyword = $search_keyword;
			}
		}
        
    	$sql = "SELECT * FROM groupoptionaltour Where 1 $where_keyword";
        
		                  
        return $this->NumResult($sql);
	}	
	
	function getdata($id){
		$sql = "SELECT * FROM groupoptionaltour Where KdGroupOptional='$id'";
		return $this->getArrayResult($sql);
	}
	
	function dropdown(){
		$sql = "SELECT KdGroupOptional, Keterangan FROM groupoptionaltour order by Keterangan";
		return $this->getArrayResult($sql);
	}
	
	function save($keterangan, $user){
		$this->locktables('groupoptionaltour');
		$data= array('Keterangan' => $keterangan,
					 'AddUser' => $user,
					 'AddDate' => date('Y-m-d')
					);
		$this->db->insert('groupoptionaltour', $data);
		$insertid= $this->db->insert_id();
		$this->unlocktables();
		return $insertid;
	}
	
	function update($keterangan, $user, $kdgroupoptional){
		$this->locktables('groupoptionaltour');
		$date = date('Y-m-d');
		$sql = "Update groupoptionaltour 
					set Keterangan='$keterangan', EditUser='$user', EditDate='$date' 
					where KdGroupOptional='$kdgroupoptional'";
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