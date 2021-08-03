<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


/**
 * Class ProyectoController
 * @package App\Http\Controllers
 */
class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    //un mildware para controlar acceso
    public function __construct(){

        //un mildware de autenticacion para poder hacer CRUD con los proyectos
        $this->middleware('auth');
    }
    

    public function index()
    {
        $proyectos = Proyecto::paginate();

        return view('proyecto.index', compact('proyectos'))
            ->with('i', (request()->input('page', 1) - 1) * $proyectos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyecto = new Proyecto();



        return view('proyecto.create', compact('proyecto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //reglas de auth
        request()->validate(Proyecto::$rules);

        //poer al proyecto en una variable para validar
        $proyecto= $request->all();
        // return $proyecto;

        if($request->hasFile('imagen')){
            //se guarde en upload y luego se inserte en public
            $proyecto['imagen']=$request->file('imagen')->store('proyecto','public');
            
            
        }

        Proyecto::create($proyecto);

        return redirect()->route('proyectos.index')
            ->with('Exito', 'Proyecto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proyecto = Proyecto::find($id);

        return view('proyecto.show', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proyecto = Proyecto::find($id);

        return view('proyecto.edit', compact('proyecto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Proyecto $proyecto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyecto $proyecto)
    {
       // request()->validate(Proyecto::$rules);

        $proyect=$request->all();
        //return $proyect;

        if($request->hasFile('imagen')){

            //borramos primero la imagen
            Storage::delete('public/'.$proyecto->imagen);
            //se guarde en upload y luego se inserte en public
            $proyect['imagen']=$request->file('imagen')->store('proyecto','public');
            
            
        }

        $proyecto->update($proyect);

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto updated successfully');
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy( $id)
    {
       ///entrega el id y por id borra
        $proyecto = Proyecto::find($id);
        // return $proyecto;

        if(!empty( $proyecto->imagen )){

            Storage::delete('public/'.$proyecto->imagen);
        }

        $proyecto->delete();

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto Borrado con exito');
    }
}
