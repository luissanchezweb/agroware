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

    .form-control:focus {
    border-color: #2eca38;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(20, 212, 33, 0.25);
    }
.form-select:focus {
    border-color: #17d43d;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(37, 157, 13, 0.25);
}

    </style>
    <div class="cont" style="text-align: center; padding:20px">
        <div class="row">
            <div class="col-12 col-md-6 col-sm-12">
                <select class="form-select" id="animals" name="animals" required>
                    <option value="">{{ __('messages.livestock_type_select')}}</option>
                </select>
            </div>
            @if(auth()->user()->hasRole('Gerente'))
            <div class="col-4 col-md-2 col-sm-4" style="margin-top: 5px">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#questionBankModal"><i class="fa-solid fa-paw"></i> {{ __('messages.livestock_register_animal')}}</button>
            </div>
            <div class="col-4 col-md-2 col-sm-4" style="margin-top: 5px">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-horse"></i>{{ __('messages.livestock_register_livestock')}}</button>
            </div>
            <div class="col-4 col-md-2 col-sm-4" style="margin-top: 5px">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop6"><i class="fa-solid fa-money-bill-wave"></i> {{ __('messages.livestock_sell_animal')}}</button>
            </div>
            @endif
        </div>
    </div>
    <div class="portada" style="text-align: center">
        <img src="../img/imagen-live.png" class="img-fluid" >
    </div>
 
    <div class="cont-tabla" style="background-color: white; box-shadow: 10px 5px 5px black; padding:30px">
        <div class="filters">
            <div class="row">
                <div class="col-6 col-l-1 col-md-1 col-sm-6">
                    <input class="form-control" type="text" id="codefilter" placeholder="{{__('messages.animal_code')}}">
                </div>
                <div class="col-6 col-md-2 col-sm-6">
                    <input class="form-control" type="text" id="racefilter" placeholder="{{__('messages.animal_race')}}">
                </div>
                <div class="col-6 col-md-2 col-sm-6">
                    <select class="form-control" id="healthfilter">
                        <option id="ds" value="" selected>{{__('messages.animal_health_select')}}</option>
                        <option value="saludable">{{__('messages.animal_health_good')}}</option>
                        <option value="enfermo">{{__('messages.animal_health_bad')}}</option>
                        <option value="observacion">{{__('messages.animal_health_observation')}}</option>
                        <option value="tratamiento">{{__('messages.animal_health_treat')}}</option>
                    </select>
                </div>
                <div class="col-6 col-md-2 col-sm-6">
                    <input class="form-control" type="text" id="foodfilter" placeholder="{{__('messages.animal_food')}}">
                </div>
                <div class="col-6 col-md-2 col-sm-6">
                    <input class="form-control" type="text" id="prodfilter" placeholder="{{__('messages.animal_prod')}}">
                </div>
                <div class="col-6 col-md-3 col-sm-6">
                    <div class="row">
                        <div class="col-4 col-md-4 col-sm-4">
                            <button class="btn btn-primary" id="filtrado"><i class="fa-solid fa-filter"></i></button>
                        </div>
                        <div class="col-4 col-md-4 col-sm-4">
                            <button class="btn btn-light" id="limpiar-filtro"><i class="fa-solid fa-broom"></i></button>
                        </div>
                        <div class="col-4 col-md-4 col-sm-4">
                            <button class="btn btn-danger" id="pdf"><i class="fa-solid fa-save"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="livestock" class="table tabla" width="99%">
                <thead class="thead-bordered">
                    <th>id</th>
                    <th>{{__('messages.animal_code')}}</th>
                    <th>{{__('messages.animal_race')}}</th>
                    <th>{{__('messages.animal_gender')}}</th>
                    <th>{{__('messages.animal_age')}}</th>
                    <th>{{__('messages.animal_weight')}}</th>
                    <th>{{__('messages.animal_health_condition')}}</th>
                    <th>{{__('messages.animal_food')}}</th>
                    <th>{{__('messages.animal_prod')}}</th>
                    <th>{{__('messages.animal_date')}}</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <hr>
        </div>
        
    </div>
    <!-- Modal -->
    <div class="modal fade live-modal" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('messages.livestock_new')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/livestock/add" style="text-align: center" class="livestock-form">
                        @csrf
                        <div>
                            <label for="peso">{{ __('messages.livestock_name')}}</label>
                            <input class="form-control" type="text" name="type" id="live-type" placeholder="{{ __('messages.livestock_name_intro')}}" required>
                        </div>
                        @error('type')
                        <span style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">{{ $message }}</span>
                        @enderror
                        <div>
                            <button type="submit" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="margin: 5px">{{ __('messages.livestock_register_livestock')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Modal 2 -->
    <div class="modal fade createAnimal" id="questionBankModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel1" >
                    <div class="modal-dialog" role="document" style="text-align: center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">{{ __('messages.register_animal')}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="create-animal" method="POST" action="/animals/add"  style="text-align: center">
                                    @csrf <!--//hidden input with a token (validation)-->
                                    <select class="form-select" id="livestock-animal" aria-label="Ganado" name="livestock" required>
                                        <option  value="" selected>{{ __('messages.livestock_type_select')}}</option>
                                    </select>
                                    @error('livestock')
                                    <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                    <div class="form-group">
                                        <label for="codigo">{{ __('messages.animal_code')}}</label>
                                        <input class="form-control" type="number" name="codigo" id="code" value="{{ old('code') }}" required>
                                        @error('code')
                                        <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                                            <p>{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="raza">{{ __('messages.animal_race')}}</label>
                                        <input class="form-control" type="text" name="raza" id="race" value="{{ old('race') }}" required>
                                        @error('race')
                                        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                            <p>{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <label for="sexo">{{ __('messages.animal_gender')}}</label>
                                    <select class="form-select" aria-label="Sexo" name="genre" id="gender" required>
                                        <option value="" selected>{{ __('messages.animal_gender_select')}}</option>
                                        <option value="macho">{{ __('messages.animal_male')}}</option>
                                        <option value="hembra">{{ __('messages.animal_female')}}</option>
                                    </select>
                                    @error('genre')
                                    <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                    <div class="form-group">
                                        <label for="peso">{{ __('messages.animal_weight')}}</label>
                                        <input class="form-control" type="number" name="peso" id="weight" value="{{ old('weight') }}" required>
                                        @error('weight')
                                        <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                                            <p>{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <label for="estado">{{ __('messages.animal_health_condition')}}</label>
                                    <select class="form-select" aria-label="estado" name="health_condition" id="health_condition" required>
                                        <option value="" selected>{{ __('messages.animal_health_select')}}</option>
                                        <option value="saludable">{{ __('messages.animal_health_good')}}</option>
                                        <option value="enfermo">{{ __('messages.animal_health_bad')}}</option>
                                    </select>
                                    @error('health_condition')
                                    <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                    <div class="form-group">
                                        <label for="notas">{{ __('messages.animal_observations')}}</label>
                                        <textarea class="form-control" id="observations" name="observations" rows="3" required></textarea>
                                        @error('observations')
                                        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                            <p>{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="alimentacion">{{ __('messages.animal_food')}}</label>
                                        <select class="form-select" id="food" aria-label="Ganado" name="alimentacion" required>
                                            <option  value="" selected>{{ __('messages.animal_food_select')}}</option>
                                        </select>
                                        @error('food')
                                        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                            <p>{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="produccion">{{ __('messages.animal_prod')}}</label>
                                        <select class="form-select" id="production" aria-label="Ganado" name="produccion" required>
                                            <option  value="" selected>{{ __('messages.animal_prod_select')}}</option>
                                        </select>
                                        @error('production')
                                        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                            <p>{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="f_nacimiento">{{ __('messages.animal_date')}}</label>
                                        <input class="form-control" type="date" name="f_nacimiento" id="birth_date" value="{{ old('birth_date') }}" required>
                                        @error('birth_date')
                                        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                            <p>{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <button style="margin: 20px; " class="btn btn-outline-dark" data-mdb-ripple-color="dark">{{ __('messages.user_register')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
              

     
    <!-- Modal 3 -->
    <div class="modal fade editparams" id="staticBackdrop3" tabindex="-1" aria-labelledby="staticBackdropLabel" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{__('messages.animal_biological_control')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="edit-animal" method="POST" action="animals/update">
                        @csrf <!--//hidden input with a token (validation)-->

                                <div class="form-group">
                                    <label for="peso">{{__('messages.animal_weight')}}</label>
                                    <input class="form-control" type="number" name="animalweight" id="animal-weight" value="" required>
                                    @error('weight')
                                    <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                </div>

                                <label for="estado">{{__('messages.animal_food')}}</label>
                                <select class="form-select" aria-label="estado" name="animalfood" id="animal-food" required>
                                    <option value="" selected>{{__('messages.animal_food_select')}}</option>
                                </select>
                                @error('health_condition')
                                <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                    <p>{{ $message }}</p>
                                </div>
                                @enderror

                                <label for="estado">{{__('messages.animal_prod')}}</label>
                                <select class="form-select" aria-label="estado" name="animalproduction" id="animal-production" required>
                                    <option value="" selected>{{__('messages.animal_prod_select')}}</option>
                                </select>
                                @error('health_condition')
                                <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                    <p>{{ $message }}</p>
                                </div>
                                @enderror
                                <button type="submit" class="edit btn btn-outline-info">{{ __('messages.animal_confirm')}}</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>            
    
                <!-- Modal 4-->
    <div class="modal fade treat-modal" id="staticBackdrop4" tabindex="-1" aria-labelledby="staticBackdropLabel" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{__('messages.request_treatment')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" style="text-align: center" class="treatForm">
                        @csrf
                        <div>
                            <label for="n_treats">{{__('messages.n_visits')}}</label>
                            <input class="form-control" type="number" id="n_treats" name="n_treats" placeholder="{{__('messages.n_visits_text')}}" required>
                        </div>
                        @error('n_treats')
                        <span style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">{{ $message }}</span>
                        @enderror
                        <div>
                            <label for="n_days_between">{{__('messages.n_days_between')}}</label>
                            <input class="form-control" type="number" name="n_days_between" id="n_days_between" placeholder="{{__('messages.n_visits_text')}}" required>
                        </div>
                        @error('n_days_between')
                        <span style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="f_nacimiento">{{__('messages.treat_starts')}}</label>
                            <input class="form-control" type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        <input type="hidden" id="treat_code"  name="treat_code" value="">
                        <div>
                            <button type="submit" class="btn btn-outline-success" data-mdb-ripple-color="success" style="margin: 5px">{{__('messages.animal_confirm')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    
    
    <!-- Modal 5-->
    <div class="modal fade notificationmodal" id="staticBackdrop5" tabindex="-1" aria-labelledby="staticBackdropLabel" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{__('messages.notify_patology')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" style="text-align: center" class="notification-form">
                        @csrf
                        <div class="form-group">
                            <label for="notas">{{__('messages.issue_explain')}}</label>
                            <textarea class="form-control" id="patology" name="patology" rows="3" required></textarea>
                            @error('patology')
                            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                        </div>
                        @error('type')
                        <span style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">{{ $message }}</span>
                        @enderror
                        <div>
                            <button type="submit" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="margin: 5px" >{{__('messages.notify')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal 6-->
    <div class="modal fade sell-modal" id="staticBackdrop6" tabindex="-1" aria-labelledby="staticBackdropLabel" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{__('messages.livestock_sell_animal')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" style="text-align: center" class="sellForm">
                        @csrf
                        <label>{{__('messages.livestock_name')}}</label>
                        <select class="form-select" id="livestock_sell" aria-label="Ganado" name="livestock_sell" required>
                            <option  value="" selected>{{__('messages.livestock_type_select')}}</option>
                        </select>
                        @error('livestock')
                        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                            <p>{{ $message }}</p>
                        </div>
                        @enderror
                        <div class="cont-peso">
                            <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="f_nacimiento">{{__('messages.min_weight')}}</label>
                                    <input class="form-control" type="number" name="animal_weight_sell" id="animal_weight_sell" placeholder="{{__('messages.n_visits_text')}}" required>
                                    @error('start_date')
                                    <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="f_nacimiento">{{__('messages.max_weight')}}</label>
                                    <input class="form-control" type="number" name="animal_weightmax_sell" id="animal_weightmax_sell" placeholder="{{__('messages.n_visits_text')}}" required>
                                    @error('start_date')
                                    <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="cont-edad">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="f_nacimiento">{{__('messages.min_age')}}</label>
                                        <input class="form-control" type="number" name="animal_age_sell" id="animal_age_sell" placeholder="{{__('messages.n_visits_text')}}" required>
                                        @error('start_date')
                                        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                            <p>{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="f_nacimiento">{{__('messages.max_age')}}</label>
                                        <input class="form-control" type="number" name="animal_agemax_sell" id="animal_agemax_sell" placeholder="{{__('messages.n_visits_text')}}" required>
                                        @error('start_date')
                                        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                                            <p>{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="n_days_between">{{__('messages.how_many')}}</label>
                            <p class="advice_animal" style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white"></p>
                            <input class="form-control" type="number" name="n_animals_sell" id="n_animals_sell" placeholder="{{__('messages.n_visits_text')}}" required>
                        </div>
                        @error('n_animals')
                        <span style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">{{ $message }}</span>
                        @enderror
    
                        <div>
                            <button type="submit" class="btn btn-outline-success" data-mdb-ripple-color="success" style="margin: 5px">{{__('messages.sell')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    @section('js')
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js" integrity="sha512-1/8DJLhOONj7obS4tw+A/2yb/cK9w5vWP+L4liQKYX/JeLZ/cqDuZfgDha4NK/kR/6b5IzHpS7/w80v4ED+8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js" integrity="sha512-v0vjOquuhHQslRkq1a5BwUIyKSD7ZbgFfQv4jzSBGwbIVTCOs5JQdotZVoRjPRzb9UToTvuP2kdR5CVE4TLgMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            </script>
        <script src="js/livestock.js"></script>
        <script type="text/javascript">
            $('#pdf').on('click', function () {
                const { jsPDF } = window.jspdf;
                var doc = new jsPDF()
                doc.autoTable({ html: '.table' })
                doc.save('tabla-ganado.pdf')
            });
            
        </script>
    @endsection
</x-homepage>
