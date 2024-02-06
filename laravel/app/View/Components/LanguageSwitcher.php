<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale;
    public array $availableLocales;

    /**
    * Create a new component instance.
    */
    public function __construct()
    {
        $this->currentLocale = app()->getLocale();
        $this->availableLocales = config('app.available_locales', ['en' => 'English']);
    }

    /**
    * Get the view / contents that represent the component.
    */
    public function render(): View|Closure|string
    {
        return view('components.language-switcher');
    }
}
