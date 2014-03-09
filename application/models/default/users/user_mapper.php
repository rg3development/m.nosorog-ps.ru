<?php
/*
 * Model of feedback mapper
 *
 * @author rav <arudyuk@gmail.com>
 * @version 1.0
 */

class User_mapper extends MY_Model {

    protected $_register = 'user/register';
    protected $_login    = 'user/login';
    protected $_forget   = 'user/forget';
    protected $_newpass  = 'user/newpass';
    protected $_success  = 'user/success';
    protected $_cabinet  = 'user/cabinet';

    protected $_table = 'clients';

    protected $settings;

    public $delta_time = 10800;

    public function  __construct() {
        parent::__construct();
        $this->settings = $this->manager_modules->get_settings();
    }

    public function is_client ()
    {
        $client_id    = $this->session->userdata('client_id');
        $client_login = $this->session->userdata('client_login');
        $client_email = $this->session->userdata('client_email');
        if ( $client_id && $client_login && $client_email )
        {
            return $this->get_user_by_login($client_login);
        }
        return FALSE;
    }

    public function inc_order_sum ( $client_id = 0, $order_sum = 0 )
    {
        $this->db->set('order_sum', "order_sum+{$order_sum}", FALSE);
        $this->db->where('id', $client_id);
        $this->db->update($this->_table);
    }

    public function get_page_content($page_id = 0)
    {
        $page = $this->page_mapper->get_page($page_id);
        $template_data['form_url'] = $page->url;

        if ( ($cmd = $this->input->get('cmd')) && ($cmd == 'logout') )
        {
            $this->logout();
            $template = $this->_login;
            return $this->load->site_view($template, $template_data, TRUE);
        }

        // check auth
        if ( $client = $this->is_client() )
        {
            $template_data['order_list'] = $this->cart_mapper->get_client_orders($client->id);
            $template_data['user_info']  = $client;
            $template = $this->_cabinet;
            return $this->load->site_view($template, $template_data, TRUE);
        }

        // password reminder
        if ( ($user = $this->input->get('u')) && ($hash = $this->input->get('hash')) )
        {
            if ( $this->hash_check($user, $hash) )
            {
                $template = $this->_newpass;
                $template_data['rem_user'] = $user;
                $template_data['rem_hash'] = $hash;
            } else {
                $template = $this->_success;
                $template_data['message'] = 'Неверная ссылка!';
            }
            return $this->load->site_view($template, $template_data, TRUE);
        }

        // change form type
        if ( $form = $this->input->get('form') )
        {
            switch ( $form )
            {
                // register
                case 'reg':
                    $template = $this->_register;
                    break;
                // login
                case 'log':
                    $template = $this->_login;
                    break;
                // forget password
                case 'rem':
                    $template = $this->_forget;
                    break;

                default:
                    $template = $this->_login;
                    break;
            }
            return $this->load->site_view($template, $template_data, TRUE);
        }


        $template = $this->_login;
        if ( $form_type = $this->input->post('form_type') )
        {
            $this->form_validation->set_message('required', 'незаполено поле: %s');
            $this->form_validation->set_message('min_length', '%s не меньше 5 символов');
            $this->form_validation->set_message('max_length', '%s не больше 255 символов');
            $this->form_validation->set_message('valid_email', 'неверно заполнено поле: %s');
            $this->form_validation->set_message('matches', 'поля должны совападать');
            switch ( $form_type )
            {
                // register
                case 1:
                    $this->form_validation->set_rules(
                        'login',
                        'логин',
                        'trim|required|min_length[5]|max_length[255]|callback_auth_login_check'
                    );
                    $this->form_validation->set_rules(
                        'email',
                        'e-mail',
                        'trim|required|valid_email|callback_auth_email_check'
                    );
                    $this->form_validation->set_rules(
                        'password',
                        'пароль',
                        'trim|required|min_length[5]|max_length[255]'
                    );
                    $template = $this->_register;
                    break;

                // login
                case 2:
                    $this->form_validation->set_rules(
                        'login',
                        'логин',
                        'trim|required|min_length[5]|max_length[255]'
                    );
                    $this->form_validation->set_rules(
                        'password',
                        'пароль',
                        'trim|required|min_length[5]|max_length[255]'
                    );
                    $template = $this->_login;
                    break;

                // forget pass
                case 3:
                    $this->form_validation->set_rules(
                        'email',
                        'e-mail',
                        'trim|required|valid_email'
                    );
                    $template = $this->_forget;
                    break;

                // new pass
                case 4:
                    $this->form_validation->set_rules(
                        'password',
                        'пароль',
                        'trim|required|min_length[5]|max_length[255]|matches[password2]'
                    );
                    $this->form_validation->set_rules(
                        'password2',
                        'подтверждение пароля',
                        'trim|required'
                    );
                    $template = $this->_newpass;

                    $rem_user  = $this->input->post('rem_user');
                    $rem_hash  = $this->input->post('rem_hash');
                    $template_data['rem_user'] = $rem_user;
                    $template_data['rem_hash'] = $rem_hash;
                    break;

                default:
                    # code...
                    break;
            }
        }

        if ( ! empty($_POST) )
        {
            if ( $this->form_validation->run() )
            {
                $login    = $this->input->post('login');
                $email    = $this->input->post('email');
                $password = $this->input->post('password');

                switch ( $form_type )
                {
                    // register
                    case 1:
                        if ( $this->register($login, $email, $password) )
                        {
                            $template_data['message'] = 'Регистрация прошла успешно!';
                        } else {
                            $template_data['message'] = 'В процессе регистрации произошла ошибка!';
                        }
                        break;
                    // login
                    case 2:
                        if ( $this->login($login, $password) )
                        {
                            $template_data['message'] = 'Авторизация прошла успешно!';
                            redirect(base_url($page->url));
                        } else {
                            $template_data['message'] = 'Неверный логин/пароль!';
                        }
                        break;
                    // forget pass
                    case 3:
                        $forget_code = $this->forget_pass($email);
                        $this->send_email($email, $forget_code, $template_data['form_url']);
                        $template_data['message'] = 'Письмо с восстановлением пароля отправлено на указанную почту!';
                        break;
                    // new pass
                    case 4:
                        $password2 = $this->input->post('password2');
                        $rem_user  = $this->input->post('rem_user');

                        if ( $this->change_pass($rem_user, $password2) )
                        {
                            $template_data['message'] = 'Пароль успешно изменен!';
                        } else {
                            $template_data['message'] = 'Ошибка изменения пароля!';
                        }
                        break;
                }
                $template = $this->_success;
            }
        }
        return $this->load->site_view($template, $template_data, TRUE);
    }

