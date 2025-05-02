<?php 

namespace Modules\SOLICITUD\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\SICA\Entities\Person;

class UsersTableSeeder extends Seeder 
{
 public function run()
    {
        $person = Person::where('document_number', 1079174115)->first();
        User::updateOrCreate(['nickname' => 'Yperez'], [
            'person_id' => $person->id,
            'email' => 'yonyp5745@gmail.com'            //Password: Yope4115
        ]);

        $person = Person::where('document_number', 1029641519)->first();
        User::updateOrCreate(['nickname' => 'Yulyfa'], [
            'person_id' => $person->id,
            'email' => 'yuly2025@gmail.com'            //Password: Yufa1519
        ]);
    }
}