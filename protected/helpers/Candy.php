<?php

class Candy
{
    const SCRIPT_VER = '1.01';
    const DATETIME = "Y-m-d H:i:s";
    const DATE = 'Y-m-d';
    const NORMAL = 'd.m.Y';
    public static $weekDay = array(1 => 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');
    public static $monthShort = array(1 => 'янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек');

    public static $alphabet = array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','щ','ш','ь','ы','ъ','э','ю','я');
    //Вернуть текущую дату в нужном формате
    public static function currentDate($format = "Y-m-d H:i:s")
    {
        return date($format);
    }

    /**
     * Эмуляция $form->error, по той причине, что yii'шная валидация либо соглашается на два ajax-запроса, либо на отсутствие error-полей
     * @param $model
     * @param $field
     */
    public static function error($model, $field)
    {
        return '<div class="errorMessage" id="' . get_class($model) . '_' . $field . '_em_" style="display: none;"></div>';
    }

    public static function dictonaryCondition(array $models, $field = 'id', $key = 'id', $conditionField, $conditionValue)
    {
        $dictionary = array();
        foreach ($models as $item) {
            if ($item->{$conditionField} == $conditionValue) {
                $dictionary[$item->{$key}] = $item->{$field};
            }
        }
        return $dictionary;
    }

    static public function verifyDate($date,$format = self::DATE, $strict = true)
    {
        $dateTime = DateTime::createFromFormat($format, $date);
        if ($strict) {
            $errors = DateTime::getLastErrors();
            if (!empty($errors['warning_count'])) {
                return false;
            }
        }
        return $dateTime !== false;
    }
    /**
     * Такой-то сахар
     * @param $date
     * @param string $format
     * @param null|str $oldFormat для некоторых форматов, к примеру 'd/m/Y' или timestamp не сработает стандартный
     * определитель форматирования, и поэтому придется указать вручную
     * @return string
     */
    public static function formatDate($date, $format = 'd.m.Y', $oldFormat = null)
    {
        $newDate = is_null($oldFormat) ? new DateTime($date) : DateTime::createFromFormat($oldFormat, $date);
        return $newDate->format($format);
    }

    public static function formatValidDate($date, $format = 'd.m.Y', $oldFormat = null)
    {
        if(!self::validateDate($date, is_null($oldFormat) ? $format : $oldFormat)){
            $date = date(is_null($oldFormat) ? $format : $oldFormat);
        }
        $newDate = is_null($oldFormat) ? new DateTime($date) : DateTime::createFromFormat($oldFormat, $date);
        return $newDate->format($format);
    }

    public static function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * Сахар, для преобразования любой переменной в массив
     * @param $var
     * @return array
     */
    public static function recommend($var)
    {
        return is_array($var) ? $var : array($var);
    }

    /**
     * Обычный сеттер для переменной, с дефолтным значением в случае неопределенности
     * @param $variable
     * @param int $default
     * @return int
     */
    public static function get(&$variable, $default = 0)
    {
        return (empty($variable) && !isset($variable)) ? $default : $variable;
    }

    /**
     * Транслитерация строки, с учетом ненужных символов
     * @param $text
     * @return mixed
     */
    public static function getLatin($text)
    {
        $text = self::convertToAlphaNum($text);
        $assoc = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i',
            'й' => 'i', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'a', 'ю' => 'uo', 'я' => 'ya',
        );
        $text = str_replace(array_keys($assoc), array_values($assoc), $text);
        $text = str_replace(' ', '-', $text);
        return $text;
    }

    /**
     * Перевести всю строк в нижний регистр и оставить только буквыы
     * @param $str
     * @return mixed|string
     */
    public static function convertToAlphaNum($str)
    {
        $res = preg_replace('|[^a-zа-я0-9 ]+|ui', ' ', $str);
        $res = trim(preg_replace('| {2,}|u', ' ', $res));
        $res = mb_strtolower($res);
        return $res;
    }

    public static function formatPrice($price)
    {
        return Yii::app()->format->number($price);
    }

