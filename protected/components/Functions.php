<?php
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 1/13/14
 * Time: 4:29 PM
 */

class Functions
{
    public static function URLFixed()
    {
        $URL = Yii::app()->request->getUrl();
        if (strrpos($URL, "?") || (strrpos($URL, "?") & strrpos($URL, "&"))) {
            $arr = explode("&", explode("?", $URL)[1]);
            $get = array();
            foreach ($arr as $key => $value) {
                $val = explode("=", $value);
                $get[$val[0]] = isset($val[1]) ? $val[1] : "";
            }
            $tmp = "";
            foreach ($_GET as $key => $value) {
                $tmp .= "/" . $key . "/" . (isset($get[$key]) ? $get[$key] : $value);
            }
            Yii::app()->request->redirect(Yii::app()->getBaseUrl(true) . "/" . Yii::app()->controller->id . "/" . Yii::app()->controller->action->id . $tmp);
        }
    }

    public static function to_money_style($money)
    {
        $money = "" . $money;
        $num = "";
        $k = 0;
        for ($i = (strlen($money) - 1); $i >= 0; $i--) {
            $k++;
            if ($k == 3 && $i != 0) {
                $num = "." . $money[$i] . $num;
                $k = 0;
            } else {
                $num = $money[$i] . $num;
            }
        }
        return $num;
    }

    public static function textToCode($str)
    {
        $tmp = Functions::locDau($str);
        $tmp = str_replace("-", "", $tmp);
        return strtoupper($tmp);
    }

    public static function locDau($alias)
    {
        $alias = Functions::nv_EncString($alias);

        //thêm trường hợp các kí tự đặc biệt
        $alias = preg_replace("/(!|\"|#|$|%|'|̣)/", '', $alias);
        $alias = preg_replace("/(̀|́|̉|$|>)/", '', $alias);
        $alias = preg_replace("'<[\/\!]*?[^<>]*?>'si", "", $alias);

        $alias = str_replace("----", " ", $alias);
        $alias = str_replace("---", " ", $alias);
        $alias = str_replace("--", " ", $alias);

        $alias = preg_replace('/(\W+)/i', '-', $alias);
        $alias = str_replace(array(
            '-8220-', '-8221-', '-7776-'
        ), '-', $alias);
        $alias = preg_replace('/[^a-zA-Z0-9\-]+/e', '', $alias);
        $alias = str_replace(array(
            'dAg', 'DAg', 'uA', 'iA', 'yA', 'dA', '--', '-8230'
        ), array(
            'dong', 'Dong', 'uon', 'ien', 'yen', 'don', '-', ''
        ), $alias);
        $alias = preg_replace('/(\-)$/', '', $alias);
        $alias = preg_replace('/^(\-)/', '', $alias);
        return strtolower($alias);
    }

    public static function nv_EncString($text)
    {
        $text = html_entity_decode($text);
        //thay thế chữ thuong
        $text = preg_replace("/(å|ä|ā|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|ä|ą)/", 'a', $text);
        $text = preg_replace("/(ß|ḃ)/", "b", $text);
        $text = preg_replace("/(ç|ć|č|ĉ|ċ|¢|©)/", 'c', $text);
        $text = preg_replace("/(đ|ď|ḋ|đ)/", 'd', $text);
        $text = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|ę|ë|ě|ė)/", 'e', $text);
        $text = preg_replace("/(ḟ|ƒ)/", "f", $text);
        $text = str_replace("ķ", "k", $text);
        $text = preg_replace("/(ħ|ĥ)/", "h", $text);
        $text = preg_replace("/(ì|í|î|ị|ỉ|ĩ|ï|î|ī|¡|į)/", 'i', $text);
        $text = str_replace("ĵ", "j", $text);
        $text = str_replace("ṁ", "m", $text);

