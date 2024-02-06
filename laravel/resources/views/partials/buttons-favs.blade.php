@can('favorite', $place)
<form method="POST" action="{{ route('places.favorite', $place) }}" style="display: inline-block;">
    @csrf
    <x-secondary-button type="submit">➕❤️</x-primary-button>
</form>
@elsecan('unfavorite', $place)
<form method="POST" action="{{ route('places.unfavorite', $place) }}" style="display: inline-block;">
    @csrf
    @method("DELETE")
    <x-secondary-button type="submit">➖❤️</x-secondary-button>
</form>
@endcan