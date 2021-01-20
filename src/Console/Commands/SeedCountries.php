<?php

namespace Andcarpi\LaravelEnderecoETelefone\Console\Commands;

use Andcarpi\LaravelEnderecoETelefone\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SeedCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Countries with geoname.org info';

    protected $url = 'http://download.geonames.org/export/dump/countryInfo.txt';

    protected $insert_fields = [
        'id'            => 16,
        'iso'           =>  0,
        'iso3'          =>  1,
        'name'          =>  4,
        'currency'      => 10,
        'currency_name' => 11,
        'language'      => 15,
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
        $this->line('Downloading country information...');
        $request = Http::get($this->url);
        if ($request->status() == 200) {
            $this->line('Download complete. Seeding started.');
            DB::transaction(function () use ($request) {
                $geonames_countries = Collect(preg_split('/\n\r|\n/', $request->body()))
                    ->filter(function ($value, $key) {
                        return (!Str::startsWith($value, '#')) and !empty($item);
                    })->each(function ($value, $key) {
                        $info = preg_split('/\t/', $value);
                        $country = new Country();
                        foreach ($this->insert_fields as $field => $index) {
                            $country->{$field} = $info[$index];
                        }
                        $country->save();
                    });
                $this->info('Seeding complete. ' . $geonames_countries->count() . ' countries added.');
            });
            return 0;
        }
        $this->error('Failed to download and seed countries. Verify your internet connection and/or url link.');

    }
}