    public function get_clients ()
    {
        return $this->db->select('*')
            ->from($this->_table)
            ->get()
            ->result();
    }

    protected function send_email ( $email, $code, $form_link )
    {
        $config['mailtype'] = 'html';
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset']  = 'utf-8';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        $this->email->from($this->settings['EMAIL']);
        $this->email->to($email);
        $this->email->subject('Восстановление пароля - ' . $this->settings['SITE_TITLE']);
        $this->email->message('От Вашего имени был сделан запрос на восстановление пароля, для смены пароля перейдите по <a href="'.base_url($form_link.$code).'">ссылке</a>. Ссылка будет активна в течении 3-х часов.');
        $this->email->send();
        $this->email->clear();
    }

    protected function register ( $login, $email, $password )
    {
        $data['login']    = $login;
        $data['email']    = $email;
        $data['password'] = $this->pass_encode($password);
        return $this->db->insert($this->_table, $data);
    }

    protected function login ( $login, $password )
    {
        if ( $auth = $this->is_auth($login, $password) )
        {
            $user_data['client_id']   = $auth->id;
            $user_data['client_login']= $auth->login;
            $user_data['client_email']= $auth->email;
            $this->session->set_userdata($user_data);
            return TRUE;
        }
        return FALSE;
    }

    protected function logout ()
    {
        $this->session->sess_destroy();
    }

    protected function change_pass ( $login, $new_pass )
    {
        $user = $this->get_user_by_login($login);

        $data['password']   = $this->pass_encode($new_pass);
        $data['salt']       = '';
        $data['active']     = 1;
        $data['forgettime'] = '';
        $this->db->where('login', $login);
        return $this->db->update($this->_table, $data);
    }

    protected function forget_pass ( $email )
    {
        $now  = date("Y-m-d H:i:s", time());
        $salt = rand(100000, 100000000);
        $code = sha1(md5($email . $salt . $now));

        $user = $this->get_user_by_email($email);

        $data['salt']       = $salt;
        $data['forgettime'] = $now;
        $data['active']     = 0;
        $this->db->where('email', $email);
        $this->db->update($this->_table, $data);

        return '?u=' . $user->login . '&hash=' . $code;
    }

    protected function hash_check ( $login, $hash )
    {
        $user  = $this->get_user_by_login($login);
        $code  = sha1(md5($user->email . $user->salt . $user->forgettime));
        $ftime = strtotime($user->forgettime);

        if ( ($code === $hash) && (time() >= $ftime) && (time() <= ($ftime + $this->delta_time)) )
        {
            return TRUE;
        }
        return FALSE;
    }

    protected function get_user_by_email ( $email )
    {
        return $this->db->select('*')
            ->from($this->_table)
            ->where('email', $email)
            ->get()
            ->row();
    }

    protected function get_user_by_login ( $login )
    {
        return $this->db->select('*')
            ->from($this->_table)
            ->where('login', $login)
            ->get()
            ->row();
    }

    public function is_email ( $email )
    {
        $query = $this->db->select('*')
            ->from($this->_table)
            ->where('email', $email)
            ->get();
        if ( $count = $query->num_rows() )
        {
            return $count;
        }
        return FALSE;
    }

    public function is_login ( $login )
    {
        $query = $this->db->select('*')
            ->from($this->_table)
            ->where('login', $login)
            ->get();
        if ( $count = $query->num_rows() )
        {
            return $count;
        }
        return FALSE;
    }

    public function is_auth ( $login, $password )
    {
        $query = $this->db->select('*')
            ->from($this->_table)
            ->where('login', $login)
            ->where('password', $this->pass_encode($password))
            ->where('active', 1)
            ->get();
        if ( $count = $query->num_rows() )
        {
            return $query->row();
        }
        return FALSE;
    }

    public function pass_encode ( $password )
    {
        return md5(md5($password));
    }

}