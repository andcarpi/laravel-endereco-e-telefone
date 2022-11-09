<?php

namespace andcarpi\LaravelEnderecoETelefone\Console\Commands;

use andcarpi\LaravelEnderecoETelefone\Models\Estado;
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
    protected $signature = 'enderecos:seed-estados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed States Table with Brazilian States using IBGE information.';

    protected $url = 'http://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome';

    protected $insert_fields = [
        'id' => 'id',
        'abreviacao' => 'sigla',
        'nome' => 'nome',
    ];

    protected $brazil_id = 76;

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
                $states = $request->json();
                foreach ($states as $state_info) {
                    $state = new Estado();
                    foreach ($this->insert_fields as $field => $index) {
                        $state->{$field} = $state_info[$index];
                    }
                    $state->paises_id = $this->brazil_id;
                    $state->save();
                }
                $this->info('Inserção de dados completa. '.count($states).' estados cadastrados.');
            });

            return 0;
        }
        $this->error('Falha ao inserir os estados. Verifique sua conexão com a internet ou se o link de download ainda é ativo.');
    }
}
