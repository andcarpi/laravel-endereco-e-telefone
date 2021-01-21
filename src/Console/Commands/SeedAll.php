<?php

namespace Andcarpi\LaravelEnderecoETelefone\Console\Commands;

use Illuminate\Console\Command;

class SeedAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addresses:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and Seed the countries, states (only with Brazil info) and cities (only with Brazil info) tables.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('addresses:seed-countries');
        $this->call('addresses:seed-brazilian-states');
        $this->call('addresses:seed-brazilian-cities');
    }
}
