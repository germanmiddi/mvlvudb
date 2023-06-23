<?php

namespace Database\Seeders;

use App\Models\Manager\Parentesco;
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
           /*  LocalidadesSeeder::class,
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
            ProgramaSocialSeeder::class, */
            ParentescosSeeder::class,
        ]);

       /*  User::create([
            'name' => 'German Middi',
            'email' => 'g@gmail.com',
            'password' => bcrypt('Inicio123')
        ]);  */

        

    }
}
