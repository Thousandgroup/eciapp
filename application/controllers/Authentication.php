<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->load->view('layouts/login');
	}

	public function process_login()
	{
		$employee_id = $this->input->post('employee_id');
		$password = $this->input->post('password');

		if ($this->_validate_input($employee_id, $password) == TRUE) {
			// proses autentikasi user
			$this->_login($employee_id, $password);
		} else {
			// tampilkan pesan error
			$this->session->set_flashdata('error', validation_errors());
			redirect('authentication');
		}
	}

	private function _validate_input($employee_id, $password)
	{
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			return false;
		} else {
			return true;
		}
	}

	private function _login($employee_id, $password)
	{
		$employeeId = $this->security->xss_clean($employee_id);
		$pass = $this->security->xss_clean($password);
		$ip = get_real_ip();
	}
}
