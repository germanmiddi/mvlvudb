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
            BarriosUpdateSeeder::class,
            CargosAutoridadesSeeder::class,
            CanalAtencionSeeder::class,
            CanalAtencionMayoresSeeder::class,
            CentrosSaludSeeder::class,
            DependenciasSeeder::class,
            CategoriesSeeder::class,
            CoberturaMedicaSeeder::class,
            ComedoresSeeder::class,
            ActividadesCbjSeeder::class,
            ActividadesCBSeeder::class,
            AcompanamientosCbjSeeder::class,
            EstadoCbiSeeder::class,
            EstadoCbjSeeder::class,
            EstadoEducativoSeeder::class,
            EstadoGabineteSeeder::class,
            EstadosSaludSeeder::class,
            EscuelasSeeder::class,
            EscuelasDependenciaSeeder::class,
            EscuelasNivelesSeeder::class,
            EscuelasOrientacionesSeeder::class,
            EscuelasTurnosSeeder::class,
            ModalidadAtencionSeeder::class,
            NivelEducativoSeeder::class,
            PaisesSeeder::class,
            ParentescosSeeder::class,
            ProgramaSocialSeeder::class,
            RoleSeeder::class,
            RolTramiteSeeder::class,
            SituacionConyugalSeeder::class,
            SedesSeeder::class,
            TipoDocumentoSeeder::class,
            TipoOcupacionSeeder::class,
            TipoPensionSeeder::class,
            TipoTramiteSeeder::class,
            TipoVinculoFamiliarSeeder::class,
            TipoViviendaSeeder::class,
            TiposActividadesSeeder::class,
            TiposEntidadesSeeder::class,
            TramiteEstadosSeeder::class,
            TiposLegajoCbSeeder::class,
            UsersMvlSeeder::class,
            DependenciasRolPrefixSeeder::class,
            TipoTramiteCBSeeder::class,
            TipoDerivacionesSeeder::class,
            TipoArticulacionesSeeder::class,
            ProgramasSocialesCBSeeder::class,
            OrigenDemandasSeeder::class,
            MotivoConsultaSeeder::class,
            MotivoBajasSeeder::class,
            FamiliarAntecedentesSeeder::class,
            EstadoInformeCBSeeder::class,
            EstadoActividadCBSeeder::class,
            ColumnExportSeeder::class,
            EstadoProgramaSocialCBSeeder::class,
            TipoTratamientosSeeder::class,
            TipoEnfermedadesSeeder::class,
            EstadoGabineteCBSeeder::class,
            CajasEntrevistasStatusesSeeder::class,
            RoleCajasSeeder::class,
            TipoTenenciaSeeder::class,
        ]);

        User::create([
            'name' => 'German Middi',
            'email' => 'g@gmail.com',
            'password' => bcrypt('Inicio123')
        ]);

    }
}
