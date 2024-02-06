<x-homepage>
    <style>
        .advices{
            padding: 10;
        }

        .advice{
            border-radius: 10px;
            padding: 5px;
            text-align: center;
            margin: 5%;
            box-shadow: 10px 5px 5px black;
        }

        .widget{
            box-shadow: 10px 5px 5px black;
        }

        .issues{
            margin: 10px;
            background-color:rgba(206, 81, 32);
            box-shadow: 10px 5px 5px black;
        }

        .ill{
            margin: 10px;
            background-color:rgb(180, 54, 54);
            box-shadow: 10px 5px 5px black;
        }

        .treatment{
            margin: 10px;
            background-color:rgb(15, 114, 55);
            box-shadow: 10px 5px 5px black;
        }

        .msg{
            color: white;
            padding: 5px;
            text-align: center;
            margin: 5%
        }
        .msg-num{
            font-size: 40px;
            color: white;
            text-align: center
        }

        .clock{
            background-color: rgb(233, 233, 233);
            box-shadow: 10px 5px 5px black;
            margin: 10px;
        }
    </style>
    <div class="contenedor" style="padding:30px">
        <div class="row">
            <div class="col-sm-8 col-12">
                <div class="clock">
                    <div style="text-align:center;padding:1em 0;"> <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=large&timezone=Europe%2FMadrid" width="100%" height="140" frameborder="0" seamless></iframe> </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="forecast">
                    <div class="widget" id="ww_3c40f4c5272cf" v='1.3' loc='id' a='{"t":"horizontal","lang":"es","sl_lpl":1,"ids":["wl6520"],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"#388E3C","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#FFFFFF","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722"}'>Weather Data Source: <a href="https://tiempolargo.com/cordoba_tiempo_25_dias_69/" id="ww_3c40f4c5272cf_u" target="_blank">El tiempo en Córdoba a 25 días</a></div><script async src="https://app1.weatherwidget.org/js/?id=ww_3c40f4c5272cf"></script> 
                </div>    
            </div>
        </div>
        <div class="row">
           <div class="col-12 col-sm-4">
               <div class="issues">

               </div>
           </div>
            <div class="col-12 col-sm-4">
                <div class="ill">

                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="treatment">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="advices" >

                </div>
            </div>
            <div class="col-12">
                <div class="img" style="text-align: center; background-color:white; box-shadow: 10px 5px 5px black;">
                    <img src="../img/logo-agro.png">
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script src='//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/d3.min.js'></script>
        <script src="js/weather.js"></script>
    @endsection
</x-homepage>
