var mapJs ={
    currentMap:null,
    markersCluster:null,
    selectorLat:'#coords-lat',
    selectorLon:'#coords-lon',
    marker:null,
    init:function(params){
        mapJs.selectorLat = params.selectorLat;
        mapJs.selectorLon = params.selectorLon;
        L.Icon.Default.imagePath = '/js/vendor/images'; //нужно для ajax-вызова нормального
        var mapSetting = {};
        if(params.cluster){
            mapJs.markersCluster = new L.MarkerClusterGroup();
        }
        mapJs.currentMap = L.map(params.id,mapSetting).setView([params.lat,params.lon ], params.zoom);
        mapJs.currentMap.scrollWheelZoom.disable();
        L.tileLayer('https://{s}.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={access_token}', {
            maxZoom: 18,
            attribution: false ,/*'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="http://mapbox.com">Mapbox</a>',*/
            id: mapBox.id,
            access_token: mapBox.access_token
        }).addTo(mapJs.currentMap);
        //добавим поиск
        if(params.draggable==true && params.search == true){
            new L.Control.GeoSearch({
                provider: new L.GeoSearch.Provider.Google()
            }).addTo(mapJs.currentMap);
        }
        $('#filter-map').show();
    },
    addBalloon:function(params){
        if(mapJs.marker!=null && params.one == true){
            mapJs.currentMap.removeLayer(mapJs.marker);
        }

        var iconUrl = '/images/map/markers/'+((params.icon != null && params.icon != '') ? params.icon : 'mark')+'.png';


        var customIcon = L.icon({
            iconUrl: iconUrl,
            iconSize:     [58, 60], // size of the icon
            iconAnchor:   [22, 60], // point of the icon which will correspond to marker's location
            popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });
        console.log(customIcon);
        var marker = mapJs.marker = L.marker([params.lat,params.lon],{draggable:params.draggable,icon: customIcon});
            marker.bindPopup(params.text);
        if(params.cluster){
            mapJs.markersCluster.addLayer(marker);
        }
        else{
            marker.addTo(mapJs.currentMap);
        }

        if(params.draggable==true){
            marker.on('dragend', function(e) {
                var latLng = e.target._latlng;
                mapJs._setCords({lat:latLng.lat,lon:latLng.lng});
            });
        }
        if(params.ajaxBalloon==true){
            marker.on('click', function(e) {
                var $mapObject = $(mapJs.currentMap._container);
                $mapObject.find('.ajax-balloon').remove();
                $.ajax({
                    type: "GET",
                    url: "/project/mapInfo",
                    data: {id:params.id, extend: params.extendAjaxPopup}
                }).done(function( data ) {
                    $mapObject.find('.ajax-balloon').remove();
                    $mapObject.prepend(data);
                });
                mapJs.currentMap.panTo(marker.getLatLng());
                return false;
            });

        }

        this._setCords(params);
    },
    addCluster:function(){
        mapJs.currentMap.addLayer(mapJs.markersCluster);
    },
    /**
     * Записать в инпуты координаты
     * @param params
     */
    _setCords:function(params){

        var $lat = $(mapJs.selectorLat),
            $lon = $(mapJs.selectorLon);
            $lat.val(params.lat);
            $lon.val(params.lon);
    }

}
