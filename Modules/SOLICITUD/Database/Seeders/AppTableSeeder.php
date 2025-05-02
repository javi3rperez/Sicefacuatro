<?php

namespace Modules\SOLICITUD\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SICA\Entities\App;

class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        $app = App::updateOrCreate([
            'name' => 'SOLICITUD'
        ], [
            'url' => '/solicitud/index',
            'color' => '#1f9c08',
            'icon' => 'fas fa-envelope-open-text',
            'description' => 'Sistema de Gestion de SOLICITUD',
            'description_english' => 'SOLICITUD management system',
        ]);
    }
}


