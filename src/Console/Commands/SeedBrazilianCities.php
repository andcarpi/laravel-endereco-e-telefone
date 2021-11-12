<?php

namespace andcarpi\LaravelEnderecoETelefone\Console\Commands;

use andcarpi\LaravelEnderecoETelefone\Models\Cidade;
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
    protected $signature = 'enderecos:seed-cidades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Cities Table with Brazilian Cities using IBGE information.';

    protected $url = 'http://servicodados.ibge.gov.br/api/v1/localidades/municipios';

    protected $insert_fields = [
        'id'            => 'id',
        'nome'          => 'nome',
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
        $this->line('Fazendo o download das informações...');
        $request = Http::get($this->url);
        if ($request->status() == 200) {
            $this->line('Download completo. Inserindo informações.');
            DB::transaction(function () use ($request) {
                $cities = $request->json();
                foreach($cities as $city_info) {
                    $city = new Cidade();
                    foreach ($this->insert_fields as $field => $index) {
                        $city->{$field} = $city_info[$index];
                    }
                    $city->estado_id = $city_info['microrregiao']['mesorregiao']['UF']['id'];
                    $city->save();
                };
                $this->info('Inserção de dados completa. ' . count($cities) . ' cidades cadastrados.');
            });
            return 0;
        }
        $this->error('Falha ao inserir as cidades. Verifique sua conexão com a internet ou se o link de download ainda é ativo');

    }
}
