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

           // Rol del instructor líder
        $rolleader = Role::updateOrCreate(['slug' => 'solicitud.leader'], [ 
            'name' => 'Instructor lider',
            'description' => 'Rol instructor lider de la aplicación SOLICITUD',
            'description_english' => 'lead instructor role of the SOLICITUD application',
            'full_access' => 'No',
            'app_id' => $app->id,
        ]);

        $userleader = User::where('nickname', 'Laupe')->firstOrFail();
        $userleader->roles()->syncWithoutDetaching([$rolleader->id]);

        // Rol de bodega
        $rolstore = Role::updateOrCreate(['slug' => 'solicitud.store'], [ 
            'name' => 'Bodega',
            'description' => 'Rol bodega de la aplicación SOLICITUD',
            'description_english' => 'store role of the SOLICITUD application',
            'full_access' => 'No',
            'app_id' => $app->id,
        ]);

        $userstore = User::where('nickname', 'Yulyfa')->firstOrFail();
        $userstore->roles()->syncWithoutDetaching([$rolstore->id]);

        // Rol de instructor
        $rolinstructor = Role::updateOrCreate(['slug' => 'solicitud.instructor'], [ 
            'name' => 'Instructor',
            'description' => 'Rol instructor de la aplicación SOLICITUD',
            'description_english' => 'instructor role of the SOLICITUD application',
            'full_access' => 'No',
            'app_id' => $app->id,
        ]);

        $userinstructor = User::where('nickname', 'Dsanchez')->firstOrFail();
        $userinstructor->roles()->syncWithoutDetaching([$rolinstructor->id]);


    }
};
