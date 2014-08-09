<?php
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 2/23/14
 * Time: 12:57 PM
 */

class UsersController extends Controller{

    public function init(){
        Functions::startup();
    }
    public function actionIndex()
    {
        Auth::login();
        Auth::permission();
        $userModel = new Auth_userModel();
        $groupModel = new Auth_groupModel();
        if (isset($_REQUEST['control']) && isset($_REQUEST['id'])) {
            $goback = isset($_REQUEST['goback']) ? $_REQUEST['goback'] : Yii::app()->getBaseUrl(true);
            $control = $_REQUEST['control'];
            if (strtoupper($control) == "BAN") {
                $userModel->upAll(array(
                        'baned' => 1
                    ), "id = " . $_REQUEST['id']);
                Yii::app()->session['notification'] = Functions::T("Success");
            }
            if (strtoupper($control) == "BANLIST") {
                $userModel->upAll(array(
                        'baned' => 1
                    ), "id in " . $_REQUEST['id']);
                Yii::app()->session['notification'] = Functions::T("Success");
            }
            if (strtoupper($control) == "UNBANLIST") {
                $userModel->upAll(array(
                        'baned' => 0
                    ), "id in " . $_REQUEST['id']);
                Yii::app()->session['notification'] = Functions::T("Success");
            }
            if (strtoupper($control) == "UNBAN") {
                $userModel->upAll(array(
                        'baned' => 0
                    ), "id = " . $_REQUEST['id']);
                Yii::app()->session['notification'] = Functions::T("Success");
            }
            if (strtoupper($control) == "EDIT") {
                if (isset($_REQUEST['password']) && isset($_REQUEST['confirm_password'])) {
                    $password = $_REQUEST['password'];
                    $c_password = $_REQUEST['confirm_password'];
                    if (strlen($password) < 6) Yii::app()->session['notification'] = Functions::T("Password length >= 6 character!");
                    else if ($c_password != $password) Yii::app()->session['notification'] = Functions::T("Confirm passwords are wrong");
                    else {
                        $userModel->upAll(array(
                                'password' => $password
                            ), "id = " . $_REQUEST['id']);
                        Yii::app()->session['notification'] = Functions::T("Success");
                    }
                }
            }
            if (strtoupper($control) == "GROUP") {
                $membershipModel = new Auth_membershipModel();
                $membershipModel->deleteAll("user_id = ".$_GET['id']);
                if(isset($_POST['group'])){
                    foreach($_POST['group'] as $value){
                        $tmp = new Auth_membershipModel();
                        $tmp->add(array(
                            'user_id'=>$_GET['id'],
                            'group_id'=>$value
                        ));
                    }
                }
                Yii::app()->session['notification'] = Functions::T("Success");
            }
            if (strtoupper($control) == "DELLIST") {
                $userModel->deleteAll("id in " . $_REQUEST['id']);
                Yii::app()->session['notification'] = Functions::T("Success");
            }
            if (strtoupper($control) == "DELETE") {
                $userModel->deleteAll("id = " . $_REQUEST['id']);
                Yii::app()->session['notification'] = Functions::T("Success");
            }
            return $this->redirect($goback);
        }
        else if (isset($_REQUEST['username']) && isset($_REQUEST['password']) && isset($_REQUEST['confirm_password'])) {
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $c_password = $_REQUEST['confirm_password'];
            if (strlen($username) < 4) Yii::app()->session['notification'] = Functions::T("Username length >= 4 character!");
            else if (strlen($password) < 6) Yii::app()->session['notification'] = Functions::T("Password length >= 6 character!");
            else if ($c_password != $password) Yii::app()->session['notification'] = Functions::T("Confirm passwords are wrong");
            else {
                if ($userModel->find("username = '" . mysql_real_escape_string($username) . "'")) Yii::app()->session['notification'] = Functions::T("Account exists");
                else if ($userModel->add(array(
                    'username' => mysql_real_escape_string($username),
                    'password' => $password,
                    'first_name'=>$_POST['first_name'],
                    'last_name'=>$_POST['last_name'],
                    'birthday'=>$_POST['birthday'],
                    'address'=>$_POST['address']
                ))) Yii::app()->session['notification'] = Functions::T("Success");
                else Yii::app()->session['notification'] = Functions::T("Error");
            }
        }
        $list = $userModel->findAll('id <> ' . Yii::app()->session['auth_user']);
        $group_list = $groupModel->findAll();
        $this->render('index', array('list' => $list, 'group_list'=>$group_list));
    }

    public function actionGroup()
    {
        Auth::login();
        Auth::permission();
        $groupModel = new Auth_groupModel();
        if (isset($_REQUEST['control']) && isset($_REQUEST['id'])) {
            $goback = isset($_REQUEST['goback']) ? $_REQUEST['goback'] : Yii::app()->getBaseUrl(true);
            $control = $_REQUEST['control'];
            if (strtoupper($control) == "EDIT") {
                if (isset($_REQUEST['name']) && isset($_REQUEST['description'])) {
                    $groupModel->upAll(array(
                            'name' => $_REQUEST['name'],
                            'description' => $_REQUEST['description']
                        ), "id = " . $_REQUEST['id']);
                    Yii::app()->session['notification'] = Functions::T("Success");
                }
            }
            if (strtoupper($control) == "PERMISSION") {
                $permission_group = new Auth_permissionsModel();
                $permission_group->deleteAll("group_id = ".$_GET['id']);
                if(isset($_POST['permission'])){
                    foreach($_POST['permission'] as $value){
                        $tmp = new Auth_permissionsModel();
                        $tmp->add(array(
                            'group_id'=>$_GET['id'],
                            'menu_action_id'=>$value
                        ));
                    }
                }
                Yii::app()->session['notification'] = Functions::T("Success");
            }
            if (strtoupper($control) == "DELETE") {
                $groupModel->deleteAll("id = " . $_REQUEST['id']);
                Yii::app()->session['notification'] = Functions::T("Success");
            }
            if (strtoupper($control) == "DELLIST") {
                $groupModel->deleteAll("id in " . $_REQUEST['id']);
                Yii::app()->session['notification'] = Functions::T("Success");
            }
            return $this->redirect($goback);
        }
        else if(isset($_REQUEST['name']) && isset($_REQUEST['description'])){
            $groupModel->add(
                array(
                    'name'=>$_REQUEST['name'],
                    'description'=>$_REQUEST['description']
                )
            );
            Yii::app()->session['notification'] = Functions::T("Success");
        }
        $list = $groupModel->findAll();
        $this->render('group', array('list' => $list));
    }
}