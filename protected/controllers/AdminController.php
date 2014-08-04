<?php
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 2/23/14
 * Time: 1:35 PM
 */

class AdminController extends Controller
{
    public function init()
    {
        $this->layout = "backend";
        Auth::login();
    }

    public function actionIndex()
    {
        return $this->render("index", array());
    }

    public function actionGenForm()
    {
        try {
            if (isset($_GET['id'])) {
                $class = ucfirst($_GET['id']) . "Model";
                $obj = new $class();
                if (isset($_GET['control']) && ($_GET['control'] == "new") && count($_POST) > 0) {
                    $val = array();
                    foreach ($obj->label as $key => $value) {
                        $val[$key] = $_POST[$key];
                    }
                    $obj->add($val);
                    return $this->redirect(Yii::app()->getBaseUrl(true) . "/admin/genform/id/" . $_GET['id']);
                }
                if (isset($_GET['control']) && ($_GET['control'] == "edit") && count($_POST) > 0 && (isset($_GET['child'])) && ($_GET['child'] != "")) {
                    $val = array();
                    foreach ($obj->label as $key => $value) {
                        $val[$key] = $_POST[$key];
                    }
                    $obj->upAll($val, "id = " . $_GET['child']);
                    return $this->redirect(Yii::app()->getBaseUrl(true) . "/admin/genform/id/" . $_GET['id']);
                }
                if (isset($_GET['control']) && ($_GET['control'] == "delete") && ($_GET['child'])) {
                    $obj->deleteAll("id = " . $_GET['child']);
                    return $this->redirect(Yii::app()->getBaseUrl(true) . "/admin/genform/id/" . $_GET['id']);
                }
                return $this->render('genform', array(
                    'obj' => $obj
                ));
            }
        } catch (Exception $e) {
//            return var_dump($e);
            return $this->render('genform', array(
                'error' => $e->getMessage()
            ));
        }
        return $this->render('genform', array());
    }

    public function actionUpload()
    {
        $this->render('upload', array());
    }

    public function actionUser()
    {
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
                ))
                ) {
                    $member_ship = new Auth_membershipModel();
                    $member_ship->add(array(
                        'user_id' => Functions::getIdUser($username),
                        'group_id' => (new Auth_groupModel())->find("code = 'MEMBER'")['id']
                    ));
                    Yii::app()->session['notification'] = Functions::T("Success");
                } else Yii::app()->session['notification'] = Functions::T("Error");
            }
        }
        $list = $userModel->findAll('id <> ' . Yii::app()->session['auth_user']);
        $group_list = $groupModel->findAll();
        $this->render('user', array('list' => $list, 'group_list'=>$group_list));
    }

    public function actionGroup()
    {
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