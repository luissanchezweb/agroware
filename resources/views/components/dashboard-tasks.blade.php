<x-homepage>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @section('css')
        <link rel="stylesheet" href="/css/taskboard.css">
    @endsection
    <div style="padding: 20px">
        <div class="row">
            <div class="col-3">

            </div>
            <div class="col-md-6 col-12">
                <h3 class="text-center" style="background-color: white; padding:10px; border-radius:10px; box-shadow: 10px 5px 5px black;">{{__('messages.dashboard')}} {{auth()->user()->name}}</h3>
            </div>
            @if(auth()->user()->hasRole('Gerente'))
            <div class="col-12 col-md-3" style="text-align:center; margin-top: 5px;">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-wheat-awn"></i> {{__('messages.asign_task')}}</button>
            </div>
            @endif
        </div>
    </div>
    <div>
        <div class="row">
        <div class="col-12 col-md-4" style="margin-top: 5px;">
            <div class="card drop" id="pending" data-status="pending">
                <div class="card-body">
                    <h6 class="text-center">{{__('messages.pending_tasks')}}</h6>
                    <hr>
                    @foreach($tasksPen as $taskPen)
                        <div class="card drag" data-id="{{$taskPen->id}}" style="height: 50px; margin: 5px">
                            <div class="card-body text-align" >
                                <div class="row">
                                    <div class="col-10 col-md-10 col-sm-10" style="text-align: left">
                                        {{$taskPen->title}}
                                    </div>
                                    <div class="col-2 col-md-2 col-sm-2" style="text-align: right; margin-top:-5px">
                                        <button class="btn view" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" data-id="{{$taskPen->id}}"> <i class="fa-solid fa-eye"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4" style="margin-top: 5px;">
            <div class="card" id="process">
                <div class="card-body drop" data-status="process">
                    <h6 class="text-center">{{__('messages.process_tasks')}}</h6>
                    <hr>
                    @foreach($tasksPro as $taskPro)
                        <div class="card drag" data-id="{{$taskPro->id}}" style="height: 50px; margin: 5px">
                            <div class="card-body text-align" >
                                <div class="row">
                                    <div class="col-10" style="text-align: left">
                                        {{$taskPro->title}}
                                    </div>
                                    <div class="col-2" style="text-align: right; margin-top:-5px">
                                        <button class="btn view" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" data-id="{{$taskPro->id}}"> <i class="fa-solid fa-eye"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4" style="margin-top: 5px;">
            <div class="card" id="done" >
                <div class="card-body drop" data-status="done">
                    <h6 class="text-center">{{__('messages.closed_tasks')}}</h6>
                    <hr>
                    @foreach($tasksDo as $taskDo)
                        <div class="card drag" data-id="{{$taskDo->id}}" style="height: 50px; margin: 5px">
                            <div class="card-body text-align">
                                    <div class="row">
                                        <div class="col-10" style="text-align: left">
                                            {{$taskDo->title}}
                                        </div>
                                        <div class="col-2" style="text-align: right; margin-top:-5px">
                                            <button class="btn view" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" data-id="{{$taskDo->id}}"> <i class="fa-solid fa-eye"></i></button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade modal-task" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{__('messages.asign_task')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/tasks/add" style="text-align: center" class="createTask">
                        @csrf
                        <div>
                            <label for="notas">{{__('messages.issue_title')}}</label>
                            <input type="text" name="title" id="task-title" class="form-control" required>
                        </div>
                        @error('title')
                        <span style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="notas">{{__('messages.issue_description')}}</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            @error('description')
                            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <label for="notas">{{__('messages.user_worker')}}</label>
                        <select class="form-select" id="user_id" aria-label="Usuarios" name="user_id" required>
                            <option  value="" selected>{{__('messages.select_worker')}}</option>
                            @foreach($users as $user)
                                <option  value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                        <div>
                            <label for="notas">{{__('messages.init_date')}}</label>
                            <input type="date" name="start_date" id="start" class="form-control" required>
                        </div>
                        @error('title')
                        <span style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">{{ $message }}</span>
                        @enderror
                        <div>
                            <label for="notas">{{__('messages.finish_date')}}</label>
                            <input type="date" name="finish_date" id="finish" class="form-control" required>
                        </div>
                        @error('title')
                        <span style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">{{ $message }}</span>
                        @enderror
                        <div>
                            <button type="submit" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="margin: 5px">{{__('messages.create')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop2" tabindex="-1" aria-labelledby="staticBackdropLabel2" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-task"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="description-task"></p>
                    <p id="start-task"></p>
                    <p id="finish-task"></p>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @section('js')
        <script src="/js/taskboard.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js" integrity="sha512-v0vjOquuhHQslRkq1a5BwUIyKSD7ZbgFfQv4jzSBGwbIVTCOs5JQdotZVoRjPRzb9UToTvuP2kdR5CVE4TLgMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endsection
</x-homepage>
