<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=20;$i++){
            if($i<=5){
                $this->SeederData();
            }
            if($i>=6 && $i<=10){
                $this->SeederData(mt_rand(1,5));
            }
            if($i>=11 && $i<=15){
                $this->SeederData(mt_rand(6,10));
            }
            if($i>=15 && $i<=20){
                $this->SeederData(mt_rand(11,15));
            }
        }
    }

    protected function SeederData($pid=0)
    {
        User::create([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make(Str::random(8)),
            'code' => Str::random(10),
            'pid' => $pid
        ]);
    }
}
