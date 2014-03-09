<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin_Controller {

    protected $_table;
    protected $_module_title;
    protected $_templates;

    public function __construct() {
        parent::__construct();
        $this->_table              = 'settings';
        $this->_module_title       = 'настройка сайта';
        $this->_templates['index'] = 'settings/index';

        $this->template_data['module_title'] = $this->_module_title;
    }

    public function index()
    {
        if ( ! empty($_POST) )
        {
            $this->form_validation->set_error_delimiters('', '<br/>');
            $this->form_validation->set_message('required', 'поле "%s" незаполнено');
            $this->form_validation->set_rules('SITE_TITLE', '<b>название</b>','trim|required');
            $this->form_validation->set_rules('SITE_COUNTERS', '<b>счетчики</b>','trim');
            if ( $this->form_validation->run() )
            {
                $new_settings = array();
                if ( !empty($_FILES) && $_FILES['SITE_LOGO']['error'] == 0 )
                {
                    $image = new Image_item();
                    $image->doUpload(90000, 90000, 'SITE_LOGO', 'gif|jpg|png|tif', 20480, 'settings');
                    $image_id = $image->save();
                    $new_settings['SITE_LOGO'] = $image_id;
                }
                $new_settings['SITE_TITLE']       = $this->input->post('SITE_TITLE');
                $new_settings['SITE_DESCRIPTION'] = $this->input->post('SITE_DESCRIPTION');
                $new_settings['SITE_KEYWORDS']    = $this->input->post('SITE_KEYWORDS');
                $new_settings['EMAIL']            = $this->input->post('EMAIL');
                $new_settings['MY_EMAIL']         = $this->input->post('MY_EMAIL');
                $new_settings['SITE_COUNTERS']    = $this->input->post('SITE_COUNTERS');
                $new_settings['ROBOTS_TXT']       = $this->input->post('ROBOTS_TXT');
                $this->manager_modules->set_settings($new_settings);
            }
        }
        $settings = $this->manager_modules->get_settings();
        if ( $settings['SITE_LOGO'] )
        {
            $small_image = new Image_item($settings['SITE_LOGO']);
            $logo = IMAGESRC.'settings/'.$small_image->getFilename();
            if ( file_exists(FCPATH.$logo) )
            {
                $settings['SITE_LOGO'] = $logo;
            } else {
                $settings['SITE_LOGO'] = NULL;
            }
        }
        $this->template_data['settings'] = $settings;
        $this->load->admin_view($this->_templates['index'], $this->template_data);
    }

}