"use strict";
let temperatura

$(document).ready(function () {
    loadSickAnimals();
    loadIssues();
    loadTemperature();
    loadTreatmentAnimals();
});



window.myWidgetParam ? window.myWidgetParam : window.myWidgetParam = [];
window.myWidgetParam.push({
    id: 11,
    cityid: '2519240',
    appid: 'a9d66d4709df4edace61f070ee443cac',
    units: 'metric',
    containerid: 'openweathermap-widget-11',
    lang: 'es'
});
(function () {
    var script = document.createElement('script');
    script.async = true;
    script.charset = "utf-8";
    script.src = "//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js";
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(script, s);
})();


function loadSickAnimals() {
    $.ajax({
        url: `sick`,
        type: "GET",
        dataType: "json"
    }).done(function (responseText) {
        $(".ill").empty();
        if(responseText != 0){
            $(".ill").append(`<p class="msg">Hay</p> <p class="msg-num"> ${responseText} </p> <p class="msg">animales enfermos</p>`);
        }else{
            $(".ill").append(`<p class="msg">No hay animales enfermos</p>`);
        }
    });
}

function loadIssues() {
    $.ajax({
        url: `num_issues`,
        type: "GET",
        dataType: "json"
    }).done(function (responseText) {
        $(".issues").empty();
        if(responseText != 0){
            $(".issues").append(`<p class="msg">Hay</p> <p class="msg-num">${responseText}</p> <p class="msg">incidencias sin resolver</p>`);
        }else{
            $(".issues").append(`<p class="msg">No hay incidencias</p>`);
        }
        
    });
}

function loadTreatmentAnimals() {
    $.ajax({
        url: `treatment`,
        type: "GET",
        dataType: "json"
    }).done(function (responseText) {
        $(".treatment").empty();
        if(responseText != 0){
            $(".treatment").append(`<p class="msg">Hay</p> <p class="msg-num">${responseText}</p> <p class="msg">animales en tratamiento</p>`);
        }else{
            $(".treatment").append(`<p class="msg">No hay animales en tratamiento</p>`);
        }
    });
}


function loadTemperature() {
    $(".advices").empty();
    $.ajax({
        url: `https://api.openweathermap.org/data/2.5/weather?q=Cordoba,es&appid=a9d66d4709df4edace61f070ee443cac&units=metric`,
        type: "GET",
        dataType: "json"
    }).done(function (responseText) {
        temperatura = responseText['main']['temp'];
        $(".advices").empty();

        if(temperatura>30){
            $(".advices").append(`<p class="advice" style=" background-color:white"> <img src="../img/Consejito.png" width="40px" height="40px" >Hace mucho calor, procura abastecer de agua el ganado y evita su exposición al sol</p>`);
        }else if(temperatura<5){
            $(".advices").append(`<p class="advice" style=" background-color:white"> <img src="../img/Consejito.png" width="40px" height="40px" >Hace mucho frío, algunos animales como las aves son especialmente sensibles, mantén el calor de los módulos</p>`);
        }else{
            $(".advices").append(`<p class="advice" style=" background-color:white"><img src="../img/Consejito.png" width="40px" height="40px" > Temperatura agradable, no es necesario tomar ninguna medida cautelar</p>`);
        }
    });
}
