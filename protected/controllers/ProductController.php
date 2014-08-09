<?php
/**
 * Created by PhpStorm.
 * User: pmint
 * Date: 8/6/14
 * Time: 12:35 PM
 */

class ProductController extends Controller{

    public function init(){
        Functions::startup();
        //Auth::login();
    }
    public function actionIndex(){
        Auth::login();
        Auth::permission('product','index');
        $rows = Yii::app()->db->createCommand()
            ->select('
                product.*,
                category.name as category_name,
                category.description as category_description
            ')
            ->from('product')
            ->join('category', 'product.category_id = category.id')
            ->where('1')
            ->queryAll();
        $this->render("index", array(
            'rows' => $rows
        ));
    }
    public function actionAdd(){
        Auth::login();
        Auth::permission('product','index');
        if(isset($_POST['submited'])){
            $categoryModel = new CategoryModel();
            $cats = $categoryModel->findAll();
            if(
                (isset($_POST['name']) && $_POST['name'] != "") &&
                (isset($_POST['category_id']) && $_POST['category_id'] != "") &&
                (isset($_POST['default_price']) && $_POST['default_price'] != "") &&
                (isset($_POST['description']))
            ){
                $model = new ProductModel();
                $find = $model->find('name like "'.$_POST['name'].'"');
                if($find) return $this->render("add", array(
                    'failedMsg' => 'Sản phẩm đã tồn tại: '.$find['name'],
                    'renderForm' => true,
                    'rows' => $cats,
                    'default' => array(
                        'name' => $_POST['name'],
                        'category_id' => $_POST['category_id'],
                        'default_price' => $_POST['default_price'],
                        'description' => $_POST['description']
                    )
                ));
                $checkCat = true;
                foreach($cats as $cat){
                    if($cat['id'] == intval($_POST['category_id'])) $checkCat = $cat;
                }
                if(!$checkCat) return $this->render("add", array(
                    'failedMsg' => 'Loại hàng không tồn tại: '.$checkCat['name'],
                    'renderForm' => true,
                    'rows' => $cats,
                    'default' => array(
                        'name' => $_POST['name'],
                        'category_id' => $_POST['category_id'],
                        'default_price' => $_POST['default_price'],
                        'description' => $_POST['description']
                    )
                ));
                $result = $model->add(array(
                    'name' => $_POST['name'],
                    'category_id' => $_POST['category_id'],
                    'quantity' => 0,
                    'default_price' => $_POST['default_price'],
                    'description' => $_POST['description']
                ));
                if(!$result) return $this->render('add', array(
                    'failedMsg' => 'Có lỗi xảy ra, không thể tạo mới Sản phẩm',
                    'renderForm' => true,
                    'rows' => $cats
                ));
                $this->render('add', array(
                    'successMsg' => 'Tạo mới thành công Sản phẩm : '.$model->name,
                    'rows' => $cats,
                    'renderForm' => true
                ));
            } else {
                return $this->render('add', array(
                    'failedMsg' => 'Vui lòng điền đầy đủ thông tin vào form !',
                    'renderForm' => true,
                    'rows' => $cats,
                    'default' => array(
                        'name' => isset($_POST['name']) ? $_POST['name'] : "",
                        'category_id' => isset($_POST['category_id']) ? $_POST['category_id'] : "",
                        'default_price' => isset($_POST['default_price']) ? $_POST['default_price'] : "",
                        'description' => isset($_POST['description']) ? $_POST['description'] : ""
                    )
                ));
            }
        } else {
            $this->render("add", array(
                'rows' => (new CategoryModel())->findAll()
            ));
        }
    }
    public function actionEdit(){
        Auth::login();
        Auth::permission('product','index');
        $params = $this->getActionParams();
        if(isset($params['id'])){
            $model = new ProductModel();
            $cats = (new CategoryModel())->findAll();
            $condition = 'id = '.$params['id'];
            $find = $model->find($condition);
            if(!$find) return $this->render("edit", array(
                'failedMsg' => 'Sản phẩm không tồn tại ',
                'renderForm' => false
            ));
            if(isset($_POST['submited'])){
                if(
                    (isset($_POST['name']) && $_POST['name'] != "") &&
                    (isset($_POST['category_id']) && $_POST['category_id'] != "") &&
                    (isset($_POST['default_price']) && $_POST['default_price'] != "") &&
                    (isset($_POST['description']))
                ){
                    $result = $model->upAll(array(
                        'name' => $_POST['name'],
                        'category_id' => $_POST['category_id'],
                        'default_price' => $_POST['default_price'],
                        'description' => isset($_POST['description']) ? $_POST['description'] : ""
                    ), 'id = '.$find['id']);
                    if(!$result) return $this->render('edit', array(
                        'failedMsg' => 'Có lỗi xảy ra, không thể cập nhật thông tin sản phẩm',
                        'renderForm' => true,
                        'rows' => $cats,
                        'default' => array(
                            'name' => $model->name,
                            'category_id' => $model->category_id,
                            'default_price' => $model->default_price,
                            'description' => $model->description
                        )
                    ));
                    $this->render('edit', array(
                        'successMsg' => 'Cập nhật thành công ',
                        'renderForm' => true,
                        'rows' => $cats,
                        'default' => array(
                            'name' => $_POST['name'],
                            'category_id' => $_POST['category_id'],
                            'default_price' => $_POST['default_price'],
                            'description' => $_POST['description']
                        )
                    ));
                } else {
                    return $this->render('add', array(
                        'failedMsg' => 'Vui lòng điền đầy đủ thông tin vào form !',
                        'renderForm' => true,
                        'rows' => $cats,
                        'default' => array(
                            'name' => isset($_POST['name']) ? $_POST['name'] : "",
                            'category_id' => isset($_POST['category_id']) ? $_POST['category_id'] : "",
                            'default_price' => isset($_POST['default_price']) ? $_POST['default_price'] : "",
                            'description' => isset($_POST['description']) ? $_POST['description'] : ""
                        )
                    ));
                }
            } else {
                return $this->render("edit", array(
                    'renderForm' => true,
                    'rows' => $cats,
                    'default' => array(
                        'name' => $find->name,
                        'category_id' => $find->category_id,
                        'default_price' => $find->default_price,
                        'description' => $find->description
                    )
                ));
            }
        } else {
            return $this->render("edit", array(
                'failedMsg' => 'Sản phẩm không tồn tại ',
                'renderForm' => false
            ));
        }
    }
    public function actionDelete(){
        Auth::login();
        Auth::permission('product','index');
        $params = $this->getActionParams();
        if(isset($params['id'])){
            $model = new ProductModel();
            $find = Yii::app()->db->createCommand()
                ->select('
                    product.*,
                    category.name as category_name,
                    category.description as category_description
                ')
                ->from('product')
                ->join('category', 'product.category_id = category.id')
                ->where('product.id = '.$params['id'])
                ->queryRow();
            if(!$find) return $this->render("delete", array(
                'failedMsg' => 'Sản phẩm không tồn tại ',
                'renderForm' => false
            ));
            if(isset($_POST['submited'])){
                $result = $model->deleteAll('id = '.$find['id']);
                if(!$result) return $this->render('delete', array(
                    'failedMsg' => 'Có lỗi xảy ra, không thể xóa Sản phẩm',
                    'renderForm' => true,
                    'default' => array(
                        'name' => $find['name'],
                        'category_id' => $find['category_id'],
                        'category_name' => $find['category_name'],
                        'category_description' => $find['category_description'],
                        'quantity' => $find['quantity'],
                        'default_price' => $find['default_price'],
                        'description' => $find['description']
                    )
                ));
                $this->render('delete', array(
                    'successMsg' => 'Xóa thành công Sản phẩm: '.$find['name'],
                    'renderForm' => false
                ));
            } else {
                return $this->render("delete", array(
                    'warningMsg' => "Việc xóa thể ảnh hưởng tới các dữ liệu có liên quan",
                    'renderForm' => true,
                    'default' => array(
                        'name' => $find['name'],
                        'category_id' => $find['category_id'],
                        'category_name' => $find['category_name'],
                        'category_description' => $find['category_description'],
                        'quantity' => $find['quantity'],
                        'default_price' => $find['default_price'],
                        'description' => $find['description']
                    )
                ));
            }
        } else {
            return $this->render("delete", array(
                'failedMsg' => 'Sản phẩm không tồn tại trong hệ thống',
                'renderForm' => false
            ));
        }
    }
    public function actionDeleteAll(){
        Auth::login();
        Auth::permission('product','index');
        if(isset($_POST['ids']) && is_array($_POST['ids']) && count($_POST['ids']) > 0){
            $model = new ProductModel();
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

    public function actionTransfer_unknow(){
        Auth::login();
        Auth::permission('product','transfer_unknow');
        Auth::login();
        $this->render('transfer_unknow', array());
    }

    public function actionTransfer_dropship(){
        Auth::login();
        Auth::permission('product','transfer_dropship');
        Auth::login();
        $this->render('transfer_dropship', array());
    }

    public function actionTransferback_dropship(){
        Auth::login();
        Auth::permission('product','transferback_dropship');
        Auth::login();
        $this->render('transfer_dropship', array());
    }
}