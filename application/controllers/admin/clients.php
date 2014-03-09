<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends Admin_Controller {

    protected $_module_title;
    protected $_templates;

    public function __construct() {
        parent::__construct();

        $this->_templates['list'] = 'clients/list';
        $this->_module_title      = 'пользователи сайта';
    }

    public function index() {
        $client_list = $this->user_mapper->get_clients();

        $this->template_data['client_list']  = $client_list;
        $this->template_data['module_title'] = $this->_module_title;

        $this->load->admin_view($this->_templates['list'], $this->template_data);
    }

}