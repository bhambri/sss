<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Messages extends VCI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('mahana_messaging');

		$this->load->helper('vci_common');
		$user	= get_message_user();

		$this->user_id	= $user['user_id'];
		$this->store_id	= $user['store_id'];
		
		$this->_vci_layout('menu-toolbar');
	}
	
	function listing($last_record_number = 0)
	{
		$view_data['caption']	= 'Messages';
		$data	= $this->mahana_messaging->get_all_threads($this->user_id, FALSE, 'desc', $last_record_number);
		$view_data['messages']	= $data['retval'];
		
		$this->load->library('pagination');

		$messages	= $this->mahana_messaging->get_all_threads_count($this->user_id);
		$config	= [
			'base_url' 	=> base_url() . 'messages/listing/',
			'total_rows'=> $messages['retval'][0]['count'],
			'per_page'	=> 10,
		];

		$this->pagination->initialize($config); 

		$view_data['pagination']	= $this->pagination->create_links();

		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Messages' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		$this->_vci_view('messages/listing', $view_data);
	}
	
	function delete() {
		foreach($_REQUEST['messages'] as $thread_id) {
			$data	= $this->mahana_messaging->remove_participant($thread_id, $this->user_id);
		}
		$this->session->set_flashdata('success', 'Message(s) Deleted');
		redirect('/messages/listing', 'refresh');
	}
	
	function markread() {
		foreach($_REQUEST['messages'] as $thread_id) {
			$data	= $this->mahana_messaging->mark_thread_read($thread_id, $this->user_id);
		}
		$this->session->set_flashdata('success', 'Message(s) marked as read');
		redirect('/messages/listing', 'refresh');
	}
	
	function view($thread_id) {
		$messages	= $this->mahana_messaging->get_full_thread($thread_id, $this->user_id);
		$this->mahana_messaging->mark_thread_read($thread_id, $this->user_id);

		$view_data['messages']	= $messages['retval'];
		$view_data['thread_id']	= $thread_id;
		
		$view_data['caption']	= 'Message';
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Messages' => array('link'=>'/messages/listing', 'attributes' => array('class'=>'breadcrumb')),
			''.$messages['retval'][0]['subject'].'' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		
		$this->_vci_view('messages/view', $view_data);
	}
	
	function reply() {
		if($this->input->post('message_id')) {
			$message_id	= $this->input->post('message_id');
			$message	= $this->input->post('message');
			$this->mahana_messaging->reply_to_message($message_id, $this->user_id, $message);
			redirect('/messages/view/' . $this->input->post('thread_id') , 'refresh');
		}
		redirect('/messages/listing', 'refresh');
	}
	
	function compose() {
		if($this->input->post('subject')) {
			$participants	= $this->input->post('participant');
			$subject		= $this->input->post('subject');
			$message		= $this->input->post('message');
			$this->mahana_messaging->send_new_message($this->user_id, $participants, $subject, $message, 10);
			$this->session->set_flashdata('success', 'Message(s) sent successfully.');
			redirect('/messages/listing', 'refresh');
		}
		
		$this->db->where('id !=', $this->user_id);
		if($this->store_id)
			$this->db->where_in('store_id', $this->store_id);
		$query = $this->db->get('chat_users');

		$chat_users	= $query->result();

		
		$view_data['chat_users']		= $chat_users;
		$view_data['caption']	= 'Compose Message';
		
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Messages' => array('link'=>'/messages/listing', 'attributes' => array('class'=>'breadcrumb')),
			'Compose Message' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		
		$this->_vci_view('messages/compose', $view_data);
	}
}