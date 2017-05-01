<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\config;

use common\config\Controller2;
use Yii;
use \yii\helpers\ArrayHelper;

/**
 * Description of Options
 *
 * @author Yousaf
 */
class Options {

    private static $_enabled = array();
    private static $_unames = array();
    private static $_unumbers = array();
    private static $_languages = array();
    private static $_languagesList = array();
    private static $_user = null;

    public static function convertNumberToArabic($str) {
        if (Yii::$app->language == 'ar') {
            $western_arabic = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
            $eastern_arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');

            $str = str_replace($western_arabic, $eastern_arabic, $str);
        }
        return $str;
    }

    public static function sendCloudMessage($toUser, $title, $msg, $code, $id, $type, $docID, $senderId, $senderName) {

        $user = \common\models\User::findOne($toUser);
        if ($user == null) {
            return "Invalid User";
        }
        if ($user->device == Controller2::ANDRIOD && $user->device_token != "") {
            return self::sendGoogleCloudMessage($user->device_token, $title, $msg, $code, $id, $type, $docID, $senderId, $senderName);
        }
        return "Other Device or Empty Token";
    }

    private static function sendGoogleCloudMessage($regId, $title, $msg, $code, $id, $type, $docID, $senderId, $senderName) {

        $authToken = Yii::$app->params['google_server_api'];

        $id = $id == null ? "" : $id;
        $type = $type == null ? "" : $type;
        $docID = $docID == null ? "" : $docID;
// The data to send to the API
//        $data = [
//        'registration_ids' => [$regId],
//        "data" => [
//                "body" => $msg,
//                "title" => $title]
//        ];
        $data = ['registration_ids' => [$regId],
            "data" => [
                "Title" => $title,
                "Command_Code" => $code,
                "Message_ID" => $id,
                "Message" => $msg,
                "Documetn_Type" => $type,
                "Req_Order_ID" => $docID,
                "Sender_Id" => $senderId,
                "Sender_Name" => $senderName
            ],
        ];
// Setup cURL
//$ch = curl_init('https://android.googleapis.com/gcm/send');
        $ch = curl_init('https://fcm.googleapis.com/fcm/send');
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: key=' . $authToken,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($data)
        ));

// Send the request
        $response = curl_exec($ch);
        $response = json_decode($response);

// Check for errors
        if ($response === FALSE) {
            return ["response" => "error", 'registrationId' => $regId];
        }

