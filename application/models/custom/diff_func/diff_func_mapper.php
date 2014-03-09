<?phpclass Diff_func_mapper extends MY_Model {  // table constants  const TABLE_CATALOG_SECTION       = 'catalog_section';  const TABLE_CATALOG_CATEGORY      = 'catalog_category';  const TABLE_CATALOG_CURRENCY      = 'catalog_currency';  const TABLE_CATALOG_ITEM          = 'catalog_item';  const TABLE_CATALOG_ITEM_IMAGES   = 'catalog_item_images';  const TABLE_CATALOG_ITEM_LINKS    = 'catalog_item_links';  const TABLE_CATALOG_USER_FIELDS   = 'catalog_user_fields';  const TABLE_CATALOG_USER_VALUES   = 'catalog_user_values';  const TABLE_CATALOG_SIMILAR_ITEMS = 'catalog_similar_items';  const TABLE_IMAGES                = 'images';  const TABLE_PAGES                 = 'pages';  // class for result object  const CLASS_SECTION  = 'Catalog_Section';  const CLASS_CATEGORY = 'Catalog_Category';  const CLASS_ITEM     = 'Catalog_Item';  public function  __construct ()  {    parent::__construct();        $this->_objects_url = 'http://nosorog-ps.ru/xml/cms3_objects.xml';    $this->_content_url = 'http://nosorog-ps.ru/xml/cms3_object_content.xml';    $this->_catalog_url = 'http://nosorog-ps.ru/xml/cms3_hierarchy.xml';  }         public function get_catalog_categories_xml(){        //$document = new SimpleXMLElement($xmlstr);        $document = simplexml_load_file($this->_coupons_url);        return $document;    }                private function get_objects_xml(){        $document = simplexml_load_file($this->_objects_url);                foreach ($document->database->table_data->row as $row){            $object=array();                                foreach ($row->field as $field){                $object[(string)$field['name']]=(string)$field;            }                 if($object['type_id'] == 80){            $objects['id']=$object['id'];            $objects['section_id'] = 1;            $objects['in_stock'] = 1;                $this->db->select('*');                $this->db->from('catalog_item');                $this->db->where('id', $objects['id']);                $result=$this->db->get()->row_array();                                if($result != null){                    $this->db->where('id', $objects['id']);                    $this->db->update('catalog_item', $objects);                 }                else{                    $this->db->insert('catalog_item', $objects);                 }                      }            if($object['type_id'] == 79){            $objects['id']=$object['id'];            $objects['parent_section_id'] = 1;            $objects['title'] = $object['name'];                $this->db->select('*');                $this->db->from('catalog_category');                $this->db->where('id', $objects['id']);                $result=$this->db->get()->row_array();                                if($result != null){                    $this->db->where('id', $objects['id']);                    $this->db->update('catalog_category', $objects);                 }                else{                    $this->db->insert('catalog_category', $objects);                 }                      }                        unset($objects);        }               }            private function get_objects2_xml(){        $document = simplexml_load_file($this->_objects_url);                foreach ($document->database->table_data->row as $row){            $object=array();                                foreach ($row->field as $field){                $object[(string)$field['name']]=(string)$field;            }                             $objects['id']=$object['id'];            $objects['section_id'] = 1;            $objects['in_stock'] = 1;                $this->db->select('*');                $this->db->from('catalog_item');                $this->db->where('id', $objects['id']);                $result=$this->db->get()->row_array();                                if($result != null){                    $this->db->where('id', $objects['id']);                    $this->db->update('catalog_item', $objects);                 }            unset($objects);        }               }        private function get_color_xml(){            $document = simplexml_load_file($this->_objects_url);                foreach ($document->database->table_data->row as $row){            $object=array();                                foreach ($row->field as $field){                $object[(string)$field['name']]=(string)$field;            }                             //color            if($object['type_id'] == 115){            $objects['id']=$object['id'];            $objects['title'] = $object['name'];                $this->db->select('*');                $this->db->from('color');                $this->db->where('id', $objects['id']);                $result=$this->db->get()->row_array();                                if($result != null){                    $this->db->where('id', $objects['id']);                    $this->db->update('color', $objects);                 }                else{                    $this->db->insert('color', $objects);                 }                      }            unset($objects);        }    }    private function get_brend_xml(){            $document = simplexml_load_file($this->_objects_url);                foreach ($document->database->table_data->row as $row){            $object=array();                                foreach ($row->field as $field){                $object[(string)$field['name']]=(string)$field;            }                             //color            if($object['type_id'] == 126){            $objects['id']=$object['id'];            $objects['title'] = $object['name'];                $this->db->select('*');                $this->db->from('brend');                $this->db->where('id', $objects['id']);                $result=$this->db->get()->row_array();                                if($result != null){                    $this->db->where('id', $objects['id']);                    $this->db->update('brend', $objects);                 }                else{                    $this->db->insert('brend', $objects);                 }                      }            unset($objects);        }    }    private function get_size_xml(){            $document = simplexml_load_file($this->_objects_url);                foreach ($document->database->table_data->row as $row){            $object=array();                                foreach ($row->field as $field){                $object[(string)$field['name']]=(string)$field;            }                             //color            if($object['type_id'] == 114){                $objects['id']=$object['id'];                $objects['title'] = $object['name'];                                    $this->db->select('*');                    $this->db->from('size');                    $this->db->where('id', $objects['id']);                    $result=$this->db->get()->row_array();                                        if($result != null){                        $this->db->where('id', $objects['id']);                        $this->db->update('size', $objects);                     }                    else{                        $this->db->insert('size', $objects);                     }                            }            unset($objects);        }    }    private function get_catalog_xml(){        $document = simplexml_load_file($this->_catalog_url);                foreach ($document->database->table_data->row as $row){            $object=array();                                foreach ($row->field as $field){                $object[(string)$field['name']]=(string)$field;            }            if($object['type_id'] == 54){                $this->db->select('*');                $this->db->from('catalog_category');                $this->db->where('id', $object['obj_id']);                $result=$this->db->get()->row_array();                 if($result != null){                     $objects['id']=$object['obj_id'];                    $objects['is_deleted']=$object['is_deleted'];                    $objects['priority']=$object['ord'];                                        $objects['hid']=$object['id'];                    $objects['rel']=$object['rel'];                    $this->db->where('id', $objects['id']);                    $this->db->update('catalog_category', $objects);                                     }                             }            if($object['type_id'] == 55){                $this->db->select('*');                $this->db->from('catalog_item');                $this->db->where('id', $object['obj_id']);                $result=$this->db->get()->row_array();                     $objects2['is_deleted']=$object['is_deleted'];                    $objects2['priority']=$object['ord'];                    $objects2['id']=$object['obj_id'];                    $objects2['rel']=$object['rel'];                if($result != null){                     $this->db->where('id', $objects2['id']);                    $this->db->update('catalog_item', $objects2);                                     }else{                    $this->db->insert('catalog_item', $objects2);                 }              }            unset($objects);        }               }        private function get_object_photos_xml(){        $document = simplexml_load_file($this->_content_url);                foreach ($document->database->table_data->row as $row){            $object_photos=array();                    $images=array();            $catalog_item_images=array();            $catalog_item=array();            foreach ($row->field as $field){                $object_photos[(string)$field['name']]=(string)$field;            }            $this->db->select('*');            $this->db->from('catalog_item');            $this->db->where('id', $object_photos['obj_id']);            $result=$this->db->get()->row_array();             if($result != null){                        //title                if(($object_photos['field_id'] == 123) || ($object_photos['field_id'] == 124)){                    if($object_photos['varchar_val'] != ''){                        $catalog_item['title']=$object_photos['varchar_val'];                        $catalog_item['id']=$object_photos['obj_id'];                        $this->db->where('id', $object_photos['obj_id']);                        $this->db->update('catalog_item', $catalog_item);                    }                }                //description                if(($object_photos['field_id'] == 432) || ($object_photos['field_id'] == 376)){                    if($object_photos['text_val'] != ''){                        $catalog_item['description']=$object_photos['text_val'];                        $catalog_item['id']=$object_photos['obj_id'];                        $this->db->where('id', $object_photos['obj_id']);                        $this->db->update('catalog_item', $catalog_item);                    }                }                //�����������                if($object_photos['field_id'] == 407){                    if($object_photos['text_val'] != ''){                        $catalog_item['description2']=$object_photos['text_val'];                        $catalog_item['id']=$object_photos['obj_id'];                        $this->db->where('id', $object_photos['obj_id']);                        $this->db->update('catalog_item', $catalog_item);                    }                }                //�����                if($object_photos['field_id'] == 441){                    if($object_photos['rel_val'] != ''){                        $catalog_item['brend_kol']=$object_photos['rel_val'];                        $catalog_item['id']=$object_photos['obj_id'];                        $this->db->where('id', $object_photos['obj_id']);                        $this->db->update('catalog_item', $catalog_item);                    }                }                //material                if($object_photos['field_id'] == 406){                    if($object_photos['text_val'] != ''){                        $catalog_item['material']=$object_photos['text_val'];                        $catalog_item['id']=$object_photos['obj_id'];                        $this->db->where('id', $object_photos['obj_id']);                        $this->db->update('catalog_item', $catalog_item);                    }                }                //color                if(($object_photos['field_id'] == 404) || ($object_photos['field_id'] == 435) || ($object_photos['field_id'] == 445)){                    if($object_photos['rel_val'] != ''){                        $catalog_item['color']=$object_photos['rel_val'];                        $catalog_item['id']=$object_photos['obj_id'];                        $this->db->where('id', $object_photos['obj_id']);                        $this->db->update('catalog_item', $catalog_item);                    }                }                //size                if(($object_photos['field_id'] == 403) || ($object_photos['field_id'] == 434)){                    if($object_photos['rel_val'] != ''){                        if((int)$object_photos['rel_val'] > 375){                            if($result['size'] == ''){                                $catalog_item['size']=$object_photos['rel_val'];                                $catalog_item['id']=$object_photos['obj_id'];                                $this->db->where('id', $object_photos['obj_id']);                                $this->db->update('catalog_item', $catalog_item);                            }else{                                $catalog_item['size']=''.$result['size'].';'.$object_photos['rel_val'];                                $catalog_item['id']=$object_photos['obj_id'];                                $this->db->where('id', $object_photos['obj_id']);                                $this->db->update('catalog_item', $catalog_item);                            }                        }                    }                }                //price                if(($object_photos['field_id'] == 257) || ($object_photos['field_id'] == 25) || ($object_photos['field_id'] == 26)|| ($object_photos['field_id'] == 27) || ($object_photos['field_id'] == 65) || ($object_photos['field_id'] == 283)){                    if($object_photos['float_val'] != ''){                        $catalog_item['new_price']=$object_photos['float_val'];                        $catalog_item['id']=$object_photos['obj_id'];                        $this->db->where('id', $object_photos['obj_id']);                        $this->db->update('catalog_item', $catalog_item);                    }                }                // old price                if(($object_photos['field_id'] == 377) || ($object_photos['field_id'] == 440)){                    if($object_photos['int_val'] != ''){                        $catalog_item['price']=$object_photos['int_val'];                        $catalog_item['id']=$object_photos['obj_id'];                        $catalog_item['is_sale']=1;                        $this->db->where('id', $object_photos['obj_id']);                        $this->db->update('catalog_item', $catalog_item);                    }                }                if(($object_photos['field_id'] == 371) || ($object_photos['field_id'] == 431) ){                    if($object_photos['text_val'] != ''){                        $this->db->select('*');                        $this->db->from('images');                        $this->db->order_by("id", "desc");                        $resut_img=$this->db->get()->row_array();                        if($resut_img != null){                            $images['id'] = $resut_img['id']+1;                        }else{                            $images['id'] = 1;                        }                        if($object_photos['text_val'][0] == '.'){                        $object_photos['text_val']=mb_substr($object_photos['text_val'], 1);                        }                        $images['filename'] = $object_photos['text_val'];                                                $images['size'] = 13;                        $images['width'] = 320;                        $images['height'] = 120;                        $images['type'] = 'jpeg';                                                $this->db->select('*');                        $this->db->from('catalog_item_images');                        $this->db->order_by("id", "desc");                        $resut_img2=$this->db->get()->row_array();                        if($resut_img2 != null){                            $catalog_item_images['id'] = $resut_img2['id']+1;                        }else{                            $catalog_item_images['id'] = 1;                        }                                                $catalog_item_images['item_id'] = $object_photos['obj_id'];                        $catalog_item_images['is_main'] = 1;                        $catalog_item_images['image_id'] = $images['id'];                        $this->db->select('*');                        $this->db->from('images');                        $this->db->where('filename', $images['filename']);                        $resulting=$this->db->get()->result_array();                                                                        if($resulting != null){                             $flaq=false;                            foreach($resulting as $index=>$res){                                $this->db->select('*');                                $this->db->from('catalog_item_images');                                $this->db->where('image_id', $res['id']);                                $this->db->where('item_id', $object_photos['obj_id']);                                $resulting2=$this->db->get()->row_array();                                if($resulting2 != null){                                     $flaq =true;                                }                            }                            if($flaq == false){                                 $this->db->insert('images', $images);                                 $this->db->insert('catalog_item_images', $catalog_item_images);                             }                        }                        else{                            $this->db->insert('images', $images);                             $this->db->insert('catalog_item_images', $catalog_item_images);                         }                        unset($resut_img);                        unset($resut_img2);                        unset($resulting);                        unset($resulting2);                    }                }                 if(($object_photos['field_id'] == 372) || ($object_photos['field_id'] == 373) || ($object_photos['field_id'] == 374) || ($object_photos['field_id'] == 375)){                    if($object_photos['text_val'] != ''){                        $this->db->select('*');                        $this->db->from('images');                        $this->db->order_by("id", "desc");                        $resut_img=$this->db->get()->row_array();                        if($resut_img != null){                            $images['id'] = $resut_img['id']+1;                        }else{                            $images['id'] = 1;                        }                        if($object_photos['text_val'][0] == '.'){                        $object_photos['text_val']=mb_substr($object_photos['text_val'], 1);                        }                        $images['filename'] = $object_photos['text_val'];                                                $images['size'] = 13;                        $images['width'] = 320;                        $images['height'] = 120;                        $images['type'] = 'jpeg';                                                $this->db->select('*');                        $this->db->from('catalog_item_images');                        $this->db->order_by("id", "desc");                        $resut_img2=$this->db->get()->row_array();                        if($resut_img2 != null){                            $catalog_item_images['id'] = $resut_img2['id']+1;                        }else{                            $catalog_item_images['id'] = 1;                        }                                                $catalog_item_images['item_id'] = $object_photos['obj_id'];                        $catalog_item_images['image_id'] = $images['id'];                        $this->db->select('*');                        $this->db->from('images');                        $this->db->where('filename', $images['filename']);                        $resulting=$this->db->get()->result_array();                                                                        if($resulting != null){                             $flaq=false;                            foreach($resulting as $index=>$res){                                $this->db->select('*');                                $this->db->from('catalog_item_images');                                $this->db->where('image_id', $res['id']);                                $this->db->where('item_id', $object_photos['obj_id']);                                $resulting2=$this->db->get()->row_array();                                if($resulting2 != null){                                     $flaq =true;                                }                            }                            if($flaq == false){                                 $this->db->insert('images', $images);                                 $this->db->insert('catalog_item_images', $catalog_item_images);                             }                        }                        else{                            $this->db->insert('images', $images);                             $this->db->insert('catalog_item_images', $catalog_item_images);                         }                        unset($resut_img);                        unset($resut_img2);                        unset($resulting);                        unset($resulting2);                    }                }            }            unset($catalog_item_images);            unset($catalog_item);            unset($object_photos);            unset($images);                   }               }            public function get_xml(){    $this->delete_size();    echo 'delete_size OK/n';          $this->get_catalog_xml();      echo 'get_catalog_xml ��/n';      $this->get_objects_xml();      echo 'get_objects_xml OK/n';      $this->get_objects2_xml();      echo 'get_objects2_xml OK/n';      $this->get_object_photos_xml();      echo 'get_object_photos_xml OK/n';       $this->podschet();        echo 'podschet ��/n';        $this->get_color_xml();       echo 'get_color_xml ��/n';       $this->get_brend_xml();       echo 'get_brend_xml ��/n';       $this->get_size_xml();       echo 'get_size_xml ��/n';    }    //������� ������    private function delete_size(){        $this->db->select('*');        $this->db->from('catalog_item');        $result =$this->db->get()->result_array();         foreach($result as $key=>$res){                    $res['size']='';            $this->db->where('id', $res['id']);            $this->db->update('catalog_item', $res);          }    }    public function podschet(){        $this->db->select('*');        $this->db->from('catalog_item');        $result =$this->db->get()->result_array();        $this->db->select('*');        $this->db->from('catalog_category');        $catalog =$this->db->get()->result_array();        foreach($result as $key=>$res){            if(($res['price'] > 0) && ($res['price'] != $res['new_price'])){                $res['discount_price']=$res['price']-$res['new_price'];                $this->db->where('id', $res['id']);                $this->db->update('catalog_item', $res);             }elseif ($res['price'] != $res['new_price']){                $res['price']=$res['new_price'];                $this->db->where('id', $res['id']);                $this->db->update('catalog_item', $res);             }             foreach($catalog as $index=>$cat){                if($res['rel'] == $cat['hid']){                    $this->db->select('*');                    $this->db->from('catalog_item_links');                    $this->db->where('item_id', $res['id']);                    $res2 =$this->db->get()->result_array();                    if($res2 == null){                        $this->db->select('*');                        $this->db->from('catalog_item_links');                        $this->db->order_by('id', 'desc');                        $res3 =$this->db->get()->row_array();                        $catalog_item_links['id'] = $res3['id']+1;                        $catalog_item_links['item_id'] = $res['id'];                        $catalog_item_links['category_id'] = $cat['id'];                        $this->db->where('id', $catalog_item_links['id']);                        $this->db->insert('catalog_item_links', $catalog_item_links);                    }                }            }        }        foreach($catalog as $index=>$cat){            foreach($catalog as $index2=>$cat2){                                if($cat['rel'] == $cat2['hid']){                    $catalog_category['id']=$cat['id'];                    $catalog_category['parent_category_id']=$cat2['id'];                    $this->db->where('id', $catalog_category['id']);                    $this->db->update('catalog_category', $catalog_category);                                    }            }        }                    }    //�������    public function get_new_product($numbs){        $this->db->select('*');        $this->db->from('catalog_item');        $this->db->where('is_deleted', 0);        $this->db->where('is_bestseller', 1);        $this->db->where('in_stock', 1);        $this->db->order_by('id', 'desc');                 $this->db->limit($numbs);        return $this->db->get()->result(self::CLASS_ITEM);    }    //������ �� �������    public function get_sale_product($numbs){        $this->db->select('*');        $this->db->from('catalog_item');        $this->db->where('is_deleted', 0);        $this->db->where('is_sale', 1);        $this->db->where('in_stock', 1);        $this->db->order_by('id', 'desc');                 $this->db->limit($numbs);        return $this->db->get()->result(self::CLASS_ITEM);    }    //������ ��������� �������� ������    public function get_category_null(){        $this->db->select('*');        $this->db->from('catalog_category');        $this->db->where('is_deleted', 0);        $this->db->where('parent_category_id', 0);        $this->db->order_by('priority', 'asc');                 return $this->db->get()->result(self::CLASS_CATEGORY);    }    public function get_category_first($id){        $this->db->select('*');        $this->db->from('catalog_category');        $this->db->where('is_deleted', 0);        $this->db->where('parent_category_id', $id);        $this->db->order_by('priority', 'asc');                 return $this->db->get()->result(self::CLASS_CATEGORY);    }    public function get_pages($parent_id){            $result = array();        $this->db->select('id, url, title, show_alias, alias');        $this->db->from('pages');        $this->db->where('parent_id',$parent_id);        $this->db->where('show',1);        $this->db->order_by("priority", "asc");         $result = $this->db->get()->result_array();        $result2 = array();        $this->db->select('parent_id, id, title, url, show_alias, alias');        $this->db->from('pages');        $this->db->where('id',$parent_id);        $result2 = $this->db->get()->row_array();        for($i=0;$i<5;$i++){            if($result2){                if($result2['parent_id'] == 0){                $result[0]['parent'] = $result2['title'];                $result[0]['parent_url'] = $result2['url'];                return $result;                }            }            $this->db->select('parent_id, id, title, url, show_alias, alias');            $this->db->from('pages');            $this->db->where('id',$result2['parent_id']);            $result2 = $this->db->get()->row_array();        }    return $result;    }    public function delivery(){        $this->db->select('*');        $this->db->from('delivery');        $this->db->order_by('sort', 'asc');             return $this->db->get()->result_array();    }    public function brends(){        $this->db->select('*');        $this->db->from('brend');        $this->db->order_by('title', 'asc');             return $this->db->get()->result_array();    }    public function get_brend($brend){        $this->db->select('*');        $this->db->from('brend');        $this->db->where('id',$brend);        $this->db->order_by('title', 'asc');             return $this->db->get()->row_array();    }    public function get_brend2($brend){        $this->db->select('*');        $this->db->from('brend');        $this->db->where('title',$brend);                     return $this->db->get()->row_array();    }    public function colours(){        $this->db->select('*');        $this->db->from('color');        $this->db->order_by('id', 'asc');             return $this->db->get()->result_array();    }    public function get_colour($color){        $this->db->select('*');        $this->db->from('color');        $this->db->where('id',$color);        $this->db->order_by('id', 'asc');             return $this->db->get()->row_array();    }    public function get_color2($color){        $this->db->select('*');        $this->db->from('color');        $this->db->where('title',$color);             return $this->db->get()->row_array();    }    public function materials(){        $this->db->select('*');        $this->db->from('p_material');        $this->db->order_by('id', 'asc');             return $this->db->get()->result_array();    }    public function sizes(){        $this->db->select('*');        $this->db->from('size');        $this->db->order_by('title', 'asc');             return $this->db->get()->result_array();    }    public function get_size20($size){        $this->db->select('*');        $this->db->from('size');        $this->db->where('title',$size);             return $this->db->get()->row_array();    }    public function get_size($size){        $this->db->select('*');        $this->db->from('size');        $this->db->where('id',$size);        $this->db->order_by('title', 'asc');             return $this->db->get()->row_array();    }    public function get_brand($id){        $this->db->select('name');        $this->db->from('p_brands');        $this->db->where('id', $id);             return $this->db->get()->row();    }    public function parser(){        $this->db->select('*');        $this->db->from('catalog_item_images');        $result2=$this->db->get()->result_array();        foreach($result2 as $index=>$res){            $res['is_main']=0;            $this->db->where('id', $res['id']);            $this->db->update('catalog_item_images', $res);        }    }}