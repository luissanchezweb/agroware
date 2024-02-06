<!DOCTYPE html>
<html>
<head>
    <title>AgroWare</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/welcome.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    <style>
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
<div class="container">
    <div class="row">
        <div class="col-md-8 col-12">
            <img src="/img/logo-agro.png" class="img-fluid">
            <h5>Diseñado para hacer tu explotación más segura, sostenible y rentable.</h5>
            <div class="col-12 funciones" style="margin-bottom: 5px;">
                <div class="row">
                    <div class="col-6" style="text-align: center; padding: 10px;">
                        <img src="/img/cuaderno.png" class="icon">
                        <p style="color: white; opacity: 1">Gestión de incidencias</p>
                    </div>
                    <div class="col-6" style="text-align: center; padding: 10px;">
                        <img src="/img/ganado.png" class="icon">
                        <p style="color: white; opacity: 1">Climatología</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="text-align: center; padding: 10px;">
                        <img src="/img/tareas.png" class="icon">
                        <p style="color: white; opacity: 1">Asignación de tareas</p>
                    </div>
                    <div class="col-6" style="text-align: center; padding: 10px;">
                        <img src="/img/clima.png" class="icon">
                        <p style="color: white; opacity: 1">Control de ganado</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12" style="box-shadow: 10px 5px 5px black; background: linear-gradient(to right bottom, #2f3441 50%, #212531 50%);">
            @if (auth()->check())
                <a href="/homepage" class="btn btn-dark">Acceder</a>
            @else
                <h2 style="text-align: center; color:white">Acceso</h2>
                <x-login_form/>
            @endif
        </div>
    </div>
</div>
</body>
</html>
