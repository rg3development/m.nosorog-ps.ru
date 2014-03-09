<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'content';
$route['rss(.)*']            = 'content/rss';
$route['yml(.)*']            = 'content/yml';
$route['xml(.)*']            = 'content/xml';
$route['sitemap.xml']        = 'content/sitemap_xml';
$route['robots.txt']         = 'content/robots_txt';
$route['^admin$']            = 'admin/map';
$route['admin/auth']         = 'admin/auth/login';
$route['admin/(.+)']         = 'admin/$1';
$route['(.)+']               = 'content';
$route['404_override']       = 'error404';