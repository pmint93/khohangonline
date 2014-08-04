<?php
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 1/6/14
 * Time: 1:32 AM
 */

Class Auth
{
    public static function getAllMenu()
    {
        $cat_model = Yii::app()->params['menu_categories'];
        $act_model = Yii::app()->params['menu_actions'];
        $cat = new $cat_model();
        $act = new $act_model();
        $cat_list = $cat->findAll();
        $temp = array();
        foreach ($cat_list as $val) {
            $tmp = $act->findAll("category_id = " . $val['id']);
            $arr = array();
            foreach ($tmp as $value) {
                $arr[$value['name']] = array(
                    'controller' => $value['controller'],
                    'action' => $value['action'],
                    'id'=>$value['id']
                );
            }
            $temp[$val['name']] = $arr;
        }
        return $temp;
    }

    public static function getMenu($user_id)
    {
        $list = array();
        $auth_permissions = Yii::app()->params['auth_permissions'];
        $auth_membership = Yii::app()->params['auth_membership'];
        $member_ship = new $auth_membership();
        $group_id = $member_ship->findAll("user_id = " . $user_id);
        if(count($group_id) <= 0) return array();
        $arr_group = "(";
        $num = 0;
        foreach ($group_id as $key => $value) {
            if ($num != 0) $arr_group .= ",";
            $arr_group .= $value['group_id'];
            $num++;
        }
        $arr_group .= ")";
        $cat_model = Yii::app()->params['menu_categories'];
        $act_model = Yii::app()->params['menu_actions'];
        $action = new $act_model();
        $permission = new $auth_permissions();
        $list_action = $permission->findAll("group_id in " . $arr_group . " group by id");
        $cat = new $cat_model();
        $list_category = $action->findAll("id in (SELECT menu_action_id from auth_permissions WHERE group_id in " . $arr_group . " group by id) group by category_id");

        $temp = Array();
        foreach ($list_category as $key => $value) {
            $name = $cat->find("id = " . $value['category_id'])['name'];
            array_push($list, array(
                'name' => $name,
                'id' => $value['category_id']
            ));
            $temp[$name] = array();
        }
        foreach ($list_action as $key => $value) {
            foreach ($list as $i => $catTmp) {
                $tmp = $action->find("id = " . $value['menu_action_id']);
                if ($catTmp['id'] == $tmp['category_id']) {
                    $temp[$catTmp['name']][$tmp['name']] = array(
                        'controller' => $tmp['controller'],
                        'action' => $tmp['action'],
                        'id'=>$tmp['id']
                    );
                }
            }
        }
        return $temp;
    }

    public static function permission($control = null, $func = null)
    {
        $auth_permissions = Yii::app()->params['auth_permissions'];
        $auth_membership = Yii::app()->params['auth_membership'];
        if (is_null($control)) $control = Yii::app()->controller->id;
        if (is_null($func)) $func = Yii::app()->controller->action->id;
        try {
            $id = Yii::app()->session['auth_user'];
            $act_model = Yii::app()->params['menu_actions'];
            $action = new $act_model();
            $act = $action->find("controller = '" . $control . "' and action = '" . $func . "'");

            if ($act) {
                $member_ship = new $auth_membership();
                $group_id = $member_ship->findAll("user_id = " . $id);
                $arr_group = "(";
                $num = 0;
                foreach ($group_id as $key => $value) {
                    if ($num != 0) $arr_group .= ",";
                    $arr_group .= $value['group_id'];
                    $num++;
                }
                $arr_group .= ")";
                $permission = new $auth_permissions();
                $result = $permission->findAll("group_id in " . $arr_group . " and menu_action_id = " . $act['id']);
                if (count($result) > 0) return true;
            }
        } catch (Exception $e) {

        }
        Yii::app()->request->redirect(Yii::app()->getBaseUrl(true) . "/error?err=70");
        return false;
    }

    public static function login(){
        if (!isset(Yii::app()->session['auth_user']) || (Yii::app()->session['auth_user'] == "")) {
            return Yii::app()->request->redirect(Yii::app()->getBaseUrl(true) . "/home/login?goback=".Yii::app()->request->getUrl());
        }
    }

    public static function hashCode($user, $pass)
    {
        return sha1(md5($user . $pass));
    }
}