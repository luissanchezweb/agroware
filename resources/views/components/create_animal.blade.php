<x-homepage>
    <form class="form" method="POST" action="/animals/add" style="text-align: center">
        @csrf <!--//hidden input with a token (validation)-->
        <select class="form-select" id="livestock" aria-label="Ganado" name="livestock" required>
            <option  value="">Tipo de ganado...</option>
        </select>
        @error('genre')
        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
            <p>{{ $message }}</p>
        </div>
        @enderror
        <div class="form-group">
            <label for="code">Código del animal</label>
            <input class="form-control" type="number" name="code" id="code" value="{{ old('code') }}" required>
            @error('code')
            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="race">Raza</label>
            <input class="form-control" type="text" name="race" id="race" value="{{ old('race') }}" required>
            @error('race')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <label for="genre">Sexo</label>
        <select class="form-select" aria-label="genre" name="genre" required>
            <option value="" selected>Selecciona un género...</option>
            <option value="macho">Macho</option>
            <option value="hembra">Hembra</option>
        </select>
            @error('genre')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        <div class="form-group">
            <label for="edad">Edad</label>
            <input class="form-control" type="number" name="age" id="age" value="{{ old('age') }}" required>
            @error('age')
            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="peso">Peso</label>
            <input class="form-control" type="number" name="weight" id="weight" value="{{ old('weight') }}" required>
            @error('weight')
            <div style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <label for="estado">Estado de salud</label>
        <select class="form-select" aria-label="estado" name="health_condition" id="health_condition" required>
            <option value="" selected>Selecciona un estado...</option>
            <option value="saludable">Sano</option>
            <option value="enfermo">Enfermo</option>
            <option value="tratamiento">Tratamiento</option>
        </select>
        @error('health_condition')
        <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
            <p>{{ $message }}</p>
        </div>
        @enderror
        <div class="form-group">
            <label for="notas">Notas</label>
            <textarea class="form-control" id="observations" name="observations" rows="3" required></textarea>
            @error('observations')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="alimentacion">Alimentación</label>
            <input class="form-control" type="text" name="food" id="food" value="{{ old('food') }}" required>
            @error('food')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="produccion">Produccion</label>
            <input class="form-control" type="text" name="production" id="production" value="{{ old('production') }}" required>
            @error('production')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="f_nacimiento">Fecha de nacimiento</label>
            <input class="form-control" type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required>
            @error('birth_date')
            <div style="margin: 3px; background-color: #2d3748; border-radius: 5px; color: white">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <button style="margin: 20px; " type="submit" class="btn btn-outline-dark" data-mdb-ripple-color="dark">Submit</button>
    </form>

    @section('js')
        <script src="/js/animal_add.js"></script>
    @endsection
</x-homepage>
