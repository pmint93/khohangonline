<?php
/**
 * Created by PhpStorm.
 * User: pmint
 * Date: 8/8/14
 * Time: 9:57 AM
 */

class CustomerController extends Controller{

    public function init(){
        Functions::startup();
        //Auth::login();
    }
    public function actionIndex(){
        $model = new CustomerModel();
        $this->render("index", array(
            'rows' => $model->findAll()
        ));
    }
    public function actionAdd(){
        if(isset($_POST['submited'])){
            if(
                (isset($_POST['code']) && $_POST['code'] != "") &&
                (isset($_POST['name']) && $_POST['name'] != "") &&
                (isset($_POST['description']))
            ){
                $model = new CustomerModel();
                $find = $model->find('code = "'.$_POST['code'].'"');
                if($find) return $this->render("add", array(
                    'failedMsg' => 'Đối tác/Khách hàng đã tồn tại: Mã ['.$find['code'].'] Tên ['.$find['name'].']'
                ));
                $result = $model->add(array(
                    'code' => $_POST['code'],
                    'name' => $_POST['name'],
                    'description' => isset($_POST['description']) ? $_POST['description'] : ""
                ));
                if(!$result) return $this->render('add', array(
                    'failedMsg' => 'Có lỗi xảy ra, không thể tạo mới Đối tác/Khách hàng'
                ));
                $this->render('add', array(
                    'successMsg' => 'Tạo mới thành công: Mã ['.$model->code.'], tên ['.$model->name.']',
                    'renderForm' => true
                ));
            } else {
                return $this->render('add', array(
                    'failedMsg' => 'Vui lòng điền đầy đủ thông tin vào form !',
                    'default' => array(
                        'code' => isset($_POST['code']) ? $_POST['code'] : "",
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
        if(isset($params['id']) || isset($params['code']) ){
            $model = new CustomerModel();
            $condition = isset($params['id']) ? 'id = '.$params['id'] : 'code = "'.$params['code'].'"';
            $find = $model->find($condition);
            if(!$find) return $this->render("edit", array(
                'failedMsg' => 'Đối tác/Khách hàng không tồn tại ',
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
                        'failedMsg' => 'Có lỗi xảy ra, không thể cập nhật thông tin Đối tác/Khách hàng',
                        'renderForm' => true,
                        'default' => array(
                            'code' => $model->code,
                            'name' => $model->name,
                            'description' => $model->description
                        )
                    ));
                    $this->render('edit', array(
                        'successMsg' => 'Cập nhật thành công ',
                        'renderForm' => true,
                        'default' => array(
                            'code' => $find['code'],
                            'name' => $_POST['name'],
                            'description' => $_POST['description']
                        )
                    ));
                } else {
                    return $this->render('add', array(
                        'failedMsg' => 'Vui lòng điền đầy đủ thông tin vào form !',
                        'renderForm' => true,
                        'default' => array(
                            'code' => isset($_POST['code']) ? $_POST['code'] : "",
                            'name' => isset($_POST['name']) ? $_POST['name'] : "",
                            'description' => isset($_POST['description']) ? $_POST['description'] : ""
                        )
                    ));
                }
            } else {
                return $this->render("edit", array(
                    'renderForm' => true,
                    'default' => array(
                        'code' => $find->code,
                        'name' => $find->name,
                        'description' => $find->description
                    )
                ));
            }
        } else {
            return $this->render("edit", array(
                'failedMsg' => 'Đối tác/Khách hàng không tồn tại ',
                'renderForm' => false
            ));
        }
    }
    public function actionDelete(){
        $params = $this->getActionParams();
        if(isset($params['id']) || isset($params['code']) ){
            $model = new CustomerModel();
            $condition = isset($params['id']) ? 'id = '.$params['id'] : 'code = "'.$params['code'].'"';
            $find = $model->find($condition);
            if(!$find) return $this->render("delete", array(
                'failedMsg' => 'Đối tác/Khách hàng không tồn tại ',
                'renderForm' => false
            ));
            if(isset($_POST['submited'])){
                $result = $model->deleteAll('id = '.$find['id']);
                if(!$result) return $this->render('delete', array(
                    'failedMsg' => 'Có lỗi xảy ra, không thể xóa Đối tác/Khách hàng',
                    'renderForm' => true,
                    'default' => array(
                        'code' => $model->code,
                        'name' => $model->name,
                        'description' => $model->description
                    )
                ));
                $this->render('delete', array(
                    'successMsg' => 'Xóa thành công Đối tác/Khách hàng: '.$find['code'],
                    'renderForm' => false
                ));
            } else {
                return $this->render("delete", array(
                    'warningMsg' => "Việc xóa thể ảnh hưởng tới các dữ liệu có liên quan",
                    'renderForm' => true,
                    'default' => array(
                        'code' => $find->code,
                        'name' => $find->name,
                        'description' => $find->description
                    )
                ));
            }
        } else {
            return $this->render("delete", array(
                'failedMsg' => 'Đối tác/Khách hàng không tồn tại trong hệ thống',
                'renderForm' => false
            ));
        }
    }
    public function actionDeleteAll(){
        if(isset($_POST['ids']) && is_array($_POST['ids']) && count($_POST['ids']) > 0){
            $model = new CustomerModel();
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