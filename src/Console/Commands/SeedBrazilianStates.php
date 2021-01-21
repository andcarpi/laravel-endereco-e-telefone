<?php

namespace Andcarpi\LaravelEnderecoETelefone\Console\Commands;

use Andcarpi\LaravelEnderecoETelefone\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SeedBrazilianStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addresses:seed-brazilian-states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed States Table with Brazilian States using IBGE information.';

    protected $url = 'http://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome';

    protected $insert_fields = [
        'id'            => 'id',
        'abbreviation'  => 'sigla',
        'name'          => 'nome',
    ];

    protected $brazil_id = 3469034;

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
        $this->line('Downloading states information...');
        $request = Http::get($this->url);
        if ($request->status() == 200) {
            $this->line('Download complete. Seeding started.');
            DB::transaction(function () use ($request) {
                $states = $request->json();
                foreach($states as $state_info) {
                    $state = new State();
                    foreach ($this->insert_fields as $field => $index) {
                        $state->{$field} = $state_info[$index];
                    }
                    $state->country_id = $this->brazil_id;
                    $state->save();
                };
                $this->info('Seeding complete. ' . count($states) . ' states added.');
            });
            return 0;
        }
        $this->error('Failed to download and seed states. Verify your internet connection and/or url link.');

    }
}
