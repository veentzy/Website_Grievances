<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Content extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function role1()
    {
        $data['title'] = 'Role1';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role1'] = $this->db->get('user_role1')->result_array();

        $this->form_validation->set_rules('role1_name', 'Role1 Name', 'required|trim');
        $this->form_validation->set_rules('summary_name', 'Summary', 'trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('content/role1', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_role1', [
                'role1' => $this->input->post('role1_name'),
                'summary' => $this->input->post('summary_name')
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New role1 added!</div>');
            redirect('content/role1');
        }
    }
}
