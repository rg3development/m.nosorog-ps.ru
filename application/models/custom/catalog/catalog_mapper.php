<?php

class Catalog_mapper extends MY_Model implements Mapper
{
    // table constants
    const TABLE_CATALOG_SECTION       = 'catalog_section';
    const TABLE_CATALOG_CATEGORY      = 'catalog_category';
    const TABLE_CATALOG_CURRENCY      = 'catalog_currency';
    const TABLE_CATALOG_ITEM          = 'catalog_item';
    const TABLE_CATALOG_ITEM_IMAGES   = 'catalog_item_images';
    const TABLE_CATALOG_ITEM_LINKS    = 'catalog_item_links';
    const TABLE_CATALOG_USER_FIELDS   = 'catalog_user_fields';
    const TABLE_CATALOG_USER_VALUES   = 'catalog_user_values';
    const TABLE_CATALOG_SIMILAR_ITEMS = 'catalog_similar_items';
    const TABLE_IMAGES                = 'images';
    const TABLE_PAGES                 = 'pages';

    // class for result object
    const CLASS_SECTION               = 'Catalog_Section';
    const CLASS_CATEGORY              = 'Catalog_Category';
    const CLASS_ITEM                  = 'Catalog_Item';

  public function  __construct ()
  {
    parent::__construct();
    $this->_path_to_image      = UPLOAD_CATALOG_IMAGE;
    $this->_template['show']   = 'catalog/index';
    $this->_template['detail'] = 'catalog/detail';
    $this->_template['yml']    = 'catalog/yml';
    $this->_template['thankyou']= 'cart/thankyou';
    $this->load->model('catalog/catalog_category');
    $this->load->model('catalog/catalog_item');
    $this->load->model('catalog/catalog_section');
  }

