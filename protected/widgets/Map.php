<?php

class Map extends CWidget
{
    public $htmlOptions = array();

    #Название места по которому будет центрироваться
    public $target = null;
    public $region = null;
    #Чем меньше тем более отдаленный зум
    public $zoom = 8;

    public $draggableBalloon = false;
    public $onlyImage = false;
    /**
     * @var Project[]|Region
     */
    public $projects = array();

    public $useCluster = false;
    #массив с обратным геокодированием по $this->target
    protected $coordsCenter = array();
    protected $coordsBalloon = array();
    public $showProjectBalloon = false;
    #url для обратного геокодирования
    const NOMINATIM_URL = 'http://nominatim.openstreetmap.org/search?format=json&limit=1';
    const VIEWPORT_URL = '//api.tiles.mapbox.com/mapbox.js/plugins/geo-viewport/v0.1.1/geo-viewport.js';

    const D_LON = '37.606201171875';
    const D_LAT='55.7425739894847';
    const T_PROJECT = 'project';
    const T_REGION = 'region';
    const T_NONE = 'none';
    private $key='';

    public $object = self::T_PROJECT;
    public function run()
    {
        $this->setOptions();
        $this->setAssets();

        echo CHtml::openTag('div', $this->htmlOptions);
           $this->onlyImage ? $this->renderStaticMap() : $this->renderMap();
        echo CHtml::closeTag('div');
    }

    /**
     * Метод, который подготовит все параметры для дальнейшего использования
     */
    private function setOptions()
    {
        if(isset($this->projects)){
            $this->object = is_array($this->projects) ? self::T_PROJECT : self::T_REGION;
        }
        else{
            $this->object = self::T_NONE;
        }
        $this->setCoordsCenter();
        $this->setCoordsBalloon();
        $id = $this->getId()."_map";
        $this->htmlOptions['id'] = $id;
        $this->htmlOptions['class'] = Candy::get($this->htmlOptions['class'],'');
        $this->htmlOptions['class'] .= "map-widget";
        if(count($this->projects)>1){ //если больше одного объекта выводим, то включим кластеризацию
            $this->useCluster = true;
        }

    }

