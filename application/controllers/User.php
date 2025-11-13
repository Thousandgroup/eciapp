<?php 
Defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->template->load('layouts/main', 'user/index');
    }

}