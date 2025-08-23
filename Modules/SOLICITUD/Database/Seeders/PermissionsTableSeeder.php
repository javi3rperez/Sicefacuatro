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
          
        //permiso para CRUD listado ROL ADMINISTRADOR
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.admin.list'], [
            'name' => 'Acceso al Rol de Administrador para listado',
            'description' => 'Acceso al Rol de Administrador para listado',
            'description_english' => 'Access to the Administrator Role for list',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;
        $rol_admin = Role::where('slug', 'solicitud.admin')->first();
        $rol_admin->permissions()->syncWithoutDetaching($permissions_admin);

        //permiso para CRUD de historial ROL ADMINISTRADOR
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.admin.record'], [
            'name' => 'Acceso al Rol de Administrador para record',
            'description' => 'Acceso al Rol de Administrador para historial',
            'description_english' => 'Access to the Administrator Role for record',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;
        $rol_admin = Role::where('slug', 'solicitud.admin')->first();
        $rol_admin->permissions()->syncWithoutDetaching($permissions_admin);

        //permiso para CRUD de inventario ROL ADMINISTRADOR
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.inventory'], [
                'name' => 'Acceso al Rol de almacenista para inventario',
                'description' => 'Acceso al Rol de Almacenista',
                'description_english' => 'Access to the Warehouse Role',
                'app_id' => $app->id
            ]);
        $permissions_admin[] = $permission->id;
        $rol_admin = Role::where('slug','solicitud.store')->first(); 
        $rol_admin->permissions()->syncWithoutDetaching($permissions_admin); 

        //permiso para CRUD de reportes ROL ADMINISTRADOR
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.admin.reports'], [
            'name' => 'Acceso al Rol de Administrador para reportes',
            'description' => 'Acceso al Rol de Administrador para reportes',
            'description_english' => 'Access to the Administrator Role for reports',
            'app_id' => $app->id
        ]);
        $permissions_admin[] = $permission->id;
        $rol_admin = Role::where('slug', 'solicitud.admin')->first();
        $rol_admin->permissions()->syncWithoutDetaching($permissions_admin);

        // Permiso para CRUD de formatos ROL ADMINISTRADOR
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.admin.formato'], [
            'name' => 'Acceso al Rol de Administrador para formatos',
            'description' => 'Acceso al Rol de Administrador para formatos',
            'description_english' => 'Access to the Administrator Role for formats',
            'app_id' => $app->id 
        ]);
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
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.leader.request'], [
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
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.leader.history'], [
                'name' => 'Acceso al Rol de instructor lider para ver historial',
                'description' => 'Acceso al Rol de instructor lider',
                'description_english' => 'Access to the instructor lead Role',
                'app_id' => $app->id
            ]);
        $permissions_leader[] = $permission->id;
        $rol_leader = Role::where('slug','solicitud.leader')->first(); 
        $rol_leader->permissions()->syncWithoutDetaching($permissions_leader);

        
        // Permiso para VER MOVIMIENTOS DEL INSTRUCTOR LIDER 
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.leader.movements'], [
            'name' => 'Acceso al Rol de instructor lider para movimientos',
            'description' => 'Acceso al Rol de instructor lider',
            'description_english' => 'Access to the instructor lead Role',
            'app_id' => $app->id
        ]);
        $permissions_leader[] = $permission->id;
        $rol_leader = Role::where('slug','solicitud.leader')->first(); 
        $rol_leader->permissions()->syncWithoutDetaching($permissions_leader);

        
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.leader.index'], [
            'name' => 'Acceso al Rol de instructor lider para historial de solicitudes',
            'description' => 'Acceso al Rol de instructor lider',
            'description_english' => 'Access to the instructor lead Role',
            'app_id' => $app->id
        ]);
        $permissions_leader[] = $permission->id;
        $rol_leader = Role::where('slug','solicitud.leader')->first(); 
        $rol_leader->permissions()->syncWithoutDetaching($permissions_leader);

          // Permiso para ELIMINAR 
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.leader.destroy'], [
            'name' => 'Acceso al Rol de instructor lider para historial de solicitudes',
            'description' => 'Acceso al Rol de instructor lider',
            'description_english' => 'Access to the instructor lead Role',
            'app_id' => $app->id
        ]);
        $permissions_leader[] = $permission->id;
        $rol_leader = Role::where('slug','solicitud.leader')->first(); 
        $rol_leader->permissions()->syncWithoutDetaching($permissions_leader);


        // Aqui comienza los permissions del rol de Almacenista
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
        
        //Permiso para crear un producto para el rol de almacenista
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.inventory.create'], [
                'name' => 'Acceso al Rol de almacenista para inventario',
                'description' => 'Acceso al Rol de Almacenista',
                'description_english' => 'Access to the Warehouse Role',
                'app_id' => $app->id
            ]);
        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug','solicitud.store')->first(); 
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

        // permiso para CRUD MOVIMIENTOS ROL ALMACENISTA
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.movements'], [
            'name' => 'Acceso al Rol de almacenista para listas de solicitud',
            'description' => 'Acceso al CRUD de listas de solicitud',
            'description_english' => 'Access to List CRUD',
            'app_id' => $app->id
        ]);

        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug', 'solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store);



            // permiso para CRUD MOVIMIENTOS ROL ALMACENISTA
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.movement.create'], [
            'name' => 'Acceso al Rol de almacenista para listas de solicitud',
            'description' => 'Acceso al CRUD de listas de solicitud',
            'description_english' => 'Access to List CRUD',
            'app_id' => $app->id
        ]);

        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug', 'solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store);

        // permiso para CRUD DE REPORTES ROL ALMACENISTA
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.report.movements'], [
            'name' => 'Acceso al Rol de almacenista para listas de solicitud',
            'description' => 'Acceso al CRUD de listas de solicitud',
            'description_english' => 'Access to List CRUD',
            'app_id' => $app->id
        ]);

        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug', 'solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store);

                // permiso para CRUD DE REPORTES ROL ALMACENISTA
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.report.movements.download'], [
            'name' => 'Acceso al Rol de almacenista para listas de solicitud',
            'description' => 'Acceso al CRUD de listas de solicitud',
            'description_english' => 'Access to List CRUD',
            'app_id' => $app->id
        ]);

        $permissions_store[] = $permission->id;
        $rol_store = Role::where('slug', 'solicitud.store')->first(); 
        $rol_store->permissions()->syncWithoutDetaching($permissions_store);
        
        //permiso para crear evidencias rol almacenista
        $permission = Permission::updateOrCreate(['slug' => 'solicitud.store.evidence.create'], [
            'name' => 'Acceso al Rol de bodega Solicitudes',
            'description' => 'Acceso al Rol de bodega',
            'description_english' => 'Access to the store Role',
            'app_id' => $app->id
        ]);
        $permissions_store[] = $permission->id; 
        $rol_store = Role::where('slug','solicitud.store')->first(); 
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

        // Solicitud - Crear
        $permissions_instructor[] = Permission::updateOrCreate(
            ['slug' => 'solicitud.instructor.request'],
            [
                'name' => 'Crear Solicitud',
                'description' => 'El instructor puede crear una solicitud',
                'description_english' => 'Instructor request creation access',
                'app_id' => $app->id
            ]
        )->id;

        // Solicitud - Guardar
        $permissions_instructor[] = Permission::updateOrCreate(
            ['slug' => 'solicitud.instructor.store'],
            [
                'name' => 'Guardar solicitud',
                'description' => 'Permite al instructor guardar una solicitud',
                'description_english' => 'Instructor request store access',
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

        // Permiso para LISTAR HISTORIAL
        $permissions_instructor[] = Permission::updateOrCreate(
            ['slug' => 'solicitud.instructor.index'], 
            [
                'name' => 'Acceso al historial de solicitudes del instructor',
                'description' => 'Permite ver el historial de solicitudes del rol instructor',
                'description_english' => 'Access to the instructor request history',
                'app_id' => $app->id
            ]
        )->id;

        // Permiso para ELIMINAR HISTORIAL
        $permissions_instructor[] = Permission::updateOrCreate(
            ['slug' => 'solicitud.instructor.destroy'], 
            [
                'name' => 'Eliminar solicitudes del instructor',
                'description' => 'Permite eliminar solicitudes del rol instructor',
                'description_english' => 'Delete instructor requests',
                'app_id' => $app->id
            ]
        )->id;

        // Movimientos
        $permissions_instructor[] = Permission::updateOrCreate(
            ['slug' => 'solicitud.instructor.movements'], 
            [
                'name' => 'Acceso al historial de movimientos',
                'description' => 'Permite ver el historial de entradas y salidas de inventario',
                'description_english' => 'Access to the inventory movement history',
                'app_id' => $app->id
            ]
        )->id;

        // Asignar todos los permisos
        $rol_instructor = Role::where('slug', 'solicitud.instructor')->first();
        $rol_instructor->permissions()->syncWithoutDetaching($permissions_instructor);


    }
}
