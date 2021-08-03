@extends('layouts.app')

@section('template_title')
    Update Proyecto
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Proyecto</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('proyectos.update', $proyecto) }}"  method="post" enctype="multipart/form-data">
                           @method("patch")
                            @csrf

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="text" name="nombre" value="{{$proyecto->nombre}}" class="form-control"  aria-describedby="emailHelp">
                                
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="file" name="imagen"  class="form-control"  aria-describedby="emailHelp">
                                <div  class="form-text">We'll never share your email with anyone else.</div>
                                @if ($proyecto->imagen)
                                <img class="img-fluid" src="{{ asset('storage/'.$proyecto->imagen) }}"  alt="..." />
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="text" name="descripcion" value="{{$proyecto->descripcion}}" class="form-control"  aria-describedby="emailHelp">
                                {{-- @error($error)
                                    <div  class="form-text">{{ $error }}</div>
                                @enderror --}}

                               
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="text" name="url" value="{{$proyecto->url}}" class="form-control"  aria-describedby="emailHelp">
                                {{-- @error($error)
                                    <div  class="form-text">{{ $error }}</div>
                                @enderror --}}
                            </div>

                            <button type="submit" class="btn btn-primary">Editar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
