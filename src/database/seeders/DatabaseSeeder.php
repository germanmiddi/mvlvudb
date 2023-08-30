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
            LocalidadesSeeder::class,
            BarriosSeeder::class,
            CanalAtencionSeeder::class,
            CoberturaMedicaSeeder::class,
            DependenciasSeeder::class,
            EstadoEducativoSeeder::class,
            NivelEducativoSeeder::class,
            PaisesSeeder::class,
            SedesSeeder::class,
            TipoDocumentoSeeder::class,
            TipoOcupacionSeeder::class,
            TipoPensionSeeder::class,
            TipoVinculoFamiliarSeeder::class,
            TipoViviendaSeeder::class,
            RolTramiteSeeder::class,
            SituacionConyugalSeeder::class,
            TipoTramiteSeeder::class,
            ProgramaSocialSeeder::class,
            ParentescosSeeder::class,
            EstadoCbiSeeder::class,
            EstadoGabineteSeeder::class,
            EscuelasSeeder::class,
            EscuelasDependenciaSeeder::class,
            EscuelasNivelesSeeder::class,
            EscuelasTurnosSeeder::class,
            CentrosSaludSeeder::class,
            EstadosSaludSeeder::class,
            ComedoresSeeder::class,
            EstadoCbjSeeder::class,
            ActividadesCbjSeeder::class,
            AcompanamientosCbjSeeder::class,
            EscuelasOrientacionesSeeder::class,
            CargosAutoridadesSeeder::class,
            TiposEntidadesSeeder::class,
            TiposActividadesSeeder::class,
            TramiteEstadosSeeder::class

        ]);

        User::create([
            'name' => 'German Middi',
            'email' => 'g@gmail.com',
            'password' => bcrypt('Inicio123')
        ]);
        
        User::create([
            'name' => 'Testing',
            'email' => 'test@test.com',
            'password' => bcrypt('Testing123')
        ]);
        User::create([
            'name' => 'Veronica',
            'email' => 'veronica@test.com',
            'password' => bcrypt('Vero123')
        ]);
        User::create([
            'name' => 'Monica',
            'email' => 'monica@test.com',
            'password' => bcrypt('Moni123')
        ]);
        
    }
}
