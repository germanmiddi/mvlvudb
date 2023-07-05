<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 1, 'INSCRIPCIÓN A ACTIVIDADES', 't'],
            [2, 1, 'INSCRIPCIÓN A COMEDORES', 't'],
            [3, 1, 'ASESORAMIENTO', 't'],
            [4, 2, 'ENTREVISTA PROFESIONAL CON TURNO', 't'],
            [5, 2, 'MULETAS', 't'],
            [6, 2, 'LENTES', 't'],
            [7, 2, 'RETIRA PASE', 't'],
            [8, 2, 'PLANTILLAS', 't'],
            [9, 2, 'PRÓTESIS', 't'],
            [12, 2, 'PASE DE TRANSPORTE', 't'],
            [13, 2, 'SILLA DE RUEDAS', 't'],
            [14, 2, 'ASISTENCIA ALIMENTARIA', 't'],
            [77, 10, 'ASISTENCIA ALIMENTARIA COVID-19', 't'],
            [78, 10, 'TARJETA ALIMENTAR', 't'],
            [15, 3, 'CONSTITUCIÓN DE ASOCIACIONES CIVILES (PERSONERÍA JURÍDICA)', 't'],
            [16, 3, 'PEDIDOS PARA EVENTOS', 't'],
            [17, 3, 'INSCRIPCIÓN MUNICIPAL DE ENTIDADES DE BIEN PÚBLICO', 't'],
            [18, 3, 'PROGRAMA TARIFA SOCIAL (ERAS)', 't'],
            [19, 3, 'RÚBRICA DE LIBROS', 't'],
            [20, 3, 'VISTA DE BALANCES', 't'],
            [21, 3, 'CERTIFICADOS DE VIGENCIA', 't'],
            [22, 3, 'CAPACITACIÓN', 't'],
            [23, 3, 'ASESORAMIENTO GENERAL', 't'],
            [24, 3, 'SUBSIDIOS', 't'],
            [25, 5, 'PLAN MÁS VIDA', 't'],
            [26, 5, 'CELIAQUÍA', 't'],
            [27, 5, 'BOLSÓN DE ALIMENTOS', 't'],
            [28, 5, 'SUBSIDIO SUBSISTENCIA', 't'],
            [29, 5, 'SUBSIDIO MICROEMPRENDIMIENTO', 't'],
            [30, 5, 'SILLA DE RUEDAS', 't'],
            [31, 5, 'MULETAS/BASTÓN/TRÍPODE', 't'],
            [32, 5, 'PLANTILLAS', 't'],
            [33, 5, 'LENTES', 't'],
            [34, 5, 'COLCHÓN', 't'],
            [35, 5, 'CAMA', 't'],
            [36, 5, 'FRAZADA', 't'],
            [39, 5, 'SANEAMIENTO', 't'],
            [40, 5, 'CUADRILLA GESTIÓN TERRITORIAL', 't'],
            [41, 5, 'DESTAPE DE POZOS', 't'],
            [42, 5, 'RECLAMOS CLOACAS / RED DE AGUA', 't'],
            [43, 5, 'RECLAMOS ELÉCTRICOS', 't'],
            [44, 5, 'SEPELIOS', 't'],
            [45, 5, 'CONSULTA', 't'],
            [46, 5, 'TICKET ALIMENTARIO', 't'],
            [47, 5, 'OTROS', 't'],
            [48, 6, 'CONSTITUCIÓN DE ASOCIACIONES CIVILES (PERSONERÍA JURÍDICA)', 't'],
            [49, 6, 'INSCRIPCIÓN A CURSOS Y TALLERES', 't'],
            [50, 6, 'ENTREVISTA CON PROFESIONAL PARA DERIVACIÓN A TRATAMIENTO', 't'],
            [51, 6, 'INSCRIPCIÓN A TRATAMIENTO GRUPAL DE HOMBRES CON CONDUCTAS VIOLENTAS', 't'],
            [52, 6, 'ASESORAMIENTO LEGAL EN TEMAS DE GÉNERO', 't'],
            [53, 6, 'ASESORAMIENTO LEGAL EN TEMAS DE DIVERSIDAD SEXUAL', 't'],
            [54, 6, 'INSCRIPCIÓN PROGRAMA DE EMPRENDIMIENTOS', 't'],
            [55, 6, 'ENTREVISTA POR BOTÓN ANTIPÁNICO', 't'],
            [56, 6, 'ADMISIÓN POR LICENCIA ESPECIAL (EMPLEADOS MUNICIPALES)', 't'],
            [57, 7, 'MATERIALES DE CONSTRUCCIÓN', 't'],
            [58, 7, 'ESTADO DE SOLICITUD DE ESCRITURA', 't'],
            [59, 7, 'SOLICITUD DE VIVIENDA', 't'],
            [60, 7, 'SOLICITUD DE RELOCALIZACIÓN', 't'],
            [61, 7, 'SOLICITUD DE SUBSIDIO', 't'],
            [62, 7, 'RECLAMOS EN COMPLEJOS HABITACIONALES', 't'],
            [63, 7, 'RECLAMOS ELÉCTRICOS', 't'],
            [64, 7, 'RECLAMOS CLOACAS / RED DE AGUA', 't'],
            [65, 7, 'SOLICITUD MEJORAMIENTO AMBIENTAL', 't'],
            [66, 8, 'ASISTENCIA TÉCNICO - PROFESIONAL', 't'],
            [67, 8, 'SERVICIO LOCAL', 't'],
            [68, 8, 'ATENCIÓN EN GUARDIA', 't'],
            [69, 8, 'ASESORAMIENTO LEGAL', 't'],
            [70, 9, 'ATENCIÓN A ADULTOS MAYORES EN SITUACIÓN DE VULNERABILIDAD', 't'],
            [71, 9, 'ATENCIÓN A PERSONAS EN SITUACIÓN DE CALLE', 't'],
            [72, 9, 'EXIMICIÓN DE TASAS, DOCUMENTOS Y OTROS', 't'],
            [73, 9, 'SOLICITUD DE INTERVENCIONES POR ACUMULADORES - CASAS TOMADAS - PREDIOS INTRUSADOS - VULNERACIÓN DE DERECHOS', 't'],
            [74, 9, 'INTERVENCIONES SOLICITADAS POR IPS U OTRAS INSTITUCIONES', 't'],
            [75, 9, 'BONOS JUBILADOS', 't'],
            [76, 9, 'PROBATION', 't'],
            [86, 2, 'INCLUSION EDUCATIVA', 't'],
            [87, 2, 'INCLUSION LABORAL', 't'],
            [88, 2, 'INCLUSION RECREATIVA', 't'],
            [89, 2, 'VIDA INDEPENDIENTE', 't'],
            [90, 2, 'SOCIO AMBIENTAL', 't'],
            [91, 2, 'AUDIFONOS', 't'],
            [92, 2, 'CAMA - COLCHONES - FRAZADAS', 't'],
            [93, 2, 'BASTON', 't'],
            [94, 2, 'OTROS ELEMENTOS', 't'],
            [10, 2, 'ASESORAMIENTO GENERAL', 't'],
            [11, 2, 'ORIENTACIÓN', 'f'],
            [37, 5, 'INSCRIPCIÓN A COMEDOR', 'f'],
            [38, 5, 'INSCRIPCIÓN A COMEDOR POR TERCERA EDAD', 'f'],
            [99, 11, 'INTERVENCIONES EN AISLAMIENTOS TERMICOS EN PAREDES EXTERIORES', 't'],
            [95, 5, 'ASISTENCIA A COMEDOR PERSONAS CON DISCAPACIDAD', 't'],
            [96, 5, 'ASISTENCIA A COMEDOR JOVENES', 't'],
            [83, 5, 'ASISTENCIA A COMEDOR NIÑAS/NIÑOS', 't'],
            [84, 5, 'ENTREVISTA CON TRABAJADORA/TRABAJADOS SOCIAL', 't'],
            [79, 12, 'INFANCIA', 't'],
            [81, 5, 'ASISTENCIA A COMEDOR', 'f'],
            [80, 13, 'JUVENTUD', 't'],
            [82, 5, 'ASISTENCIA A COMEDOR PERSONAS MAYORES', 't'],
            [85, 7, 'ATENCION CON PROFESIONAL', 't'],
            [97, 11, 'INTERVENCIONES SANITARIAS', 't'],
            [98, 11, 'INTERVENCIONES EN AISLAMIENTOS TERMICOS EN TECHOS', 't'],
            [100, 13, 'IGUALDAD DE GÉNERO', 't'],
            [101, 14, 'ASISTENCIA ALIMENTARIA', 't'],
            [102, 14, 'ASISTENCIA ALIMENTARIA', 't'],
            [103, 14, 'BONOS', 't'],
            [104, 14, 'CAMA - COLCHONES - FRAZADAS', 't'],
            [105, 14, 'ENTREVISTA PROFESIONAL CON TURNO', 't'],
            [106, 14, 'EXIMICIÓN DE TASAS, DOCUMENTOS, OTROS', 't'],
            [107, 14, 'INTERVENCIONES SOLICITADAS POR IPS U OTRAS INSTITUCIONES', 't'],
            [108, 14, 'LENTES', 't'],
            [109, 14, 'SOCIOAMBIENTAL', 't'],
            [110, 14, 'SOLICITUD DE INTERVENCIONES POR ACUMULADORES - CASAS TOMADAS - PREDIOS INTRUSADOS', 't'],
            [111, 14, 'RECREATIVO', 't'],
        ];

        foreach ($data as $row) {
            DB::table('tipo_tramite')->insert([
                'id' => $row[0],
                'dependencia_id' => $row[1],
                'description' => $row[2],
                'activo' => $row[3],
            ]);
        }
    }
}