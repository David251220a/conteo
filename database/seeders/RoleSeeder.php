<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $admin = Role::create(['name' => 'admin']);
        $admin = Role::find(1);

        // $permission = Permission::create(['name' => 'rol.index', 'descripcion' => 'Rol Index'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'rol.create', 'descripcion' => 'Rol Crear'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'rol.edit', 'descripcion' => 'Rol Editar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'rol.show', 'descripcion' => 'Rol Ver'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'rol.update', 'descripcion' => 'Rol Actualizar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'rol.store', 'descripcion' => 'Rol Guardar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'rol.delete', 'descripcion' => 'Rol Elimnar'])->syncRoles($admin);

        // $permission = Permission::create(['name' => 'usuario.index', 'descripcion' => 'Usuario Index'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'usuario.create', 'descripcion' => 'Usuario Crear'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'usuario.edit', 'descripcion' => 'Usuario Editar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'usuario.show', 'descripcion' => 'Usuario Ver'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'usuario.update', 'descripcion' => 'Usuario Actualizar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'usuario.store', 'descripcion' => 'Usuario Guardar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'usuario.delete', 'descripcion' => 'Usuario Elimnar'])->syncRoles($admin);


        // $permission = Permission::create(['name' => 'referente.index', 'descripcion' => 'Referente Index'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'referente.create', 'descripcion' => 'Referente Crear'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'referente.edit', 'descripcion' => 'Referente Editar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'referente.show', 'descripcion' => 'Referente Ver'])->syncRoles($admin);

        // $permission = Permission::create(['name' => 'local.index', 'descripcion' => 'Local Index'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'local.create', 'descripcion' => 'Local Crear'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'local.edit', 'descripcion' => 'Local Editar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'local.show', 'descripcion' => 'Local Ver'])->syncRoles($admin);

        // $permission = Permission::create(['name' => 'vehiculo.index', 'descripcion' => 'Vehiculo Index'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'vehiculo.create', 'descripcion' => 'Vehiculo Crear'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'vehiculo.edit', 'descripcion' => 'Vehiculo Editar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'vehiculo.show', 'descripcion' => 'Vehiculo Ver'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'vehiculo.agregar_local', 'descripcion' => 'Vehiculo Agregar Locales'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'vehiculo.eliminar_local', 'descripcion' => 'Vehiculo Eliminar Locales'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'vehiculo.pagar', 'descripcion' => 'Vehiculo Pagar'])->syncRoles($admin);

        // $permission = Permission::create(['name' => 'consulta.referente', 'descripcion' => 'Consulta Referente'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'consulta.referentesPorLocal', 'descripcion' => 'Consulta Referente por Local'])->syncRoles($admin);

        // $permission = Permission::create(['name' => 'lista.index', 'descripcion' => 'Lista Index'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'lista.create', 'descripcion' => 'Lista Crear'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'lista.edit', 'descripcion' => 'Lista Editar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'lista.show', 'descripcion' => 'Lista Ver'])->syncRoles($admin);

        // $permission = Permission::create(['name' => 'candidato.index', 'descripcion' => 'Candidato Index'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'candidato.create', 'descripcion' => 'Candidato Crear'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'candidato.edit', 'descripcion' => 'Candidato Editar'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'candidato.show', 'descripcion' => 'Candidato Ver'])->syncRoles($admin);

        // $permission = Permission::create(['name' => 'voto.intendente_manual', 'descripcion' => 'Voto Intendente Manual'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'voto.consejal_manual', 'descripcion' => 'Voto Consejal Manual'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'voto.consejal_import', 'descripcion' => 'Voto Consejal Import'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'voto.consulta_votos_carga', 'descripcion' => 'Voto Consulta Voto Carga'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'voto.consulta_lista', 'descripcion' => 'Voto Consulta por Lista'])->syncRoles($admin);
        // $permission = Permission::create(['name' => 'voto.dhondt', 'descripcion' => 'Voto DHONDT'])->syncRoles($admin);

        // $permission = Permission::create(['name' => 'voto.show', 'descripcion' => 'Voto'])->syncRoles($admin);

        // $permission = Permission::create(['name' => 'consulta.simulacion', 'descripcion' => 'Consulta Simulacion']);
        // $permission = Permission::create(['name' => 'consulta.simulacion_ver', 'descripcion' => 'Consulta Simulacion Ver']);

        // $permission = Permission::create(['name' => 'padron.index', 'descripcion' => 'Padron Vista Principal']);
        // $permission = Permission::create(['name' => 'role.permiso_crear', 'descripcion' => 'Rol: Crear Permiso']);
        // $permission = Permission::create(['name' => 'sondeo.index', 'descripcion' => 'Sondeo: Carga']);
        // $permission = Permission::create(['name' => 'sondeo.show', 'descripcion' => 'Sondeo: Consulta']);

        // $permission = Permission::create(['name' => 'consulta.resumen', 'descripcion' => 'Consulta: Resumen Referente']);
        // $permission = Permission::create(['name' => 'padron.todos', 'descripcion' => 'Padron: Todos']);
        // $permission = Permission::create(['name' => 'habilitacion.estado_alumno', 'descripcion' => 'Habilitacion de Curso: Estado Alumno']);

    }

}
