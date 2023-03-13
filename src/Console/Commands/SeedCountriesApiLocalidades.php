<?php

namespace andcarpi\LaravelEnderecoETelefone\Console\Commands;

use andcarpi\LaravelEnderecoETelefone\Models\Pais;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SeedCountriesApiLocalidades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enderecos:seed-paises';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insere dados dos países utilizando a API Paises do IBGE';

    protected $url = 'https://servicodados.ibge.gov.br/api/v1/localidades/paises?orderBy=nome';

    protected $insert_fields = [
        'id' => 16,
        'iso' => 0,
        'iso3' => 1,
        'nome' => 4,
        //'currency'      => 10,
        //'currency_name' => 11,
        //'language'      => 15,
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
        $request = Http::withoutVerifying()->get($this->url);
        if ($request->status() == 200) {
            $this->line('Download completo. Inserindo informações.');
            DB::transaction(function () use ($request) {
                $countries = $request->json();
                foreach ($countries as $country) {
                    Pais::InsertOrIgnore([
                        'id' => $country['id']['M49'],
                        'iso' => $country['id']['ISO-ALPHA-2'],
                        'iso3' => $country['id']['ISO-ALPHA-3'],
                        'nome' => $country['nome'],
                    ]);
                }
                $this->info('Inserção de dados completa. '.count($countries).' países cadastrados.');
            });

            return 0;
        }
        $this->error('Falha ao inserir os países. Verifique sua conexão com a internet ou se o link de download ainda é ativo.');
    }
}
