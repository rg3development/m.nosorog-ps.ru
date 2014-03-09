<?php

class Breadcrumbs_mapper extends MY_Model
{

	public function  __construct()
	{
		parent::__construct();
		$this->_template['index']    = 'breadcrumbs/index';

        $this->_table_item	= 'pages';
	}

	public function get_page_content ( $page_id = 0 )
	{
		$map       = $this->_get_pages_tree();

        $data['map'] = $map;

		return $this->load->site_view($this->_template['index'], $data, TRUE);
	}

	protected function _get_pages_tree() 
    {
        $active_url = uri_string();
        if (substr($active_url, 0, 1) == '/') $active_url = substr($active_url, 1);
        if (substr($active_url, -1, 1) == '/') $active_url = substr($active_url, 0, -1);
        $page_info    = $this->manager_modules->get_page_data($active_url);
        
        $pager=array();
        $itemser=0;
                    if($page_info['page']['parent_id']>0){
                        $pager[$itemser]['title']    = $page_info['page']['title'];
                        $pager[$itemser]['url']    = $page_info['page']['url'];
                        
                        $data=$this-> get_array_data($page_info['page']['parent_id']);
                        for ($itemser=1; $page_info['page']['parent_id']>0; $itemser++)
                        {
                            
                                if($data['parent_id']>0){                            
                                $pager[$itemser]['id']    = $data['id'];
                                $pager[$itemser]['title']    = $data['title'];
                                $pager[$itemser]['parent_id']    = $data['parent_id'];
                                $pager[$itemser]['url']    = $data['url'];
                                
                                $data=$this-> get_array_data($pager[$itemser]['parent_id']);
                                }
                                else 
                                {
                                    if($data['show']!=1)break;
                                    
                                    $pager[$itemser]['id']    = $data['id'];
                                    $pager[$itemser]['title']    = $data['title'];
                                    $pager[$itemser]['url']    = $data['url'];
                                
                                break;
                                }
                            
                        }
                    }
                    else
                    {
                        $pager[$itemser]['title']    = $page_info['page']['title'];
                        $pager[$itemser]['url']    = $page_info['page']['url'];
                        
                    }
        foreach($pager as $key=>$pagesd){}
   
        $hkey=$key;
        if($key>0)
        {
            $pager2=$pager;
            $pager=array();
            $k=0;
            for($key=$key+1;$key>0;$key--)
            {
                $pager[$k]=$pager2[$key-1];
                $k++;
            }
        
        }
        
        $pager[0]['hkey']=$hkey;
     
		return $pager;
	
	}
    public function get_array_data($id) {
		$id = (int)$id;
		$sql = "select `id`, `title`, `parent_id`, `show`, `url`  from {$this->_table_item} where `id` = {$id}";
		$data = $this->db->query($sql)->row_array();
		if (sizeof($data) > 0) return $data;
		return '';
	}
}