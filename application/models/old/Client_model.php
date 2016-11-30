<?php
/**
 * Created by PhpStorm.
 * User: FERNANDO
 * Date: 25/05/2015
 * Time: 6:55
 */

class Client_model extends CI_Model {

    function   __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_all(){
        $query = $this->db->get('cliente');
        return $query->result();
    }

    public function get_by($id){
        $query = $this->db->get_where('cliente',['cliente_id'=>$id]);
        return ($query->num_rows()>0)?$query->row():false;
    }

    public function create($name,$cedula,$telefono){
        $data=['name'=>$name,'cedula'=>$cedula,'telefono'=>$telefono];
        $this->db->insert("cliente",$data);
        return $this->db->insert_id();
    }

    public function update($name,$cedula,$telefono,$id){
        $data=['name'=>$name,'cedula'=>$cedula,'telefono'=>$telefono];
        $this->db->update("cliente",$data,['cliente_id'=>$id]);
    }

    public function delete($id){
        $this->db->delete('cliente',['cliente_id'=>$id]);
    }
}