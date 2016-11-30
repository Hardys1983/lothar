<?php

class News_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function create($data) {
        $this->db->set('date', $data['date']);
        $this->db->set('content', $data['content']);
        $this->db->set('title', $data['title']);
        $this->db->set('state', $data['state']);
        $this->db->set('main_image', $data['main_image']);
        return $this->db->insert('news');

        //return $this->db->inserted_id();
    }

    function get_by_id($id) {
        $this->db->where('news_id', $id);
        $query = $this->db->get('news');

        return $query->row();
    }

    function get_by_date($date) {
        $this->db->where('date', $date);
        $query = $this->db->get('news');

        return $query->result();
    }

    function get_all() {
        $query = $this->db->get('news');

        return $query->result();
    }

    function update($id, $data) {
        
        $this->db->where('news_id', $id);
        if (isset($data['date']))
            $this->db->set('date', $data['date']);
        if (isset($data['content']))
            $this->db->set('content', $data['content']);
        if (isset($data['title']))
            $this->db->set('title', $data['title']);
        if (isset($data['state']))
            $this->db->set('state', $data['state']);
        if (isset($data['main_image']))
            $this->db->set('main_image', $data['main_image']);
        //print_r($data);die();
        $this->db->update('news');
        return $this->db->affected_rows();
    }

    function delete($id) {
        $this->db->where('news_id', $id);
        $this->db->delete('news');

        return $this->db->affected_rows();
    }
}
