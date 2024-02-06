<form class="form" method="POST" action="/login" style="text-align: center">
    @csrf <!--//hidden input with a token (validation)-->
    <div class="form-group" style="margin-top: 50px">
        <label for="email" style="margin: 3px; color: white; padding:5px">Correo</label>
        <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required>
        @error('email')
        <div style="margin: 3px;color: white">
            <p>{{ $message }}</p>
        </div>
        @enderror
    </div>
    <div class="form-group" style="margin-top: 30px">
        <label for="password" style="margin: 3px; color: white; padding:5px">Contraseña</label>
        <input class="form-control" type="password" name="password" id="password" required>
        @error('password')
        <div style="margin: 3px; color: white">
            <p>{{ $message }}</p>
        </div>
        @enderror
    </div>
    <button style="margin: 20px; " type="submit" class="btn btn-dark" data-mdb-ripple-color="dark">Entrar</button>
</form>
