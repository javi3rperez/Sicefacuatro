<?php

namespace Modules\SOLICITUD\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SICA\Entities\EPS;
use Modules\SICA\Entities\PensionEntity;
use Modules\SICA\Entities\Person;
use Modules\SICA\Entities\PopulationGroup;


class PeopleTableSeeder extends Seeder 
{

    public function run()
    {

    $population_group = PopulationGroup::firstOrCreate(['name' => 'NINGUNA']);
    $eps = EPS::firstOrCreate(['name' => 'NO REGISTRA']);
    $pension_entity = PensionEntity::firstOrCreate(['name' => 'NO REGISTRA']);

    Person::firstOrCreate(['document_number' => 1079174115],
    [
    'document_type' => 'Cedula Ciudadania',
    'first_name' => 'YONY JAVIER',
    'first_last_name' => 'PEREZ',
    'second_last_name' => 'TIMOTE',
    'eps_id' => $eps->id,
    'population_group_id' => $population_group->id,
    'pension_entity_id' => $pension_entity->id

    ]);

    Person::firstOrCreate(['document_number' => 1079176912],
    [
    'document_type' => 'Tarjeta de Identidad',
    'first_name' => 'LAURA MICHELLE',
    'first_last_name' => 'PERDOMO',
    'second_last_name' => 'ROJAS',
    'eps_id' => $eps->id,
    'population_group_id' => $population_group->id,
    'pension_entity_id' => $pension_entity->id

    ]);

    Person::firstOrCreate(['document_number' => 1079176266],
    [
    'document_type' => 'Cedula Ciudadania',
    'first_name' => 'DANNA SOFIA',
    'first_last_name' => 'SANCHEZ',
    'second_last_name' => 'DIAZ',
    'eps_id' => $eps->id,
    'population_group_id' => $population_group->id,
    'pension_entity_id' => $pension_entity->id

    ]);

    Person::firstOrCreate(['document_number' => 1029641519],
    [
    'document_type' => 'Cedula Ciudadania',
    'first_name' => 'YULY NATALIA',
    'first_last_name' => 'FARFAN',
    'second_last_name' => 'RAMIREZ',
    'eps_id' => $eps->id,
    'population_group_id' => $population_group->id,
    'pension_entity_id' => $pension_entity->id

    ]);

}
}