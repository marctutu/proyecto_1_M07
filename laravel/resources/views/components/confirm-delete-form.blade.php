<p>{{ __("Are you sure you want to delete this element?") }}</p>
<form method="POST" action="{{ route($parentRoute . '.destroy', $model) }}">
    @csrf
    @method("DELETE")
    <div class="mt-4">
        <x-danger-button>
            {{ __('Confirm delete') }}
        </x-danger-button>
        <x-secondary-button href="{{ route($parentRoute . '.index') }}">
            {{ __('Back to list') }}
        </x-secondary-button>        
    </div>
</form>