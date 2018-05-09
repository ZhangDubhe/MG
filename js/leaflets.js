/**
 * Created by Administrator on 2016/9/30.
 */
var map = L.map('map').setView([31.3,121.503], 12);
/*
* sk.eyJ1IjoiZHViaGUiLCJhIjoiY2owanQycWgxMDF2NjMzcjYzc2xkOGJlYiJ9.ZTM9XYhRZb-NEu9VC77MwQ
* token in mapbox
* ECNU 14.7121.403,31.229
  */
var basemap = 'https://api.mapbox.com/styles/v1/dubhe/ciu4vv0lk00qp2irqkao65sao/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZHViaGUiLCJhIjoiY2l0cmY1aTJ5MDMyZDJ5bXN5aTF5b3h4ayJ9.RPD1mY_4cYtegDf1BSIQ7A';
var basemap1='https://api.mapbox.com/styles/v1/dubhe/ciu441t3900ac2ho8ajynwik8/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZHViaGUiLCJhIjoiY2l0cmY1aTJ5MDMyZDJ5bXN5aTF5b3h4ayJ9.RPD1mY_4cYtegDf1BSIQ7A';
var base;
if ($(window).width()>=768){
    base=basemap1;
}
else {
    base = basemap;
}
L.tileLayer(base,
    {
    attribution: 'Data &copy; ' +
    '<a href="http://openstreetmap.org">OSM</a>, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom:18
}).addTo(map);
//console.debug("The Leaflet is ok~");
/*
暗夜版style，可添加图层
 */
var location_point;
function get_location() {

    map.locate({setView: true, maxZoom: 16});

    function onLocationFound(e) {
        var radius = e.accuracy / 2;
        location_point=e;
        L.marker(e.latlng).addTo(map)
            .bindPopup("You are within " + radius + " meters from this point").openPopup();

        L.circle(e.latlng, radius).addTo(map);
    }

    map.on('locationfound', onLocationFound);
    function onLocationError(e) {
        alert(e.message);
    }
    console.debug(location_point.latlng.y,location_point.latlon.x);
    map.on('locationerror', onLocationError);
};
var get_point_value;

function get_point() {
    get_point_value=true;
    if(get_point_value)
    {
        console.debug("Now is going~");
        console.debug(location_point.latlng);

        add_point();
    }
}

var att={
    name:"Hello world~",
        intro:"nihao"
};
function add_point() {

    L.marker([31.24508,121.506591]).addTo(map)
        .bindPopup("名称:百度地图"+"\n介绍："+att.intro).openPopup();
    L.marker([31.2282946971,121.4719531679]).addTo(map)
        .bindPopup("名称：腾讯地图"+"\n介绍："+att.intro).openPopup();
    L.marker([31.239440392,121.4999975563]).addTo(map)
        .bindPopup("名称：谷歌地图"+"\n介绍："+att.intro).openPopup();
    L.marker([31.2414353686,121.4955504538]).addTo(map)
        .bindPopup("名称：谷歌earth"+"\n介绍："+att.intro).openPopup();
    L.marker([31.2273445171,121.4771614379]).addTo(map)
        .bindPopup("名称：图吧地图"+"\n介绍："+att.intro).openPopup();
    L.marker([31+1*13/60+1*48.99/3600,121+1*28/60+1*3.01/3600]).addTo(map)
        .bindPopup("名称：经纬度"+"\n介绍："+att.intro).openPopup();
};
//以下是学校建筑
function getColor1(d) {
    return d > 1000 ? '#800026' :
        d > 500 ? '#BD0026' :
            d > 200 ? '#E31A1C' :
                d > 100 ? '#FC4E2A' :
                    d > 50 ? '#FD8D3C' :
                        d > 20 ? '#FEB24C' :
                            d > 10 ? '#FED976' :
                                '#FFEDA0';
}



function style(feature) {
    return{
        fillColor: getColor1(feature.properties.Area),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
    };}
   


function onEachFeature(feature, layer) {
    // does this feature have a property named popupContent?
    layer.on('click', function () {
        layer.bindPopup("There are " + feature.properties.Area + "people in this building")
    });
}
// 更新 Layer 中的数据
var geofeature = L.geoJson(ECNUBuilding2, {
    style: style,
    onEachFeature: onEachFeature
}).addTo(map);
geofeature.addTo(map);

var marketIcon = L.Icon.extend({
    options: {
        shadowUrl: '../filesource/ing/images/marker-shadow.PNG',

        iconSize:     [38, 95],
        shadowSize:   [50, 64],
        iconAnchor:   [22, 94],
        shadowAnchor: [4, 62],
        popupAnchor:  [-3, -76]
    }
});
L.icon=function (option) {
    return new L.Icon(option);
};
//出现在地图上的类 map_on

function check_up() {
    if(if_star){

    }//收藏之后生成气泡并标注在地图上

    else if(location_point){
        L.marker(location_point.latlng).addTo(map)
            .bindPopup("You just have been there").openPopup();
        var lon=location_point.x;
        var lat=location_point.y;
        console.debug(lon,lat);

    };//在当前地方收藏
}//