<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Админ',
                'guard_name' => 'admin',
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Менеджер',
                'guard_name' => 'manager',
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Модеранор',
                'guard_name' => 'moderator',
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'SIMbank',
                'guard_name' => 'simbank',
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Пользователь',
                'guard_name' => 'user',
                'created_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                'updated_at' => \Illuminate\Support\Carbon::now()->toDateTimeString()
            ],

        ];

        DB::table('countries')->insert($data);
    }
}
