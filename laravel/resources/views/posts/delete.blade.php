@extends('layouts.box-app')

@section('box-title')
    {{ __('Post') . " " . $post->id }}
@endsection

@section('box-content')
    <x-confirm-delete-form parentRoute='posts' :model=$post />
@endsection