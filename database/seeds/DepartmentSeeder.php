<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Recursos Humanos',
            'Tecnologia da Informação',
            'Marketing',
            'Vendas',
            'Contabilidade',
            'Logística',
            'Desenvolvimento de Produto',
            'Atendimento ao Cliente',
            'Administração',
            'Qualidade',
        ];

        foreach ($departments as $department) {
            Department::create([
                'name' => $department
            ]);
        }
    }
}
