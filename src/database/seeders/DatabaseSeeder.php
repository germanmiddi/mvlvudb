<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ActividadesCbjSeeder::class
            AcompanamientosCbjSeeder::class
            BarriosSeeder::class
            CargosAutoridadesSeeder::class
            CanalAtencionSeeder::class
            CentrosSaludSeeder::class
            CategoriesSeeder::class
            CoberturaMedicaSeeder::class
            ComedoresSeeder::class
            DependenciasSeeder::class
            EstadoCbiSeeder::class
            EstadoCbjSeeder::class
            EstadoEducativoSeeder::class
            EstadoGabineteSeeder::class
            EstadosSaludSeeder::class
            EscuelasSeeder::class
            EscuelasDependenciaSeeder::class
            EscuelasNivelesSeeder::class
            EscuelasOrientacionesSeeder::class
            EscuelasTurnosSeeder::class
            ModalidadAtencionSeeder::class
            NivelEducativoSeeder::class
            PaisesSeeder::class
            ParentescosSeeder::class
            ProgramaSocialSeeder::class
            RoleSeeder::class
            RolTramiteSeeder::class
            SituacionConyugalSeeder::class
            SedesSeeder::class
            TipoDocumentoSeeder::class
            TipoOcupacionSeeder::class
            TipoPensionSeeder::class
            TipoTramiteSeeder::class
            TipoVinculoFamiliarSeeder::class
            TipoViviendaSeeder::class
            TiposActividadesSeeder::class
            TiposEntidadesSeeder::class
            TramiteEstadosSeeder::class
            UsersMvlSeeder::class
        ]);

        User::create([
            'name' => 'German Middi',
            'email' => 'g@gmail.com',
            'password' => bcrypt('Inicio123')
        ]);
        
    }
}