    /**
     * Вывести изображение . Первый параметр модель media, далее параметры будут раскидываться кто-куда.
     * @param $params [scale:{ширина}x{высота}]
     * @return string
     */
    public static function preview($params)
    {
        if (!$params[0]) {
            $scale = explode('x', $params['scale']);
            $params['style'] = "width:{$scale[0]}px;height:{$scale[1]}px";
            return CHtml::openTag('img', $params);
        }
        if(!empty($params['noGif']) && $params[0]->ext == '.gif'){
            return CHtml::image($params[0]->makeWebPath(), '', array('class' => !empty($params['class']) ? $params['class'] : ''));
        }
        $res = $params[0]->makePreview($params);
        if (strcmp($res['src'], '') == 0) return '';
        if (isset($params['src_only'])) return $res['src'];
        $tag_params = array();
        $tag_params['src'] = !empty($params['absoluteUrl']) ? (Yii::app()->request->hostInfo . $res['src'])
            : $res['src'];
        foreach ($params as $k => $v) {
            if (preg_match("/^class$|^title$|^style$|^alt$|^on*+/", $k, $matches))
                $tag_params[$k] = $v;
        }
        if (preg_match("/png$/", $tag_params['src'], $matches)) {
            $classArr = array();
            if (isset($tag_params['class'])) {
                $classArr = explode(" ", (string)$tag_params['class']);
            }
            $classArr[] = "png";
            $tag_params['class'] = join(" ", $classArr);
        }
        return CHtml::tag("img", $tag_params, false, true);
    }

    /**
     * Получить имя базы данных. Используется кеш
     * @return int
     */
    public static function dbName()
    {
        static $name = null;
        if (!$name) {
            $name = preg_match("/dbname=([^;]*)/", Yii::app()->db->connectionString, $matches);
            $name = $matches[1];
        }
        return $name;
    }

    public static function differenceSecond($maxDate, $minDate)
    {
        $maxDate = new DateTime($maxDate);
        $minDate = new DateTime($minDate);
        return $diffInSeconds = $maxDate->getTimestamp() - $minDate->getTimestamp();;
    }


    public static function differenceDay($maxDate,$minDate){
        $date1 = new DateTime($maxDate);
        $date2 = new DateTime($minDate);

        return $date2->diff($date1)->format("%a");
    }
    /**
     * @param str $dateStart обычная дата которую необходимо увеличить
     * @param $interval формата '+ 1 days'
     * @param $format формат выходного значения
     * @return DateTime
     */
    public static function editDate($dateStart, $interval, $format = self::DATETIME)
    {
        return date($format, strtotime($dateStart . " $interval"));
    }

    /**
     * Функция возвращает окончание для множественного числа слова на основании числа и массива окончаний
     * @param  $number Integer Число на основе которого нужно сформировать окончание
     * @param  $endingsArray  Array Массив слов или окончаний для чисел (1, 4, 5),
     *         например array('яблоко', 'яблока', 'яблок')
     * @return String
     */
    public static function getNumEnding($number, $endingArray)
    {
        $number = $number % 100;
        if ($number >= 11 && $number <= 19) {
            $ending = $endingArray[2];
        } else {
            $i = $number % 10;
            switch ($i) {
                case (1):
                    $ending = $endingArray[0];
                    break;
                case (2):
                case (3):
                case (4):
                    $ending = $endingArray[1];
                    break;
                default:
                    $ending = $endingArray[2];
            }
        }
        return $ending;
    }

    /**
     * Выборка случайного элемента с учетом веса
     *
     * @param array $values индексный массив элементов
     * @param array $weights индексный массив соответствующих весов
     * @return mixed выбранный элемент
     */
    static function rand_by_weight($values, $weights)
    {
        $total = array_sum($weights);
        $n = 0;
        $num = mt_rand(0, $total);

        foreach ($values as $i => $value) {
            if(isset($weights[$i])){
                $n += $weights[$i];
                if ($n >= $num) {
                    return $values[$i];
                }
            }
        }
    }

    /**
     * @param str $dateStart обычная дата которую необходимо увеличить
     * @param $interval формата '+ 1 days'
     * @param $format формат выходного значения
     * @return DateTime
     */
    public static function date_plus($dateStart, $interval, $format = self::DATETIME)
    {
        if (is_null($dateStart)) {
            $dateStart = self::currentDate();
        }
        return date($format, strtotime($dateStart . " $interval"));
    }

    public static function unsetJsonKey(&$json, $key)
    {
        $array = CJSON::decode($json);

        if (array_key_exists($key, $array)) {
            unset($array[$key]);
        }
        $json = CJSON::encode($array);
    }

    public static function pushJson(&$json, $key, $value)
    {
        $array = CJSON::decode($json);
        $array[$key] = $value;
        $json = CJSON::encode($array);
    }

