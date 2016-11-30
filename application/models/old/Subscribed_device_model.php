<?php
class Subscribed_device_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function create($item)
    {
        $this->db->insert('subscribed_device', $item);
    }

    public function set_token($imei, $token, $device_type){
        $device = $this->is_registered($imei);

        if( $device != NULL ){
            $data = ['subscribed_device_token' => $token];
            $this->update($device->subscribed_device_id, $data );
        }else{
            $data = ['subscribed_device_imei' => $imei, 'subscribed_device_token' => $token, 'device_type' => $device_type];
            $this->create($data);
        }
    }

    function is_registered($imei){
        $this->db->select('*');
        $this->db->from('subscribed_device');
        $this->db->where('subscribed_device_imei', $imei);
        $query = $this->db->get();

        if($query->num_rows() < 1){
            return null;
        }
        else{
            return $query->row();
        }
    }


	function get_all()
	{
		$this->db->select('*');
		$this->db->from('subscribed_device');
		$query = $this->db->get();

		if($query->num_rows() < 1){
			return null;
		}
		else{
			return $query->result();
		}
	}

	function update($id, $item)
	{
		$this->db->where('subscribed_device_id', $id);
		$this->db->update('subscribed_device', $item);
	}

	function delete($id)
	{
		$this->db->where('subscribed_device_id', $id);
		$this->db->delete('subscribed_device');
	}
}