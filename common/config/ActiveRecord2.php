<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\config;

class ActiveRecord2 extends \yii\db\ActiveRecord
{
    
    public $PID = 0;
    
//    public function afterSave($insert, $changedAttributes) {
//        
//        $action = $this->isNewRecord?"New":"Update";
//        $id = $this->getPrimaryKey();
//        \frontend\controllers\LogController::createLog($id, $this->PID, $action);
//        
//        parent::afterSave($insert, $changedAttributes);
//    }
//    
//    public function afterDelete() {
//        $action = "Delete";
//        $id = $this->getPrimaryKey();
//        \frontend\controllers\LogController::createLog($id, $this->PID, $action);
//        parent::afterDelete();
//    }
//    
    
}