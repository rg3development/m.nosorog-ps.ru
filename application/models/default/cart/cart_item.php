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
        $this->_info['id']           = 0;
        $this->_info['item_id']      = 0;
        $this->_info['order_id']     = 0;
        $this->_info['date_created'] = '';
        $this->_info['base_price']   = 0;
        $this->_info['qty']          = 0;
    }

    public function __set($name, $value) {
        if (isset($this->_info[$name])) {
            if ($name == 'date_created') {
                $this->_info[$name] = trim($value);
            } else {
                $this->_info[$name] = (int)$value;
            }
        } else {
            return parent::__set($name, $value);
        }
    }
}