<?php
    class Auth_membershipModel extends CActiveRecord{
        public $hashCode = array(
            
        );
        public $alias;
        public $label_select = 'id';
        public function tableName()
        {
            return 'auth_membership';
        }
        public $label = array(
            'user_id'=>array(
                        'name'=>'User',
                        'type'=>'relation',
                        'table'=>'auth_user'
                    ),'group_id'=>array(
                        'name'=>'Group',
                        'type'=>'relation',
                        'table'=>'auth_group'
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