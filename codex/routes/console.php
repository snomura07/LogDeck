<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('app:hello', function (): void {
    $this->comment('LogDeck is ready.');
});
