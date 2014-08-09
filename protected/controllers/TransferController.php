<?php
/**
 * Created by PhpStorm.
 * User: pmint
 * Date: 8/7/14
 * Time: 9:12 AM
 */

class TransferController extends Controller{

    public function init(){
        Functions::startup();
        //Auth::login();
    }
    public function actionIndex(){
        Auth::login();
        Auth::permission('transfer','index');
        $this->render("index");
    }
    public function actionReceipt(){
        Auth::login();
        Auth::permission('transfer','receipt');
        /*
         * Nhap
         */
        if(isset($_POST['submited'])){
            $order_model = new OrderModel();
            $transfer_model = new TransferModel();
            $transfer_detail_model = new Transfer_detailModel();
            $product_model = new ProductModel();
            $provider_model = new ProviderModel();
            if(
                (isset($_POST['provider']) && $_POST['provider'] != "") &&
                (isset($_POST['transfer']) && is_array($_POST['transfer'])) &&
                (isset($_POST['transfer']['name']) && is_array($_POST['transfer']['name']) && count($_POST['transfer']['name']) > 0 ) &&
                (isset($_POST['transfer']['quantity']) && is_array($_POST['transfer']['quantity']) && count($_POST['transfer']['quantity']) > 0 ) &&
                ($_POST['transfer']['name'][0] != "" && intval($_POST['transfer']['quantity'][0]) > 0 && intval($_POST['transfer']['price'][0]) > 0) &&
                (isset($_POST['description']))
            ){
                /*
                 * Create Order
                 */
                $status = (new Order_statusModel())->find('code like "received"');
                $type = (new Order_typeModel())->find('code like "xuat"');
                if($status && $type){
                    $order = $order_model->add(array(
                        'code' => null,
                        'date' => date('Y-m-d H:i:s'),
                        'type' => $type['id'],
                        'provider_id' => $_POST['provider'],
                        'customer_id' => null,
                        'customer_name' => null,
                        'address' => null,
                        'phone' => null,
                        'status' => $status['id'],
                        'description' => $_POST['description']
                    ));
                    if($order){
                        /*
                         * Create Transfer
                         */
                        $order = $order_model->find('1 ORDER BY id DESC'); // pop recent order
                        $transfer = $transfer_model->add(array(
                            'date' => date('Y-m-d H:i:s'),
                            'type' => 1, // mac dinh (xuat) <0: nhap>
                            'description' => '',
                            'order_id' => $order['id']
                        ));
                        if($transfer){
                            /*
                             * Create transfer detail
                             */
                            $transfer = $transfer_model->find('1 ORDER BY id DESC'); // pop recent transfer
                            $transfer_detail = true;
                            for($i = 0; $i < count($_POST['transfer']['name']); $i++){
                                if(
                                    $_POST['transfer']['name'][$i] == "" ||
                                    $_POST['transfer']['quantity'][$i] == "" ||
                                    $_POST['transfer']['price'][$i] == ""
                                ) continue;
                                $transfer_detail &= $transfer_detail_model->add(array(
                                    'product_id' => $_POST['transfer']['name'][$i],
                                    'quantity' => $_POST['transfer']['quantity'][$i],
                                    'price' => $_POST['transfer']['price'][$i],
                                    'transfer_id' => $transfer['id']
                                ));
                            }
                            if($transfer_detail){
                                $this->render('receipt', array(
                                    'successMsg' => "Nhập hàng thành công, mã đơn hàng: ".$order['id'],
                                    'providers' => $provider_model->findAll(),
                                    'products' => $product_model->findAll(),
                                    'default' => array(
                                        'user_name' => Yii::app()->session['username'],
                                        'date' => date('d-m-Y')
                                    )
                                ));
                            } else {
                                $order = $order_model->deleteAll('id = '.$order['id']);
                                $transfer = $transfer_model->deleteAll('id = '.$transfer['id']);
                                $this->render("receipt", array(
                                    'failedMsg' => "Không thể nhập sản phẩm vào kho, hủy bỏ đơn hàng ...",
                                    'providers' => $provider_model->findAll(),
                                    'products' => $product_model->findAll(),
                                    'default' => array(
                                        'user_name' => Yii::app()->session['username'],
                                        'date' => date('d-m-Y')
                                    )
                                ));
                            }
                        } else {
                            $order = $order_model->deleteAll('id = '.$order['id']);
                            $this->render("receipt", array(
                                'failedMsg' => "Không thể nhập kho, hủy bỏ đơn hàng ...",
                                'providers' => $provider_model->findAll(),
                                'products' => $product_model->findAll(),
                                'default' => array(
                                    'user_name' => Yii::app()->session['username'],
                                    'date' => date('d-m-Y')
                                )
                            ));
                        }
                    } else {
                        $this->render("receipt", array(
                            'failedMsg' => "Không thể tạo đơn hàng nhập",
                            'providers' => $provider_model->findAll(),
                            'products' => $product_model->findAll(),
                            'default' => array(
                                'user_name' => Yii::app()->session['username'],
                                'date' => date('d-m-Y')
                            )
                        ));
                    }
                } else {
                    $this->render("receipt", array(
                        'failedMsg' => "Order_type || Order_status not valid",
                        'providers' => $provider_model->findAll(),
                        'products' => $product_model->findAll(),
                        'default' => array(
                            'user_name' => Yii::app()->session['username'],
                            'date' => date('d-m-Y')
                        )
                    ));
                }

            } else {
                $this->render("receipt", array(
                    'failedMsg' => "Đơn hàng không đúng, hủy bỏ đơn hàng ...",
                    'providers' => $provider_model->findAll(),
                    'products' => $product_model->findAll(),
                    'default' => array(
                        'user_name' => Yii::app()->session['username'],
                        'date' => date('d-m-Y')
                    )
                ));
            }
        } else {
            $this->render("receipt", array(
                'providers' => (new ProviderModel())->findAll(),
                'products' => (new ProductModel())->findAll(),
                'default' => array(
                    'user_name' => Yii::app()->session['username'],
                    'date' => date('d-m-Y')
                )
            ));
        }
    }
    public function  actionDelivery(){
        /*
         * Xuat
         */

        Auth::login();
        Auth::permission('transfer','delivery');

        if(isset($_POST['submited'])){
            $order_model = new OrderModel();
            $transfer_model = new TransferModel();
            $transfer_detail_model = new Transfer_detailModel();
            $product_model = new ProductModel();
            $customer_model = new CustomerModel();
            if(
                (isset($_POST['customer']) && $_POST['customer'] != "") &&
                (isset($_POST['transfer']) && is_array($_POST['transfer'])) &&
                (isset($_POST['transfer']['name']) && is_array($_POST['transfer']['name']) && count($_POST['transfer']['name']) > 0 ) &&
                (isset($_POST['transfer']['quantity']) && is_array($_POST['transfer']['quantity']) && count($_POST['transfer']['quantity']) > 0 ) &&
                ($_POST['transfer']['name'][0] != "" && intval($_POST['transfer']['quantity'][0]) > 0 && intval($_POST['transfer']['price'][0]) > 0) &&
                (isset($_POST['description']))
            ){
                /*
                 * Create Order
                 */
                $status = (new Order_statusModel())->find('code like "received"');
                $type = (new Order_typeModel())->find('code like "nhap"');
                if($status && $type){
                    $order = $order_model->add(array(
                        'code' => null,
                        'date' => date('Y-m-d H:i:s'),
                        'type' => $type['id'],
                        'provider_id' => null,
                        'customer_id' => $_POST['customer'],
                        'customer_name' => null,
                        'address' => null,
                        'phone' => null,
                        'status' => $status['id'],
                        'description' => $_POST['description']
                    ));
                    if($order){
                        /*
                         * Create Transfer
                         */
                        $order = $order_model->find('1 ORDER BY id DESC'); // pop recent order
                        $transfer = $transfer_model->add(array(
                            'date' => date('Y-m-d H:i:s'),
                            'type' => 0, // xuat: 1 || 0: nhap
                            'description' => '',
                            'order_id' => $order['id']
                        ));
                        if($transfer){
                            /*
                             * Create transfer detail
                             */
                            $transfer = $transfer_model->find('1 ORDER BY id DESC'); // pop recent transfer
                            $transfer_detail = true;
                            for($i = 0; $i < count($_POST['transfer']['name']); $i++){
                                if(
                                    $_POST['transfer']['name'][$i] == "" ||
                                    $_POST['transfer']['quantity'][$i] == "" ||
                                    $_POST['transfer']['price'][$i] == ""
                                ) continue;
                                $transfer_detail &= $transfer_detail_model->add(array(
                                    'product_id' => $_POST['transfer']['name'][$i],
                                    'quantity' => $_POST['transfer']['quantity'][$i],
                                    'price' => $_POST['transfer']['price'][$i],
                                    'transfer_id' => $transfer['id']
                                ));
                            }
                            if($transfer_detail){
                                $this->render('delivery', array(
                                    'successMsg' => "Xuất hàng thành công, mã đơn hàng: ".$order['id'],
                                    'customers' => $customer_model->findAll(),
                                    'products' => $product_model->findAll(),
                                    'default' => array(
                                        'user_name' => Yii::app()->session['username'],
                                        'date' => date('d-m-Y')
                                    )
                                ));
                            } else {
                                $order = $order_model->deleteAll('id = '.$order['id']);
                                $transfer = $transfer_model->deleteAll('id = '.$transfer['id']);
                                $this->render("delivery", array(
                                    'failedMsg' => "Không thể nhập sản phẩm vào kho...",
                                    'customers' => $customer_model->findAll(),
                                    'products' => $product_model->findAll(),
                                    'default' => array(
                                        'user_name' => Yii::app()->session['username'],
                                        'date' => date('d-m-Y')
                                    )
                                ));
                            }
                        } else {
                            $order = $order_model->deleteAll('id = '.$order['id']);
                            $this->render("delivery", array(
                                'failedMsg' => "Không thể nhập kho, hủy bỏ đơn hàng...",
                                'customers' => $customer_model->findAll(),
                                'products' => $product_model->findAll(),
                                'default' => array(
                                    'user_name' => Yii::app()->session['username'],
                                    'date' => date('d-m-Y')
                                )
                            ));
                        }
                    } else {
                        $this->render("delivery", array(
                            'failedMsg' => "Không thể tạo đơn hàng xuất",
                            'customers' => $customer_model->findAll(),
                            'products' => $product_model->findAll(),
                            'default' => array(
                                'user_name' => Yii::app()->session['username'],
                                'date' => date('d-m-Y')
                            )
                        ));
                    }
                } else {
                    $this->render("delivery", array(
                        'failedMsg' => "Order_type || Order_status not valid",
                        'customers' => $customer_model->findAll(),
                        'products' => $product_model->findAll(),
                        'default' => array(
                            'user_name' => Yii::app()->session['username'],
                            'date' => date('d-m-Y')
                        )
                    ));
                }

            } else {
                $this->render("delivery", array(
                    'failedMsg' => "Đơn hàng không đúng, hủy bỏ đơn hàng ...",
                    'customers' => $customer_model->findAll(),
                    'products' => $product_model->findAll(),
                    'default' => array(
                        'user_name' => Yii::app()->session['username'],
                        'date' => date('d-m-Y')
                    )
                ));
            }
        } else {
            $this->render("delivery", array(
                'customers' => (new CustomerModel())->findAll(),
                'products' => (new ProductModel())->findAll(),
                'default' => array(
                    'user_name' => Yii::app()->session['username'],
                    'date' => date('d-m-Y')
                )
            ));
        }
    }
    public function actionApiAll(){
        Auth::login();
        Auth::permission('transfer','receipt');
        if(isset($_POST['product_suggestion'])){
            $rows = (new ProductModel())->findAll('name like "%'.$_POST['product_suggestion'].'%"');
            $names = array();
            $ids = array();
            if($rows){
                foreach($rows as $row){
                    array_push($names, $row['name']);
                    array_push($ids, $row['id']);
                }
            }
            echo json_encode(array(
                'status' => $rows ? 1 : 0,
                'msg' => $rows ? 'success' : 'failed',
                'rows' => array(
                    'names' => $names,
                    'ids' => $ids
                )
            ));
        }
    }
}