<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {

        //Modificar el request
        $request->request->add(['username' => Str::slug($request->username)]);

        //Validación
        $this->validate($request, [
            'username' => ['required', 'unique:users,username,'.auth()->user()->id,'min:3','max:20', 'not_in:twitter,editar-perfil'],
            'email' => ['required', 'unique:users,email,'.auth()->user()->id],            
        ]);

        if($request->imagen){
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            $imagenPath= public_path('perfiles'). '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        

        //Guardar Cambios
        $usuario = User::find(auth()->user()->id);

        $usuario->username = $request->username;
        $usuario->email= $request->email;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        /* //Autenticacion
        if($request->password AND !auth()->attempt($request->only('password') )){
            //return back regresa a la pagina anterior con el mensaje de erros guardado en  la sesion con with
            return back()->with('mensaje', 'Password Anterior Incorrecto');
        }
        $usuario->password = Hash::make($request->new_password); */
        
        $usuario->save();

        //Redireccionar al usuario
        return redirect()->route('posts.index', $usuario->username);
    }
}
