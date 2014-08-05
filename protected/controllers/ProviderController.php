<?php
/**
 * Created by PhpStorm.
 * User: pmint
 * Date: 8/5/14
 * Time: 10:23 AM
 */

class ProviderController extends Controller{

    public function init(){
        Functions::startup();
    }
    public function actionIndex(){
        $this->render("index");
    }
    public function add(){

    }
}