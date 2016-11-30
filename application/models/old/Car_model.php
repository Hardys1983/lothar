<?php
/**
 * Created by PhpStorm.
 * User: FERNANDO
 * Date: 25/05/2015
 * Time: 6:55
 */

class Car_model extends CI_Model {

    function   __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_all(){
        $query = $this->db->get('auto');
        return $query->result();
    }

    public function get_by_client($cliente_id){
        $query = $this->db->get_where("auto",['cliente_id'=>$cliente_id]);
        return $query->result();
    }

    public function get_by($id){
        $query = $this->db->get_where('auto',['auto_id'=>$id]);
        return ($query->num_rows()>0)?$query->row():false;
    }

    public function create($marca,$modelo,$km,$url_photo,$cliente_id){
        $data=['marca'=>$marca,'modelo'=>$modelo,'km'=>$km,'cliente_id'=>$cliente_id,'url_photo'=>$url_photo];
        $this->db->insert("auto",$data);
        return $this->db->insert_id();
    }

    function update_qr_path($url_qr,$car_id){
        $this->db->update("auto",['url_qr'=>$url_qr],["auto_id"=>$car_id]);
    }

    public function update($marca,$modelo,$km,$id){
        $data=['marca'=>$marca,'modelo'=>$modelo,'km'=>$km];
        $this->db->update("auto",$data,['auto_id'=>$id]);
    }

    public function update_url($url,$id){
        $data=['url_photo'=>$url];
        $this->db->update("auto",$data,['auto_id'=>$id]);
    }

    public function delete($id){
        $this->db->delete('auto',['auto_id'=>$id]);
    }
    
    public function update_all($auto_id, $data){
        $this->db->update("auto", $data, ['auto_id' => $auto_id]);
    }
}