<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        //Valdidacion login
        $this->validate($request, [
            'email'=> 'required|email',
            'password'=> 'required'
        ]);

        

        //Autenticacion
        if(!auth()->attempt($request->only('email', 'password'), $request->remember)){
            //return back regresa a la pagina anterior con el mensaje de erros guardado en  la sesion con with
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        //Redireccionar a la vista de dashboard la cual esta en el controlador de post
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
