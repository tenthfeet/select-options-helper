<?php

namespace Tenthfeet\SelectOptions;

use Illuminate\Support\Facades\Blade;

class SelectOptionsServiceProvider
{
    public function boot(): void
    {
        // Blade directive
        Blade::directive('options', function ($expression) {
            return "<?php echo generate_options($expression); ?>";
        });
    }
}
