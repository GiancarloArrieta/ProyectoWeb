<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Departamento;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $roles = [
            ['nombre' => 'Administrador'],
            ['nombre' => 'Usuario'],
            ['nombre' => 'Auxiliar'],
        ];

        foreach ($roles as $rol) {
            Rol::firstOrCreate($rol);
        }

        // Crear departamentos
        $departamentos = [
            ['nombre' => 'Ventas'],
            ['nombre' => 'Producción'],
            ['nombre' => 'Soporte Técnico'],
            ['nombre' => 'Administración'],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::firstOrCreate($departamento);
        }

        // Crear usuario administrador
        $adminRol = Rol::where('nombre', 'Administrador')->first();
        $adminDept = Departamento::where('nombre', 'Administración')->first();

        Usuario::firstOrCreate(
            ['correo' => 'admin@dulcesricos.com'],
            [
                'nombre' => 'Administrador',
                'correo' => 'admin@dulcesricos.com',
                'contreseña' => Hash::make('admin123'),
                'id_rol' => $adminRol->id,
                'id_departamento' => $adminDept->id,
            ]
        );

        // Crear usuario de soporte
        $auxiliarRol = Rol::where('nombre', 'Auxiliar')->first();
        $soporteDept = Departamento::where('nombre', 'Soporte Técnico')->first();

        Usuario::firstOrCreate(
            ['correo' => 'soporte@dulcesricos.com'],
            [
                'nombre' => 'Técnico de Soporte',
                'correo' => 'soporte@dulcesricos.com',
                'contreseña' => Hash::make('soporte123'),
                'id_rol' => $auxiliarRol->id,
                'id_departamento' => $soporteDept->id,
            ]
        );

        // Crear usuario regular
        $usuarioRol = Rol::where('nombre', 'Usuario')->first();
        $ventasDept = Departamento::where('nombre', 'Ventas')->first();

        Usuario::firstOrCreate(
            ['correo' => 'usuario@dulcesricos.com'],
            [
                'nombre' => 'Usuario de Prueba',
                'correo' => 'usuario@dulcesricos.com',
                'contreseña' => Hash::make('usuario123'),
                'id_rol' => $usuarioRol->id,
                'id_departamento' => $ventasDept->id,
            ]
        );
    }
}
