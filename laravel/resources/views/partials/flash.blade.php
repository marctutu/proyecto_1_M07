<div id="flash">
@if ($message = Session::get('success'))
    @include('partials.flash-message', ['type' => "success", 'message' => $message])
@endif
@if ($message = Session::get('error'))
    @include('partials.flash-message', ['type' => "danger", 'message' => $message])
@endif
@if ($message = Session::get('warning'))
    @include('partials.flash-message', ['type' => "warning", 'message' => $message])
@endif
@if ($message = Session::get('info'))
    @include('partials.flash-message', ['type' => "info", 'message' => $message])
@endif
@if ($errors->any())
    @foreach ($errors->all() as $error)
        @include('partials.flash-message', ['type' => "danger", 'message' => $error])
    @endforeach
@endif
</div>

<script>
    document.querySelectorAll(".close-flash-message").forEach(function(element) {
        element.addEventListener('click', function() {
            this.parentNode.remove()
        });
    });
</script>