    private function setAssets()
    {
        if($this->onlyImage){
            Yii::app()->clientScript->registerScriptFile(self::VIEWPORT_URL, CClientScript::POS_HEAD);
        }
        if($this->useCluster){
            Yii::app()->clientScript->registerCssFile('/css/vendor/MarkerCluster.css');
            Yii::app()->clientScript->registerCssFile('/css/vendor/MarkerCluster.Default.css');
            Yii::app()->clientScript->registerScriptFile('/js/vendor/leaflet.markercluster.js', CClientScript::POS_END);
        }
        if($this->draggableBalloon){
            Yii::app()->clientScript->registerCssFile('/js/vendor/L.GeoSearch/l.geosearch.css');
            Yii::app()->clientScript->registerScriptFile('/js/vendor/L.GeoSearch/l.control.geosearch.js', CClientScript::POS_END);
            Yii::app()->clientScript->registerScriptFile('/js/vendor/L.GeoSearch/l.geosearch.provider.google.js', CClientScript::POS_END);
        }
        Yii::app()->clientScript->registerCssFile('/css/vendor/leaflet.css');
        Yii::app()->clientScript->registerScriptFile('/js/vendor/leaflet.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile('/js/map.js', CClientScript::POS_END);
    }

    private function setCoordsCenter()
    {
        if($this->region){
            $this->coordsCenter = array('lat'=>$this->region->lat,'lon'=>$this->region->lon);
            return false;
        }
        if(is_null($this->target) && isset($this->projects)){
            if($this->object == self::T_PROJECT){
                #иногда нам будут передавать только проекты, поэтому по одному из них найдем центральную точку
                if(count($this->projects)>0 && !$this->projects[0]->isNewRecord){
                    $example = array_shift(array_values($this->projects)); //будем по первому находить центральную точку
                    #если есть по чему отображать - сразу заполним координаты (без геоопределения)
                    if($example->lat!='' && $example->lon!=''){
                        $this->coordsCenter = array('lat'=>$example->lat,'lon'=>$example->lon);
                        return false;
                    }
                    else{
                        //$this->target = "{$example->region->name} {$this->owner->user->company_address}";
                    }
                }
                else{ //создаем проект, выставим центр - его регион
                    $this->coordsCenter = array(
                        'lat'=> !empty($this->owner->region) ? $this->owner->region->lat:self::D_LAT,
                        'lon'=> !empty($this->owner->region) ? $this->owner->region->lon:self::D_LON);
                    return false;
                }
            }
            else{ #когда отображаем регион
                $this->coordsCenter = array('lat'=>@Candy::get($this->projects->lat,self::D_LAT),'lon'=>@Candy::get($this->projects->lon,self::D_LON));
                return false;
            }
        }
        if(is_null($this->target)){
            //$this->target = "{$this->owner->region->name} {$this->owner->user->company_address}";//текущий регион + город пользователя
            $this->target = "{$this->owner->region->name}";//текущий регион + город пользователя
        }

        $data = '[]';//file_get_contents(self::NOMINATIM_URL . "&q=" . urlencode($this->target));
        $json = json_decode($data, true);
        $this->coordsCenter = isset($json[0]) ? $json[0] : array('lat'=>self::D_LAT,'lon'=>self::D_LON);
    }

    private function setCoordsBalloon()
    {
        if ($this->object == self::T_PROJECT) {
            foreach ($this->projects as $project) {
                if ($project->issetCoords()) {
                    $lat = $project->lat;
                    $lon = $project->lon;
                } else {
                    $lat = $this->coordsCenter['lat'];
                    $lon = $this->coordsCenter['lon'];
                }
                array_push($this->coordsBalloon, array('id' => $project->id, 'lat' => $lat, 'lon' => $lon,'text'=>$project->name));
            }
        }
        else{
            array_push($this->coordsBalloon, $this->coordsCenter);
        }

    }

    private function renderMap()
    {
        $js = <<<JS
            var params = {
                id:"{$this->htmlOptions['id']}",
                lat:{$this->coordsCenter['lat']},
                lon:{$this->coordsCenter['lon']},
                zoom:{$this->zoom},
                cluster:{$this->jsVar($this->useCluster)},
                draggable:{$this->jsVar($this->draggableBalloon)}
            }
            mapJs.init(params);
JS;
        if(count($this->coordsBalloon)){
            foreach($this->coordsBalloon as $balloon){
                $balloon['id'] = isset($balloon['id']) ? $balloon['id']: 0;
                $js .= <<<JS
            mapJs.addBalloon({
                lat:{$balloon['lat']},
                lon:{$balloon['lon']},
                draggable:{$this->jsVar($this->draggableBalloon)},
                id:"{$balloon['id']}",
                cluster:{$this->jsVar($this->useCluster)},
                ajaxBalloon:{$this->jsVar($this->showProjectBalloon)}

            });
JS;
            }
        }
        if($this->useCluster){
            $js .= <<<JS
        mapJs.addCluster();
JS;
        }

        Yii::app()->clientScript->registerScript($this->htmlOptions['id'], $js, CClientScript::POS_END);


    }

    private function renderStaticMap(){
        $staticParam = array(
            'center'=>implode(',',array($this->coordsCenter['lat'],$this->coordsCenter['lon'])),
            'zoom'=>$this->zoom,
            'maptype'=>'mapnik',
            'size'=>implode('x',array($this->htmlOptions['width'],$this->htmlOptions['height']))
        );
        if(count($this->coordsBalloon)){
            $balloonList = array();
            foreach($this->coordsBalloon as $balloon){
                $balloonList[] = implode(',',array($this->coordsCenter['lat'],$this->coordsCenter['lon'],'type'=>'lighblue1'));
            }
            $staticParam['markers'] = implode('|',$balloonList);
        }

        echo CHtml::image($this->owner->createUrl('site/staticMap',$staticParam),'',array('class'=>'static'));
    }
    private function jsVar($var){
        return $var==false ? 0 : 1;
    }
}