<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $roles = [         
                ['name' => "APP-VUDS-VU-OP", 
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - VENTANILLA UNICA OPERADOR'
                ],       
                ['name' => "APP-VUDS-ALL-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - TODO OPERADOR'
                ],
            
                ['name' => "APP-VUDS-PM-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - PERSONAS MAYORES OPERADOR'
                ],
            
                ['name' => "APP-VUDS-NIN-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - NIÑEZ OPERADOR'
                ],
            
            ['name' => "APP-VUDS-HAB-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - HABITAT OPERADOR'
                ],
            
            ['name' => "APP-VUDS-GEN-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - GENERO OPERADOR'
                ],
            
            ['name' => "APP-VUDS-FOR-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - FORTALECIMIENTO OPERADOR'
                ],
            
            ['name' => "APP-VUDS-ENT-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - ENTIDADES OPERADOR'
                ],
            
            ['name' => "APP-VUDS-DIS-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - DISCAPACIDAD OPERADOR'
                ],
            
            ['name' => "APP-VUDS-CBI-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBI  OPERADOR'
                ],
            
            ['name' => "APP-VUDS-CBICBJ-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBI-CBJ OPERADOR'
                ],
            
            ['name' => "APP-VUDS-CBJ-OP",
                'permissions' =>	'OPERADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBJ OPERADOR'
                ],
            
            ['name' => "APP-VUDS-VU-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - VENTANILLA UNICA ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-ALL-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - TODO ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-PM-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - PERSONAS MAYORES ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-NIN-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - NIÑEZ ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-HAB-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - HABITAT ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-GEN-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - GENERO ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-FOR-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - FORTALECIMIENTO ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-ENT-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - ENTIDADES ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-DIS-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - DISCAPACIDAD ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-CBI-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBI  ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-CBICBJ-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBI-CBJ ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-CBJ-ADM",
                'permissions' =>	'ADMINISTRADOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBJ ADMINISTRADOR'
                ],
            
            ['name' => "APP-VUDS-VU-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - VENTANILLA UNICA DIRECTOR'
                ],
            
            ['name' => "APP-VUDS-ALL-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - TODO DIRECTOR'
                ],
            
            ['name' => "APP-VUDS-PM-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - PERSONAS MAYORES DIRECTOR'
                ],
            
            ['name' => "APP-VUDS-NIN-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - NIÑEZ DIRECTOR'
                ],
            
            ['name' => "APP-VUDS-HAB-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - HABITAT DIRECTOR'
                ],
            
                   ['name' => "APP-VUDS-GEN-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - GENERO DIRECTOR'
                ],
            
               ['name' => "APP-VUDS-FOR-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - FORTALECIMIENTO DIRECTOR'
                ],
            
                ['name' => "APP-VUDS-ENT-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - ENTIDADES DIRECTOR'
                ],
            
                ['name' => "APP-VUDS-DIS-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - DISCAPACIDAD DIRECTOR'
                ],
            
                ['name' => "APP-VUDS-CBI-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBI  DIRECTOR'
                ],
            
                ['name' => "APP-VUDS-CBICBJ-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBI-CBJ DIRECTOR'
                ],
            
                ['name' => "APP-VUDS-CBJ-DIR",
                'permissions' =>	'DIRECTOR',
                'description' =>	'Grupo Ventanilla Unica Desa Social - CBJ DIRECTOR'
                ]
        ];


        DB::table('roles')->insert($roles);

    }
}