// Decode the response
//$responseData = json_decode($response, TRUE);
// Print the date from the response
        return ["response" => $response, 'registrationId' => $regId];
    }

    public static function getMessageCount($type) {
        $rtn = 0;
        $user = Yii::$app->user->id;
        if ($type == 1) {
            $c = \common\models\Messages::find()->where(['to_user' => $user, 'viewed' => 0,])->andWhere("parent_id is null and (option_type is null or option_type = '1' )")->count();
            $rtn = $c;
            $sql = "SELECT count(*) as cnt FROM es_messages a where a.to_user = '$user' and a.viewed = '0' and a.parent_id in 
            (select b.id from es_messages b where b.to_user = '$user' and b.option_type = 1 and b.parent_id is null) ";

            $r = Yii::$app->getDb()->createCommand($sql)->queryOne();
            $rtn+=$r['cnt'];
        }

        if ($type == 2) {
            $sql = "select count(id) as cnt from es_messages
                    where option_type = '" . Controller2::REQUEST . "' and to_user = '$user' and viewed = '0' 
                    and option_id in(
                    select a.id from es_request a
                    where a.provider_id is null and status <>'" . \common\models\Order::ACCEPTED . "'
                    and a.category_id in(select b.id from es_provider_cat  b where b.user_id = '$user'))";

            $r = Yii::$app->getDb()->createCommand($sql)->queryOne();
            $rtn+=$r['cnt'];
        }
        if ($type == 3) {
            $sql = "select count(id) as cnt from es_messages
                    where option_type = '" . Controller2::REQUEST . "' and to_user = '$user' and viewed = '0' 
                    and option_id in(select a.id from es_request a
                    where a.provider_id = '$user' and status <>'" . \common\models\Order::ACCEPTED . "')";
            $r = Yii::$app->getDb()->createCommand($sql)->queryOne();
            $rtn+=$r['cnt'];
        }
        if ($type == 4) {
            $sql = "select count(id) as cnt from es_messages
                    where option_type = '" . Controller2::ORDER . "' and to_user = '$user' and viewed = '0' 
                    and option_id in(select a.id from es_order a where a.provider_id = '$user' )";

            $r = Yii::$app->getDb()->createCommand($sql)->queryOne();
            $rtn+=$r['cnt'];
        }

        if ($type == 5) {
            $sql = "select count(id) as cnt from es_messages
                    where option_type = '" . Controller2::REQUEST . "' and to_user = '$user' and viewed = '0' 
                    and option_id in(
                    select a.id from es_request a
                    where a.user_id = '$user' and status <>'" . \common\models\Order::ACCEPTED . "')";
            $r = Yii::$app->getDb()->createCommand($sql)->queryOne();
            $rtn+=$r['cnt'];
        }
        if ($type == 6) {
            $sql = "select count(id) as cnt from es_messages
                    where option_type = '" . Controller2::ORDER . "' and to_user = '$user' and viewed = '0' 
                    and option_id in(select a.id from es_order a where a.user_id = '$user')";

            $r = Yii::$app->getDb()->createCommand($sql)->queryOne();
            $rtn+=$r['cnt'];
        }
        if ($type == 7) {
            $sql = "SELECT count(*) as cnt FROM es_messages a where a.to_user = '$user' and a.viewed = '0' and a.parent_id in 
            (select b.id from es_messages b where b.from_user = '$user' and b.option_type = 1 and b.parent_id is null) ";
            $r = Yii::$app->getDb()->createCommand($sql)->queryOne();
            $rtn+=$r['cnt'];
        }
        return $rtn;
    }

    public static function getIsServiceProvider() {
        if (self::$_user == null) {
            self::$_user = \common\models\User::findOne(Yii::$app->user->id);
        }
        if (self::$_user == null) {
            return false;
        }
        return self::$_user->account_type;
    }

    public static function getFrontendAddress() {
        return \Yii::$app->params['fronendaddress'];
    }

    public static function getAccountTypes() {
        $rtn = [['id' => 0, 'name' => Yii::t('app', 'End User')], ['id' => 1, 'name' => Yii::t('app', 'Service Provider')]];
        return ArrayHelper::map($rtn, 'id', 'name');
    }

    public static function getRatingList() {
        $rtn = [['id' => 0, 'name' => 0], ['id' => 1, 'name' => 1], ['id' => 2, 'name' => 2], ['id' => 3, 'name' => 3], ['id' => 4, 'name' => 4], ['id' => 5, 'name' => 5]];
        return ArrayHelper::map($rtn, 'id', 'name');
    }

    public static function getRatingSearch() {
        $rtn = [['id' => 0, 'name' => 'Less than 1', 'value' => ['operator' => '<', 'operand' => 1]],
            ['id' => 1, 'name' => 'less than 2', 'value' => ['operator' => '<', 'operand' => 2]],
            ['id' => 2, 'name' => 'less than 3', 'value' => ['operator' => '<', 'operand' => 3]],
            ['id' => 3, 'name' => 'less than 4', 'value' => ['operator' => '<', 'operand' => 4]],
            ['id' => 4, 'name' => 'less than 5', 'value' => ['operator' => '<', 'operand' => 5]],
            ['id' => 5, 'name' => 'equal to 1', 'value' => ['operator' => '<', 'operand' => 1]],
            ['id' => 6, 'name' => 'equal to 2', 'value' => ['operator' => '<', 'operand' => 2]],
            ['id' => 7, 'name' => 'equal to 3', 'value' => ['operator' => '<', 'operand' => 3]],
            ['id' => 8, 'name' => 'equal to 4', 'value' => ['operator' => '<', 'operand' => 4]],
            ['id' => 9, 'name' => 'equal to 5', 'value' => ['operator' => '<', 'operand' => 5]],
            ['id' => 10, 'name' => 'more than 1', 'value' => ['operator' => '>', 'operand' => 1]],
            ['id' => 11, 'name' => 'more than 2', 'value' => ['operator' => '>', 'operand' => 2]],
            ['id' => 12, 'name' => 'more than 3', 'value' => ['operator' => '>', 'operand' => 3]],
            ['id' => 13, 'name' => 'more than 4', 'value' => ['operator' => '>', 'operand' => 4]],
        ];
        return $rtn;
    }

    public static function getRatingById($id) {
        if ($id == null)
            return "";
        $acTypes = self::getRatingSearch();
        return $acTypes[$id];
    }

    public static function getAccountTypeById($id) {
        if ($id == null)
            return "";
        $acTypes = self::getAccountTypes();
        return $acTypes[$id];
    }

    public static function getYesNo() {
        $rtn = [['id' => 1, 'name' => Yii::t('app', 'Yes')], ['id' => 0, 'name' => Yii::t('app', 'No')]];
        return ArrayHelper::map($rtn, 'id', 'name');
        ;
    }

    public static function getYesNoById($id) {
        return Yii::t('app', ($id == '1' ? 'Yes' : 'No'));
    }

    public static function getDefaultCounty() {
        return \common\models\Settings::findOne(1)->def_country;
    }

    public static function getCurrencies() {
        $countries = \common\models\Currency::findAll(['active' => '1']);
        $arrc = array();
        foreach ($countries as $value) {
            array_push($arrc, array('id' => $value->id, 'name' => Yii::t('app', $value->name)));
        }
        return ArrayHelper::map($arrc, 'id', 'name');
    }

    public static function getProviders() {
        $countries = \common\models\User::findAll(['account_type' => '1']);

        return ArrayHelper::map($countries, 'id', 'fullname');
    }

    public static function getEndUsers() {
        $countries = \common\models\User::findAll(['account_type' => '0']);

        return ArrayHelper::map($countries, 'id', 'fullname');
    }

    public static function getRequestStatus() {
        $pending = \common\models\Request::PENDING;
        $cancel = \common\models\Request::CANCELLED;
        $declined = \common\models\Request::DECLINE;


        $models = [
            ['id' => $pending, 'name' => Yii::t('app', $pending)],
            ['id' => $cancel, 'name' => Yii::t('app', $cancel)],
            ['id' => $declined, 'name' => Yii::t('app', $declined)],
        ];
        return ArrayHelper::map($models, 'id', 'name');
    }

    public static function getOrderStatus() {
        $accept = \common\models\Order::ACCEPTED;
        $cancel = \common\models\Order::CANCELLED;
        $declined = \common\models\Order::DECLINE;
//$inproces = \common\models\Order::INPROCESS;
// $onway = \common\models\Order::ONWAY;
        $complete = \common\models\Order::COMPLETED;
//$receive = \common\models\Order::RECEIVED;
        $review = \common\models\Order::REVIEWED;

        $models = [
            ['id' => $accept, 'name' => Yii::t('app', $accept)],
            ['id' => $cancel, 'name' => Yii::t('app', $cancel)],
            ['id' => $declined, 'name' => Yii::t('app', $declined)],
//            ['id' => $inproces, 'name' => Yii::t('app', $inproces)],
//            ['id' => $onway, 'name' => Yii::t('app', $onway)],
            ['id' => $complete, 'name' => Yii::t('app', $complete)],
//            ['id' => $receive, 'name' => Yii::t('app', $receive)],
            ['id' => $review, 'name' => Yii::t('app', $review)],
        ];
        return ArrayHelper::map($models, 'id', 'name');
    }

    private static function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }
        array_multisort($sort_col, $dir, $arr);
    }

    public static function getRequestUsers() {
        $subQuery = \common\models\Request::find()->select('user_id')->where(['provider_id' => Yii::$app->user->id]);
        $query = \common\models\User::find()->where(['in', 'id', $subQuery]);
        $models = $query->all();
        return ArrayHelper::map($models, 'id', 'fullname');
    }

    public static function getOrderUsers() {
        $subQuery = \common\models\Order::find()->select('user_id')->where(['provider_id' => Yii::$app->user->id]);
        $query = \common\models\User::find()->where(['in', 'id', $subQuery]);
        $models = $query->all();
        return ArrayHelper::map($models, 'id', 'fullname');
    }

    public static function getOrderProvider() {
        $subQuery = \common\models\Order::find()->select('provider_id')->where(['user_id' => Yii::$app->user->id]);
        $query = \common\models\User::find()->where(['in', 'id', $subQuery]);
        $models = $query->all();
        return ArrayHelper::map($models, 'id', 'fullname');
    }

    public static function getRequestProvider() {
        $subQuery = \common\models\Request::find()->select('provider_id')->where(['user_id' => Yii::$app->user->id]);
        $query = \common\models\User::find()->where(['in', 'id', $subQuery]);
        $models = $query->all();
        return ArrayHelper::map($models, 'id', 'fullname');
    }

    public static function getOpenRequestUser() {
        $subQuery1 = \common\models\Providercategory::find()->select('category_id')->where(['user_id' => Yii::$app->user->id]);
        $subQuery = \common\models\Request::find()->select('user_id')
                ->where(['in', 'category_id', $subQuery1])
                ->andWhere(['status' => \common\models\Request::PENDING])
                ->andWhere(['is', 'provider_id', null]);
        $query = \common\models\User::find()->where(['in', 'id', $subQuery]);
        $models = $query->all();
        return ArrayHelper::map($models, 'id', 'fullname');
    }

    public static function getMsgUsers() {
        $subQuery = \common\models\Messages::find()->select('from_user')->where(['to_user' => Yii::$app->user->id]);
        $query = \common\models\User::find()->where(['in', 'id', $subQuery]);
        $models = $query->all();
        return ArrayHelper::map($models, 'id', 'fullname');
    }

    public static function getLanguages() {
        if (self::$_languagesList == null) {
            self::$_languagesList = \common\models\Languages::findAll(['active' => '1']);
        }
        return self::$_languagesList;
    }

    public static function getLangDir($lang = null) {
        if ($lang == null) {
            $lang = Yii::$app->language;
        }
        if (self::$_languages == null || count(self::$_languages) == 0) {
            $arr = \common\models\Languages::find()->all();
            foreach ($arr as $value) {
                self::$_languages[$value->id] = $value->direction;
            }
        }
        return isset(self::$_languages[$lang]) ? self::$_languages[$lang] : 'ltr';
    }

    public static function getPackages() {
        $countries = \common\models\Package::find()->all();
        $arrc = array();
        foreach ($countries as $value) {
            array_push($arrc, array('id' => $value->id, 'name' => Yii::t('app', $value->name)));
        }
        return ArrayHelper::map($arrc, 'id', 'name');
    }

    public static function getDevices() {
        $arrc = array();
        array_push($arrc, array('id' => Controller2::ANDRIOD, 'name' => Yii::t('app', 'Andriod')));
        array_push($arrc, array('id' => Controller2::iOS, 'name' => Yii::t('app', 'iOS')));
        return ArrayHelper::map($arrc, 'id', 'name');
    }

    public static function getUsers() {
        $countries = \common\models\User::find()->all();
        return ArrayHelper::map($countries, 'id', 'fullname');
    }

    public static function getBusinesses() {
        $countries = \common\models\Business::find()->all();
        return ArrayHelper::map($countries, 'id', 'add_title');
    }

    public static function getMyBusinesses($cat = null) {
        $countrieso = \common\models\Business::find()
                ->where(['user_id' => Yii::$app->user->id]);
        if ($cat != null) {
            $countrieso->andWhere(['category_id' => $cat]);
        }
        $countries = $countrieso->all();
        return ArrayHelper::map($countries, 'id', 'add_title');
    }

    public static function getSubCategories($cat = null) {
        $countries = \common\models\Subcategory::find()->where(['category_id' => $cat])->orderBy(['order' => SORT_ASC])->all();
        $arrc = array();
        foreach ($countries as $value) {
            array_push($arrc, array('id' => $value->id, 'name' => Yii::t('app', $value->name)));
        }
        self::array_sort_by_column($arrc, 'name');
        return ArrayHelper::map($arrc, 'id', 'name');
    }

    public static function getCategories() {
        $countries = \common\models\Category::find()->orderBy(['order' => SORT_ASC])->all();
        $arrc = array();
        foreach ($countries as $value) {
            array_push($arrc, array('id' => $value->id, 'name' => Yii::t('app', $value->name)));
        }
        self::array_sort_by_column($arrc, 'name');
        return ArrayHelper::map($arrc, 'id', 'name');
    }

    public static function getMyCategoriesArray() {
        $countries = \common\models\Category::find()
                ->joinWith(['provider'])
                ->where(['user_id' => \Yii::$app->user->id])
                ->all();
        $arrc = array();
        foreach ($countries as $value) {
            array_push($arrc, $value->id);
        }
        return $arrc;
    }

    public static function getMyCategories() {
        $countries = \common\models\Category::find()
                ->joinWith(['provider'])
                ->where(['user_id' => \Yii::$app->user->id])
                ->all();
        $arrc = array();
        foreach ($countries as $value) {
            array_push($arrc, array('id' => $value->id, 'name' => Yii::t('app', $value->name)));
        }
        self::array_sort_by_column($arrc, 'name');
        return ArrayHelper::map($arrc, 'id', 'name');
    }

    public static function getNotMyCategories() {
        $mycats = \common\models\Providercategory::find()->select(['category_id'])->where(['user_id' => \Yii::$app->user->id])->asArray();
        $countries = \common\models\Category::find()
                ->where(['not in', 'id', $mycats])
                ->orderBy(['order' => SORT_ASC])
                ->all();
        $arrc = array();
        foreach ($countries as $value) {
            array_push($arrc, array('id' => $value->id, 'name' => Yii::t('app', $value->name)));
        }
        self::array_sort_by_column($arrc, 'name');
        return ArrayHelper::map($arrc, 'id', 'name');
    }

    public static function getCities() {
        
        $countries = \common\models\Cities::find()->where(['active' => '1'])->orderBy(['name' => SORT_ASC])->all();
        $arrc = array();
        foreach ($countries as $value) {
            array_push($arrc, array('id' => $value->id, 'name' => Yii::t('app', $value->name)));
        }
        self::array_sort_by_column($arrc, 'name');
        return ArrayHelper::map($arrc, 'id', 'name');
    }

    public static function getCountries() {
        $countries = \common\models\Countries::findAll(['active' => '1']);
        $arrc = array();
        foreach ($countries as $value) {
            array_push($arrc, array('id' => $value->id, 'name' => Yii::t('app', $value->name)));
        }
        return ArrayHelper::map($arrc, 'id', 'name');
    }

    public static function getUNumbers($option) {
        if (self::$_unumbers == null || count(self::$_unumbers) == 0) {
            $arr = \common\models\Unumbers::find()->all();
            foreach ($arr as $value) {
                self::$_unumbers[$value->name] = $value->num != "" ? $value->num : 4;
            }
        }
        return isset(self::$_unumbers[$option]) ? self::$_unumbers[$option] : 4;
    }

    public static function getEnabled($option) {
        if (self::$_enabled == null || count(self::$_enabled) == 0) {
            $arr = \common\models\Enabled::find()->all();
            foreach ($arr as $value) {
                self::$_enabled[$value->name] = $value->enabled == 1 ? true : false;
            }
        }
        return isset(self::$_enabled[$option]) ? self::$_enabled[$option] : false;
    }

    public static function getUNames($option) {
        $rtn = "----UNKNOW----";

        if ($option == 'createSuccess') {
            $rtn = 'Record have been created successfully';
        } elseif ($option == 'updateSuccess') {
            $rtn = 'Record have been updated successfully';
        } elseif ($option == 'deleteSuccess') {
            $rtn = 'Record have been deleted successfully';
        }

        return $rtn;
    }

    public static $OptionName = array(
        array('id' => Controller2::LOGIN, 'name' => 'Login', 'pname' => 'Login', 'policy' => 'N', 'log' => 'Y',),
        //    array('id' => Controller2::REPORT_BUG, 'name' => 'Report Issue / Error', 'pname' => 'Report Issue / Error', 'policy' => 'N'),
        array('id' => Controller2::LOGOUT, 'name' => 'Logout', 'pname' => 'Logout', 'policy' => 'N', 'log' => 'Y',),
        array('id' => Controller2::CHANGE_PASS, 'name' => 'Change Password', 'pname' => 'Change Password', 'policy' => 'N', 'log' => 'Y',),
        array('id' => Controller2::PACKAGE, 'name' => 'Subscription', 'pname' => 'Subscriptions', 'policy' => 'N', 'log' => 'N'),
        array('id' => Controller2::ATTACHMENTS, 'name' => 'Attachment', 'pname' => 'Attachments', 'policy' => 'N'), 'log' => 'N',
        array('id' => Controller2::USERS, 'name' => 'User', 'pname' => 'Users', 'policy' => 'Y', 'qpolicy' => 'Y', 'log' => 'Y',
            array(array('id' => 1300, 'name' => 'View', 'denied' => '0'),
                array('id' => 1301, 'name' => 'Create', 'denied' => '0'),
                array('id' => 1302, 'name' => 'Update', 'denied' => '0'),
                array('id' => 1303, 'name' => 'Delete', 'denied' => '0'),
                array('id' => 1304, 'name' => 'Admin', 'denied' => '0'))),
        array('id' => Controller2::ROLE, 'name' => 'Role', 'pname' => 'Roles', 'policy' => 'Y', 'qpolicy' => 'Y', 'log' => 'Y',
            array(array('id' => 1500, 'name' => 'View', 'denied' => '0'),
                array('id' => 1501, 'name' => 'Create', 'denied' => '0'),
                array('id' => 1502, 'name' => 'Update', 'denied' => '0'),
                array('id' => 1503, 'name' => 'Delete', 'denied' => '0'),
                array('id' => 1504, 'name' => 'Admin', 'denied' => '0'))),
        array('id' => Controller2::LOG, 'name' => 'Log', 'pname' => 'Log', 'policy' => 'Y', 'log' => 'N',
            array(array('id' => 1403, 'name' => 'Delete', 'denied' => '0'),
                array('id' => 1404, 'name' => 'Admin', 'denied' => '0'))),
        array('id' => Controller2::NOTIFICATION, 'name' => 'Notification', 'pname' => 'Notifications', 'policy' => 'N'),
        array('id' => Controller2::CATEGORY, 'name' => 'Category', 'pname' => 'Categories', 'policy' => 'N', 'qpolicy' => 'N', 'log' => 'N'),
        array('id' => Controller2::SUBCATEGORY, 'name' => 'Sub Category', 'pname' => 'Sub Categories', 'policy' => 'N', 'qpolicy' => 'N', 'log' => 'N'),
        array('id' => Controller2::COUNTRY, 'name' => 'State', 'pname' => 'States', 'policy' => 'N', 'qpolicy' => 'N', 'log' => 'N'),
        array('id' => Controller2::CITY, 'name' => 'City', 'pname' => 'Cities', 'policy' => 'N', 'qpolicy' => 'N', 'log' => 'N'),
        array('id' => Controller2::CURRENCY, 'name' => 'Currency', 'pname' => 'Currencies', 'policy' => 'N', 'qpolicy' => 'N', 'log' => 'N'),
        array('id' => Controller2::BUSINESS, 'name' => 'Product/Service', 'pname' => 'Products/Services', 'policy' => 'N', 'qpolicy' => 'N', 'log' => 'N'),
        array('id' => Controller2::CATEGORY_REQUEST, 'name' => 'Request for Category', 'pname' => 'Requests for Category', 'policy' => 'N', 'qpolicy' => 'N', 'log' => 'N'),
        array('id' => Controller2::FEEDBACK, 'name' => 'Rating / Feedback', 'pname' => 'Ratings / Feedbacks', 'policy' => 'N', 'qpolicy' => 'N', 'log' => 'N'),
        array('id' => Controller2::REQUEST, 'name' => 'Request', 'pname' => 'Requests', 'policy' => 'N', 'qpolicy' => 'N', 'log' => 'N'),
        array('id' => Controller2::ORDER, 'name' => 'Order', 'pname' => 'Orders', 'policy' => 'N', 'qpolicy' => 'N', 'log' => 'N'),
    );

    public static function getActionOption($id) {
        $ActionOptionName = "";

        foreach (Options::$OptionName as $item) {
            if ($item['policy'] == "Y") {
                foreach ($item as $rows) {
                    if (is_array($rows)) {
                        foreach ($rows as $value) {
                            if ($value["id"] == $id) {
                                $ActionOptionName = Yii::t('app', $value["name"]);
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $ActionOptionName;
    }

    public static function getPolicyOptions() {

        $OptionNames = array();
        $count = 0;
        foreach (Options::$OptionName as $item) {
            $count ++;
            if ($item['policy'] == "Y") {
                $OptionNames[$count] = $item;
            }
        }

        return $OptionNames;
    }

    public static function getQoutaPolicyOptions() {

        $OptionNames = array();
        $count = 0;
        foreach (Options::$OptionName as $item) {
            $count ++;
            $pol = 'N';
            if (isset($item['qpolicy']))
                $pol = $item['qpolicy'];
            if ($pol == "Y") {
                $OptionNames[$count] = $item;
            }
        }

        return $OptionNames;
    }

    public static function getOptionName($id) {
        $OptionName = "";

        if ($id == Controller2::BUSINESS) {
            return Yii::t('app', Options::getUNames('business'));
        }

        foreach (Options::$OptionName as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                $OptionName = Yii::t('app', $item['name']);
                break;
            }
        }
        return $OptionName;
    }

    public static function getMaintainLog($id) {
        $MaintinLog = false;
        foreach (Options::$OptionName as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                if (isset($item['log']))
                    $MaintinLog = $item['log'] == 'Y' ? true : false;
                break;
            }
        }
        return $MaintinLog;
    }

    public static function getOptionPName($id) {
        $OptionName = "";
        if ($id == Controller2::BUSINESS) {
            return Yii::t('app', Options::getUNames('business'));
        }
        foreach (Options::$OptionName as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                $OptionName = Yii::t('app', $item['pname']);
                break;
            }
        }
        return $OptionName;
    }

    public static function getOptionById($id) {
        $Option = null;
        foreach (Options::$OptionName as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                $item['name'] = Yii::t('app', $item['name']);
                $Option = $item;
                break;
            }
        }
        return $Option;
    }

    public static function isRights($user_id, $option_id) {

        if (Yii::app()->user->isAdmin()) {
            return true;
        }
        $option = MenuRights::model()->findAllByAttributes(
                array('user_id' => $user_id, 'menu_id' => $option_id));

        if (!isset($option)) {
            return false;
        }

        if (count($option) < 1) {
            return false;
        } else {
            return true;
        }
    }

}
