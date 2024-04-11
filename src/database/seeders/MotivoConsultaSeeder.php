<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotivoConsultaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Crisis de Angustia Recurrentes'],
            ['id' => 2, 'description' => 'Semblante Desvitalizado'],
            ['id' => 3, 'description' => 'Desregulación del Estado de Ánimo'],
            ['id' => 4, 'description' => 'Dificultad en la Capacidad de Expresión Emocional (enojos, inhibiciones, etc)'],
            ['id' => 5, 'description' => 'Duelo'],
            ['id' => 6, 'description' => 'Problemáticas Vinculadas a Condiciones Médicas'],
            ['id' => 7, 'description' => 'Episodios de Ansiedad'],
            ['id' => 8, 'description' => 'Episodios de Ansiedad por Separación'],
            ['id' => 9, 'description' => 'Dificultades para sostener la Atención y la Impulsividad Motora'],
            ['id' => 10, 'description' => 'Problematicas en el Autoestima'],
            ['id' => 11, 'description' => 'Problematicas de Género e Identidad'],
            ['id' => 12, 'description' => 'Déficit en la Autonomía Esperable para la Edad'],
            ['id' => 13, 'description' => 'Trastorno de la Imagen Corporal'],
            ['id' => 14, 'description' => 'Trastorno del Sueño'],
            ['id' => 15, 'description' => 'Problemas en los Hábitos Alimentarios'],
            ['id' => 16, 'description' => 'Conductas disruptivas'],
            ['id' => 17, 'description' => 'Problemas en la Vinculación y/o Relaciones Sociales'],
            ['id' => 18, 'description' => 'Separación Parental'],
            ['id' => 19, 'description' => 'Exposición a Situaciones de Conflictos Familiares/con la Ley'],
            ['id' => 20, 'description' => 'Problematicas de Vinculación Familiar'],
            ['id' => 21, 'description' => 'Problemas en la Construcción de la Identidad Filiatoria y/o Comprensión de la Estructura Familiar'],
            ['id' => 22, 'description' => 'Dificultades Familiares en la Contención Emocional y/o Puesta de Límites'],
            ['id' => 23, 'description' => 'Migración/Mudanza'],
            ['id' => 24, 'description' => 'Problematicas Relacionadas a la Adopción'],
            ['id' => 25, 'description' => 'Dificultades en el Lenguaje y la Comunicación'],
            ['id' => 26, 'description' => 'Dificultades del Aprendizaje Generalizadas'],
            ['id' => 27, 'description' => 'Problemas en la Lecto-Escritura'],
            ['id' => 28, 'description' => 'Dificultades en el Área de Matemáticas'],
            ['id' => 29, 'description' => 'Problemas de Adaptación escolar'],
            ['id' => 30, 'description' => 'Dificultades en las Funciones Ejecutivas (atención, memoria de trabajo, flexibilidad, inhibición, planificación)'],
        ];

        DB::table('motivo_consultas')->insert($data);
    }
}
