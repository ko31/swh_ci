<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wars extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('wars_model');
    }

	public function index()
	{
		$records = $this->wars_model->read_history();
        $data['records'] = $records;
		$this->load->view('history', $data);
	}

	public function update()
	{
		$this->wars_model->update_history();
	}
}
