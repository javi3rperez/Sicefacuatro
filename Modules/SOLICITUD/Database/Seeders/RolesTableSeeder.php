<?php 

namespace Modules\SOLICITUD\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\SICA\Entities\App;
use Modules\SICA\Entities\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $app = App::where('name', 'SOLICITUD')->firstOrFail();

        $roladmin = Role::updateOrCreate(['slug' => 'solicitud.admin'], [
            'name' => 'Administrador',
            'description' => 'Rol administrador de la aplicación SOLICITUD',
            'description_english' => 'Administrator role of the SOLICITUD application',
            'full_access' => 'No',
            'app_id' => $app->id,
        ]);

        $useradministrador = User::where('nickname', 'Yperez')->firstOrFail();
        $useradministrador->roles()->syncWithoutDetaching([$roladmin->id]);

        // Rol de usuario líder
        $rolstore = Role::updateOrCreate(['slug' => 'solicitud.store'], [ 
            'name' => 'Instructor lider',
            'description' => 'Rol instructor lider de la aplicación SOLICITUD',
            'description_english' => 'lead instructor role of the SOLICITUD application',
            'full_access' => 'No',
            'app_id' => $app->id,
        ]);

        $userstore = User::where('nickname', 'Yulyfa')->firstOrFail();
        $userstore->roles()->syncWithoutDetaching([$rolstore->id]);
    }
};
