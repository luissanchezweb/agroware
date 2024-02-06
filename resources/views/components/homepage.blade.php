<!DOCTYPE html>
<html>
<head>
    <title>AgroWare</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('css')
    <style>
        
            body{
                background-image: url('../img/palm_leaf.png')
            }
        
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
</head>
<body>
        <div class="container-fluid overflow-hidden">
            <div class="row vh-100 overflow-auto">
                <div class="col-12 col-sm-3 col-xl-2 px-sm-2 px-0 bg-dark d-flex sticky-top">
                    <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                        <a class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                            <form action="{{ route('languageChange')}}" method="POST">
                                @csrf
                                <select name="language" onchange="this.form.submit()" class="bg-dark" style="color: white; background-color:	RGB(52, 58, 64); border:none">
                                    <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="es" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>Español</option>
                                </select>
                            </form>
                        </a>
                        <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                            <li >
                                <a href="/homepage" class="nav-link px-sm-0 px-2" >
                                    <i class="fa-solid fa-home" style="color: green"></i><span class="ms-1 d-none d-sm-inline" style="color: white; margin-top:50px">{{ trans('messages.navbar_home')}}</span> </a>
                            </li>
                            @if(auth()->user()->hasRole('Gerente'))
                                <li>
                                    <a href="/users" class="nav-link px-sm-0 px-2">
                                    <i class="fa fa-users" style="color: green"></i><span class="ms-1 d-none d-sm-inline" style="color: white; margin-top:50px">{{ trans('messages.navbar_workers')}}</span> </a>
                                </li>
                            @endif
                            <li>
                                <a href="/issues/{{auth()->user()->id}}" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-circle-exclamation" style="color: green"></i><span class="ms-1 d-none d-sm-inline" style="color: white; margin-top:50px">{{ trans('messages.navbar_issues')}}</span> </a>
                            </li>
                            <li>
                                <a href="/livestock" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-cow" style="color: green"></i><span class="ms-1 d-none d-sm-inline" style="color: white; margin-top:50px">{{ trans('messages.navbar_livestock')}}</span> </a>
                            </li>
                            <li>
                                <a href="/tasks" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-tractor" style="color: green"></i><span class="ms-1 d-none d-sm-inline" style="color: white; margin-top:50px">{{ trans('messages.navbar_tasks')}}</span> </a>
                            </li>
                            <li>
                                <a href="/fullcalender" class="nav-link px-sm-0 px-2">
                                    <i class="fa-regular fa-calendar-days" style="color: green"></i> <span class="ms-1 d-none d-sm-inline" style="color: white; margin-top:50px">{{ trans('messages.navbar_calendar')}}</span> </a>
                            </li>
                            <li>
                                <a href="/about" class="nav-link px-sm-0 px-2">
                                <i class="fa fa-user" style="color: green"></i><span class="ms-1 d-none d-sm-inline" style="color: white; margin-top:50px">{{ trans('messages.about')}}</span> </a>
                            </li>
                        </ul>
                        <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{asset(auth()->user()->avatar)}}" alt="profile" width="28" height="28" class="rounded-circle">
                                <span class="d-none d-sm-inline mx-1">{{auth()->user()->name}}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="/logout"> {{ __('messages.logout')}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col d-flex flex-column h-100  col-sm-9">
                    
                    {{ $slot }} 
                </div>
            </div>
        </div>
        <div class="content">
            
        </div>


@yield('js')
</body>
</html>
