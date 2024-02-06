<x-homepage>
    <div class="contenedor" style="text-align: center; padding: 20px">
        <div class="row">
            <div class="col-12 col-md-6">
                <select class="form-select" aria-label="type" name="type" id="type" required>
                    <option value="" selected> {{ __('messages.issues_see_issues')}}</option>
                    <option value="pending">{{ __('messages.issues_pending')}}</option>
                    <option value="closed">{{ __('messages.issues_closed')}}</option>
                </select>
            </div>
            <div class="col-12 col-md-6" style="margin-top: 5px">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    style="text-align: center">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ __('messages.issues_report')}}
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="portada" style="text-align: center">
            <img src="../img/granja-cerdos.jpg"  class="img-fluid">
    </div>
    <div class="respuesta" style="margin-top: 50px; text-align: center; box-shadow: 10px 5px 5px black; padding: 15px; background-color:rgba(208, 178, 122)">
        <div class="row">
            <div class="col-sm-3 col-6">
                <button class="btn btn-outline-dark boton" id="animales">{{ __('messages.issues_animals')}}</button>
            </div>
            <div class="col-sm-3 col-6">
                <button class="btn btn-outline-dark boton" id="maquinaria">{{ __('messages.issues_machines')}}</button>
            </div>
            <div class="col-sm-3 col-6">
                <button class="btn btn-outline-dark boton" id="finca">{{ __('messages.issues_field')}}</button>
            </div>
            <div class="col-sm-3 col-6">
                <button class="btn btn-outline-dark boton" id="otros">{{ __('messages.issues_other')}}</button>
            </div>
        </div>
        <div class="issues">
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-issue" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{  __('messages.issue_what') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form report-issue" method="POST" action="/issues/report" style="text-align: center">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{  __('messages.issue_title') }}</label>
                            <input class="form-control" type="text" name="title" id="title" required>
                            @error('title')
                                <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">{{  __('messages.issue_description') }}</label>
                            <textarea name="description" cols="50" rows="5" placeholder="{{ __('messages.issue_explain')}}" id="description" required></textarea>
                            @error('description')
                                <span
                                    style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">{{ $message }}</span>
                            @enderror
                        </div>
                        <label for="type">{{  __('messages.issues_type') }}</label>
                        <select class="form-select" aria-label="type" name="type" id="type" required>
                            <option value="" selected>{{  __('messages.issues_type_select') }}</option>
                            <option value="animals">{{  __('messages.issues_animals') }}</option>
                            <option value="machines">{{  __('messages.issues_machines') }}</option>
                            <option value="field">{{  __('messages.issues_field') }}</option>
                            <option value="other">{{  __('messages.issues_other') }}</option>
                        </select>
                        @error('type')
                            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                        @enderror
                        <div>
                            <button type="submit" class="btn btn-outline-dark" data-mdb-ripple-color="dark"
                                style="margin: 5px">{{ __('messages.issues_report')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js" integrity="sha512-v0vjOquuhHQslRkq1a5BwUIyKSD7ZbgFfQv4jzSBGwbIVTCOs5JQdotZVoRjPRzb9UToTvuP2kdR5CVE4TLgMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script src="/js/issues.js"></script>
        <script>
            function loadAnimalPendingIssues() {
                $('.issues').empty();
                $('.issues').attr('data-type', 'animals');
                $('.issues').attr('data-status', 'pending');
                $.ajax({
                    type: "get",
                    url: "/getAnimalPendingIssues",
                    dataType: "json",
                    success: function (response) {
                        $('.respuesta').show();
                        $('.pulsado').attr('class','btn btn-outline-dark boton');
                        $("#animales").attr('class', 'btn btn-dark pulsado');
                        if(response.data!= null){
                        show = `<div  style="overflow-y:scroll; overflow-x:hidden; max-height: 400px; margin: 20px;><div class= card> <div class="card-body cont-issues">`;
                        for (const key in response.data) {
                            @foreach ($users_rep as $user)
                                    if ({{$user->id}} == response.data[key]['reported_by_id']){
                                        let title = '{{  __('messages.issue_title') }}';
                                        let reported_by = '{{  __('messages.issue_reported_by') }}';
                                        let user = '{{$user->name}}';
                                        let view = '{{  __('messages.issue_view') }}';
                                        let close = '{{  __('messages.issue_close') }}';
                                        show += `
                                            <div class="card">
                                                    <div class="card-body">
                                                        <div style="text-align:left">
                                                            <div class="row">
                                                            <div class="col-6">
                                                                <p><b>${title}: </b><small>${response.data[key]['title']}</small></p>
                                                                <p><b>${reported_by}: </b><small> ${user} ${moment(response.data[key]['created_at']).fromNow()}</small></p>
                                                            </div>
                                                            <div class="col-6" style="text-align:right">
                                                                <a href="/issue/${response.data[key]['id']}" class="btn btn-outline-info"> <i class="fa-solid fa-eye"></i>${view}</a>
                                                                <button id="${response.data[key]['id']}" class="btn btn-outline-dark close"> <i class="fa-solid fa-check-double"></i> ${close}</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            }
                            @endforeach
                        }

                            show += `</div></div></div>`;
                            $('.issues').append(show);
                            $('.close').on("click", closeIssue);
                        }else{
                            $('.issues').append(`<div class="img" style="text-align: center; margin: 20px;">
            <img src="../img/cerdito (2).png" width="300px" height="300px">
        </div>`);
                        }
                            $('.issues').show();
                        }
                    });
                }
            function loadMachinePendingIssues() {
                $('.issues').empty();
                $('.issues').attr('data-type', 'machines');
                $('.issues').attr('data-status', 'pending');
                $.ajax({
                    type: "get",
                    url: "/getMachinePendingIssues",
                    dataType: "json",
                    success: function (response) {
                        $('.respuesta').show();
                        $('.pulsado').attr('class','btn btn-outline-dark boton');
                        $("#maquinaria").attr('class', 'btn btn-dark pulsado');
                        if(response.data!= null){
                        show = `<div style="overflow-y:scroll; overflow-x:hidden; max-height: 400px; margin: 20px;><div class= card> <div class="card-body cont-issues">`;
                        for (const key in response.data) {
                            @foreach ($users_rep as $user)
                                    if ({{$user->id}} == response.data[key]['reported_by_id']){
                                        let title = '{{  __('messages.issue_title') }}';
                                        let reported_by = '{{  __('messages.issue_reported_by') }}';
                                        let user = '{{$user->name}}';
                                        let view = '{{  __('messages.issue_view') }}';
                                        let close = '{{  __('messages.issue_close') }}';
                                        show +=`
                                            <div class="card">
                                                    <div class="card-body">
                                                        <div style="text-align:left">
                                                            <div class="row">
                                                            <div class="col-6">
                                                                <p><b>${title}: </b><small>${response.data[key]['title']}</small></p>
                                                                <p><b>${reported_by}: </b><small> ${user} ${moment(response.data[key]['created_at']).fromNow()}</small></p>
                                                            </div>
                                                            <div class="col-6" style="text-align:right">
                                                                <a href="/issue/${response.data[key]['id']}" class="btn btn-outline-info"> <i class="fa-solid fa-eye"></i>${view}</a>
                                                                <button id="${response.data[key]['id']}" class="btn btn-outline-dark close"> <i class="fa-solid fa-check-double"></i> ${close}</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            }
                            @endforeach
                        }

                        show += `</div></div></div>`;
                        $('.issues').append(show);
                        $('.close').on("click", closeIssue);
                        //! VEER
                    }else{
                        $('.issues').append(`<div class="img" style="text-align: center; margin: 20px;">
            <img src="../img/cerdito (2).png" width="300px" height="300px">
        </div>`);
                    }
                        $('.issues').show();
                    }


                });
                e.stopImmediatePropagation();
            }
            function loadFieldPendingIssues() {
                $('.issues').empty();
                $('.issues').attr('data-type', 'field');
                $('.issues').attr('data-status', 'pending');
                $.ajax({
                    type: "get",
                    url: "/getFieldPendingIssues",
                    dataType: "json",
                    success: function (response) {
                        $('.respuesta').show();
                        $('.pulsado').attr('class','btn btn-outline-dark boton');
                        $("#finca").attr('class', 'btn btn-dark pulsado');
                        if(response.data!= null){
                        show = `<div style="overflow-y:scroll; overflow-x:hidden; max-height: 400px; margin: 20px;><div class= card> <div class="card-body cont-issues">`;
                        for (const key in response.data) {
                            @foreach ($users_rep as $user)
                                    if ({{$user->id}} == response.data[key]['reported_by_id']){
                                        let title = '{{  __('messages.issue_title') }}';
                                        let reported_by = '{{  __('messages.issue_reported_by') }}';
                                        let user = '{{$user->name}}';
                                        let view = '{{  __('messages.issue_view') }}';
                                        let close = '{{  __('messages.issue_close') }}';
                                        show +=`
                                            <div class="card">
                                                    <div class="card-body">
                                                        <div style="text-align:left">
                                                            <div class="row">
                                                            <div class="col-6">
                                                                <p><b>${title}: </b><small>${response.data[key]['title']}</small></p>
                                                                <p><b>${reported_by}: </b><small> ${user} ${moment(response.data[key]['created_at']).fromNow()}</small></p>
                                                            </div>
                                                            <div class="col-6" style="text-align:right">
                                                                <a href="/issue/${response.data[key]['id']}" class="btn btn-outline-info"> <i class="fa-solid fa-eye"></i>${view}</a>
                                                                <button id="${response.data[key]['id']}" class="btn btn-outline-dark close"> <i class="fa-solid fa-check-double"></i>${close}</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            }
                            @endforeach
                        }

                        show += `</div></div></div>`;
                        $('.issues').append(show);
                        $('.close').on("click", closeIssue);
                    }else{
                        $('.issues').append(`<div class="img" style="text-align: center; margin: 20px;">
            <img src="../img/cerdito (2).png" width="300px" height="300px">
        </div>`);
                    }
                        $('.issues').show();
                    }


                });
                e.stopImmediatePropagation();
            }

            function loadOtherPendingIssues() {
                $('.issues').empty();
                $('.issues').attr('data-type', 'other');
                $('.issues').attr('data-status', 'pending');
                $.ajax({
                    type: "get",
                    url: "/getOtherPendingIssues",
                    dataType: "json",
                    success: function (response) {
                        $('.respuesta').show();
                        $('.pulsado').attr('class','btn btn-outline-dark boton');
                        $("#otros").attr('class', 'btn btn-dark pulsado');
                        if(response.data!= null){
                        show = `<div style="overflow-y:scroll; overflow-x:hidden; max-height: 400px; margin: 20px;><div class= card> <div class="card-body cont-issues">`;
                            console.log(response.data);
                        for (const key in response.data) {

                            @foreach ($users_rep as $user)
                                    if ({{$user->id}} == response.data[key]['reported_by_id']){
                                        let title = '{{  __('messages.issue_title') }}';
                                        let reported_by = '{{  __('messages.issue_reported_by') }}';
                                        let user = '{{$user->name}}';
                                        let view = '{{  __('messages.issue_view') }}';
                                        let close = '{{  __('messages.issue_close') }}';
                                        show += `
                                            <div class="card">
                                                    <div class="card-body">
                                                        <div style="text-align:left">
                                                            <div class="row">
                                                            <div class="col-6">
                                                                <p><b>${title}: </b><small>${response.data[key]['title']}</small></p>
                                                                <p><b>${reported_by}: </b><small> ${user} ${moment(response.data[key]['created_at']).fromNow()}</small></p>
                                                            </div>
                                                            <div class="col-6" style="text-align:right">
                                                                <a href="/issue/${response.data[key]['id']}" class="btn btn-outline-info"> <i class="fa-solid fa-eye"></i>${view}</a>
                                                                <button id="${response.data[key]['id']}" class="btn btn-outline-dark close"> <i class="fa-solid fa-check-double"></i> ${close}</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            }
                            @endforeach
                        }

                        show += `</div></div></div>`;
                        $('.issues').append(show);
                        $('.close').on("click", closeIssue);
                    }else{
                        $('.issues').append(`<div class="img" style="text-align: center; margin: 20px;">
            <img src="../img/cerdito (2).png" width="300px" height="300px">
        </div>`);
                    }
                        $('.issues').show();
                    }


                });
                e.stopImmediatePropagation();
            }

            function loadAnimalClosedIssues() {
                $('.issues').empty();
                $('.issues').attr('data-type', 'animals');
                $('.issues').attr('data-status', 'closed');
                $.ajax({
                    type: "get",
                    url: "/getAnimalClosedIssues",
                    dataType: "json",
                    success: function (response) {
                        $('.respuesta').show();
                        $('.pulsado').attr('class','btn btn-outline-dark boton');
                        $("#animales").attr('class', 'btn btn-dark pulsado');
                        if(response.data!= null){
                        show = `<div style="overflow-y:scroll; overflow-x:hidden; max-height: 400px; margin: 20px;><div class= card> <div class="card-body cont-issues">`;
                        for (const key in response.data) {
                            @foreach ($users_rep as $user)
                                    if ({{$user->id}} == response.data[key]['reported_by_id']){
                                        let title = '{{  __('messages.issue_title') }}';
                                        let reported_by = '{{  __('messages.issue_reported_by') }}';
                                        let user = '{{$user->name}}';
                                        let view = '{{  __('messages.issue_view') }}';
                                        show +=`
                                            <div class="card">
                                                    <div class="card-body">
                                                        <div style="text-align:left">
                                                            <div class="row">
                                                            <div class="col-6">
                                                                <p><b>${title}: </b><small>${response.data[key]['title']}</small></p>
                                                                <p><b>${reported_by}: </b><small> ${user} ${moment(response.data[key]['created_at']).fromNow()}</small></p>
                                                            </div>
                                                            <div class="col-6" style="text-align:right">
                                                                <a href="/issue/${response.data[key]['id']}" class="btn btn-outline-info"> <i class="fa-solid fa-eye"></i>${view}</a>

                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            }
                            @endforeach
                        }

                            show += `</div></div></div>`;
                            $('.issues').append(show);
                        }else{
                            $('.issues').append(`<div class="img" style="text-align: center; margin: 20px;">
            <img src="../img/cerdito (2).png" width="300px" height="300px">
        </div>`);
                        }
                            $('.issues').show();
                        }
                    });
                    e.stopImmediatePropagation();
                }

            function loadMachineClosedIssues() {
                $('.issues').empty();
                $('.issues').attr('data-type', 'machines');
                $('.issues').attr('data-status', 'closed');
                $.ajax({
                    type: "get",
                    url: "/getMachineClosedIssues",
                    dataType: "json",
                    success: function (response) {
                        $('.respuesta').show();
                        $('.pulsado').attr('class','btn btn-outline-dark boton');
                        $("#maquinaria").attr('class', 'btn btn-dark pulsado');
                        if(response.data!= null){
                        show = `<div style="overflow-y:scroll; overflow-x:hidden; max-height: 400px; margin: 20px;><div class= card> <div class="card-body cont-issues">`;
                        for (const key in response.data) {
                            @foreach ($users_rep as $user)
                                    if ({{$user->id}} == response.data[key]['reported_by_id']){
                                        let title = '{{  __('messages.issue_title') }}';
                                        let reported_by = '{{  __('messages.issue_reported_by') }}';
                                        let user = '{{$user->name}}';
                                        let view = '{{  __('messages.issue_view') }}';
                                        show +=`
                                            <div class="card">
                                                    <div class="card-body">
                                                        <div style="text-align:left">
                                                            <div class="row">
                                                            <div class="col-6">
                                                                <p><b>${title}: </b><small>${response.data[key]['title']}</small></p>
                                                                <p><b>${reported_by}: </b><small> ${user} ${moment(response.data[key]['created_at']).fromNow()}</small></p>
                                                            </div>
                                                            <div class="col-6" style="text-align:right">
                                                                <a href="/issue/${response.data[key]['id']}" class="btn btn-outline-info"> <i class="fa-solid fa-eye"></i>${view}</a>

                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            }
                            @endforeach
                        }

                        show += `</div></div></div>`;
                        $('.issues').append(show);
                    }else{
                            $('.issues').append(`<div class="img" style="text-align: center; margin: 20px;">
            <img src="../img/cerdito (2).png" width="300px" height="300px">
        </div>`);
                        }
                        $('.issues').show();
                    }


                });
                e.stopImmediatePropagation();
            }

            function loadFieldClosedIssues() {
                $('.issues').empty();
                $('.issues').attr('data-type', 'field');
                $('.issues').attr('data-status', 'closed');
                $.ajax({
                    type: "get",
                    url: "/getFieldClosedIssues",
                    dataType: "json",
                    success: function (response) {
                        $('.respuesta').show();
                        $('.pulsado').attr('class','btn btn-outline-dark boton');
                        $("#finca").attr('class', 'btn btn-dark pulsado');
                        if(response.data!= null){
                        show = `<div style="overflow-y:scroll; overflow-x:hidden; max-height: 400px; margin: 20px;><div class= card> <div class="card-body cont-issues">`;
                        for (const key in response.data) {
                            @foreach ($users_rep as $user)
                                    if ({{$user->id}} == response.data[key]['reported_by_id']){
                                        let title = '{{  __('messages.issue_title') }}';
                                        let reported_by = '{{  __('messages.issue_reported_by') }}';
                                        let user = '{{$user->name}}';
                                        let view = '{{  __('messages.issue_view') }}';
                                        show += `
                                            <div class="card">
                                                    <div class="card-body">
                                                        <div style="text-align:left">
                                                            <div class="row">
                                                            <div class="col-6">
                                                                <p><b>${title}: </b><small>${response.data[key]['title']}</small></p>
                                                                <p><b>${reported_by}: </b><small> ${user} ${moment(response.data[key]['created_at']).fromNow()}</small></p>
                                                            </div>
                                                            <div class="col-6" style="text-align:right">
                                                                <a href="/issue/${response.data[key]['id']}" class="btn btn-outline-info"> <i class="fa-solid fa-eye"></i>${view}</a>

                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            }
                            @endforeach
                        }

                        show += `</div></div></div>`;
                        $('.issues').append(show);
                    }else{
                            $('.issues').append(`<div class="img" style="text-align: center; margin: 20px;">
            <img src="../img/cerdito (2).png" width="300px" height="300px">
        </div>`);
                        }
                        $('.issues').show();
                    }


                });
                e.stopImmediatePropagation();
            }

            function loadOtherClosedIssues() {
                $('.issues').empty();
                $('.issues').attr('data-type', 'other');
                $('.issues').attr('data-status', 'closed');
                $.ajax({
                    type: "get",
                    url: "/getOtherClosedIssues",
                    dataType: "json",
                    success: function (response) {
                        $('.respuesta').show();
                        $('.pulsado').attr('class','btn btn-outline-dark boton');
                        $("#otros").attr('class', 'btn btn-dark pulsado');
                        if(response.data!= null){
                        show = `<div style="overflow-y:scroll; overflow-x:hidden; max-height: 400px; margin: 20px;>
                                    <div class= card>
                                        <div class="card-body cont-issues">`;

                        for (const key in response.data) {

                            @foreach ($users_rep as $user)
                                    if ({{$user->id}} == response.data[key]['reported_by_id']){
                                        let title = '{{  __('messages.issue_title') }}';
                                        let reported_by = '{{  __('messages.issue_reported_by') }}';
                                        let user = '{{$user->name}}';
                                        let view = '{{  __('messages.issue_view') }}';
                                        show += `
                                            <div class="card">
                                                    <div class="card-body">
                                                        <div style="text-align:left">
                                                            <div class="row">
                                                            <div class="col-6">
                                                                <p><b>${title}: </b><small>${response.data[key]['title']}</small></p>
                                                                <p><b>${reported_by}: </b><small> ${user} ${moment(response.data[key]['created_at']).fromNow()}</small></p>
                                                            </div>
                                                            <div class="col-6" style="text-align:right">
                                                                <a href="/issue/${response.data[key]['id']}" class="btn btn-outline-info"> <i class="fa-solid fa-eye"></i>${view}</a>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            }
                            @endforeach
                        }

                        show += `</div></div></div>`;
                        $('.issues').append(show);
                    }else{
                            $('.issues').append(`<div class="img" style="text-align: center; margin: 20px;">
            <img src="../img/cerdito (2).png" width="300px" height="300px">
        </div>`);
                        }
                        $('.issues').show();
                    }


                });
                e.stopImmediatePropagation();
            }
        </script>
    @endsection
</x-homepage>
