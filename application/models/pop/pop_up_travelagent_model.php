<?php
class Pop_up_travelagent_model extends CI_Model
{
	function __construct(){
        parent::__construct();
        $this->load->library('globallib');
    }
    
	function getTourList($limit,$offset,$arrSearch)
	{
        $mylib = new globallib();
        
	 	if($offset !=''){
			$offset = $offset;
		}
        else{
        	$offset = 0;
        }
        //print_r($arrSearch);die;
        $where_keyword="";
        if(count($arrSearch)*1>0)
        {
			if($arrSearch["keyword"]!="")
			{
		    	unset($arr_keyword);
				$arr_keyword[0] = "stock.Nama";
		        
				$search_keyword = $mylib->search_keyword($arrSearch["keyword"], $arr_keyword);
				$where_keyword = $search_keyword;
			}
				
		}
        	
		$sql = "
			SELECT * 
			FROM tour
			WHERE 
				1
				".$where_keyword."
			ORDER BY 
			  tour.Nama ASC 
			LIMIT 
			  $offset,$limit
		";
		//echo $sql;
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }
    
    function getGroup()
	{
        $mylib = new globallib();
        
        $sql = "
			SELECT * FROM groupstock ORDER BY Group_stkid ASC;
		";
		//echo $sql;
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }

    function num_travel_row($arrSearch)
    {		
        $mylib = new globallib();
        
        $where_keyword="";
        $where_kd_grouptravel = "";
        $where_nm_grouptravel="";
        if(count($arrSearch)*1>0)
        {
			if($arrSearch["keyword"]!="")
			{
		    	unset($arr_keyword);
		        $arr_keyword[0] = "tour.Tour_id";
				$arr_keyword[1] = "tour.Nama";
		        
				$search_keyword = $mylib->search_keyword($arrSearch["keyword"], $arr_keyword);
				$where_keyword = $search_keyword;
			}
			
			if($arrSearch["kd_grouptravel"]!="")
			{
				$where_kd_grouptravel = "AND tour.Tour_id = '".$arrSearch["kd_grouptravel"]."'";	
			}
			
			if($arrSearch["nm_grouptravel"]!="")
			{
				$where_nm_grouptravel = "AND tour.Nama LIKE '%".$arrSearch["nm_grouptravel"]."%'";	
			}
		}
        	
		$sql = "
			SELECT * 
			FROM tour
			WHERE 
				1
				".$where_keyword."
				".$where_kd_grouptravel."
				".$where_nm_grouptravel." 
		";
		//echo $sql;
        $qry = $this->db->query($sql);
        $num = $qry->num_rows();
        $qry->free_result();
        return $num;
	}
}
?>