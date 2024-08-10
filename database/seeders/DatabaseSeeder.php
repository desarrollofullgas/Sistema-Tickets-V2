<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('regions')->insert([
            'name' => 'México',
            'status' =>'Activo',
            'created_at' => now(),
        ]);
        // \App\Models\User::factory(10)->create();

        DB::table('permisos')->insert([
            'titulo_permiso' => 'Administrador',
            'descripcion' => 'Control Total del Sistema',
            'flag_trash' => 0,
            'created_at' => now(),
        ]);


        DB::table('panels')->insert([
            'titulo_panel' => 'Dashboard',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Tickets',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Tareas',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Compras',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Almacenes',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Áreas',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Departamentos',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Estaciones',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Regiones',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Roles',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Usuarios',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Zonas',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Categorías',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Marcas',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Productos',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Fallas',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Prioridades',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Servicios',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Tipos',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Manuales',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Versiones',
            'created_at' => now(),
        ]);

        DB::table('panels')->insert([
            'titulo_panel' => 'Global',
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 1,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 2,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 3,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 4,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 5,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 6,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 7,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 8,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 9,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 10,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 11,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 12,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 13,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);

        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 14,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 15,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 16,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 17,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 18,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 19,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 20,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        DB::table('panel_permiso')->insert([
            'permiso_id' => 1,
            'panel_id' => 21,
            'wr' => 1,
            're' => 1,
            'ed' => 1,
            'de' => 1,
            'vermas' => 1,
            'verpap' => 1,
            'restpap' => 1,
            'vermaspap' => 1,
            'created_at' => now(),
        ]);
        

        

        DB::table('zonas')->insert([
            'name' => 'MÉRIDA 1',
            'status' => 'Activo',
            'created_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Desarrollo FullGas',
            'username' => 'Desarrollo',
            'permiso_id' => 1,
            'region_id' => 1,
            'status' => 'Activo',
            'email' => 'desarrollo@fullgas.com.mx',
            'password' => Hash::make('Desarrollo1.'),
            'created_at' => now()
        ]);


        DB::table('estacions')->insert([
            'name' => 'Estacion  Prueba',
            'zona_id' => 1,
            'num_estacion' => 1,
            'status' => 'Activo',
            'created_at' => now(),
        ]);

        DB::table('categorias')->insert([
            'name' => 'Productos (Genéricos)',
            'status' => 'Activo',
            'created_at' => now(),
        ]);

        DB::table('marcas')->insert([
            'name' => 'Logitech',
            'status' => 'Activo',
            'created_at' => now(),
        ]);

        DB::table('productos')->insert([
            'name' => 'MousePad',
            'categoria_id' => 1,
            'marca_id' => 1,
            'modelo' => 'Modelo1',
            'descripcion' => 'MousePad',
            'prioridad' => 'Alto',
            'unidad' => 'Pieza',
            'status' => 'Activo',
            'created_at' => now(),
        ]);
       
        DB::table('versions')->insert([
            'titulo_version' => 'Versión',
            'version' => 1,
            'status' => 'Actual',
            'flag_trash' => 0,
            'created_at' => now(),
        ]);

    }
}
