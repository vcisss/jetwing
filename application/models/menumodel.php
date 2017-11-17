<?php
class Menumodel extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    
    function get_root($level){
				$sql = "select * from menu where root='1' and UserLevelId='$level' and FlagAktif='1'  order by urutan"; //and UserLevelId='$level'
		/*$sql = "SELECT menu.* FROM
	(SELECT * FROM menu where root='1'  order by urutan)menu		
	INNER JOIN
	(SELECT * FROM userlevelpermissions WHERE userlevelid='-1' AND (`add`='Y' OR `edit`='Y' OR `delete`='Y' OR `view`='Y'))lv
	ON lv.tablename=menu.nama";
*/
		$qry = $this->db->query($sql);
		$row = $qry->result_array();
		$qry->free_result();
		return $row;
	}
	
	function get_drop_down($level)
	{
	 	$sql = "select distinct ulid from menu where ulid!='' and root=1  and FlagAktif='1'  and UserLevelId='$level' order by ulid";  // and UserLevelId='$level'
		$qry = $this->db->query($sql);
		$row = $qry->result_array();
		$qry->free_result();
		return $row;
				
	}
	function get_sub_menu($root,$level)
	{
		$sql = "select * from menu where root='$root' and UserLevelId='$level'  and FlagAktif='1' order by urutan"; //and UserLevelId='$level'
	/*	$sql = "select a.*,b.* from menu a, userlevelpermissions b where a.ulid='$root' and a.nama=b.tablename
and b.userlevelid=$level and (b.add='Y' or  b.edit='Y' or b.delete='Y' or b.view='Y')
order by urutan";
*/
//		$sql = "select * from menu where root='$root' and url=''  and UserLevelId='$level'
//		union
//		select a.* from menu a, userlevelpermissions b where a.root='$root' and a.flagaktif='1' and a.nama=b.tablename
//		and b.userlevelid=$level and (b.add='Y' or  b.edit='Y' or b.delete='Y' or b.view='Y')
//		order by urutan";

		$qry = $this->db->query($sql);
		$row = $qry->result_array();
		$qry->free_result();
		return $row;	
	}
}
?>