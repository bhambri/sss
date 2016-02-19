<?php
/*
---------------------------------------------------------------
*	Class:		Contact_model extends Model defined in Core libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality to contact model. 
---------------------------------------------------------------
*/

class Contact_model extends CI_Model{

	/**
     * method  add_contact
     * Description function for adding contact us data
     * on basis of id
     * @param nane
     */
    function add_contact( $data ){
		

		$this->db->insert('contact', $data);
		if($this->db->insert_id() > 0)
		{
			return $this->db->insert_id();
		} else
		{
			return false;
		}
    }

    /**
     * method  add_enquiry
     * Description function for adding enquiry sumited at front
     * @param nane
     */
    function add_enquiry(){
		$data = array(
			'name' => htmlspecialchars($this->input->post('name')),
			'comments' => htmlspecialchars($this->input->post('how_know')),
			'email' => htmlspecialchars($this->input->post('email')),
			'city' => htmlspecialchars($this->input->post('city')),
			'state' => htmlspecialchars($this->input->post('state')),
			'address' => htmlspecialchars($this->input->post('address')),
			'phone' => htmlspecialchars($this->input->post('cphone')),
			'looking_to_invest' => htmlspecialchars($this->input->post('invest')),
			'no_of_units' => htmlspecialchars($this->input->post('units')),
			'zip_code' => htmlspecialchars($this->input->post('zip')),
			'contact_type' => 'E',
			);
		
		$this->db->insert('contact', $data);
		if($this->db->insert_id() > 0)
		{
			return $this->db->insert_id();
		} else
		{
			return false;
		}
    }
}