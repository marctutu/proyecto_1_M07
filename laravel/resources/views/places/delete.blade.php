@extends('layouts.box-app')

@section('box-title')
    {{ __('Place') . " " . $place->id }}
@endsection

@section('box-content')
    <x-confirm-delete-form parentRoute='places' :model=$place />
@endsection