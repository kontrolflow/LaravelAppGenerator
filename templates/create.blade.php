@extends('bs.card')

@section('javascript')
@endsection

@section('title', 'Add $modelDisplayName$ Form')

@section('nav')
    @include('bs.nav')
@endsection

@section('cardHeader')
    <b>Add $modelDisplayName$ Form</b>
@endsection

@section('cardBody')
    <form method='POST' action='/#ROUTE#'>
        @csrf
$formFields$
        <button type="submit" class="btn btn-danger btn-block">Add $modelDisplayName$</button>
    </form>
@endsection
