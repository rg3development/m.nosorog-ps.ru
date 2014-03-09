<?php

class Cart_mapper extends MY_Model
{

    public function  __construct() {
        parent::__construct();

        $this->load->library('cart');

        $this->_table_item  = 'cart_item';
        $this->_table_order = 'cart_order';

        $this->_template['index']    = 'cart/index';
        $this->_template['checkout'] = 'cart/checkout';
        $this->_template['thankyou'] = 'cart/thankyou';

        $this->cart->product_name_rules = '\d\D';
        $this->cart->product_id_rules   = '^.';
    }

    public function get_client_orders ( $client_id = 0 )
    {
        $order_list = $this->db->select('*')
            ->from($this->_table_order)
            ->where('client_id', $client_id)
            ->get()
            ->result();

        $result = array();
        foreach ( $order_list as $key => $order )
        {
            $data['order'] = $order;

            $cart_data     = array();
            $data['items'] = array();

            $cart_items = $this->get_cart_items($order->id);
            foreach ( $cart_items as $index => $cart_item )
            {
                $cart_data['cart'] = $cart_item;
                $cart_data['catalog'] = $this->catalog_mapper->get_object($cart_item->item_id, 'item');
                $data['items'][] = $cart_data;
            }
            $result[] = $data;
        }
        // print_r($result);exit;
        return $result;
    }

    public function get_history ( $limit = 0, $order_by = 'id', $order_type = 'ASC', $date_from = 0, $date_to = 0 )
    {
        $this->db->select('*');
        $this->db->from($this->_table_order);

        if ( $date_from )
        {
            $this->db->where('date_created >=', $date_from);
        }
        if ( $date_to )
        {
            $this->db->where('date_created <=', $date_to);
        }
        if ( $limit )
        {
            $this->db->limit($limit);
        }
        $this->db->order_by($order_by, $order_type);

        $order_list = $this->db->get()->result();

        $result = array();
        foreach ( $order_list as $key => $order )
        {
            $data['order'] = $order;

            $cart_data     = array();
            $data['items'] = array();

            $cart_items = $this->get_cart_items($order->id);
            foreach ( $cart_items as $index => $cart_item )
            {
                $cart_data['cart'] = $cart_item;
                $cart_data['catalog'] = $this->catalog_mapper->get_object($cart_item->item_id, 'item');
                $data['items'][] = $cart_data;
            }
            $result[] = $data;
        }
        return $result;
    }

    public function get_cart_items ( $order_id = 0 )
    {
        return $cart_items = $this->db->select('*')
            ->from($this->_table_item)
            ->where('order_id', $order_id)
            ->get()
            ->result();
    }

