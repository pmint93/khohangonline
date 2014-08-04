<?php
    class Auth_userModel extends CActiveRecord{
        public $hashCode = array(
            'password'=>'username',
        );
        public $alias;
        public $label_select = 'username';
        public function tableName()
        {
            return 'auth_user';
        }
        public $label = array(
            'first_name'=>array(
                        'name'=>'First name',
                        'type'=>'text',
                        
                    ),'last_name'=>array(
                        'name'=>'Last name',
                        'type'=>'text',
                        
                    ),'email'=>array(
                        'name'=>'Email',
                        'type'=>'text',
                        
                    ),'username'=>array(
                        'name'=>'Username',
                        'type'=>'text',
                        
                    ),'password'=>array(
                        'name'=>'Password',
                        'type'=>'text',
                        
                    ),'birthday'=>array(
                        'name'=>'Birthday',
                        'type'=>'date',
                        
                    ),'address'=>array(
                        'name'=>'Address',
                        'type'=>'text',
                        
                    ),'baned'=>array(
                        'name'=>'Baned',
                        'type'=>'boolean',
                        
                    ),
        );

        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }
        public function add($arr, $sign=true){
            foreach ($this->label as $key => $value) {
                $this->$key = isset($arr[$key])?$arr[$key]:'';
            }
            foreach ($this->hashCode as $key => $value){
                $this->$key = Auth::hashCode($this->$value,$this->$key);
            }
            if($sign){
                $this->create_by = null;
                if(isset(Yii::app()->session['auth_user']) && Yii::app()->session['auth_user'] != ''){
                    $this->create_by = intval(Yii::app()->session['auth_user']);
                }
            }
            $date = new DateTime();
            $this->create_on = $date->format('Y-m-d H:i:s');
            return $this->save();
        }
        public function upAll($arr, $condition, $sign=true){
            $arrTmp = $arr;
            $old = $this->find($condition);
            foreach ($this->hashCode as $key => $value){
                if(isset($arrTmp[$key])) $arrTmp[$key] = Auth::hashCode($old[$value],$arrTmp[$key]);
                if(isset($arr[$key])) $arr[$key] = Auth::hashCode($old[$value],$arr[$key]);
            }
            if($sign){
                $arrTmp['modify_by'] = null;
                if(isset(Yii::app()->session['auth_user']) && Yii::app()->session['auth_user'] != ''){
                    $arrTmp['modify_by'] = intval(Yii::app()->session['auth_user']);
                }
            }
            $date = new DateTime();
            $arrTmp['modify_on'] = $date->format('Y-m-d H:i:s');

            try{
                return $this->updateAll($arrTmp, $condition);
            }
            catch(Exception $e){
                return $this->updateAll($arr, $condition);
            }
        }
    }