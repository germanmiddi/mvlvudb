<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleNewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $roles = [         
                ['name' => "APP-VUDS-VU-OP-PROF", 
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - VENTANILLA UNICA PROFESIONAL'
                ],       
                ['name' => "APP-VUDS-ALL-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - TODO PROFESIONAL'
                ],
            
                ['name' => "APP-VUDS-PM-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - PERSONAS MAYORES PROFESIONAL'
                ],
            
                ['name' => "APP-VUDS-NIN-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - NIÑEZ PROFESIONAL'
                ],
            
            ['name' => "APP-VUDS-HAB-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - HABITAT PROFESIONAL'
                ],
            
            ['name' => "APP-VUDS-GEN-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - GENERO PROFESIONAL'
                ],
            
            ['name' => "APP-VUDS-FOR-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - FORTALECIMIENTO PROFESIONAL'
                ],
            
            ['name' => "APP-VUDS-ENT-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - ENTIDADES PROFESIONAL'
                ],
            
            ['name' => "APP-VUDS-DIS-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - DISCAPACIDAD PROFESIONAL'
                ],
            
            ['name' => "APP-VUDS-CBI-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBI  PROFESIONAL'
                ],
            
            ['name' => "APP-VUDS-CBICBJ-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBI-CBJ PROFESIONAL'
                ],
            
            ['name' => "APP-VUDS-CBJ-OP-PROF",
                'permissions' =>	'PROFESIONAL',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBJ PROFESIONAL'
                ]
        ];

        DB::table('roles')->insert($roles);

    }
}
