<?php

    Class Menu_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

     
    	
    	 public function get_all_title() 
         {
            $this->db->select('pg_title.*');
            $this->db->from('pg_title');
    		$this->db->where('pg_title.PARENT_ID = ',0,TRUE);
            $this->db->order_by('pg_title.TITLE_NAME', 'ASC');
            return $this->db->get()->result();
        }


         public function get_all_category() 
         {
            $this->db->select('post_category.*');
            $this->db->from('post_category');
            $this->db->order_by('post_category.CAT_ID', 'ASC');
            return $this->db->get()->result();
         }



        public function get_all_menu() 
        {
            $data=$this->db->query("SELECT TITLE_NAME,TITLE_ID,PG_URI,TITLE_NAME_BN FROM pg_title pt WHERE ACTIVE_STAT='Y' AND PARENT_ID=0 ORDER BY ORDER_NO ASC")->result();
            return $data;
        }
        public function get_chile_menu($id)
        {
            $data=$this->db->query("SELECT TITLE_NAME,TITLE_ID,PG_URI,TITLE_NAME_BN FROM pg_title pt WHERE PARENT_ID=$id ORDER BY ORDER_NO ASC")->result();
            return $data; 
        }


         public function insert_csv($data, $table) 
         {
           $this->db->insert($table, $data);
         }


         public function search($keyword)
        {
            $this->db->like('TITLE_NAME',$keyword);
            $query  =   $this->db->get('pg_title');
            return $query->result();
        }





        

    }
