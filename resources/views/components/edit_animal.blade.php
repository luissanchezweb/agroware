<x-homepage>
    <form class="form" method="POST" action="/animals/update/{{$animal->id}}" style="text-align: center">
        @csrf <!--//hidden input with a token (validation)-->
        <select class="form-select" id="livestock" aria-label="livestock" name="livestock" disabled>
            <option value="{{$livestock->id}}">{{$livestock->type}}</option>
        </select>
        @error('livestock')
        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
            <p>{{ $message }}</p>
        </div>
        @enderror
        <div class="form-group">
            <label for="codigo">Código del animal</label>
            <input class="form-control" type="text" name="code" id="code" value="{{$animal->code }}" disabled>
            @error('code')
            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="raza">Raza</label>
            <input class="form-control" type="text" name="race" id="race" value="{{ $animal->race }}" required>
            @error('race')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <label for="sexo">Sexo</label>
        <select class="form-select" aria-label="Sexo" name="genre" required>
            @if($animal->genre == "macho")
                <option value="macho" selected>Macho</option>
                <option value="hembra">Hembra</option>
            @else
                <option value="macho">Macho</option>
                <option value="hembra" selected>Hembra</option>
            @endif
        </select>
        @error('genre')
        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
            <p>{{ $message }}</p>
        </div>
        @enderror
        <div class="form-group">
            <label for="edad">Edad</label>
            <input class="form-control" type="number" name="age" id="age" value="{{ $animal->age }}" required>
            @error('age')
            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="peso">Peso</label>
            <input class="form-control" type="number" name="weight" id="weight" value="{{ $animal->weight }}" required>
            @error('peso')
            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <label for="estado">Estado de salud</label>
        <select class="form-select" aria-label="estado" name="health_condition" id="health_condition" required>
            @if($animal->health_condition == "saludable")
                <option value="saludable" selected>Sano</option>
                <option value="enfermo">Enfermo</option>
                <option value="tratamiento">Tratamiento</option>
            @elseif($animal->health_condition == "enfermo")
                <option value="saludable">Sano</option>
                <option value="enfermo" selected>Enfermo</option>
                <option value="tratamiento">Tratamiento</option>
            @else
                <option value="saludable">Sano</option>
                <option value="enfermo">Enfermo</option>
                <option value="tratamiento" selected>Tratamiento</option>
            @endif

        </select>
        @error('health_condition')
        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
            <p>{{ $message }}</p>
        </div>
        @enderror
        <div class="form-group">
            <label for="notas">Observaciones</label>
            <textarea class="form-control" id="observations" name="observations" rows="3" required>{{$animal->observations}}</textarea>
            @error('observations')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="alimentacion">Alimentación</label>
            <input class="form-control" type="text" name="food" id="food" value="{{ $animal->food }}" required>
            @error('food')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="produccion">Produccion</label>
            <input class="form-control" type="text" name="production" id="production" value="{{ $animal->production }}" required>
            @error('production')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="f_nacimiento">Fecha de nacimiento</label>
            <input class="form-control" type="date" name="birth_date" id="birth_date" value="{{ $animal->birth_date }}" required>
            @error('f_nacimiento')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <button style="margin: 20px; " type="submit" class="btn btn-outline-dark" data-mdb-ripple-color="dark">Editar</button>
    </form>

    @section('js')
        <script src="/js/animal_add.js"></script>
    @endsection
</x-homepage>
