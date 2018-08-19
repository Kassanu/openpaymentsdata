<?php

class Payments_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_payment($id) {

    }

    public function get_payments($search, $limit, $offset) {
        $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE);
        $this->db->from("general_payment_data_2017");
        if ($search !== false) {
            $tokens = explode(' ', $search, 2);
            if (count($tokens) === 2) {
                $this->db->like('physician_first_name', $tokens[0]);
                $this->db->like('physician_last_name', $tokens[1]);
            }
            $this->db->or_like('physician_first_name', $search);
            $this->db->or_like('physician_last_name', $search);
        }
        if ($limit !== false) {
            $this->db->limit($limit, $offset);
        }
        $results = $this->db->get();
        if ($results) {
            $count = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
            return ["total"=>$count->row()->Count, "results"=>$results->result()];
        }

        return false;
    }

    public function searchPhysicians($search, $limit) {
        if ($search !== false) {
            $this->db->select('physician_first_name, physician_last_name');
            $this->db->from("general_payment_data_2017");
            $tokens = explode(' ', $search, 2);
            if (count($tokens) === 2) {
                $this->db->like('physician_first_name', $tokens[0]);
                $this->db->like('physician_last_name', $tokens[1]);
            }
            $this->db->or_like('physician_first_name', $search);
            $this->db->or_like('physician_last_name', $search);
            $this->db->group_by(array("physician_first_name", "physician_last_name"));
            $this->db->limit($limit);
            $results = $this->db->get();
            if ($results) {
                return $results->result();
            }
        }
        return false;
    }

}