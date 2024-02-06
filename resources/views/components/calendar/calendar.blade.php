<x-homepage>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @section('css')
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
       <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    @endsection
    <style>
        a {
            color: #000000;
            text-decoration: none;
        }

    </style>
<div style="background-color: white; padding:3px; box-shadow: 10px 5px 5px black;">
    <div id='calendar'></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.js'></script>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $('.fc-today-button').text("Hoy");
        var calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',  
          themeSystem: 'bootstrap5',
          selectable: true,
          height: 700,
          locale: '{{app()->getLocale()}}',
          eventClick: function (event) {
            Swal.fire({
                            title: '¿Deseas eliminar este evento?',
                            icon: 'warning',
                            showDenyButton: true,
                            confirmButtonText: 'Eliminar',
                            denyButtonText: `Cancelar`,
                          }).then((result) => {
                            if (result.isConfirmed) {
                                var titulo = event.event._def.title;
                                var result = "";
                                for (let i = 0; i < titulo.length; i++) {
                                    if(titulo[i] != "("){
                                        result += titulo[i];
                                    }else{
                                        break;
                                    }                                    
                                }

                                $.ajax({
                                    type: "post",
                                    url: `/delete/${titulo}/${result.substr(0, result.length-1)}`,
                                    dataType: "json",
                                    success: function (response) {
                                        displayMessage('Evento eliminado');
                                        event.event.remove();
                                    }
                                });
                            }
                          })
          }  
        });

        $.ajax({
        type: "get",
        url: "/getEvents",
        dataType: "json",
        success: function (response) {
            for (const event in response.data) {
                if(response.data[event]['type'] == "vet"){
                    calendar.addEvent({
                    title: response.data[event]['title'],
                    start: response.data[event]['start'],
                    end: response.data[event]['end'],
                    color: 'green'
                });
                }else if(response.data[event]['type'] == "pending"){
                    calendar.addEvent({
                    title: response.data[event]['title'],
                    start: response.data[event]['start'],
                    end: response.data[event]['end'],
                    color: 'red'
                });
                }else if(response.data[event]['type'] == "process"){
                    calendar.addEvent({
                    title: response.data[event]['title'],
                    start: response.data[event]['start'],
                    end: response.data[event]['end'],
                    color: 'lightblue'
                });  
                }else if(response.data[event]['type'] == "done"){
                    calendar.addEvent({
                    title: response.data[event]['title'],
                    start: response.data[event]['start'],
                    end: response.data[event]['end'],
                    color: 'lightgreen'
                });  
                }else{
                    calendar.addEvent({
                    title: response.data[event]['title'],
                    start: response.data[event]['start'],
                    end: response.data[event]['end'],
                    color: 'purple'
                });  
                }
                
            }  
        }
        });
        
        calendar.render();
        

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        

    });

    function displayMessage(message) {
        toastr.success(message);
    }


</script>

</x-homepage>
