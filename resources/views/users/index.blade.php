<x-homepage>
    <style>
        .page-link{
            color: green;
        }

        .pagination {
    --bs-pagination-padding-x: 0.75rem;
    --bs-pagination-padding-y: 0.375rem;
    --bs-pagination-font-size: 1rem;
    --bs-pagination-color: green;
    --bs-pagination-bg: white;
    --bs-pagination-border-width: green;
    --bs-pagination-border-color: green;
    --bs-pagination-border-radius: var(--bs-border-radius);
    --bs-pagination-hover-color: white;
    --bs-pagination-hover-bg: green;
    --bs-pagination-hover-border-color: green;
    --bs-pagination-focus-color: green;
    --bs-pagination-focus-bg: green;
    --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(58, 255, 18, 0.25);
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: green;
    --bs-pagination-active-border-color: green;
    --bs-pagination-disabled-color: var(--bs-secondary-color);
    --bs-pagination-disabled-bg: var(--bs-secondary-bg);
    --bs-pagination-disabled-border-color: var(--bs-border-color);
    display: flex;
    padding-left: 0;
    list-style: none;
}
    </style>
    <div class="logo" style="box-shadow: 10px 5px 5px black; bottom: 0; background-color:white; margin-top:30px;">
        <div class="img" style="text-align: center">
            <img src="../img/logo-agro.png">
        </div>
    </div>
    <div style="margin-top: 20px; background-color:white; padding:10px; box-shadow: 10px 5px 5px black;">
        <div class="table-responsive">
            <table class="table" style="width: 99%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('messages.user_name')}}</th>
                        <th>{{ __('messages.user_username')}}</th>
                        <th>{{ __('messages.user_mail')}}</th>
                        <th>{{ __('messages.user_charge')}}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div style="margin-top: 30px">
        <div class="row" style="text-align: center">
            <div class="col-4">
                <button class="btn btn-warning update" data-id="" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" > <i class="fa-solid fa-user-pen"></i> {{ __('messages.user_edit')}}</button>
            </div>
            <div class="col-4">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-user-plus"></i>  {{ __('messages.user_create')}}</button>
            </div>
            <div class="col-4">  
                <button class="btn btn-danger delete" data-id=""> <i class="fa-solid fa-user-minus"></i> {{ __('messages.user_delete')}}</button>
            </div>
        </div>
    </div>
            
            


    <div class="modal fade new-user-modal" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('messages.user_new')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form new-user" method="POST" action="/users/create" enctype="multipart/form-data" style="text-align: center">
                        @csrf <!--//hidden input with a token (validation)-->
                        <div class="form-group">
                            <label for="name">{{ __('messages.user_name')}}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                                <p >{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">{{ __('messages.user_username')}}</label>
                            <input class="form-control" type="text" name="username" id="username" value="{{ old('username') }}" required>
                            @error('username')
                            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('messages.user_mail')}}</label>
                            <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('messages.user_password')}}</label>
                            <input class="form-control" type="password" name="password" id="password" required>
                        </div>
                        @error('password')
                        <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                        <div class="form-group">
                            <label for="avatar">{{ __('messages.user_profile')}}</label>
                            <input class="form-control" type="file" name="avatar" id="avatar" value="{{ old('avatar') }}">
                            @error('avatar')
                            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="flexRadioDefault1" value="Gerente">
                            <label class="form-check-label" for="flexRadioDefault1">
                                {{ __('messages.user_boss')}}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="flexRadioDefault2" value="Trabajador" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                {{ __('messages.user_worker')}}
                            </label>
                        </div>
                        <button style="margin: 20px; " type="submit" class="btn btn-outline-dark" data-mdb-ripple-color="dark" >{{ __('messages.user_register')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 -->
    <div class="modal fade edit-user-modal" id="staticBackdrop2" tabindex="-1" aria-labelledby="staticBackdropLabel2" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('messages.user_edit')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form edit-user" method="POST" action="/users/update" style="text-align: center">
                        @csrf <!--//hidden input with a token (validation)-->
                        <div class="form-group">
                            <label for="name">{{ __('messages.user_name')}}</label>
                            <input class="form-control" type="text" name="nameuser" id="nameuser" value="" required>
                            @error('name')
                            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">{{ __('messages.user_username')}}</label>
                            <input class="form-control" type="text" name="usernameuser" id="usernameuser" value="" required>
                            @error('username')
                            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('messages.user_mail')}}</label>
                            <input class="form-control" type="email" name="emailuser" id="emailuser" value="" required>
                            @error('email')
                            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="avatar">{{ __('messages.user_profile')}}</label>
                            <input class="form-control" type="file" name="avataruser" id="avataruser" value="">
                            @error('avatar')
                            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userrole" id="user-trabajador" value="Trabajador">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    {{ __('messages.user_worker')}}
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="userrole" id="user-gerente" value="Gerente">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    {{ __('messages.user_boss')}}
                              
                                </label>
                              </div>
                              @error('rol')
                            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <button style="margin: 20px;" id="create" type="submit" class="btn btn-outline-dark" data-mdb-ripple-color="dark">{{ __('messages.user_edition')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js" integrity="sha512-v0vjOquuhHQslRkq1a5BwUIyKSD7ZbgFfQv4jzSBGwbIVTCOs5JQdotZVoRjPRzb9UToTvuP2kdR5CVE4TLgMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            </script>
        <script src="/js/users.js"></script>
    @endsection
    
</x-homepage>