        $text = preg_replace("/(ö|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|ö|ø|ō)/", 'o', $text);
        $text = str_replace("ṗ", "p", $text);
        $text = preg_replace("/(ġ|ģ|ğ|ĝ)/", "g", $text);
        $text = preg_replace("/(ü|ù|ú|ū|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|ü|ų|ů)/", 'u', $text);
        $text = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ|ÿ)/", 'y', $text);
        $text = preg_replace("/(ń|ñ|ň|ņ)/", 'n', $text);
        $text = preg_replace("/(ŝ|š|ś|ṡ|ș|ş|³)/", 's', $text);
        $text = preg_replace("/(ř|ŗ|ŕ)/", "r", $text);
        $text = preg_replace("/(ṫ|ť|ț|ŧ|ţ)/", 't', $text);

        $text = preg_replace("/(ź|ż|ž)/", 'z', $text);
        $text = preg_replace("/(ł|ĺ|ļ|ľ)/", "l", $text);

        $text = preg_replace("/(ẃ|ẅ)/", "w", $text);

        $text = str_replace("æ", "ae", $text);
        $text = str_replace("þ", "th", $text);
        $text = str_replace("ð", "dh", $text);
        $text = str_replace("£", "pound", $text);
        $text = str_replace("¥", "yen", $text);

        $text = str_replace("ª", "2", $text);
        $text = str_replace("º", "0", $text);
        $text = str_replace("¿", "?", $text);

        $text = str_replace("µ", "mu", $text);
        $text = str_replace("®", "r", $text);

        //thay thế chữ hoa
        $text = preg_replace("/(Ä|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|Ą|Å|Ā)/", 'A', $text);
        $text = preg_replace("/(Ḃ|B)/", 'B', $text);
        $text = preg_replace("/(Ç|Ć|Ċ|Ĉ|Č)/", 'C', $text);
        $text = preg_replace("/(Đ|Ď|Ḋ)/", 'D', $text);
        $text = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|Ę|Ë|Ě|Ė|Ē)/", 'E', $text);
        $text = preg_replace("/(Ḟ|Ƒ)/", "F", $text);
        $text = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ|Ï|Į)/", 'I', $text);
        $text = preg_replace("/(Ĵ|J)/", "J", $text);

        $text = preg_replace("/(Ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|Ø)/", 'O', $text);
        $text = preg_replace("/(Ü|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|Ū|Ų|Ů)/", 'U', $text);
        $text = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ|Ÿ)/", 'Y', $text);
        $text = str_replace("Ł", "L", $text);
        $text = str_replace("Þ", "Th", $text);
        $text = str_replace("Ṁ", "M", $text);

        $text = preg_replace("/(Ń|Ñ|Ň|Ņ)/", "N", $text);
        $text = preg_replace("/(Ś|Š|Ŝ|Ṡ|Ș|Ş)/", "S", $text);
        $text = str_replace("Æ", "AE", $text);
        $text = preg_replace("/(Ź|Ż|Ž)/", 'Z', $text);

        $text = preg_replace("/(Ř|R|Ŗ)/", 'R', $text);
        $text = preg_replace("/(Ț|Ţ|T|Ť)/", 'T', $text);
        $text = preg_replace("/(Ķ|K)/", 'K', $text);
        $text = preg_replace("/(Ĺ|Ł|Ļ|Ľ)/", 'L', $text);

        $text = preg_replace("/(Ħ|Ĥ)/", 'H', $text);
        $text = preg_replace("/(Ṗ|P)/", 'P', $text);
        $text = preg_replace("/(Ẁ|Ŵ|Ẃ|Ẅ)/", 'W', $text);
        $text = preg_replace("/(Ģ|G|Ğ|Ĝ|Ġ)/", 'G', $text);
        $text = preg_replace("/(Ŧ|Ṫ)/", 'T', $text);

        return $text;
    }

    public static function genModel($mConfig)
    {
        $autoCreate = isset($mConfig['autoCreate']) ? $mConfig['autoCreate'] : false;
        $database = $mConfig['database'];
        $collate = isset($mConfig['collate']) ? $mConfig['collate'] : 'utf8_unicode_ci';
        $tableLog = isset($mConfig['tableLog'])?$mConfig['tableLog']:"";
        foreach ($database as $table => $conf) {
            $className = ucfirst($table) . "Model";
            $label = "";
            $var_arr = "`id` int(11) NOT NULL AUTO_INCREMENT";
            $select_name = "'id'";
            foreach ($conf as $key => $value) {
                if(strtoupper($key) == "HASHCODE") continue;
                $tagName = isset($value['label']) ? $value['label'] : $key;
                $type = isset($value['type']) ? $value['type'] : "text";
                if (isset($value['select']) && ($value['select'] == true)) {
                    $select_name = "'$key'";
                }

                $notnull = (isset($value['null']) && $value['null']) ?  "" : "NOT NULL";
                $label_table = "";
                if (strtoupper($type) == "RELATION") {
                    $table_relation = $value['table'];
                    $var_arr .= ",`$key` int(11) $notnull";
                    $ondelete = isset($value['ondelete'])?$value['ondelete']:"CASCADE";
                    $var_arr .= ",CONSTRAINT `".$table."_$key` FOREIGN KEY (`$key`) REFERENCES `$table_relation` (`id`) ON DELETE $ondelete";
                    $label_table = "'table'=>'$table_relation'";
                } else {
                    $var_arr .= ",`$key` ".((strtoupper($type)=='STRING')?'text':$type)." $notnull  COLLATE $collate";
                }
                $label .= "'$key'=>array(
                        'name'=>'$tagName',
                        'type'=>'$type',
                        $label_table
                    ),";
            }
            if(($tableLog != "")){
                $var_arr .= ", `create_by` int(11) DEFAULT NULL, CONSTRAINT `".$table."_create_on` FOREIGN KEY (`create_by`) REFERENCES `$tableLog` (`id`) ON DELETE SET NULL";
                $var_arr .= ", `modify_by` int(11) DEFAULT NULL, CONSTRAINT `".$table."_modify_by` FOREIGN KEY (`modify_by`) REFERENCES `$tableLog` (`id`) ON DELETE SET NULL";
                $var_arr .= ", `modify_on` datetime";
                $var_arr .= ", `create_on` datetime";
            }
            $var_arr .= ",PRIMARY KEY (`id`)";
            $query = "CREATE TABLE IF NOT EXISTS `" . $table . "`(
                $var_arr
            )";
            if ($autoCreate) {
                Yii::app()->db->createCommand($query)->query();
            }
            $hashCode = isset($conf['hashCode'])?$conf['hashCode']:array();
            $hash_list = "";
            foreach($hashCode as $k=>$c){
                $hash_list .= "'$k'=>'$c',";
            }

            $content = "<?php
    class $className extends CActiveRecord{
        public \$hashCode = array(
            $hash_list
        );
        public \$alias;
        public \$label_select = $select_name;
        public function tableName()
        {
            return '$table';
        }
        public \$label = array(
            $label
        );

        public static function model(\$className = __CLASS__)
        {
            return parent::model(\$className);
        }
        public function add(\$arr, \$sign=true){
            foreach (\$this->label as \$key => \$value) {
                \$this->\$key = isset(\$arr[\$key])?\$arr[\$key]:'';
            }
            foreach (\$this->hashCode as \$key => \$value){
                \$this->\$key = Auth::hashCode(\$this->\$value,\$this->\$key);
            }
            if(\$sign){
                \$this->create_by = null;
                if(isset(Yii::app()->session['$tableLog']) && Yii::app()->session['$tableLog'] != ''){
                    \$this->create_by = intval(Yii::app()->session['$tableLog']);
                }
            }
            \$date = new DateTime();
            \$this->create_on = \$date->format('Y-m-d H:i:s');
            return \$this->save();
        }
        public function upAll(\$arr, \$condition, \$sign=true){
            \$arrTmp = \$arr;
            \$old = \$this->find(\$condition);
            foreach (\$this->hashCode as \$key => \$value){
                if(isset(\$arrTmp[\$key])) \$arrTmp[\$key] = Auth::hashCode(\$old[\$value],\$arrTmp[\$key]);
                if(isset(\$arr[\$key])) \$arr[\$key] = Auth::hashCode(\$old[\$value],\$arr[\$key]);
            }
            if(\$sign){
                \$arrTmp['modify_by'] = null;
                if(isset(Yii::app()->session['$tableLog']) && Yii::app()->session['$tableLog'] != ''){
                    \$arrTmp['modify_by'] = intval(Yii::app()->session['$tableLog']);
                }
            }
            \$date = new DateTime();
            \$arrTmp['modify_on'] = \$date->format('Y-m-d H:i:s');

            try{
                return \$this->updateAll(\$arrTmp, \$condition);
            }
            catch(Exception \$e){
                return \$this->updateAll(\$arr, \$condition);
            }
        }
    }";
            $f = fopen("protected/models/$className.php", "w");
            fwrite($f, $content);
            fclose($f);
        }
    }

    public static function startup(){

    }

    public static function logs(){
        $link = Yii::app()->getBaseUrl(true).Yii::app()->request->getUrl();
        $browserModel = new Browser();
        $platform = Functions::getOS();
        $browser = $browserModel->getBrowser()." - ".$browserModel->getVersion();
        $ip = $_SERVER["REMOTE_ADDR"];
        $time = (new DateTime())->format("Y-m-d H:i:s");
        $log = new Users_logsModel();
        $from_url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:NULL;
        $log->add(array(
            'link'=>$link,
            'platform'=>$platform,
            'browser'=>$browser,
            'address'=>$ip,
            'from_url'=>$from_url,
            'time'=>$time
        ));
    }

    public static function getOS() {
        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
        $os_platform    =   "Unknown OS Platform";

        $os_array       =   array(
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }

        }

        return $os_platform;

    }

    static function m_htmlchars($t=""){
        $t = preg_replace("/&(?!#[0-9]+;)/s", '&amp;', $t );
        $t = str_replace( "<", "&lt;"  , $t );
        $t = str_replace( ">", "&gt;"  , $t );
        $t = str_replace( '"', "&quot;", $t );
        $t = str_replace( "'", '&#039;', $t );
        $t = str_replace( '“', '&ldquo;', $t );
        $t = str_replace( '”', '&rdquo;', $t );
        return $t;
    }

    static  function m_unhtmlchars($str){
        return str_replace(array('&ldquo;', '&rdquo;', '&lt;', '&gt;', '&quot;', '&amp;', '&#92;', '&#39'), array('“', '”', '<', '>', '"', '&', chr(92), chr(39)), $str);
    }

    public static function T($str){
        $lang = isset(Yii::app()->session['language'])?Yii::app()->session['language']:Yii::app()->language;
        $tmp = $str;
        if(isset(Yii::app()->params['label'][$lang])){
            $tmp = isset(Yii::app()->params['label'][$lang][$str])?Yii::app()->params['label'][$lang][$str]:$str;
        }
        if(($tmp == $str) && (isset(Yii::app()->params['description'][$lang]))){
            return isset(Yii::app()->params['description'][$lang][$str])?Yii::app()->params['description'][$lang][$str]:$str;
        }
        return $tmp;
    }

    public static function setSessionAccount($username){
        $auth_user = Yii::app()->params['auth_user'];
        $userModel = new $auth_user();
        $user = $userModel->find("username = '".$username."'");
        if($user){
            Yii::app()->session['auth_user'] = $user['id'];
            Yii::app()->session['username'] = $user['username'];
            Yii::app()->session['first_name'] = ($user['first_name']!="")?$user['first_name']:"name";
            Yii::app()->session['last_name'] = ($user['last_name']!="")?$user['last_name']:"No";
        }
    }
    public static function getIdUser($username){
        $auth_user = Yii::app()->params['auth_user'];
        $userModel = new $auth_user();
        $user = $userModel->find("username = '".$username."'");
        return $user['id'];
    }
    public static function getListPermission($group){
        $groupModel = new Auth_permissionsModel();
        $list_per = $groupModel->findAll("group_id = ".$group);
        $tmp =  array();
        foreach($list_per as $per){
            array_push($tmp, intval($per['menu_action_id']));
        }
        return $tmp;
    }
    public static function getListGroup($user){
        $membership = new Auth_membershipModel();
        $list = $membership->findAll("user_id = ".$user);
        $tmp = array();
        foreach($list as $group){
            array_push($tmp, intval($group['group_id']));
        }
        return $tmp;
    }

    public static function Time($time){
        $time_now = new DateTime();
        $time_over = DateTime::createFromFormat('Y-m-d H:i:s', $time);
        $h = intval(($time_now->getTimestamp() - $time_over->getTimestamp())/3600);
        $m = intval(($time_now->getTimestamp() - $time_over->getTimestamp())/60);
        $s = intval(($time_now->getTimestamp() - $time_over->getTimestamp()));
        if($s < 60){
            if($s <= 1) return Functions::T("now");
            return strval($s)." ".Functions::T("seconds ago");
        }
        if($m < 60){
            if($m == 1) return Functions::T("about an minute ago");
            return strval($m)." ".Functions::T("minutes ago");
        }
        if($h < 12){
            if($h == 1) return Functions::T("about an hour ago");
            return strval($h)." ".Functions::T("hours ago");
        }
        if(($h >=12) && ($h <24)){
            if ($time_over->format("d") == $time_now->format("d")) return Functions::T("Today");
            else return Functions::T("Yesterday");
        }
        if(($h >=24) && ($h <48) & ((intval($time_over->format("d")) - intval($time_now->format("d"))) == 1)) return Functions::T("Yesterday");
        return $time_over->format("Y-m-d H:i:s");
    }
}