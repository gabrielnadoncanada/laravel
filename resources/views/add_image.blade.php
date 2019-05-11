@extends('layouts.app')
 
@section('content')
<div class="container">
    <div class="row justify-content-center">

    <!-- form to add a new custom location -->
       
        <div class="col-md-12">
           <form action="{{ url("location_add") }}"  method="POST" class="form-horizontal">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Verifiez les informations
                </div>
            @endif
            <div class="form-group">
                <label for="task" class="col-sm-3 control-label">Ajouter un emplacement</label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="task-name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                    @if($errors->has('name'))
                      <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        Validez
                    </button>
                </div>
            </div>
          </form>
        </div>

    <!-- form to upload an image with location -->

        <div class="col-md-12">
           <form action="{{ url("image_add") }}"  method="POST" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Verifiez les informations
                </div>
            @endif
            <div class="form-group">
                <label for="location_id" class="col-sm-3 control-label">Emplacement(s) disponible(s)</label>
                <div class="col-sm-6">
                    <select name="location_id" id="location_id" class="form-control {{ $errors->has('location_id') ? 'is-invalid' : '' }}">
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach    
                    </select>
                    @if($errors->has('location_id'))
                      <div class="invalid-feedback">{{ $errors->first('location_id') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="task" class="col-sm-3 control-label">Ajouter une image</label>
                <div class="col-sm-6">
                    <input type="file" name="image" id="image" class="{{ $errors->has('image') ? 'is-invalid' : '' }}">
                    @if($errors->has('image'))
                      <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        Soumettre
                    </button>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
@endsection