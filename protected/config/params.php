<?php

// this contains the application parameters that can be maintained via GUI
return array(
	// this is displayed in the header section
    'building'=>false,
    'menu_categories'=>'Menu_categoriesModel',
    'menu_actions'=>'Menu_actionModel',
    'auth_user'=>'Auth_userModel',
    'auth_permissions'=>'Auth_permissionsModel',
    'auth_membership'=>'Auth_membershipModel',
    'label'=>require(dirname(__FILE__).'/labelLanguage.php'),
    'description'=>require(dirname(__FILE__).'/description.php')
);