    /**
     * По дате отдаст номера дня недели в формате проекта, а не ISO-8601 (т.е. -1)
     * @param $date
     */
    public static function getWeekDay($date = null)
    {
        if (is_null($date)) {
            $date = self::currentDate();
        }
        return date('N', strtotime($date)) - 1;
    }

    public static function model2Array(CActiveRecord $model)
    {
        return $model->getAttributes();
    }

    public static function models2Array(array $models)
    {
        $list = array();
        foreach ($models as $model) {
            $list[] = self::model2Array($model);
        }
        return $list;
    }

    public static function isSerialize($string)
    {
        $data = @unserialize($string);
        return $data !== false;
    }

    /**
     * Метод, который, получив полный массив и выбранные id (может быть в виде сериаллайз массива),
     * вернет строку через сепоратор ответ
     * @param $fullArray
     * @param $selectedId
     */
    public static function implodeFromPart($fullArray, $selectedId, $separator = ',')
    {
        if(self::isSerialize($selectedId)){
            $selectedId = unserialize($selectedId);
        }
        $result = '';
        foreach ($fullArray as $key => $item) {
            if (in_array($key, $selectedId))
                $result[$key] = $item;
        }
        return implode(', ', $result);
    }

    /**
     * В зависимости от id получить выбранный результат
     */
    public static function returnDictionaryValue($dictionary, $id, $separator = ',')
    {
        if (is_null($id)) {
            return $dictionary;
        } elseif (Candy::isSerialize($id) || is_array($id)) {
            return Candy::implodeFromPart($dictionary, $id, $separator);
        } else {
            return $dictionary[$id];
        }
    }

    public static function returnDictionaryWithIcon($dictionary,$id, $isName, $separator= ',',$keyName='name',$keyIcon='icon'){
        if(!$isName){
            return $dictionary[$id]['icon']; //мы только за иконкой зашли
        }
        $flatDrop = array();
        foreach($dictionary as $key => $item){
            $flatDrop[$key] = $item['name'];
        }
        if (is_null($id)) {
            return $flatDrop;
        } elseif (Candy::isSerialize($id) || is_array($id)) {
            return Candy::implodeFromPart($flatDrop, $id);
        } else {
            return $flatDrop[$id];
        }
    }
    public static function cleanBuffer(){
        if (ob_get_level()) {
            ob_end_clean();
        }
    }

    /**
     * Отоформатируем числа и добавим постфикс "млн", "млрд" и т.д.
     * @param $str
     */
    public static function formatNumber($str){
        if(strpos($str,'.')) //если внутри точка, есть то ничего делать не будем
            return number_format($str, 1, ',', ' ');
        //$str = (floatval($str));
        $formatPostfix = array( //список постфиксов, где ключи количество знаков
            3=>Yii::t('main', 'тыс'),
            6=>Yii::t('main', 'млн'),
            9=>Yii::t('main', 'млрд'),
            12=>Yii::t('main', 'трлн')
        );
        $postfix = '';
        foreach($formatPostfix as $length=>$name){
            $diff = strlen($str)-$length; // разница длины переданного числа с возможным постфиксов
            if($diff>0 && $diff<=3){
                $number = substr($str,0,$diff); //получим целую часть будущего числа
                $part = substr($str,$diff,1); //получим остаток
                $number .='.'.$part;
                $postfix = $name;
                break;
            }
        }
        $number = isset($number) ? $number : $str;
        $whole = floor($number);
        $fraction = $number - $whole;

        return Yii::t('main',"{n} $postfix",array('{n}'=>number_format($number, $fraction == 0 ? 0 : 1, ',', ' ')));
    }

    public static function formatFinPlanNumber($number)
    {
        if(strlen($number) < 7) {
            return number_format($number / 1000000,3, ',', ' ');
        }
        return number_format(mb_strcut($number,0,-6),0, ',', ' ');
    }

    public static function getIndexItem($item)
    {
        if($item['object'] == 'news'){
            return News::model()->findByPk($item['id']);
        } elseif($item['object'] == 'analytics'){
            return Analytics::model()->findByPk($item['id']);
        }
        elseif($item['object'] == 'event'){
            return Event::model()->findByPk($item['id']);
        }
        return false;
    }

    public static function cutString($str, $max)
    {
        if (mb_strlen($str) > $max) {
            return mb_strcut($str, 0, $max) . "...";
        }
        return $str;
    }

    public static function getCurrentUrl(){
        return Yii::app()->request->hostInfo.Yii::app()->request->requestUri;
    }
}