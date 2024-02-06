@extends('layouts.box-app')

@section('box-title')
    {{ __('File') . " " . $file->id }}
@endsection

@section('box-content')
    <x-confirm-delete-form parentRoute='files' :model=$file />
@endsection