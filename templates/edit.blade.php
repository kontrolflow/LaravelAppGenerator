@extends('bs.card')

@section('javascript')
@endsection

@section('title', 'Edit Name Form')

@section('nav')
    @include('bs.nav')
@endsection

@section('cardHeader')
    <form method='POST' action='/#ROUTE#/{{ $camelCase->id }}'>
        <b>Edit Name Form</b>
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm float-right" href="{{ $deleteUrl }}" role="button">Delete</button>
    </form>
@endsection

@section('cardBody')
    <form method='POST' action='/#ROUTE#/{{ $camelCase->id }}'>
        @csrf
        @method('PUT')

$formFields$
        <button type="submit" class="btn btn-danger btn-block">Edit Name</button>
    </form>
@endsection