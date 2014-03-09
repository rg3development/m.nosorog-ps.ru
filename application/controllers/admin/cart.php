<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends Admin_Controller {

    protected $_module_title;
    protected $_templates;

    public function __construct() {
        parent::__construct();
        $this->_module_title       = 'история заказов';
        $this->_templates['index'] = 'cart/index';

        $this->template_data['module_title'] = $this->_module_title;
    }

    public function index ()
    {
        if ( ! $limit = $this->input->get('f_limit') )
        {
            $limit = 0;
        }
        if ( ! $sort_by = $this->input->get('f_sort_by') )
        {
            $sort_by = 'id';
        }
        if ( ! $sort_type = $this->input->get('f_sort_type') )
        {
            $sort_type = 'DESC';
        }
        if ( ! $date_from = $this->input->get('f_date_from') )
        {
            $date_from = '';
        }
        if ( ! $date_to = $this->input->get('f_date_to') )
        {
            $date_to = '';
        }

        $cart_history = $this->cart_mapper->get_history($limit, $sort_by, $sort_type, $date_from, $date_to);

        $this->template_data['f_limit']     = $limit;
        $this->template_data['f_sort_by']   = $sort_by;
        $this->template_data['f_sort_type'] = $sort_type;
        $this->template_data['f_date_from'] = $date_from;
        $this->template_data['f_date_to']   = $date_to;

        $this->template_data['module_title'] = $this->_module_title;
        $this->template_data['cart_history'] = $cart_history;

        $this->load->admin_view($this->_templates['index'], $this->template_data);
    }

}