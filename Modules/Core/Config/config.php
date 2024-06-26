<?php

return [
    'themes' => [
        /**
         * Absolute paths as to where stylist can discover themes.
         */
        'paths' => [
            base_path('Themes'),
        ],

        /**
         * Specify the name of the theme that you wish to activate. This should be the same
         * as the theme name that is defined within that theme's json file.
         */
        'activate' => null,
    ],
    /*
    |--------------------------------------------------------------------------
    | These are the core modules that should NOT be disabled under any circumstance
    |--------------------------------------------------------------------------
    */
    'CoreModules' => [
        'core',
        'dashboard',
        'user',
        'workshop',
        'setting',
        'media',
        'tag',
        'page',
        'translation',
    ],

    /*
    |--------------------------------------------------------------------------
    | Load additional view namespaces for a module
    |--------------------------------------------------------------------------
    | You can specify place from which you would like to use module views.
    | You can use any combination, but generally it's advisable to add only one,
    | extra view namespace.
    | By default every extra namespace will be set to false.
    */
    'useViewNamespaces' => [
        // Read module views from /Themes/<backend-theme-name>/views/modules/<module-name>
        'backend-theme' => false,
        // Read module views from /Themes/<frontend-theme-name>/views/modules/<module-name>
        'frontend-theme' => false,
        // Read module views from /resources/views/asgard/<module-name>
        'resources' => false,
    ],
];
