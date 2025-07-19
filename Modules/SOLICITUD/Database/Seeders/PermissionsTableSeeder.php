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
        

        // Aqui comienza los permissions del rol de administrador
        $permissions_admin = []; 
       
        $app = App::where('name', 'SOLICITUD')->first();

       
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.admin.welcome'], [ 
            'name' => 'Acceso al Rol de Administrador Solicitudes',
            'description' => 'Acceso al Rol de Administrador Solicitudes',
            'description_english' => 'Access to the Administrator Role',
            'app_id' => $app->id
        ]);
        //+
        $permissions_admin[] = $permission->id; 
        $rol_admin = Role::where('slug', 'solicitud.admin')->first();
        $rol_admin->permissions()->syncWithoutDetaching($permissions_admin);




         // Aqui comienza los permissions del rol del Instructor lider  
        $permissions_leader = []; 
                
          
        $app = App::where('name', 'SOLICITUD')->first();
            
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.leader.welcome'], [
               'name' => 'Acceso al Rol de instructor lider Solicitudes',
               'description' => 'Acceso al Rol de instructor lider',
               'description_english' => 'Access to the instructor lead Role',
               'app_id' => $app->id
           ]);

        $permissions_leader[] = $permission->id; 
        $rol_leader = Role::where('slug','solicitud.leader')->first(); 
        $rol_leader->permissions()->syncWithoutDetaching($permissions_leader);

        // Permiso para CRUD INVENTRIO ROL INSTRUCTOR LIDER
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.leader.inventory'], [
                'name' => 'Acceso al Rol de instructor lider para inventario',
                'description' => 'Acceso al Rol de instructor lider',
                'description_english' => 'Access to the instructor lead Role',
                'app_id' => $app->id
            ]);
        $permissions_leader[] = $permission->id;
        $rol_leader = Role::where('slug','solicitud.leader')->first(); 
        $rol_leader->permissions()->syncWithoutDetaching($permissions_leader); 

        // Permiso para CRUD CREAR SOLICITUD ROL INSTRUCTOR LIDER
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.leader.create'], [
                'name' => 'Acceso al Rol de instructor lider para solicitud',
                'description' => 'Acceso al Rol de instructor lider',
                'description_english' => 'Access to the instructor lead Role',
                'app_id' => $app->id
            ]);
        $permissions_leader[] = $permission->id;
        $rol_leader = Role::where('slug','solicitud.leader')->first(); 
        $rol_leader->permissions()->syncWithoutDetaching($permissions_leader);

        // Permiso para CRUD GUARDAR SOLICITUD ROL INSTRUCTOR LIDER
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.leader.store'], [
                'name' => 'Acceso al Rol de instructor lider para solicitud',
                'description' => 'Acceso al Rol de instructor lider',
                'description_english' => 'Access to the instructor lead Role',
                'app_id' => $app->id
            ]);
        $permissions_leader[] = $permission->id;
        $rol_leader = Role::where('slug','solicitud.leader')->first();
        $rol_leader->permissions()->syncWithoutDetaching($permissions_leader);

        // Permiso para CRUD HISTORIAL DE SOLICITUDES ROL INSTRUCTOR LIDER
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.leader.index'], [
                'name' => 'Acceso al Rol de instructor lider para solicitud',
                'description' => 'Acceso al Rol de instructor lider',
                'description_english' => 'Access to the instructor lead Role',
                'app_id' => $app->id
            ]);
        $permissions_leader[] = $permission->id;
        $rol_leader = Role::where('slug','solicitud.leader')->first(); 
        $rol_leader->permissions()->syncWithoutDetaching($permissions_leader);



      // Aqui comienza los permissions del rol de bodega 
        $permissions_store = []; 
                    
          
        $app = App::where('name', 'SOLICITUD')->first();
    
          
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.welcome'], [
                'name' => 'Acceso al Rol de bodega Solicitudes',
                'description' => 'Acceso al Rol de bodega',
                'description_english' => 'Access to the store Role',
                'app_id' => $app->id
            ]);
        $permissions_store[] = $permission->id; 
        $rol_store = Role::where('slug','solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store);


        //Permiso para CRUD INVENTRIO ROL ALMACENISTA
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.inventory'], [
                'name' => 'Acceso al Rol de almacenista para inventario',
                'description' => 'Acceso al Rol de Almacenista',
                'description_english' => 'Access to the Warehouse Role',
                'app_id' => $app->id
            ]);
        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug','solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store); 

        // Permiso para CRUD PRODUCTOS ROL ALMACENISTA
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.products'], [
            'name' => 'Acceso al Rol de almacenista para productos',
            'description' => 'Acceso al CRUD de Productos',
            'description_english' => 'Access to Products CRUD',
            'app_id' => $app->id
        ]);

        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug', 'solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store);
        
        // Permiso para CRUD CATEGORIA ROL ALMACENISTA
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.categories'], [
            'name' => 'Acceso al Rol de almacenista para categorias',
            'description' => 'Acceso al CRUD de Productos',
            'description_english' => 'Access to Categories CRUD',
            'app_id' => $app->id
        ]);

        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug', 'solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store);

        // Permiso para CRUD LISTA DE SOLICITUDES ROL ALMACENISTA
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.list'], [
            'name' => 'Acceso al Rol de almacenista para listas de solicitud',
            'description' => 'Acceso al CRUD de listas de solicitud',
            'description_english' => 'Access to List CRUD',
            'app_id' => $app->id
        ]);

        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug', 'solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store);
        
        // Permiso para CRUD LOTES ROL ALMACENISTA
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.lots'], [
            'name' => 'Acceso al Rol de almacenista para lotes',
            'description' => 'Acceso al CRUD de lotes',
            'description_english' => 'Access to Lots CRUD',
            'app_id' => $app->id
        ]);

        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug', 'solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store);
        
        // Permiso para CRUD EVIDENCIA ROL ALMACENISTA
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.evidence'], [
            'name' => 'Acceso al Rol de almacenista para Evidencia',
            'description' => 'Acceso al CRUD de Evidencia',
            'description_english' => 'Access to Evidencia CRUD',
            'app_id' => $app->id
        ]);

        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug', 'solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store);

            
        // Permisos del rol de instructor
        $permissions_instructor = [];

        // Bienvenida
        $permissions_instructor[] = Permission::updateOrCreate(
            ['slug' => 'solicitud.instructor.welcome'],
            [
                'name' => 'Acceso al panel de Instructor',
                'description' => 'Permite ver la pantalla de bienvenida del instructor',
                'description_english' => 'Access to Instructor dashboard',
                'app_id' => $app->id
            ]
        )->id;

        // Inventario
        $permissions_instructor[] = Permission::updateOrCreate(
            ['slug' => 'solicitud.instructor.inventory'],
            [
                'name' => 'Inventario para Instructor',
                'description' => 'El instructor puede ver el inventario',
                'description_english' => 'Instructor access to inventory',
                'app_id' => $app->id
            ]
        )->id;

        // Crear solicitud
        $permissions_instructor[] = Permission::updateOrCreate(
            ['slug' => 'solicitud.instructor.request'],
            [
                'name' => 'Crear Solicitud',
                'description' => 'El instructor puede crear una solicitud',
                'description_english' => 'Instructor request creation access',
                'app_id' => $app->id
            ]
        )->id;

        // Historial
        $permissions_instructor[] = Permission::updateOrCreate(
            ['slug' => 'solicitud.instructor.history'],
            [
                'name' => 'Historial de solicitudes',
                'description' => 'El instructor puede ver el historial de solicitudes',
                'description_english' => 'Instructor request history access',
                'app_id' => $app->id
            ]
        )->id;

        // Asignar todos los permisos de una sola vez
        $rol_instructor = Role::where('slug', 'solicitud.instructor')->first();
        $rol_instructor->permissions()->syncWithoutDetaching($permissions_instructor);
    }
}


