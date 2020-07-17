<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // it need to be updated in the future
        // in the access control development stage
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // create roles and give permissions to them
        $role1 = Role::create(['name' => 'user']);
        $role1->givePermissionTo('edit articles');
        $role1->givePermissionTo('delete articles');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('publish articles');
        $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['name' => 'manager']);
        $role3->givePermissionTo('edit articles');
        $role3->givePermissionTo('delete articles');

        $role4 = Role::create(['name' => 'moderator']);
        $role4->givePermissionTo('edit articles');
        $role4->givePermissionTo('delete articles');

        $role5 = Role::create(['name' => 'simbank']);
        $role5->givePermissionTo('edit articles');
        $role5->givePermissionTo('delete articles');

        // we have fixed 5 roles now
        $roles = [$role1, $role2, $role3, $role4, $role5];

        // index in $roles array
        // we want to have users with all diapason roles
        // so we assign roles to the users one by one
        $roleIndex = 0;
        for($i = 0; $i < config('seed.usersCount'); $i ++){
            $user = Factory(\App\Models\User::class)->create([
                'name' => $faker->firstName,
                'email' => $faker->email,
            ]);

            $user->assignRole($roles[$roleIndex]);

            // we have only 5 roles, so need to reset couter
            if($roleIndex == 4){
                $roleIndex = 0;
            }
        }
    }
}
