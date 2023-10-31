@extends('layouts.app')

@section('content')
<!-- ... -->
<form method="POST" action="{{ route('files.update', $file) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- ... campos del formulario ... -->
    <input type="file" name="upload" required>
    <!-- ... -->
</form>
<!-- ... -->
@endsection

