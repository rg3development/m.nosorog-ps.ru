<?php

class Search_mapper extends MY_Model
{

    protected $_search_param;
    protected $_search_url;
    protected $_search_value;

    public function __construct()
    {
        parent::__construct();
        $this->_template['search_form']   = 'search/form';
        $this->_template['search_result'] = 'search/results';

        $this->_search_param = 'search';
        $this->_search_url   = $this->_get_search_url();

        if ( $search = $this->input->post($this->_search_param) )
        {
            $this->_search_value = $search;
        } else {
            $this->_search_value = '';
        }
    }

    public function get_form ()
    {
        $template_data = array();
        $template_data['search']['param'] = $this->_search_param;
        $template_data['search']['url']   = $this->_search_url;
        $template_data['search']['value'] = $this->_search_value;
        return $this->load->site_view($this->_template['search_form'], $template_data, TRUE);
    }

    protected function _get_search_url ()
    {
        $module_page = $this->manager_modules->get_module_page(__CLASS__);
        if ( $module_page )
        {
            return base_url($module_page->url);
        }
        return '';
    }

    public function get_page_content ( $page_id = 0 )
    {
        $search_result = array();
        $search_result['count']   = 0;
        $search_result['text']    = array();
        $search_result['news']    = array();
        $search_result['catalog'] = array();
        if ( $this->_search_value )
        {
            if ( SEARCH_MODULE_TEXT )
            {
                $search_result['text']  = $this->text_mapper->search($this->_search_value);
                $search_result['count'] += count($search_result['text']);
            }
            if ( SEARCH_MODULE_NEWS )
            {
                $search_result['news']  = $this->news_mapper->search($this->_search_value);
                $search_result['count'] += count($search_result['news']);
            }
            if ( SEARCH_MODULE_CATALOG )
            {
                $search_result['catalog'] = $this->catalog_mapper->search($this->_search_value);
                $search_result['count']   += count($search_result['catalog']);
            }
        }

        $template_data = array();
        $template_data['search_result'] = $search_result;
        return $this->load->site_view($this->_template['search_result'], $template_data, TRUE);
    }

    protected function _get_news_content($sentence = '') {
        if (empty($sentence)) return array();
        $sql = "select li.id id, l.parent_id parent_id, l.description description, p.url url
                from {$this->_tables['news_category']} li inner join {$this->_tables['news_item']} l on li.parent_id = l.id inner join {$this->_tables['pages']} p on p.id=l.parent_id
                where l.description like '%".$sentence."%' and p.show = 1";
        $pages = $this->db->query($sql)->result_array();
        $content_url_array = array();
        $content = '';
        foreach ($pages as $page) {
            $content .= str_replace('<br/>', '', $page['description']);
            $content_url_array[] = array('content' => mb_strtolower($content), 'url' => $page['url'].'?news_id='.$page['id']);
        }
        return $content_url_array;
    }

}