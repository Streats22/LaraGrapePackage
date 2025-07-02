<?php

return [
    // Path to where LaraGrape should look for custom blocks (relative to base_path)
    'blocks_path' => resource_path('views/filament/blocks'),

    // (Optional) User override for blocks path. If set, this will be used instead of blocks_path.
    // Example: base_path('custom/blocks')
    'user_blocks_path' => null,

    // Path to where LaraGrape should look for published views
    'views_path' => resource_path('views/vendor/LaraGrape'),

    // Path to where LaraGrape migrations will be published
    'migrations_path' => database_path('migrations'),

    // Other settings can be added here as needed
    // 'some_option' => 'default_value',
]; 