  // получить список разделов каталога
  public function get_section_list ( $order_title = 'id', $order_type = 'DESC' )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_SECTION);
    $this->db->where('is_deleted !=', 1);
    $this->db->order_by($order_title, $order_type);
    return $this->db->get()->result(self::CLASS_SECTION);
  }

  // получение 1го каталога для указанной страницы
  public function get_catalog ( $page_id = 0 )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_SECTION);
    $this->db->where('is_deleted !=', 1);
    $this->db->where('parent_page_id', $page_id);
    return $this->db->get()->row(self::CLASS_SECTION);
  }

  // получить список категорий раздела
  public function get_category_list ( $section_id = 0, $order_title = 'id', $order_type = 'DESC' )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_CATEGORY);
    $this->db->where('parent_section_id', $section_id);
    $this->db->where('is_deleted !=', 1);
    $this->db->order_by($order_title, $order_type);
    return $this->db->get()->result(self::CLASS_CATEGORY);
  }

  public function get_category_tree ()
  {
    $first_level = $this->get_category_sublist(0, 'priority', 'ASC');
    $result = array();
    foreach ( $first_level as $key => $value )
    {
      $result[] = array (
        'item' => $value,
        'list' => $this->get_category_sublist($value->id, 'priority', 'ASC'),
      );
    }
    return $result;
  }

  public function get_category_sublist ( $category_id = 0, $order_title = 'id', $order_type = 'DESC' )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_CATEGORY);
    $this->db->where('parent_category_id', $category_id);
    $this->db->where('is_deleted !=', 1);
    $this->db->order_by($order_title, $order_type);
    return $this->db->get()->result(self::CLASS_CATEGORY);
  }
    public function get_category_2( $category_id = 0, $order_title = 'id', $order_type = 'DESC' )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_CATEGORY);
    $this->db->where('id', $category_id);
    $this->db->where('is_deleted !=', 1);
    $this->db->order_by($order_title, $order_type);
    return $this->db->get()->row(self::CLASS_CATEGORY);
  }

  public function get_section_category_tree ( $section_id = 0 )
  {
    $first_level = $this->get_section_category_sublist($section_id, 0);
    $result = array();
    foreach ( $first_level as $key => $value )
    {
      $result[] = array (
        'item' => $value,
        'list' => $this->get_section_category_sublist($section_id, $value->id),
      );
    }
    return $result;
  }

  public function get_section_category_sublist ( $section_id = 0, $category_id = 0, $order_title = 'priority', $order_type = 'ASC' )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_CATEGORY);
    $this->db->where('parent_section_id', $section_id);
    $this->db->where('parent_category_id', $category_id);
    $this->db->where('is_deleted !=', 1);
    $this->db->order_by($order_title, $order_type);
    return $this->db->get()->result(self::CLASS_CATEGORY);
  }

  // получить список категорий каталога
  public function get_full_category_list ( $order_title = 'id', $order_type = 'DESC' )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_CATEGORY);
    $this->db->where('is_deleted !=', 1);
    $this->db->order_by($order_title, $order_type);
    return $this->db->get()->result(self::CLASS_CATEGORY);
  }

  // поиск товаров по title, description, article
  public function search_item ( $search_query = '' )
  {
    $search_query = $this->db->escape_like_str($search_query);
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_ITEM);
    $this->db->like('title', $search_query);
    $this->db->or_like('description', $search_query);
    $this->db->or_like('article', $search_query);
    return $this->db->get()->result(self::CLASS_ITEM);
  }

    public function search ( $search_query = '' )
    {
        $search_query = $this->db->escape_like_str($search_query);
        $this->db->select('
            catalog_item.*,
            pages.url
        ');
        $this->db->from('pages');
        $this->db->join('catalog_section', 'catalog_section.parent_page_id = pages.id');
        $this->db->join('catalog_item', 'catalog_item.section_id = catalog_section.id');
        $this->db->where('pages.show', 1);
        $this->db->where('catalog_section.is_deleted', 0);
        $this->db->where('catalog_item.is_deleted', 0);
        $this->db->where("(
            catalog_item.title LIKE '%{$search_query}%'
            OR catalog_item.article LIKE '%{$search_query}%'
            OR catalog_item.description LIKE '%{$search_query}%'
        )", NULL, FALSE);
        $this->db->order_by('pages.level', 'ASC');
        $search_result = $this->db->get()->result(self::CLASS_ITEM);

        $result = array();
        if ( $search_result )
        {
            foreach ( $search_result as $key => $catalog_obj )
            {
                $cur_item['object'] = $catalog_obj;
                $cur_item['link']   = base_url($catalog_obj->url);
                $result[] = $cur_item;
            }
        }
        return $result;
    }

  public function get_num_products ( $section_id = 0 )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_ITEM);
    $this->db->where('is_deleted !=', 1);
    $this->db->where('section_id', $section_id);
    $query = $this->db->get();
    return $query->num_rows();
  }

  // получить список товаров в разделе
  public function get_section_item_list ( $section_id = 0, $order_title = 'id', $order_type = 'DESC', $limit = 0 )
  {
    $this->db->distinct();
    $this->db->select('
      catalog_item.id,
      catalog_item.title,
      catalog_item.description,
      catalog_item.article,
      catalog_item.price,
      catalog_item.discount_price,
      catalog_item.discount_percent,
      catalog_item.section_id,
      catalog_item.priority,
      catalog_item.in_stock,
      catalog_item.is_bestseller,
      catalog_item.is_sale
    ');
    $this->db->from('catalog_item');
    $this->db->join('catalog_section', 'catalog_section.id = catalog_item.section_id');
    $this->db->where('catalog_section.id', $section_id);
    $this->db->where('catalog_section.is_deleted', 0);
    $this->db->where('catalog_item.is_deleted', 0);
    $this->db->order_by($order_title, $order_type);
    if ( $limit )
    {
      $this->db->limit($limit);
    }
    $tmp = $this->db->get()->result(self::CLASS_ITEM);
    foreach ($tmp as $key => $tmp_item) {
        $tmp[$key]->exist_discount_category();
    }
    return $tmp;
  }

  // получение списка доступных товаров
  public function get_item_list ( $order_title = 'id', $order_type = 'DESC', $limit = 0 )
  {
    $this->db->select('
      catalog_item.id,
      catalog_item.title,
      catalog_item.description,
      catalog_item.article,
      catalog_item.price,
      catalog_item.discount_price,
      catalog_item.discount_percent,
      catalog_item.section_id
    ');
    $this->db->from('catalog_item');
    $this->db->where('is_deleted', 0);
    $this->db->order_by($order_title, $order_type);
    if ( $limit )
    {
      $this->db->limit($limit);
    }
    $tmp = $this->db->get()->result(self::CLASS_ITEM);
    foreach ($tmp as $key => $tmp_item) {
        $tmp[$key]->exist_discount_category();
    }
    return $tmp;
  }

  // получить список товаров в категории
  public function get_category_item_list ( $category_id = 0, $order_title = 'id', $order_type = 'DESC' )
  {
    $this->db->distinct();
    $this->db->select('
      catalog_item.*
    ');
    $this->db->from('catalog_item');
    $this->db->join('catalog_item_links', 'catalog_item_links.item_id = catalog_item.id');
    $this->db->join('catalog_category', 'catalog_category.id = catalog_item_links.category_id');
    $this->db->where('catalog_category.is_deleted', 0);
    $this->db->where('catalog_item.is_deleted', 0);
    $this->db->where('catalog_item.price !=', 0);
    $this->db->where("(`catalog_category`.`id` = '{$category_id}' OR `catalog_category`.`parent_category_id` = '{$category_id}')");
    $this->db->order_by($order_title, $order_type);
    $tmp = $this->db->get()->result(self::CLASS_ITEM);
    foreach ($tmp as $key => $tmp_item) {
        $tmp[$key]->exist_discount_category();
    }
    return $tmp;
  }

  public function get_bestsellers ( $order_title = 'priority', $order_type = 'ASC', $limit = 0 )
  {
    $this->db->select('*');
    $this->db->from('catalog_item');
    $this->db->where('is_deleted', 0);
    $this->db->where('is_bestseller', 1);
    $this->db->order_by($order_title, $order_type);
    if ( $limit )
    {
      $this->db->limit($limit);
    }
    return $this->db->get()->result(self::CLASS_ITEM);
  }

  // получить список категорий, которые привязаны к товару
  public function get_item_category_list ( $item_id = 0 )
  {
    $this->db->distinct();
    $this->db->select('
      catalog_category.id,
      catalog_category.parent_category_id,
      catalog_category.parent_section_id,
      catalog_category.title
    ');
    $this->db->from('catalog_category');
    $this->db->join('catalog_item_links', 'catalog_item_links.category_id = catalog_category.id');
    $this->db->join('catalog_item', 'catalog_item.id = catalog_item_links.item_id');
    $this->db->where('catalog_item.id', $item_id);
    $this->db->where('catalog_category.is_deleted', 0);
    $this->db->where('catalog_item.is_deleted', 0);
    return $this->db->get()->result(self::CLASS_CATEGORY);
  }

  // получение похожих товаров
  public function get_similar_items ( $item_id = 0 )
  {
    $this->db->select('
      catalog_item.id,
      catalog_item.title,
      catalog_item.description,
      catalog_item.article,
      catalog_item.discount_price,
      catalog_item.discount_percent,
      catalog_item.price
    ');
    $this->db->from(self::TABLE_CATALOG_SIMILAR_ITEMS);
    $this->db->join('catalog_item', 'catalog_item.id = catalog_similar_items.sim_item_id');
    $this->db->where('catalog_similar_items.item_id', $item_id);
    $tmp = $this->db->get()->result(self::CLASS_ITEM);
    foreach ($tmp as $key => $tmp_item) {
        $tmp[$key]->exist_discount_category();
    }
    return $tmp;
  }

  // проверить похожий товар
  public function check_similar ( $item_id = 0, $sim_item_id = 0 )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_SIMILAR_ITEMS);
    $this->db->where('item_id', $item_id);
    $this->db->where('sim_item_id', $sim_item_id);
    if ( $this->db->count_all_results() )
    {
      return TRUE;
    }
    return FALSE;
  }

  public function set_similar_items ( $item_id = 0, $sim_item_id = 0 )
  {
    if ( ! $this->check_similar($item_id, $sim_item_id) )
    {
      $data = array (
        'item_id'     => $item_id,
        'sim_item_id' => $sim_item_id
      );
      $insert_query = $this->db->insert_string(self::TABLE_CATALOG_SIMILAR_ITEMS, $data);
      $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
      $this->db->query($insert_query);
      return TRUE;
    }
    return FALSE;
  }

  public function unset_similar_items ( $item_id, $sim_item_id = 0 )
  {
    $data = array (
      'item_id'     => $item_id,
      'sim_item_id' => $sim_item_id
    );
    $this->db->delete(self::TABLE_CATALOG_SIMILAR_ITEMS, $data);
  }

  // получить основное изображение товара
  public function get_main_image ( $item_id = 0 )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_ITEM_IMAGES);
    $this->db->where('item_id', $item_id);
    $this->db->where('is_main', 1);
    return $this->db->get()->row();
  }

  // получить 1е изображение товара
  public function get_first_image ( $item_id = 0 )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_ITEM_IMAGES);
    $this->db->where('item_id', $item_id);
    $this->db->order_by('priority', 'DESC');
    $this->db->limit(1);
    return $this->db->get()->row();
  }

  // получить все изображения товара
  public function get_images ( $item_id = 0 )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_ITEM_IMAGES);
    $this->db->where('item_id', $item_id);
    $this->db->order_by('priority', 'DESC');
    return $this->db->get()->result();
  }

  // отвязать товар от категории
  public function unlink ( $item_id, $category_id )
  {
    $data = array (
      'item_id'     => $item_id,
      'category_id' => $category_id
    );
    $this->db->delete(self::TABLE_CATALOG_ITEM_LINKS, $data);
  }

  // получить объект указанного типа (section, category, item)
  public function get_object ( $object_id = 0, $object_type = '' )
  {
    switch ( $object_type )
    {
      case 'section':
        $table = self::TABLE_CATALOG_SECTION;
        $class = self::CLASS_SECTION;
        break;

      case 'category':
        $table = self::TABLE_CATALOG_CATEGORY;
        $class = self::CLASS_CATEGORY;
        break;

      case 'item':
        $table = self::TABLE_CATALOG_ITEM;
        $class = self::CLASS_ITEM;
        break;

      default:
        return FALSE;
        break;
    }
    $this->db->select('*');
    $this->db->from($table);
    $this->db->where('id', $object_id);
    $result = $this->db->get()->result($class);
    if ( ! empty($result) )
    {
        if ($object_type == 'item') {
            $result[0]->exist_discount_category();
        }
        return $result[0];
    }
    return FALSE;
  }

  // получить список валют
  public function get_currency_list ()
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_CURRENCY);
    return $this->db->get()->result();
  }

  public function get_section_currency ( $section_id = 0 )
  {
    $this->db->select('value');
    $this->db->from('catalog_currency');
    $this->db->join('catalog_section', 'catalog_section.currency_id = catalog_currency.id');
    $this->db->where('catalog_section.id', $section_id);
    $this->db->where('catalog_section.is_deleted !=', 1);
    return $this->db->get()->row()->value;
  }

  // получить список всех привязок товаров и категорий
  public function get_category_items ( $object_id )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_ITEM_LINKS);
    return $this->db->get()->result();
  }

  // сохранить/обновить данные объекта
  public function save ( $object )
  {
    $object_class = get_class($object);
    switch ( $object_class )
    {
      case self::CLASS_SECTION:
        if ( $object->id )
        {
          $this->db->update(self::TABLE_CATALOG_SECTION, $object, array('id' => $object->id));
        } else {
          $this->db->insert(self::TABLE_CATALOG_SECTION, $object);
          return $this->db->insert_id();
        }
        break;

      case self::CLASS_CATEGORY:
        if ( $object->id )
        {
          $this->db->update(self::TABLE_CATALOG_CATEGORY, $object, array('id' => $object->id));
        } else {
          $this->_inc_num_categories($object->parent_section_id);
          $this->db->insert(self::TABLE_CATALOG_CATEGORY, $object);
        }
        break;

      case self::CLASS_ITEM:
        if ( $object->id )
        {
          $this->db->update(self::TABLE_CATALOG_ITEM, $object, array('id' => $object->id));
        } else {
          $this->db->insert(self::TABLE_CATALOG_ITEM, $object);
          return $this->db->insert_id();
        }
        break;

      default:
        return FALSE;
        break;
    }
    return TRUE;
  }

  // добавление пользовательского поля
  public function user_field_add ( $section_id, $uf_title, $uf_type )
  {
    if ( count($uf_title) == count($uf_type) )
    {
      for ( $i = 0; $i < count($uf_title); $i++ )
      {
        if ( $uf_title[$i] )
        {
          $data = array (
             'title'      => $uf_title[$i],
             'type'       => $uf_type[$i],
             'section_id' => $section_id
          );
          $this->db->insert(self::TABLE_CATALOG_USER_FIELDS, $data);
        }
      }
    }
  }

  // обновление пользовательского поля
  public function user_field_upd ( $section_id, $cur_uf_title, $cur_uf_id )
  {
    if ( count($cur_uf_title) == count($cur_uf_id) )
    {
      for ( $i = 0; $i < count($cur_uf_title); $i++ )
      {
        if ( $cur_uf_title[$i] )
        {
          $data = array (
             'title' => $cur_uf_title[$i]
          );
        } else {
          $data = array (
             'is_deleted' => 1
          );
        }
        $this->db->where('section_id', $section_id);
        $this->db->where('id', $cur_uf_id[$i]);
        $this->db->update(self::TABLE_CATALOG_USER_FIELDS, $data);
      }
    }
  }

    // получить список пользовательских полей
    public function get_uf_list ( $section_id )
    {
        $this->db->select('*');
        $this->db->from(self::TABLE_CATALOG_USER_FIELDS);
        $this->db->where('section_id', $section_id);
        $this->db->where('is_deleted', 0);
        return $this->db->get()->result_array();
    }

    // получить список значений пользовательских полей
    public function get_uf_values ( $section_id, $item_id )
    {
        $this->db->select('*');
        $this->db->from(self::TABLE_CATALOG_USER_VALUES);
        $this->db->join('catalog_user_fields', 'catalog_user_values.user_field_id = catalog_user_fields.id');
        $this->db->where('catalog_user_fields.is_deleted', 0);
        $this->db->where('catalog_user_fields.section_id', $section_id);
        $this->db->where('catalog_user_values.item_id', $item_id);
        return $this->db->get()->result_array();
    }

    // добавление значений пользовательских полей
    public function set_uf_values ( $item_id, $uf_values, $uf_ids, $uf_types )
    {
        for ( $i = 0; $i < count($uf_values); $i++ )
        {
            $data = array();
            $data['value_int']    = NULL;
            $data['value_float']  = NULL;
            $data['value_string'] = NULL;
            $data['value_text']   = NULL;
            $data['value_date']   = NULL;
            if ( $uf_values[$i] )
            {
                switch ( $uf_types[$i] )
                {
                    case 1:
                        $data['value_int'] = (int) $uf_values[$i];
                        break;
                    case 2:
                        $data['value_float'] = (float) $uf_values[$i];
                        break;
                    case 3:
                        $data['value_string'] = (string) $uf_values[$i];
                        break;
                    case 4:
                        $data['value_text'] = trim($uf_values[$i]);
                        break;
                    case 5:
                        $data['value_date'] = date('Y-m-d H:i:s', strtotime($uf_values[$i]));
                        break;
                    default:
                        continue;
                        break;
                }
            }
            $data['item_id']       = $item_id;
            $data['user_field_id'] = $uf_ids[$i];
            $this->db->insert(self::TABLE_CATALOG_USER_VALUES, $data);
        }
    }

    // обновление значений пользовательских полей
    public function upd_uf_values ( $item_id, $uf_values, $uf_ids, $uf_types )
    {
        if ( count($uf_values) == count($uf_ids) )
        {
            for ( $i = 0; $i < count($uf_values); $i++ )
            {
                $data = array();
                $data['value_int']    = NULL;
                $data['value_float']  = NULL;
                $data['value_string'] = NULL;
                $data['value_text']   = NULL;
                $data['value_date']   = NULL;
                if ( $uf_values[$i] )
                {
                    switch ( $uf_types[$i] )
                    {
                        case 1:
                            $data['value_int'] = (int) $uf_values[$i];
                            break;
                        case 2:
                            $data['value_float'] = (float) $uf_values[$i];
                            break;
                        case 3:
                            $data['value_string'] = (string) $uf_values[$i];
                            break;
                        case 4:
                            $data['value_text'] = trim($uf_values[$i]);
                            break;
                        case 5:
                            $data['value_date'] = date('Y-m-d H:i:s', strtotime($uf_values[$i]));
                            break;
                        default:
                            continue;
                            break;
                    }
                }
                $this->db->where('item_id', $item_id);
                $this->db->where('user_field_id', $uf_ids[$i]);
                $this->db->update(self::TABLE_CATALOG_USER_VALUES, $data);
            }
        }
    }

  public function get_yml ( $model = FALSE, $vendor = 'NoName' )
  {
    $page_info = $this->manager_modules->get_page_data(array());

    $category_list = $this->get_full_category_list();

    $offer_list = array();
    foreach ( $category_list as $key => $category )
    {
      $offer_list = array_merge($offer_list, $this->get_category_item_list($category->id));
    }
    $offer_list = array_unique($offer_list);

    // Использование yml в формате <vendor> и <model>
    $data['yml']['model']               = $model;
    $data['yml']['vendor']              = $vendor;

    $data['yml']['catalog_date']        = date("Y-m-d H:i");

    $data['yml']['shop_name']           = $page_info['site_settings']['title'];
    $data['yml']['shop_company']        = $page_info['site_settings']['title'];
    $data['yml']['shop_url']            = base_url();

    $data['yml']['currency_id']         = 'RUR';

    $data['yml']['categories']          = $category_list;
    $data['yml']['offers']              = $offer_list;

    $data['yml']['local_delivery_cost'] = 0;
    $data['yml']['offer_type']          = 'vendor.model';
    $data['yml']['offer_available']     = 'true';

    return $this->load->site_view($this->_template['yml'], $data, TRUE);
  }

  // добавление изображения
  public function images_add ( $item_id, $imgs_id )
  {
    if ( ! empty($imgs_id) )
    {
      $data = array();
      foreach ( $imgs_id as $key => $image_id )
      {
        $is_main = ( $key == 0 ) ? 1 : 0;
        $data[] = array (
          'item_id'  => $item_id,
          'image_id' => $image_id,
          'is_main'  => $is_main
        );
      }
      $this->db->insert_batch(self::TABLE_CATALOG_ITEM_IMAGES, $data);
    }
  }

    // редактирование изображения
    public function images_edit ( $item_id, $imgs_id )
    {
        if ( ! empty($imgs_id) )
        {
            $data = array();
            foreach ( $imgs_id as $key => $image_id )
            {
                $data[] = array (
                    'item_id'  => $item_id,
                    'image_id' => $image_id
                );
            }
            $this->db->insert_batch(self::TABLE_CATALOG_ITEM_IMAGES, $data);
        }
    }

    // установить самое первое изображение в качестве основного, если уже не установлено
    public function set_first_main_img ( $item_id = 0 )
    {
        $cur_main_img = $this->get_main_image($item_id);
        if ( empty($cur_main_img) )
        {
            $data['is_main'] = 1;

            $this->db->where('item_id', $item_id);
            $this->db->order_by('id', 'asc');
            $this->db->limit(1);
            $this->db->update(self::TABLE_CATALOG_ITEM_IMAGES, $data);
        }
    }

  private function reset_main_img ( $item_id )
  {
    $data['is_main'] = 0;
    $this->db->where('item_id', $item_id);
    $this->db->update(self::TABLE_CATALOG_ITEM_IMAGES, $data);
  }

  public function images_save ( $item_id, $cur_imgs, $cur_priority, $main_img )
  {
    if ( !empty($cur_imgs) && !empty($cur_priority) )
    {
      foreach ( $cur_imgs as $key => $image_id )
      {
        $data = array (
          'priority' => $cur_priority[$key],
        );
        $this->db->where('id', $image_id);
        $this->db->update(self::TABLE_CATALOG_ITEM_IMAGES, $data);
      }
      if ( $main_img )
      {
        $this->reset_main_img($item_id);
        $data2['is_main'] = 1;
        $this->db->where('id', $main_img);
        $this->db->update(self::TABLE_CATALOG_ITEM_IMAGES, $data2);
      }
    }
  }

  public function image_delete ( $item_id, $image_id )
  {
    if ( $item_id )
    {
      $data['item_id'] = $item_id;
      $data['image_id'] = $image_id;
      $this->db->delete(self::TABLE_CATALOG_ITEM_IMAGES, $data);
    }
  }

  // получение списка изображений товара
  public function get_item_images ( $item_id )
  {
    $this->db->select('*');
    $this->db->from(self::TABLE_CATALOG_ITEM_IMAGES);
    $this->db->where('item_id', $item_id);
    $this->db->order_by('priority', 'DESC');
    $result = $this->db->get()->result_array();
    $res = array();
    foreach ($result as $key => $value)
    {
      $res[] = array (
        'info' => $value,
        'img'  => new Image_item($value['image_id']),
      );
    }
    return $res;
  }

  // получение списка категорий, привязаннх к товару
  public function get_item_links ( $item_id )
  {
    $this->db->select('category_id');
    $this->db->from(self::TABLE_CATALOG_ITEM_LINKS);
    $this->db->where('item_id', $item_id);
    $result = $this->db->get()->result_array();
    $res = array();
    foreach ($result as $key => $value)
    {
      $res[] = $value['category_id'];
    }
    return $res;
  }

  // привязка категории к товару
  public function links_add ( $item_id, $category_id_list )
  {
    if ( !empty($category_id_list) && !in_array(0, $category_id_list) )
    {
      $data = array();
      foreach ( $category_id_list as $category_id )
      {
        $data[] = array (
          'item_id'     => $item_id,
          'category_id' => $category_id
        );
      }
      $this->db->insert_batch(self::TABLE_CATALOG_ITEM_LINKS, $data);
    }
  }

  // перевязка ссылок категорий на товар
  public function links_edit ( $item_id, $category_id_list )
  {
    if ( !empty($category_id_list) && !in_array(0, $category_id_list) )
    {
      $this->db->delete(self::TABLE_CATALOG_ITEM_LINKS, array('item_id' => $item_id));
      $data = array();
      foreach ( $category_id_list as $category_id )
      {
        $data[] = array (
          'item_id'     => $item_id,
          'category_id' => $category_id
        );
      }
      $this->db->insert_batch(self::TABLE_CATALOG_ITEM_LINKS, $data);
    } elseif ( !empty($category_id_list) && in_array(0, $category_id_list) ) {
      $this->db->delete(self::TABLE_CATALOG_ITEM_LINKS, array('item_id' => $item_id));
    }
  }

  private function _inc_num_categories ( $section_id )
  {
    $this->db->set('num_categories', 'num_categories + 1', FALSE);
    $this->db->where('id', $section_id);
    return $this->db->update(self::TABLE_CATALOG_SECTION);
  }

  private function _dec_num_categories ( $section_id )
  {
    $this->db->set('num_categories', 'num_categories - 1', FALSE);
    $this->db->where('id', $section_id);
    return $this->db->update(self::TABLE_CATALOG_SECTION);
  }

  // удаление данных объекта
  public function delete ( $object_id, $object_type )
  {
    switch ( $object_type )
    {
      case 'section':
        $this->_set_is_deleted(self::TABLE_CATALOG_SECTION, $object_id, 1);
        break;

      case 'category':
        $this->_dec_num_categories($object_id->parent_section_id);
        $this->_set_is_deleted(self::TABLE_CATALOG_CATEGORY, $object_id->id, 1);
        break;

      case 'item':
        $this->_set_is_deleted(self::TABLE_CATALOG_ITEM, $object_id->id, 1);
        break;

      default:
        return FALSE;
        break;
    }
    return TRUE;
  }

  private function _set_is_deleted ( $table, $id, $value )
  {
    $this->db->set('is_deleted', $value);
    $this->db->where('id', $id);
    return $this->db->update($table);
  }

  public function get_page_content ( $page_id = 0 )
  {
    // update cart
    if ( isset($_POST['type']) && ($_POST['type'] == 'upd') && isset($_POST['my_ids']) && isset($_POST['my_qty']) )
    {
      foreach ( $_POST['my_ids'] as $key => $rowid )
      {
        $data[] = array (
          'rowid' => $rowid,
          'qty'   => $_POST['my_qty'][$key]
        );
      }
      $this->cart->update($data);
      redirect($_SERVER['HTTP_REFERER']);
    }

    // add to cart
    if ( isset($_POST['type']) && ($_POST['type'] == 'add') && isset($_POST['item_id']) && isset($_POST['qty']) )
    {
      $item_id  = $_POST['item_id'];
      $quantity = $_POST['qty'];
      $size = $_POST['size2'];
      if(empty($size)){
      $size ='no size';
      }
      $find_item = FALSE;
      foreach ( $this->cart->contents() as $item )
      {
        if ( $item['id'] == $item_id )
        {
          $find_item = TRUE;
          $data = array(
            'rowid' => $item['rowid'],
            'qty'   => $item['qty'] + $quantity
          );
          $this->cart->update($data);
          break;
        }
      }
      if ( ! $find_item )
      {
        $item = $this->get_object($item_id, 'item') ;
        $data = array (
          'id'    => $item->id,
          'qty'   => $quantity,
          'price' => $item->get_discount_price(),
          'size' => $size,
          'name'  => $item->title,
          'options' => array (
              'article' => $item->article
          )
        );
        $this->cart->insert($data);
      }
      redirect($_SERVER['HTTP_REFERER']);
    }

    // delete from cart
    if ( isset($_POST['type']) && ($_POST['type'] == 'del') && isset($_POST['rowid']) )
    {
      $data = array(
        'rowid' => $_POST['rowid'],
        'qty'   => 0
      );
      $this->cart->update($data);
      redirect($_SERVER['HTTP_REFERER']);
    }
    // quick_click cart
    if ( isset($_POST['type']) && ($_POST['type'] == 'quick_click') && isset($_POST['id_tovar']) )
    {
        $this->form_validation->set_rules('name2', 'Имя', 'required');
        $this->form_validation->set_rules('tel2', 'Телефон', 'required');
        $this->form_validation->set_rules('adr2', 'Адрес', 'required');
        $this->form_validation->set_rules('email2', 'Электронный адрес', 'required|valid_email');

        $this->form_validation->set_message('required', '<span>Поле "%s" не заполнено</span>');
        $this->form_validation->set_message('valid_email', '<span>Введен недействительный электронный адрес.</span>');
               
        if ( $this->form_validation->run() )
        {
        $size  = $_POST['size1'];
            $item = $this->get_object($_POST['id_tovar'], 'item') ;
            $data = array (
              'id'    => $item->id,
              'qty'   => 1,
              'price' => $item->get_discount_price(),
              'size' => $size,
              'name'  => $item->title,
              'options' => array (
                  'article' => $item->article
              )
            );
            $this->cart->insert($data);
            
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
        
            $now = date("Y-m-d H:i:s", time());
            $order_data = array();
            $order_data['name']            = $this->input->post('name2');
            $order_data['address']          = $this->input->post('adr2');
            $order_data['phone']           = $this->input->post('tel2');
            $order_data['email']           = $this->input->post('email2');
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
                $data['size']         = $item['size'];
                $data['date_created'] = $now;
                $cart_data[] = $data;
            }
            $this->db->insert_batch('cart_item', $cart_data);

                        // TODO: payment operations

            $this->_send_mails($this->input->post('email2'), $order_id, $total_price);
            $this->cart->destroy();
            
            return $this->load->site_view($this->_template['thankyou'], array(), TRUE);
        }else{
            $data = array (
            'item'       => $this->get_object($_POST['id_tovar'], 'item')
            );
        return $this->load->site_view($this->_template['detail'], $data, true);
        }
      
    }

    $catalog_products = array();
    $paginator        = array();
    // выбор каталога для текущей страницы
    $section = $this->get_catalog($page_id);

    if ( ! empty($section) )
    {
      // single item
      if ( $item_id = $this->input->get('item') )
      {
        if ( $section->similar_items )
        {
          $similar_items = $this->get_similar_items($item_id);
        } else {
          $item_cats = $this->get_item_category_list($item_id);
          if ( !empty($item_cats) )
          {
            $similar_items = array();
            foreach ( $item_cats as $category )
            {
              $similar_items = array_merge($similar_items, $this->get_category_item_list($category->id));
            }
            $similar_items = array_unique($similar_items);
          } else {
            $similar_items = array();
          }
        }
        $data = array (
          'item'       => $this->get_object($item_id, 'item'),
          'similar'    => $similar_items,
        );
        return $this->load->site_view($this->_template['detail'], $data, true);
      }

      // item list
      if ( $cat_id = $this->input->get('cat') )
      {
        $catalog_products = $this->get_category_item_list($cat_id);
        if ( isset($_REQUEST['type']) && ($_REQUEST['type'] == 'filter'))
        { 
            unset($catalog_products);
            $catalog_products=array();
            $catalog_prod=array();
            $brend_id=0;
            $color_id=0;
            if(!empty($_REQUEST['brendz'])){
                $brend_id=$this->diff_func_mapper->get_brend2($_REQUEST['brendz']);
            }
            if(!empty($_REQUEST['colorz'])){
                $color_id=$this->diff_func_mapper->get_color2($_REQUEST['colorz']);    
            }
            $this->db->distinct();
            $this->db->select('
              catalog_item.*
            ');
            $this->db->from('catalog_item');
            $this->db->join('catalog_item_links', 'catalog_item_links.item_id = catalog_item.id');
            $this->db->join('catalog_category', 'catalog_category.id = catalog_item_links.category_id');
            $this->db->where('catalog_category.is_deleted', 0);
            $this->db->where('catalog_item.is_deleted', 0);
            $this->db->where('catalog_item.price !=', 0);
            if(!empty($_REQUEST['brendz'])){
                $this->db->where('catalog_item.brend_kol',$brend_id['id'] );
            }
            if(!empty($_REQUEST['colorz'])){
                $this->db->where('catalog_item.color',$color_id['id'] );    
            }
            $this->db->where("(`catalog_category`.`id` = '{$cat_id}' OR `catalog_category`.`parent_category_id` = '{$cat_id}')");
            $this->db->order_by('catalog_item.priority', 'ask');
            $catalog_prod = $this->db->get()->result(self::CLASS_ITEM);
            foreach ($catalog_prod as $key => $tmp_item) {
                $catalog_prod[$key]->exist_discount_category();
            }
            if(!empty($_REQUEST['sizez'])){
            $ind=0;
            $size_id=$this->diff_func_mapper->get_size20($_REQUEST['sizez']);
                foreach($catalog_prod as $index1=>$cat_p){
                    $flaq_size=false;                                              
                    $sizer=explode(';', $cat_p->size);                        
                    foreach($sizer as $siz){                            
                        if((int)$siz == (int)$size_id['id'] ){                               
                            $flaq_size=true;                                   
                        }
                    }
                    if($flaq_size == true){
                        $catalog_products[$ind]=$cat_p;
                        $ind++;
                    }
                  
                    
                }
            }else{
                $catalog_products = $catalog_prod;
            }
                               
        }  
            
      } else {
        $catalog_products = $this->get_section_item_list($section->id);
        if ( isset($_REQUEST['type']) && ($_REQUEST['type'] == 'filter'))
        { 
            unset($catalog_products);
            $catalog_products=array();
            $catalog_prod=array();
            $brend_id=0;
            $color_id=0;
            if(!empty($_REQUEST['brendz'])){
                $brend_id=$this->diff_func_mapper->get_brend2($_REQUEST['brendz']);
            }
            if(!empty($_REQUEST['colorz'])){
                $color_id=$this->diff_func_mapper->get_color2($_REQUEST['colorz']);    
            }
            $this->db->distinct();
            $this->db->select('
              catalog_item.*
            ');
            $this->db->from('catalog_item');
            $this->db->join('catalog_section', 'catalog_section.id = catalog_item.section_id');
            $this->db->where('catalog_section.id', $section->id);
            $this->db->where('catalog_section.is_deleted', 0);
            $this->db->where('catalog_item.is_deleted', 0);
            if(!empty($_REQUEST['brendz'])){
                $this->db->where('catalog_item.brend_kol',$brend_id['id'] );
            }
            if(!empty($_REQUEST['colorz'])){
                $this->db->where('catalog_item.color',$color_id['id'] );    
            }
            $this->db->order_by('catalog_item.priority', 'ask');
            $catalog_prod = $this->db->get()->result(self::CLASS_ITEM);
            foreach ($catalog_prod as $key => $tmp_item) {
                $catalog_prod[$key]->exist_discount_category();
            }
            if(!empty($_REQUEST['sizez'])){
            $ind=0;
            $size_id=$this->diff_func_mapper->get_size20($_REQUEST['sizez']);
                foreach($catalog_prod as $index1=>$cat_p){
                    $flaq_size=false;                                              
                    $sizer=explode(';', $cat_p->size);                        
                    foreach($sizer as $siz){                            
                        if((int)$siz == (int)$size_id['id'] ){                               
                            $flaq_size=true;                                   
                        }
                    }
                    if($flaq_size == true){
                        $catalog_products[$ind]=$cat_p;
                        $ind++;
                    }
                  
                    
                }
            }else{
                $catalog_products = $catalog_prod;
            }
                               
        } 
      }

      $count_per_page = $section->count_per_page;
      $total_rows     = count($catalog_products);

      $section_url = $this->page_mapper->get_page($section->parent_page_id)->url;

      // pagination create: [ $module_config = '', $base_url = '', $total_rows = 0, $per_page = 0 ]
      $paginator = $this->pagination->create('pagination_catalog', $section_url, $total_rows, $count_per_page);

      $catalog_products = array_splice($catalog_products, (int) $this->input->get('per_page'), $count_per_page);
    }

    $data = array(
      'catalog_products' => $catalog_products,
      'paginator'        => $paginator,
    );
    return $this->load->site_view($this->_template['show'], $data, true);
  }

  /* START saving discounts */
  public function get_saving_discounts ()
  {
    $this->db
      ->select('*')
      ->from('catalog_discounts');
    return $this->db->get()->result();
  }

  public function remove_saving_discounts ()
  {
    $this->db->empty_table('catalog_discounts');
  }

  public function set_saving_discounts ( $order_limit, $discount_price, $discount_percent )
  {
    if ( (count($order_limit) == count($discount_price)) && (count($order_limit) == count($discount_percent)) )
    {
      for ( $i = 0; $i < count($order_limit); $i++ )
      {
        if ( ($order_limit[$i] > 0) && (($discount_price[$i] > 0) || ($discount_percent[$i] > 0 && $discount_percent[$i] < 100)) )
        {
          $data = array (
             'order_limit'      => $order_limit[$i],
             'discount_price'   => $discount_price[$i],
             'discount_percent' => $discount_percent[$i]
          );
          $this->db->insert('catalog_discounts', $data);
        }
      }
    }
  }

  public function get_saving_discount ( $order_limit = 0 )
  {
    $this->db->select('*');
    $this->db->from('catalog_discounts');
    $this->db->where('order_limit <=', $order_limit);
    $this->db->order_by('order_limit', 'desc');
    $this->db->limit(1);
    return $this->db->get()->row();
  }
  /* END saving discounts */







/*================================================================================
================================================================================
================================================================================*/


  public function qwerty() {
    // == breadcrumbs ==========================================================
    $category_list = array();
    $item_info = array();
    if ( ( ! empty($selection) ) && ( get_class($selection) == 'Catalog_item') )
    {
      $item_info = array (
        'id' => $selection->id,
        'title' => $selection->title
      );
      $cur_cat = $this->get_category($selection->parent_id);
      $category_list = $this->_get_parents_list($cur_cat->id, $cur_cat->title);
    }
    if ( ( ! empty($selection) ) && ( get_class($selection) == 'Catalog_category') )
    {
      $category_list = $this->_get_parents_list($selection->id, $selection->title);
    }
    // == breadcrumbs ==========================================================
  }

  /*-- page breadcrumbs ------------------------------------------------------*/

  protected function _get_parents_list ( $category_id, $category_title )
  {
    $result = array();
    // add all parents to result array
    $category_tree = $this->_get_pages_tree_up($category_id);
    foreach ( $category_tree as $key => $cat_item )
    {
      $item = $this->get_category($cat_item);
      $result[] = array (
        'id' => $item->id,
        'title' => $item->title
      );
    }
    // add current page to result array
    $result[] = array (
      'id' => $category_id,
      'title' => $category_title
    );
    return $result;
  }

  // get all parents for current page
  protected function _get_pages_tree_up ( $page_id, $pages_array = array() )
  {
    $page = $this->db->select('parent_id, title')->from($this->_table)->where('id', $page_id)->get()->row_array();
    if ( ! empty($page['parent_id']) )
    {
      $pages_array[] = $page['parent_id'];
      return $this->_get_pages_tree_up($page['parent_id'], $pages_array);
    }
    return array_reverse($pages_array);
  }

  /*-- page breadcrumbs end --------------------------------------------------*/
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
                    <td>Размер</td>
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
                    <td>{$cart_item['size']}</td>
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
        $userinfo .= '<p>Имя - '.$db_result['name'].'</p>';
        $userinfo .= '<p>Адрес - '.$db_result['address'].'</p>';
        $userinfo .= '<p>Телефон - '.$db_result['phone'].'</p>';
        $userinfo .= '<p>Электронная почта - '.$db_result['email'].'</p>';
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


}