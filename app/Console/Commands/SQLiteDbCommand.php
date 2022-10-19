<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SQLiteDbCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:boot-tests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a sqlite database for the purpose of running tests.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $store = Storage::disk('local');
        if ($store->exists('database.sqlite')) {
            $store->delete('database.sqlite');
        }
        $store->put('database.sqlite', '');
        $store->setVisibility('database.sqlite', 'public');
    }
}
