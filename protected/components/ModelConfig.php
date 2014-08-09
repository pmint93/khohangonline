<?php
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 2/24/14
 * Time: 10:54 PM
 */

class ModelConfig
{
    public static $config = array(
        'autoCreate' => true,
        'collate'=>'utf8_unicode_ci',
        'tableLog'=>'auth_user',
        'database' => array(
            'auth_user' => array(
                'first_name' => array(
                    'type' => 'text',
                    'label' => 'First name'
                ),
                'last_name' => array(
                    'type' => 'text',
                    'label' => 'Last name'
                ),
                'email' => array(
                    'type' => 'text',
                    'label' => 'Email'
                ),
                'username' => array(
                    'type' => 'text',
                    'label' => 'Username',
                    'select' => true
                ),
                'password' => array(
                    'type' => 'text',
                    'label' => 'Password',
                ),
                'birthday' => array(
                    'type' => 'date',
                    'label' => 'Birthday'
                ),
                'address' => array(
                    'type' => 'text',
                    'label' => 'Address'
                ),
                'baned' => array(
                    'type' => 'boolean',
                    'label' => 'Baned'
                ),
                #######################
                ### Config Table
                'hashCode' => array(
                    'password'=>'username'
                )
            ),
            'auth_group' => array(
                'name' => array(
                    'type' => 'text',
                    'label' => 'Group name',
                    'select' => true
                ),
                'code' => array(
                    'type' => 'text',
                    'label' => 'Code'
                ),
                'description' => array(
                    'type' => 'string',
                    'label' => 'Description'
                )
            ),
            'auth_membership' => array(
                'user_id' => array(
                    'type' => 'relation',
                    'table' => 'auth_user',
                    'label' => 'User'
                ),
                'group_id' => array(
                    'type' => 'relation',
                    'table' => 'auth_group',
                    'label' => 'Group'
                )
            ),
            #Table Config
            'config' => array(
                'code' => array(
                    'type' => 'text',
                    'label' => 'Code',
                    'select' => true
                ),
                'value' => array(
                    'type' => 'text',
                    'label' => 'Value'
                ),
                'description' => array(
                    'type' => 'string',
                    'label' => 'Description'
                )
            ),
            ########################
            'users_logs' => array(
                'from_url'=>array(
                    'type' => 'text',
                    'label' => 'From URL'
                ),
                'link' => array(
                    'type' => 'text',
                    'label' => 'Link'
                ),
                'time' => array(
                    'type' => 'datetime',
                    'label' => 'Time'
                ),
                'address' => array(
                    'type' => 'text',
                    'label' => 'IP Address'
                ),
                'platform' => array(
                    'type' => 'text',
                    'label' => 'Platform'
                ),
                'browser' => array(
                    'type' => 'text',
                    'label' => 'Browser'
                )
            ),
            'menu_categories' => array(
                'name'=>array(
                    'type' => 'text',
                    'label' => 'Category Name',
                    'select' => true
                ),
                'description' => array(
                    'type' => 'string',
                    'label' => 'Description'
                )
            ),
            'menu_action' => array(
                'name'=>array(
                    'type' => 'text',
                    'label' => 'Action Name',
                    'select' => true
                ),
                'category_id'=>array(
                    'type' => 'relation',
                    'table' => 'menu_categories',
                    'label' => 'Category'
                ),
                'controller'=>array(
                    'type' => 'text',
                    'label' => 'Controller'
                ),
                'action'=>array(
                    'type' => 'text',
                    'label' => 'Action'
                ),
                'description' => array(
                    'type' => 'string',
                    'label' => 'Description'
                )
            ),
            'auth_permissions' => array(
                'menu_action_id' => array(
                    'type' => 'relation',
                    'table' => 'menu_action',
                    'label' => 'Action'
                ),
                'group_id' => array(
                    'type' => 'relation',
                    'table' => 'auth_group',
                    'label' => 'Group'
                )
            ),
            ###############
            'category' => array(
                'name' => array(
                    'type' => 'varchar(255)',
                    'label' => 'Name'
                ),
                'description' => array(
                    'type' => 'text',
                    'label' => "Decription",
                    'null' => true
                )
            ),
            'product' => array(
                'name' => array(
                    'type' => 'varchar(255)',
                    'label' => 'Name'
                ),
                'category_id' => array(
                    'type' => 'relation',
                    'table' => 'category',
                    'label' => 'Category ID'
                ),
                'quantity' => array(
                    'type' => 'int',
                    'label' => 'Name'
                ),
                'default_price' => array(
                    'type' => 'int',
                    'label' => 'Default price'
                ),
                'description' => array(
                    'type' => 'text',
                    'label' => "Description",
                    'null' => true
                )
            ),
            'order_type' => array(
                'code' => array(
                    'type' => 'varchar(20)',
                    'label' => 'Order type code'
                ),
                'description' => array(
                    'type' => 'string',
                    'label' => 'Description',
                    'null' => true
                )
            ),
            'order_status' => array(
                'code' => array(
                    'type' => 'varchar(20)',
                    'label' => 'Status code'
                ),
                'description' => array(
                    'type' => 'string',
                    'label' => 'Description',
                    'null' => true
                )
            ),
            'customer' => array(
                'code' => array(
                    'type' => 'varchar(20)',
                    'label' => 'Code'
                ),
                'name' => array(
                    'type' => 'varchar(255)',
                    'label' => 'Name'
                ),
                'description' => array(
                    'type' => 'string',
                    'label' => 'Description',
                    'null' => true
                )
            ),
            'provider' => array(
                'code' => array(
                    'type' => 'varchar(20)',
                    'label' => 'Code'
                ),
                'name' => array(
                    'type' => 'varchar(255)',
                    'label' => 'Name'
                ),
                'description' => array(
                    'type' => 'string',
                    'label' => 'Description',
                    'null' => true
                )
            ),
            'order' => array(
                'code' => array(
                    'type' => 'varchar(20)',
                    'label' => 'Code',
                    'null' => true
                ),
                'date' => array(
                    'type' => 'datetime',
                    'label' => 'Date'
                ),
                'type' => array(
                    'type' => 'relation',
                    'table' => 'order_type',
                    'label' => 'Type'
                ),
                'provider_id' => array(
                    'type' => 'relation',
                    'table' => 'provider',
                    'label' => 'Provider id',
                    'null' => true
                ),
                'customer_id' => array(
                    'type' => 'relation',
                    'table' => 'customer',
                    'label' => 'Customer id',
                    'null' => true
                ),
                'customer_name' => array(
                    'type' => 'varchar(255)',
                    'label' => 'Customer name',
                    'null' => true
                ),
                'address' => array(
                    'type' => 'string',
                    'label' => 'Address',
                    'null' => true
                ),
                'phone' => array(
                    'type' => 'varchar(50)',
                    'label' => 'Phone number',
                    'null' => true
                ),
                'status' => array(
                    'type' => 'relation',
                    'table' => 'order_status',
                    'label' => 'Status'
                ),
                'description' => array(
                    'type' => 'string',
                    'label' => 'Description',
                    'null' => true
                )
            ),
            'transfer' => array(
                'date' => array(
                    'type' => 'datetime',
                    'label' => 'Date'
                ),
                'type' => array(
                    'type' => 'boolean',
                    'label' => 'Type'
                ),
                'description' => array(
                    'type' => 'string',
                    'label' => 'Description',
                    'null' => true
                ),
                'order_id' => array(
                    'type' => 'relation',
                    'table' => 'order',
                    'label' => 'Order id'
                ),
            ),
            'transfer_detail' => array(
                'product_id' => array(
                    'type' => 'relation',
                    'table' => 'product',
                    'label' => 'Product id'
                ),
                'quantity' => array(
                    'type' => 'int',
                    'label' => 'price'
                ),
                'price' => array(
                    'type' => 'int',
                    'label' => 'Price'
                ),
                'transfer_id' => array(
                    'type' => 'relation',
                    'table' => 'transfer',
                    'label' => 'Transfer id'
                )
            )
        )
    );
}