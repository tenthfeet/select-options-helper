<?php

namespace Tenthfeet\SelectOptions;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SelectOptionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Blade directive
        Blade::directive('options', function ($expression) {
            return "<?php echo generate_options($expression); ?>";
        });
    }
}
