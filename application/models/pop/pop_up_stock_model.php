<?php
class Pop_up_stock_model extends CI_Model
{
	function __construct(){
        parent::__construct();
        $this->load->library('globallib');
    }
    
	function getStockIDList($limit,$offset,$arrSearch)
	{
        $mylib = new globallib();
        
	 	if($offset !=''){
			$offset = $offset;
		}
        else{
        	$offset = 0;
        }
        
        $where_keyword="";
        $where_kd_grouptravel = "";
        $where_nm_grouptravel="";
        if(count($arrSearch)*1>0)
        {
			if($arrSearch["keyword"]!="")
			{
		    	unset($arr_keyword);
		        $arr_keyword[0] = "stock.KdGroup";
				$arr_keyword[1] = "stock.NamaGroup";
		        
				$search_keyword = $mylib->search_keyword($arrSearch["keyword"], $arr_keyword);
				$where_keyword = $search_keyword;
			}
			
			if($arrSearch["kd_grouptravel"]!="")
			{
				$where_kd_grouptravel = "AND stock.KdGroup = '".$arrSearch["kd_grouptravel"]."'";	
			}
			
			if($arrSearch["nm_grouptravel"]!="")
			{
				$where_nm_grouptravel = "AND stock.NamaGroup LIKE '%".$arrSearch["nm_grouptravel"]."%'";	
			}
		}
        	
		$sql = "
			SELECT * 
			FROM stock
			WHERE 
				1
				".$where_keyword."
				".$where_kd_grouptravel."
				".$where_nm_grouptravel."
			ORDER BY 
			  stock.Nama ASC 
			LIMIT 
			  $offset,$limit
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
		        $arr_keyword[0] = "group_tour.KdGroup";
				$arr_keyword[1] = "group_tour.NamaGroup";
		        
				$search_keyword = $mylib->search_keyword($arrSearch["keyword"], $arr_keyword);
				$where_keyword = $search_keyword;
			}
			
			if($arrSearch["kd_grouptravel"]!="")
			{
				$where_kd_grouptravel = "AND group_tour.KdGroup = '".$arrSearch["kd_grouptravel"]."'";	
			}
			
			if($arrSearch["nm_grouptravel"]!="")
			{
				$where_nm_grouptravel = "AND group_tour.NamaGroup LIKE '%".$arrSearch["nm_grouptravel"]."%'";	
			}
		}
        	
		$sql = "
			SELECT * 
			FROM group_tour
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