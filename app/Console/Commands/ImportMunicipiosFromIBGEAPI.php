<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MunicipioController;

class ImportMunicipiosFromIBGEAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'municipios:import {uf}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa para o Banco de dados os munícipios da UF desejada via API do IBGE.';

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
        $this->info(
            MunicipioController::ImportMunicipiosFromIBGEAPI($this->argument('uf'))
        );
        return 0;
    }
}
