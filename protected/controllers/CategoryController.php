<?php
/**
 * Created by PhpStorm.
 * User: pmint
 * Date: 8/6/14
 * Time: 10:41 AM
 */

class CategoryController extends Controller{

    public function init(){
        Functions::startup();
        //Auth::login();
    }
    public function actionIndex(){
        $model = new CategoryModel();
        $this->render("index", array(
            'rows' => $model->findAll()
        ));
    }
    public function actionAdd(){
        if(isset($_POST['submited'])){
            if(
                (isset($_POST['name']) && $_POST['name'] != "") &&
                (isset($_POST['description']))
            ){
                $model = new CategoryModel();
                $find = $model->find('name like "'.$_POST['name'].'"');
                if($find) return $this->render("add", array(
                    'failedMsg' => 'Nhóm hàng đã tồn tại: '.$find['name']
                ));
                $result = $model->add(array(
                    'name' => $_POST['name'],
                    'description' => isset($_POST['description']) ? $_POST['description'] : ""
                ));
                if(!$result) return $this->render('add', array(
                    'failedMsg' => 'Có lỗi xảy ra, không thể tạo mới nhóm hàng'
                ));
                $this->render('add', array(
                    'successMsg' => 'Tạo mới thành công nhóm hàng : '.$model->name,
                    'renderForm' => true
                ));
            } else {
                return $this->render('add', array(
                    'failedMsg' => 'Vui lòng điền đầy đủ thông tin vào form !',
                    'default' => array(
                        'name' => isset($_POST['name']) ? $_POST['name'] : "",
                        'description' => isset($_POST['description']) ? $_POST['description'] : ""
                    )
                ));
            }
        } else {
            $this->render("add", array());
        }
    }
    public function actionEdit(){
        $params = $this->getActionParams();
        if(isset($params['id'])){
            $model = new CategoryModel();
            $condition = 'id = '.$params['id'];
            $find = $model->find($condition);
            if(!$find) return $this->render("edit", array(
                'failedMsg' => 'Nhóm hàng không tồn tại ',
                'renderForm' => false
            ));
            if(isset($_POST['submited'])){
                if(
                    (isset($_POST['name']) && $_POST['name'] != "") &&
                    (isset($_POST['description']))
                ){
                    $result = $model->upAll(array(
                        'name' => $_POST['name'],
                        'description' => isset($_POST['description']) ? $_POST['description'] : ""
                    ), 'id = '.$find['id']);
                    if(!$result) return $this->render('edit', array(
                        'failedMsg' => 'Có lỗi xảy ra, không thể cập nhật thông tin nhóm hàng',
                        'renderForm' => true,
                        'default' => array(
                            'name' => $model->name,
                            'description' => $model->description
                        )
                    ));
                    $this->render('edit', array(
                        'successMsg' => 'Cập nhật thành công ',
                        'renderForm' => true,
                        'default' => array(
                            'name' => $_POST['name'],
                            'description' => $_POST['description']
                        )
                    ));
                } else {
                    return $this->render('add', array(
                        'failedMsg' => 'Vui lòng điền đầy đủ thông tin vào form !',
                        'renderForm' => true,
                        'default' => array(
                            'name' => isset($_POST['name']) ? $_POST['name'] : "",
                            'description' => isset($_POST['description']) ? $_POST['description'] : ""
                        )
                    ));
                }
            } else {
                return $this->render("edit", array(
                    'renderForm' => true,
                    'default' => array(
                        'name' => $find->name,
                        'description' => $find->description
                    )
                ));
            }
        } else {
            return $this->render("edit", array(
                'failedMsg' => 'Nhóm hàng không tồn tại ',
                'renderForm' => false
            ));
        }
    }
    public function actionDelete(){
        $params = $this->getActionParams();
        if(isset($params['id'])){
            $model = new CategoryModel();
            $condition = 'id = '.$params['id'];
            $find = $model->find($condition);
            if(!$find) return $this->render("delete", array(
                'failedMsg' => 'Nhóm hàng không tồn tại ',
                'renderForm' => false
            ));
            if(isset($_POST['submited'])){
                $result = $model->deleteAll('id = '.$find['id']);
                if(!$result) return $this->render('delete', array(
                    'failedMsg' => 'Có lỗi xảy ra, không thể xóa nhóm hàng',
                    'renderForm' => true,
                    'default' => array(
                        'name' => $model->name,
                        'description' => $model->description
                    )
                ));
                $this->render('delete', array(
                    'successMsg' => 'Xóa thành công nhóm hàng: '.$find['name'],
                    'renderForm' => false
                ));
            } else {
                return $this->render("delete", array(
                    'warningMsg' => "Việc xóa thể ảnh hưởng tới các dữ liệu có liên quan",
                    'renderForm' => true,
                    'default' => array(
                        'name' => $find->name,
                        'description' => $find->description
                    )
                ));
            }
        } else {
            return $this->render("delete", array(
                'failedMsg' => 'Nhóm hàng không tồn tại trong hệ thống',
                'renderForm' => false
            ));
        }
    }
    public function actionDeleteAll(){
        if(isset($_POST['ids']) && is_array($_POST['ids']) && count($_POST['ids']) > 0){
            $model = new CategoryModel();
            $condition = 'id IN ('.implode(',', $_POST['ids']).')';
            if($model->deleteAll($condition)){
                echo json_encode(array(
                    'status' => 0,
                    'msg' => 'Xóa thành công: '.$condition
                ));
            } else {
                echo json_encode(array(
                    'status' => 1,
                    'msg' => 'Xóa không thành công: '.$condition
                ));
            }
        } else {
            echo json_encode(array(
                'status' => 1,
                'msg' => 'Invalid parameters !'
            ));
        }
    }
}