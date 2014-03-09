<?php
/*
 * Model of cart
 *
 * @author rav <arudyuk@gmail.com>
 * @version 1.0
 */

class Cart_item extends MY_Model_Item {

    public function __construct() {
        parent::__construct();
        $this->_info['id']              = 0;
        $this->_info['phone']           = '';
        $this->_info['address']         = '';
        $this->_info['full_name']       = '';
        $this->_info['order_total']     = 0;
        $this->_info['items_total']     = 0;
        $this->_info['positions_total'] = 0;
        $this->_info['date_created']    = 0;
        $this->_info['email']           = '';
        $this->_info['comments']        = '';
        $this->_info['payment_method']  = 0;
    }

    public function __set($name, $value) {
        if (isset($this->_info[$name])) {
            if ($name == 'phone' || $name == 'address' || $name == 'full_name' || $name == 'email' || $name == 'comments' ) {
                $this->_info[$name] = trim($value);
            } else {
                $this->_info[$name] = (int)$value;
            }
        } else {
            return parent::__set($name, $value);
        }
    }
}