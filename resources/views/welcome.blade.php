@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h2>Images aléatoires</h2>
        </div>
    </div>
    <div class="row">
        @foreach ($images as $image)
        <div class="col-3 mr-5 mb-3">
            <a href="{{ url("/images/{$image->id}") }}">{{ $image->title }}</a>
            <img src="{{ asset("/images/{$image->name}") }}">
            <div class="row">
                <div class="col">
                    @include('inc.delete')
                    @include('inc.report')
                    @include('inc.edit-button')
                </div>
            </div>
        </div>
        @endforeach
        {{ $images->links() }}
    </div>
</div>
@endsection