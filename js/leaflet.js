/**
 * Created by Administrator on 2016/9/30.
 */
var map = L.map('map').setView([31.220,121.444], 10);

L.tileLayer('https://api.mapbox.com/styles/v1/dubhe/ciu441t3900ac2ho8ajynwik8/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZHViaGUiLCJhIjoiY2l0cmY1aTJ5MDMyZDJ5bXN5aTF5b3h4ayJ9.RPD1mY_4cYtegDf1BSIQ7A',
    {
    attribution: 'Data &copy; ' +
    '<a href="http://openstreetmap.org">OpenStreetMap</a>, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom:18
}).addTo(map);
/*
暗夜版style，可添加图层
 */
function get_location() {

    map.locate({setView: true, maxZoom: 16});

    function onLocationFound(e) {
        var radius = e.accuracy / 2;

        L.marker(e.latlng).addTo(map)
            .bindPopup("You are within " + radius + " meters from this point").openPopup();

        L.circle(e.latlng, radius).addTo(map);
    }

    map.on('locationfound', onLocationFound);
    function onLocationError(e) {
        alert(e.message);
    }

    map.on('locationerror', onLocationError);
};



function add_point(y,x,att) {
    L.marker(y,x).addTo(map)
        .bindPopup("名称："+att.name+"\n介绍："+att.intro).openPopup();
}
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