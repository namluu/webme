<?php
Config::set('site_name', 'Webme');

Config::set('route_admin', 'admin12a');
Config::set('routes', array(
    'default' => '',
    Config::get('route_admin') => 'admin_'
));

Config::set('languages', array('en', 'vi'));
Config::set('default_route', 'default');
Config::set('default_language', 'en');
Config::set('default_controller', 'home');
Config::set('default_action', 'index');

Config::set('base_url', 'http://webme.loc/');
Config::set('admin_url', Config::get('base_url').Config::get('route_admin').'/');

Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', '');
Config::set('db.db_name', 'webme');

Config::set('salt', '23drf4yy6@aw177');