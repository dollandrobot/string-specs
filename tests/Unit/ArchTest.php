<?php

declare(strict_types=1);

use App\Models\StringSet;

arch()->preset()->php();
arch()->preset()->strict()
    ->ignoring('App\Filament')
    ->ignoring(StringSet::class);
arch()->preset()->security();

arch('controllers')
    ->expect('App\Http\Controllers')
    ->not->toBeUsed();

//