    public function get_page_content($page_id = 0)
    {
        $total = $this->cart->total();
        $discount_price = 0;

        $client = $this->user_mapper->is_client();
        if ( $client )
        {
            $saving_discount = $this->catalog_mapper->get_saving_discount($client->order_sum);
            if ( $saving_discount )
            {
                if ($saving_discount->discount_percent > 0 && $saving_discount->discount_percent < 100)
                {
                    $discount_price = $total - (($total * $saving_discount->discount_percent) / 100);
                    $discount_price = $this->cart->format_number($discount_price);
                }
                elseif ($saving_discount->discount_price > 0 && $saving_discount->discount_price < $total)
                {
                    $discount_price = $total - $saving_discount->discount_price;
                }
            }
        }

        $total_price = ($discount_price > 0) ? $discount_price : $total;

        $template_data = array();

        $template_data['client']         = $client;
        $template_data['total']          = $total;
        $template_data['total_price']    = $total_price;
        $template_data['discount_price'] = $discount_price;

        $this->form_validation->set_rules('full_name', 'Фамилия, имя', 'required');
        $this->form_validation->set_rules('email', 'Электронный адрес', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Телефон', 'required');
        $this->form_validation->set_rules('address', 'Адрес', 'required');

        $this->form_validation->set_message('required', '<span>Поле "%s" не заполнено</span>');
        $this->form_validation->set_message('valid_email', '<span>Введен недействительный электронный адрес.</span>');

        if ( isset($_POST['type']) )
        {
            if ( $_POST['type'] == 'order' )
            {
                return $this->load->site_view($this->_template['checkout'], $template_data, TRUE);
            }
            if ( $_POST['type'] == 'save' )
            {
                if ( $this->form_validation->run() )
                {
                    if ( $total )
                    {
                        $now = date("Y-m-d H:i:s", time());
                        // save order
                        $order_data = array();
                        $order_data['full_name']       = $this->input->post('full_name');
                        $order_data['phone']           = $this->input->post('phone');
                        $order_data['address']         = $this->input->post('address');
                        $order_data['email']           = $this->input->post('email');
                        $order_data['comments']        = $this->input->post('comments');
                        $order_data['payment_method']  = $this->input->post('payment_method');
                        $order_data['order_total']     = $total_price;
                        $order_data['positions_total'] = $this->cart->total_items();
                        $order_data['items_total']     = count($this->cart->contents());
                        $order_data['date_created']    = $now;

                        if ( $client )
                        {
                            $order_data['client_id'] = $client->id;
                            $this->user_mapper->inc_order_sum($client->id, $total_price);
                        }

                        $this->db->insert('cart_order', $order_data);

                        $order_id = $this->db->insert_id();
                        $order_data['order_id'] = $order_id;

                        // save cart item
                        $data = array();
                        foreach ( $this->cart->contents() as $item )
                        {
                            $data['item_id']      = $item['id'];
                            $data['order_id']     = $order_id;
                            $data['base_price']   = $item['price'];
                            $data['qty']          = $item['qty'];
                            $data['date_created'] = $now;
                            $cart_data[] = $data;
                        }
                        $this->db->insert_batch('cart_item', $cart_data);

                        // TODO: payment operations

                        $this->_send_mails($this->input->post('email'), $order_id, $total_price);
                        $this->cart->destroy();
                    } else {
                        redirect(base_url('catalog'));
                    }
                    return $this->load->site_view($this->_template['thankyou'], array(), TRUE);
                } else {
                    return $this->load->site_view($this->_template['checkout'], $template_data, TRUE);
                }
            }
        }
        return $this->load->site_view($this->_template['index'], $template_data, TRUE);
    }

    private function _send_mails ( $user_email, $order_id, $total_price )
    {
        $cart_settings = $this->manager_modules->get_settings();

        // список товаров в заказе
        $purchases = "
            <p>Номер заказа: {$order_id}</p>
            <table style='width:100%;'>
                <tr>
                    <td>Наименование</td>
                    <td>Количество</td>
                    <td>Цена</td>
                    <td>Сумма</td>
                    <td>Артикул</td>
                </tr>
        ";
        foreach ( $this->cart->contents() as $cart_item )
        {
            $purchases .= "
                <tr>
                    <td>{$cart_item['name']}</td>
                    <td>{$cart_item['qty']}</td>
                    <td>{$cart_item['price']} руб.</td>
                    <td>{$cart_item['subtotal']} руб.</td>
                    <td>{$cart_item['options']['article']}</td>
                </tr>
            ";
        }
        $purchases .= "
            <tr>
                <td>Итоговая сумма заказа:</td>
                <td></td>
                <td></td>
                <td>" . $this->cart->format_number($total_price) . "</td>
            </tr>
        ";
        $purchases .= '</table><br/>';

        // информация о покупателе
        $sql = "
            SELECT
                *
            FROM
                `cart_item`
                    JOIN
                        `cart_order`
                    ON
                        cart_order.id = cart_item.order_id
            WHERE
                cart_order.id = '{$order_id}'
        ";
        $db_result = $this->db->query($sql)->row_array();
        $userinfo = '<br/><div>';
        $userinfo .= '<p>Имя - '.$db_result['full_name'].'</p>';
        $userinfo .= '<p>Адрес - '.$db_result['address'].'</p>';
        $userinfo .= '<p>Телефон - '.$db_result['phone'].'</p>';
        $userinfo .= '<p>Электронная почта - '.$db_result['email'].'</p>';
        $userinfo .= '<p>Способ оплаты - '.$this->_payment_method($db_result['payment_method']).'</p>';
        $userinfo .= '<p>Комментарии - '.$db_result['comments'].'</p>';
        $userinfo .= '</div></br>';

        // формат сообщения письма оператору
        $operator_message = '<html><header></header><body><div>';
        $operator_message .= $cart_settings['CART_OPERATOR_MESSAGE'];
        $operator_message .= '</br></div>';
        $operator_message .= $purchases;
        $operator_message .= '<br/><div>';
        $operator_message .= $userinfo;
        $operator_message .= '</body></html>';

        // отправка письма оператору
        $this->_send_mail(
            $cart_settings['CART_OPERATOR_SENDER_EMAIL'],
            $cart_settings['CART_OPERATOR_SENDER_NAME'],
            $cart_settings['CART_OPERATOR_EMAIL'],
            $cart_settings['CART_OPERATOR_SUBJECT'],
            $operator_message
        );

        // формат сообщения письма покупателю
        $client_message = '<html><header></header><body><div>';
        $client_message .= $cart_settings['CART_CLIENT_MESSAGE'];
        $client_message .= '</br></div>';
        $client_message .= $purchases;
        $client_message .= '<br/><div>';
        $client_message .= '</body></html>';

        // отправка письма покупателю
        $this->_send_mail(
            $cart_settings['CART_CLIENT_SENDER_EMAIL'],
            $cart_settings['CART_CLIENT_SENDER_NAME'],
            $user_email,
            $cart_settings['CART_CLIENT_SUBJECT'],
            $client_message
        );
    }

    private function _send_mail ( $from_email, $from_name, $to_email, $subject, $message )
    {
        // Load Email library
        $this->load->library('email');
        // Setting Email Preferences
        $config['mailtype'] = 'html';
        // Sending Email
        $this->email->initialize($config);
        $this->email->from($from_email, $from_name);
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    public function _payment_method ( $index = 0 )
    {
        $result = array();
        $result[0] = 'unknown';
        $result[1] = 'Наличными';
        $result[2] = 'Банковской картой';
        if ( isset($result[$index]) )
        {
            return $result[$index];
        }
        return $result[0];
    }

}