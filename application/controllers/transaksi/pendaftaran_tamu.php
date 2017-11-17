<?php

class Pendaftaran_tamu extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->library('globallib');
        $this->load->model('globalmodel');
        $this->load->model('transaksi/pendaftaran_tamu_model');
    }

    function index() 
    {
    	$mylib = new globallib();
        $sign = $mylib->getAllowList("all");
        $offset = $this->uri->segment(4);
        
        if ($sign == "Y") {
            
            $data['leader'] = $this->pendaftaran_tamu_model->getTourleader();
			$data['tour'] = $this->pendaftaran_tamu_model->getTourtravel();
			$data['guide'] = $this->pendaftaran_tamu_model->getTourguide();
			$data['propinsi'] = $this->pendaftaran_tamu_model->getPropinsi();
			$data['pendaftaran'] = $this->pendaftaran_tamu_model->getBeo();
			$data['offset'] = "";
			
            $data['track'] = $mylib->print_track();

            $this->load->view('transaksi/Pendaftaran_tamu/pendaftaran_tamu_list', $data);
        } else {
            $this->load->view('denied');
        }
    } 
  
    function search() 
    {
    	$mylib = new globallib();
    	
        $user = $this->session->userdata('username');

        // hapus dulu yah
        $this->db->delete('ci_query', array('module' => 'voucher_beo', 'AddUser' => $user));

		$search_value = "";
		$search_value .= "search_keyword=".$mylib->save_char($this->input->post('search_keyword'));
		$search_value .= "&search_status=".$this->input->post('search_status');
		
		$data = array(
            'query_string' => $search_value,
            'module' => "voucher_beo",
            'AddUser' => $user
        );
		
        $this->db->insert('ci_query', $data);

        $query_id = $this->db->insert_id();

        redirect('/transaksi/voucher_beo/index/' . $query_id . '');
    }
    
    
    function getList()
    {
    		
    	    $keyword = $this->uri->segment(5);
            $status = $this->uri->segment(6);
            
            //echo  $keyword." - ".$status;die;
            	
            // pagination
            $this->load->library('pagination');
            $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
            $config['full_tag_close'] = '</ul>';
            $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
            $config['cur_tag_close'] = '</a></li>';
            $config['per_page'] = '25';
            $config['first_link'] = 'First';
            $config['last_link'] = 'Last';
            $config['num_links'] = 2;
            $config['total_rows'] = $this->pendaftaran_tamu_model->num_pendaftaran_row();
            $config['base_url'] = base_url() . 'index.php/transaksi/pendaftaran_tamu/index/';
            $config['uri_segment'] = 4;
            $page = $this->uri->segment(4);
            
            $data['tour'] = $this->pendaftaran_tamu_model->getTourtravel();
			
			if($page==""){
				$data['startnum']=1;
			}else{
				$data['startnum']=$page+1;
			}
			
            $data['data'] = $this->pendaftaran_tamu_model->getPendaftaranList($keyword,$status,$page,$config['per_page']);
			
			$this->pagination->initialize($config);
            $data["pagination"] = $this->pagination->create_links();
            
		$this->load->view('transaksi/pendaftaran_tamu/pendaftaran_tamu_getlist', $data);
	}
    
    
    public function ajax_add() {    	
        //$this->_validate();
        //echo "<pre>";print_r($_POST);echo "</pre>";die; 
        $user = $this->session->userdata('username');
        $mylib = new globallib(); 
        
        $tanggal = $this->input->post('v_date_pendaftaran');
        $no_pendaftaran = $this->input->post('v_no_pendaftaran');
        $tourleader = $this->input->post('v_tourleader');
        $tourtravel = $this->input->post('v_tourtravel');
        $tourguide = $this->input->post('v_tourguide');
        $propinsi = $this->input->post('v_propinsi');
        $pax_adult = $this->input->post('pax_adult'); 
        $pax_child = $this->input->post('pax_child');   
        $keterangan = $this->input->post('v_ket');    
                
        //jenis 1 piutang sedangkan jenis 2 lunas	
		$data = array(
		    'id_pendaftaran'=>$no_pendaftaran,
            'Tanggal'=>$mylib->ubah_tanggal($tanggal),
            'Leader_id'=>$tourleader,
            'Guide_id'=>$tourguide,
            'Tour_id'=>$tourguide,   
            'Propinsi_id'=>$propinsi, 
            'PAX_adult'=>$pax_adult, 
            'PAX_child'=>$pax_child, 
            'Keterangan'=>$keterangan,      
            'AddUser'=>$user,
            'AddDate'=>date('Y-m-d')         
        );
        
        $this->db->insert("pendaftaran", $data);
        echo json_encode(array("status" => TRUE));
    }

    
    public function ajax_update() {    	
        
        //$this->_validate();
        //echo "<pre>";print_r($_POST);echo "</pre>";die; 
        $user = $this->session->userdata('username');
        $mylib = new globallib(); 
        
        $tanggal = $this->input->post('v_date_pendaftaran');
        $no_pendaftaran = $this->input->post('v_no_pendaftaran');
        $tourleader = $this->input->post('v_tourleader');
        $tourtravel = $this->input->post('v_tourtravel');
        $tourguide = $this->input->post('v_tourguide');
        $propinsi = $this->input->post('v_propinsi');
        $pax_adult = $this->input->post('pax_adult'); 
        $pax_child = $this->input->post('pax_child');   
        $keterangan = $this->input->post('v_ket');     
                
        //jenis 1 piutang sedangkan jenis 2 lunas	
		$data = array(
            'Tanggal'=>$mylib->ubah_tanggal($tanggal),
            'Leader_id'=>$tourleader,
            'Guide_id'=>$tourguide,
            'Tour_id'=>$tourtravel,   
            'Propinsi_id'=>$propinsi, 
            'PAX_adult'=>$pax_adult, 
            'PAX_child'=>$pax_child, 
            'Keterangan'=>$keterangan,      
            'EditUser'=>$user,
            'EditDate'=>date('Y-m-d')         
        );
        
        $this->db->update("pendaftaran", $data, array('id_pendaftaran'=>$no_pendaftaran));
        echo json_encode(array("status" => TRUE));
    }
        
    public function ajax_edit_pendaftaran($id) {
        $nodok = str_replace("-", "/", $id);
        $data = $this->pendaftaran_tamu_model->get_by_id($nodok);
  
        echo json_encode($data);
    }
    
    public function generate_number_voucher() {
    	
    	$tgl=date('d-m-Y');
        $bulan = substr($tgl, 3, 2);
        $tahun = substr($tgl, -2);
        $no    = $this->get_no_counter('pendaftaran','id_pendaftaran',$tahun,$bulan);
		    	
        $data = array('v_no_pendaftaran'=>$no);
        echo json_encode($data);
    }
    
    function lock($id) 
    {
    	$this->db->update("pendaftaran", array('Status'=>1),array('id_pendaftaran'=>$id));
    	echo json_encode(array("status" => TRUE));
    }
    
    function get_no_counter( $table_name, $col_primary, $thn,$bln) {
        $query = "
        SELECT
            " . $table_name . "." . $col_primary . "
        FROM
            " . $table_name . "
        WHERE
            1
            AND SUBSTR(" . $table_name . "." . $col_primary . ", 1,4) = '" .$thn.$bln. "'

        ORDER BY
            " .$table_name . "." . $col_primary . " DESC
        LIMIT
            0,1
        ";
        //echo $query;
        $qry = mysql_query($query);
        $row = mysql_fetch_array($qry);
        list($col_primary_ok) = $row;

        $counter = (substr($col_primary_ok, 4, 7) * 1) + 1;
        $counter_fa = sprintf($thn . $bln. sprintf("%07s", $counter));
        return $counter_fa;

    }
    
	function doPrint()
	{
		//echo "<pre>";print_r($_POST);echo "</pre>";die;
		$this->load->library('printreportlib');
		$mylib = new globallib();
		$printlib = new printreportlib();
		
		$nodok = $this->uri->segment(4);
		$user = $this->session->userdata('username');
		$spasi_awal = " ";
		
		$arr_epson = array();
		$arr_epson = $mylib->sintak_epson();
		
		$echo = "";
		$echo .= $spasi_awal;
		$pt = $printlib->getNamaPT();
		
		
		$total_spasi = 135;
	    $total_spasi_header = 80;
	    
	    
	    $jml_detail  = 8;
	    $ourFileName = "voucher-beo.txt";
		
		$header = $this->pendaftaran_tamu_model->getHeader($nodok);
		$detail = $this->pendaftaran_tamu_model->getDetail_cetak($nodok);
		$note_header = substr($header->note,0,40);
		
		$echo="";
		$counter = 1;
		foreach($detail as $val)
		{
            $arr_data["detail_pcode"][$counter] = $val["inventorycode"];
            $arr_data["detail_namabarang"][$counter] = substr($val["NamaLengkap"],0,60);
            $arr_data["detail_qty"][$counter] = $val["quantity"];
            $arr_data["detail_satuan"][$counter] = $val["SatuanSt"];
			$arr_data["detail_namasatuan"][$counter] = $val["NamaSatuan"];
			$counter++;
		}
        
        $curr_jml_detail = count($detail);
        $jml_page = ceil($curr_jml_detail/$jml_detail);
        
        $nama_dokumen = "VOUCHER";
        
        $grand_total = 0;
        for($i_page=1;$i_page<=$jml_page;$i_page++)
        {
            if($i_page%2==0)
            {
                $echo.="\r\n"; 
                $echo.="\r\n"; 
            }
            
            // header
            {
                $echo.=$arr_epson["cond"].$pt->Nama;
                $echo.="\r\n";    
                
                $echo.=$arr_epson["cond"].$pt->Alamat1;
                $echo.="\r\n";    
                
                $echo.=$arr_epson["cond"].$pt->Alamat2;
                $echo.="\r\n";    
                
                $echo.=$arr_epson["cond"]."Phone:".$pt->TelpPT;
                $echo.="\r\n"; 
            }
            $echo.="\r\n";
			$echo .= $arr_epson["cond"].$nama_dokumen;
            $echo.="\r\n"; 
            $echo.="\r\n"; 
            
            // No. Voucher
            {
            	// ----------------------------------------------------
                $echo.=$arr_epson["cond"]."No. Voucher";
                $limit_spasi = (20-2);
                for($i=0;$i<($limit_spasi-strlen("No. Voucher"));$i++)
                {
                    $echo.=" ";
                }
                $echo.=": ";
                
                $echo.=$arr_epson["cond"].$header->no_voucher;         
                
                // -----------------------------------------------------
                $echo.="\r\n"; 
            } 
            
            // No. Voucher Travel
            {
            	// ----------------------------------------------------
                $echo.=$arr_epson["cond"]."No. Vouc. Travel";
                $limit_spasi = (20-2);
                for($i=0;$i<($limit_spasi-strlen("No. Vouc. Travel"));$i++)
                {
                    $echo.=" ";
                }
                $echo.=": ";
                
                $echo.=$arr_epson["cond"].$header->no_voucher_travel;         
                
                // -----------------------------------------------------
                $echo.="\r\n"; 
            }  
            
            // Tanggal
            {
            	// ----------------------------------------------------
                $echo.=$arr_epson["cond"]."Exp. Date";
                $limit_spasi = (20-2);
                for($i=0;$i<($limit_spasi-strlen("Exp. Date"));$i++)
                {
                    $echo.=" ";
                }
                $echo.=": ";
                
                $echo.=$arr_epson["cond"].$mylib->ubah_tanggal($header->expDate);         
                
                $limit_spasi = 65;
                for($i=0;$i<($limit_spasi-strlen($header->expDate));$i++)
                {
                    $echo.=" ";
                }
                // -----------------------------------------------------
                $echo.="\r\n"; 
            }
            
            // Travel
            {
            	// ----------------------------------------------------
                $echo.=$arr_epson["cond"]."Travel";
                $limit_spasi = (20-2);
                for($i=0;$i<($limit_spasi-strlen("Travel"));$i++)
                {
                    $echo.=" ";
                }
                $echo.=": ";
                
                $echo.=$arr_epson["cond"].$header->Nama;         
                
                $limit_spasi = 65;
                for($i=0;$i<($limit_spasi-strlen($header->Nama));$i++)
                {
                    $echo.=" ";
                }
                // -----------------------------------------------------
                $echo.="\r\n"; 
            }
            
            // Nilai
            {
            	// ----------------------------------------------------
                $echo.=$arr_epson["cond"]."Nilai";
                $limit_spasi = (20-2);
                for($i=0;$i<($limit_spasi-strlen("Nilai"));$i++)
                {
                    $echo.=" ";
                }
                $echo.=": ";
                
                $echo.=$arr_epson["cond"].number_format($header->nilai);         
                
                $limit_spasi = 65;
                for($i=0;$i<($limit_spasi-strlen($header->nilai));$i++)
                {
                    $echo.=" ";
                }
                // -----------------------------------------------------
                $echo.="\r\n"; 
            }
            
            // BEO
            {
            	// ----------------------------------------------------
                $echo.=$arr_epson["cond"]."BEO";
                $limit_spasi = (20-2);
                for($i=0;$i<($limit_spasi-strlen("BEO"));$i++)
                {
                    $echo.=" ";
                }
                $echo.=": ";
                
                $echo.=$arr_epson["cond"].$header->BEO;         
                
                $limit_spasi = 65;
                for($i=0;$i<($limit_spasi-strlen($header->BEO));$i++)
                {
                    $echo.=" ";
                }
                // -----------------------------------------------------
                $echo.="\r\n"; 
            }
            
            // ket
            {
            	// ----------------------------------------------------
                $echo.=$arr_epson["cond"]."Keterangan";
                $limit_spasi = (20-2);
                for($i=0;$i<($limit_spasi-strlen("Keterangan"));$i++)
                {
                    $echo.=" ";
                }
                $echo.=": ";
                
                $echo.=$arr_epson["cond"].$header->Keterangan;         
                
                $limit_spasi = 65;
                for($i=0;$i<($limit_spasi-strlen($header->Keterangan));$i++)
                {
                    $echo.=" ";
                }
                // -----------------------------------------------------
                $echo.="\r\n"; 
            }

            $echo .= "\r\n";  
			
			if($user!="mechael0101")
	        {
		        $data = array(
		            'form_data' => "delivery-order",
		            'noreferensi' => $header->no_voucher,
		            'userid' => $user,
		            'print_date' => date('Y-m-d H:i:s'),
		            'print_page' => "Setengah Letter"
		        );

		        $this->db->insert('log_print', $data);
	        }
		}

		$paths = "path/to/";
	    $name_text_file='voucher-beo-'.$user.'.txt';
	    $mylib->create_txt_report($paths,$name_text_file,$echo);
	    
		header("Content-type: application/txt");
		header("Content-Disposition: attachment; filename=" . $name_text_file);
		$content = read_file($paths."/".$name_text_file);
		echo $content;
		
	}
    		
}

?>