<?php

namespace Database\Seeders;

use App\Models\Athlete;
use App\Models\athleteClub;
use App\Models\Club;
use App\Models\ClubType;
use App\Models\Coach;
use App\Models\CoachCategory;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodClub;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class clubSeeder extends Seeder
{
    public function run()
    {
       $clubTypes = [
    [
        'name' => 'Club',
        'is_create' => 0,
    ],
    [
        'name' => 'Sekolah Renang',
        'is_create' => 1,
    ],
    [
        'name' => 'Sekolah Regular',
        'is_create' => 0,
    ],
    [
        'name' => 'Eksternal Club',
        'is_create' => 0,
    ],
];
        $categories = [
            'Belum Ditambahkan',
            'Head of Coach',
            'Physical Coach',
            'Swimming Tech',
        ];

        foreach ($clubTypes as $ct) {
             ClubType::create([
        'name' => $ct['name'],
        'is_create' => $ct['is_create'],
    ]);
}
        foreach ($categories as $category) {
            CoachCategory::create(['name' => $category]);
        }
            Coach::create([
                "name"=>"Belum ditambahkan",
                "pob"=>"",
                "city"=>"",
                "profile"=>"",
                "email"=>"",
                "dob"=>"",
                "club_id"=>null,
                "coach_category_id"=>1,
            ]);
            Club::create([
                'name' => 'Tidak terafiliasi Manapun ' ,
                'nick' => "Belum Terdaftar",
                'owner' => 1,
                'owner_photo' => "",
                'address' => "",
                'hoc' =>coach::get()[0]->id,
                'homebase' => "",
                'pool_status' => "",
                'registration_fee' =>0,
                'registration_link' =>"",
                'status' => "",
                'logo' => "",
                'type_id' => 1,
                'email' => "",
                'status' => 0,
                'number_of_members' => "",
                'notarial_deed' => ""
            ]);
          PaymentMethod::create(['name'=>"Gopay"]);
            PaymentMethodClub::create([
            'payment_method_id'=>1,
            'club_id'=>1,
            'payment_address'=>"000000000000",
            'photo'=>""]);





        }
}
