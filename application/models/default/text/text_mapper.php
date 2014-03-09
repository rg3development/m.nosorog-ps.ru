<?php
/*
 * Model of text mapper
 *
 * @author rav <arudyuk@gmail.com>
 * @version 1.0
 */

class Text_mapper extends MY_Model implements Mapper {

    public function  __construct() {
        parent::__construct();
        $this->_table_item  = 'text_item';
        $this->_template    = 'text/index';

        $this->load->model('text/text_item');
    }

    public function get_object($id) {
        $sql = "select id, parent_id, title, description, show_title from {$this->_table_item} where id = {$id}";
        $res = $this->db->query($sql)->row_array();
        if (sizeof($res) == 0) return false;
        return $this->_get_object($res);
    }

    public function get_all_objects($page_id = 0, $order = 'id desc') {
        $sql = "select id, parent_id, title, description, show_title from {$this->_table_item}";
        if ($page_id > 0) $sql .= " where parent_id = {$this->db->escape($page_id)}";
        $sql .= " order by $order";
        $data = $this->db->query($sql)->result_array();
        if ($data === false) return array();
        return $this->_create_collection($data);
    }

    public function get_page_content($page_id = 0) {
        $data = array();
        $page_id = (int)$page_id;
        $sql = "select id, title, parent_id, description, show_title from {$this->_table_item}";
        if ($page_id > 0) $sql .= " where parent_id = {$page_id}";
        $sql .= " limit 0,1";
        $data = $this->db->query($sql)->result_array();
        if (empty($data)) return '';
        $tmp_objects = $this->_create_collection($data);
        return $this->load->site_view($this->_template, array('text_object' => $tmp_objects[0]), true);
    }

    public function get_widjet($id = 1000) {
        $id = (int)$id;
        $sql = "select id, title, parent_id, description, show_title from {$this->_table_item} where id = {$id}";
        $data = $this->db->query($sql)->row_array();
        if (sizeof($data) > 0) return $data;
        return '';
    }

    public function save($object) {
        if (!($object instanceof Text_item)) return false;
        if ($object->id > 0) {
            $updated = date("Y-m-d H:i", time());
            $sql = "update {$this->_table_item}
                    set title = {$this->db->escape($object->title)},
                        parent_id = {$this->db->escape($object->parent_id)},
                        show_title = {$object->show_title},
                        description = {$this->db->escape($object->description)},
                        date_updated = {$this->db->escape($updated)}
                    where id = {$object->id}";
            if ($this->db->query($sql)) {
                return $object->id;
            } else return false;
        }
        $created = date("Y-m-d H:i", time());
        $sql = "insert into {$this->_table_item}
                set title = {$this->db->escape($object->title)},
                    parent_id = {$this->db->escape($object->parent_id)},
                    show_title = {$object->show_title},
                    description = {$this->db->escape($object->description)},
                    date_updated = {$this->db->escape($created)},
                    date_created = {$this->db->escape($created)}";
        if ($this->db->query($sql)) {
            return $object->id;
        } else return false;
    }

    protected function _get_object($data = array()) {
        $tmp_object                 = new Text_item();
        $tmp_object->id             = $data['id'];
        $tmp_object->parent_id      = $data['parent_id'];
        $tmp_object->title          = $data['title'];
        $tmp_object->show_title     = $data['show_title'];
        $tmp_object->description    = $data['description'];
        return $tmp_object;
    }

    public function search ( $search_query = '' )
    {
        $search_query = $this->db->escape_like_str($search_query);
        $this->db->select('
            text_item.*,
            pages.url
        ');
        $this->db->from('pages');
        $this->db->join('text_item', 'text_item.parent_id = pages.id');
        $this->db->where('pages.show', 1);
        $this->db->where("(
            text_item.title LIKE '%{$search_query}%'
            OR text_item.description LIKE '%{$search_query}%'
        )", NULL, FALSE);
        $this->db->order_by('pages.level', 'ASC');
        $search_result = $this->db->get()->result_array();

        $result = array();
        if ( $search_result )
        {
            foreach ( $search_result as $key => $text_obj )
            {
                $cur_item['object'] = $this->_get_object($text_obj);
                $cur_item['link']   = base_url($text_obj['url']);
                $result[] = $cur_item;
            }
        }
        return $result;
    }

}