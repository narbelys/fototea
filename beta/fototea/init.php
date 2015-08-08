<?php

use \Fototea\Config\FConfig;

ORM::configure('mysql:host=' . FConfig::getValue('db_hostname') . ';dbname=' . FConfig::getValue('db_name'));
ORM::configure('username', FConfig::getValue('db_user'));
ORM::configure('password', FConfig::getValue('db_password'));
ORM::configure('logging', FConfig::getValue('db_query_log'));

//Date and locale function
