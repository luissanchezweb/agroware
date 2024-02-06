<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /*
     * Función para cambiar el lenguaje de la aplicación
     */
    public function change(Request $request)
    {
        $language = $request->language;
        if(in_array($language, ['en','es'])){
            session(['locale' => $language]);
        }

      //Verifica si el idioma se guarda correctamente en la sesión
        return redirect()->back();
    }
}
