<?

$page_data['widgets'] = array();

/* get widget data */

$footer_menu = $this->page_mapper->get_menu(0, 0);
$main_slider1 = $this->banner_mapper->get_widget(1);
$main_slider2 = $this->banner_mapper->get_widget(2);
$main_slider3 = $this->banner_mapper->get_widget(3);
$main_slider4 = $this->banner_mapper->get_widget(4);
$main_slider5 = $this->banner_mapper->get_widget(5);
$main_slider6 = $this->banner_mapper->get_widget(6);
$main_slider7 = $this->banner_mapper->get_widget(7);
$text_banner = $this->text_mapper->get_widjet(1);
$search_form = $this->search_mapper->get_form();

/* set template data */

$page_data['widgets']['footer_menu'] = $footer_menu[0];
$page_data['widgets']['text_banner'] = $text_banner;
$page_data['widgets']['main_slider1'] = $main_slider1;
$page_data['widgets']['main_slider2'] = $main_slider2;
$page_data['widgets']['main_slider3'] = $main_slider3;
$page_data['widgets']['main_slider4'] = $main_slider4;
$page_data['widgets']['main_slider5'] = $main_slider5;
$page_data['widgets']['main_slider6'] = $main_slider6;
$page_data['widgets']['main_slider7'] = $main_slider7;
$page_data['widgets']['search_form'] = $search_form;

?>