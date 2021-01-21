<?php

namespace Andcarpi\LaravelEnderecoETelefone\Console\Commands;

use Andcarpi\LaravelEnderecoETelefone\Models\City;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SeedBrazilianCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addresses:seed-brazilian-cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Cities Table with Brazilian Cities using IBGE information.';

    protected $url = 'http://servicodados.ibge.gov.br/api/v1/localidades/municipios';

    protected $insert_fields = [
        'id'            => 'id',
        'name'          => 'nome',
    ];

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
        $this->line('Downloading cities information...');
        $request = Http::get($this->url);
        if ($request->status() == 200) {
            $this->line('Download complete. Seeding started.');
            DB::transaction(function () use ($request) {
                $cities = $request->json();
                foreach($cities as $city_info) {
                    $city = new City();
                    foreach ($this->insert_fields as $field => $index) {
                        $city->{$field} = $city_info[$index];
                    }
                    $city->state_id = $city_info['microrregiao']['mesorregiao']['UF']['id'];
                    $city->save();
                };
                $this->info('Seeding complete. ' . count($cities) . ' cities added.');
            });
            return 0;
        }
        $this->error('Failed to download and seed cities. Verify your internet connection and/or url link.');

    }
}
