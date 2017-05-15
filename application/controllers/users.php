<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller 
{

	function __construct()
	{

		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
	}

	public function index()
	{
		$data['user_list'] = $this->users_model->get_all_users();
		$this->load->view('show_users', $data);
	}

	public function getById($id)
	{

		$query = $this->db->get_where('users',array('id'=>$id));
		return $query->row_array();
	}

	public function edit()
	{
		$id = $this->uri->segment(3);
		$data['user'] = $this->getById($id);
		$this->load->view('edit', $data);
	}

	public function insert_users_to_db($data)
	{
		return $this->db->insert('users', $data);
	}


	function pr($str)
	{
		echo "<pre>";
		print_r($str);
		echo "</pre>";
	}

	public function update()
	{


		$mdata['name']=$_POST['name'];
		$mdata['email']=$_POST['email'];
		$mdata['address']=$_POST['address'];
		$mdata['mobile']=$_POST['mobile'];
		$res=$this->update_info($mdata, $_POST['id']);
		if($res)
		{
			header('location:'.base_url()."index.php/users/".$this->index());
		}
	}

	public function update_info($data,$id)
	{
		$this->db->where('users.id',$id);
		return $this->db->update('users', $data);
	}

	public function delete_a_user($id)
	{
		$this->db->where('users.id',$id);
		return $this->db->delete('users');
	}
	public function delete($id)
	{
		$this->delete_a_user($id);
		$this->index();
	}
	public function insert_new_user()
	{

		$udata['name'] = $this->input->post('name');
		$udata['email'] = $this->input->post('email');
		$udata['address'] = $this->input->post('address');
		$udata['mobile'] = $this->input->post('mobile');
		$res = $this->insert_users_to_db($udata);
		if($res)
		{
			header('location:'.base_url()."index.php/users/".$this->index());
		}

	}
	public function add_form()
	{

		$this->load->view('insert');
	}

}
