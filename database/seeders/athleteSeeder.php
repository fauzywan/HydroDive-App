<?php

namespace Database\Seeders;

use App\Models\Athlete;
use App\Models\athleteClub;
use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class athleteSeeder extends Seeder
{

    public function run(): void
    {
        Athlete::factory()->count(40)->create();

        for ($i=1; $i <=5; $i++) {
           $nc= Club::create([
                'name' => "Club $i" ,
                'nick' => "C$i",
                'owner' => 1,
                'owner_photo' => "",
                'address' => "",
                'hoc' =>1,
                'homebase' => "",
                'pool_status' => "",
                'registration_fee' =>0,
                'registration_link' =>"",
                'status' => "",
                'logo' => "",
                'type_id' => 2,
                'email' => "club$i@gmail.com",
                'status' => 2,
                'number_of_members' => "",
                'notarial_deed' => ""
            ]);
             User::create([
            'name' => "Club $i" ,
            'role_id' => 5,
            'email' =>  "club$i@gmail.com",
            'password' => bcrypt('123'),
        ]);

    }

 Athlete::where('id',">=",1)->where('id',"<=",8)->get()->map(function($a){
                athleteClub::create(['athlete_id'=>$a->id,'club_id'=>2,'status'=>1]);
            });
            Athlete::where('id',">=",9)->where('id',"<=",16)->get()->map(function($a){
                athleteClub::create(['athlete_id'=>$a->id,'club_id'=>3,'status'=>1]);
            });
            Athlete::where('id',">=",17)->where('id',"<=",24)->get()->map(function($a){
                athleteClub::create(['athlete_id'=>$a->id,'club_id'=>4,'status'=>1]);
            });
            Athlete::where('id',">=",25)->where('id',"<=",32)->get()->map(function($a){
                athleteClub::create(['athlete_id'=>$a->id,'club_id'=>5,'status'=>1]);
            });
            Athlete::where('id',">=",33)->where('id',"<=",40)->get()->map(function($a){
                athleteClub::create(['athlete_id'=>$a->id,'club_id'=>6,'status'=>1]);
            });
    }
}
