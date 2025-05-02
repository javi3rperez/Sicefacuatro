<?php

namespace Modules\SOLICITUD\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SICA\Entities\App;
use Modules\SICA\Entities\Permission;
use Modules\SICA\Entities\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear una lista de permisos para el rol 
        $permissions_admin = []; // Lista de permisos para el rol de administrador
        
        // Consultar aplicación SICA para registrar los roles
        $app = App::where('name', 'SOLICITUD')->first();


        // Vista de configuración (Administrador)
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.admin.welcome'], [ // Registro o actualización de permiso
            'name' => 'Acceso al Rol de Administrador Solicitudes',
            'description' => 'Acceso al Rol de Administrador Solicitudes',
            'description_english' => 'Access to the Administrator Role',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id; // Almacenar permiso para rol
        // Consulta de ROLES
        $rol_admin = Role::where('slug', 'solicitud.admin')->first(); // Rol Administrador
        // Asignación de PERMISOS para los ROLES de la aplicación AGROSOFT (Sincronización de las relaciones sin eliminar las relaciones existentes)
        $rol_admin->permissions()->syncWithoutDetaching($permissions_admin);


           // Crear una lista de permisos para el rol de instructor lider
        $permissions_store = []; // Lista de permisos para el rol de instructor lider
                
           // Consultar aplicación SICA para registrar los roles
           $app = App::where('name', 'SOLICITUD')->first();
   
           // Vista de configuración (Instructor lider)
           $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.welcome'], [// Registro o actualización de permiso
               'name' => 'Acceso al Rol de instructor lider Solicitudes',
               'description' => 'Acceso al Rol de instructor lider',
               'description_english' => 'Access to the instructor lead Role',
               'app_id' => $app->id
           ]);
           $permissions_store[] = $permission->id; // Almacenar permiso para rol
           
           // Consulta de ROLES
           $rol_store = Role::where('slug','solicitud.store')->first(); // Rol Instructor lider
           // Asignación de PERMISOS para los ROLES de la aplicación Solicitud (Sincronización de las relaciones sin eliminar las relaciones existentes)
           $rol_store->permissions()->syncWithoutDetaching($permissions_store);

    }
}