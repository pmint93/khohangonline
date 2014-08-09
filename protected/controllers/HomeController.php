<?php
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 2/23/14
 * Time: 12:57 PM
 */

class HomeController extends Controller{

    public function init(){
        Functions::startup();
    }

    public function actionSetLanguage(){
        Yii::app()->session['language'] = isset($_GET['lang'])?$_GET['lang']:Yii::app()->language;
        $back = isset($_GET['goback'])?$_GET['goback']:Yii::app()->getBaseUrl(true);
        Yii::app()->session['notification'] = Functions::T("Success");
        $this->redirect($back);
    }
    public function actionIndex(){
        Auth::login();
        Yii::app()->params['menu_parent'] = 'home';
        $this->render('index', array());
    }
    public function actionLogin(){
        $goback = isset($_REQUEST['goback'])?$_REQUEST['goback']:Yii::app()->getBaseUrl(true);
        if(isset(Yii::app()->session['auth_user']) && (Yii::app()->session['auth_user'] != "")){
            return $this->redirect($goback);
        }
        if(isset($_POST['username']) && isset($_POST['password'])){
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            if(strlen($username) < 4) Yii::app()->session['notification'] = Functions::T("Username length >= 4 character!");
            else if(strlen($password) < 6) Yii::app()->session['notification'] = Functions::T("Password length >= 6 character!");
            else{
                $model = new Auth_userModel();
                $info = $model->find("username = '".mysql_real_escape_string($_POST['username'])."' and password = '".Auth::hashCode($_POST['username'],$_POST['password'])."'");
                if($info){
                    if($info['baned'] == 1) Yii::app()->session['notification'] = Functions::T("Account is ban");
                    else{
                        Functions::setSessionAccount(mysql_real_escape_string($username));
                        Yii::app()->session['notification'] = Functions::T("Success");
                        return $this->redirect($goback);
                    }
                }
                Yii::app()->session['notification'] = Functions::T("Username or password wrong");
            }
        }
        $this->render('login', array());
    }
    public function actionLogout(){
        Yii::app()->session->clear();
        $goback = isset($_REQUEST['goback'])?$_REQUEST['goback']:Yii::app()->getBaseUrl(true);
        $this->redirect($goback);
    }
    public function actionBuilding(){
        $this->render('building', array());
    }
}