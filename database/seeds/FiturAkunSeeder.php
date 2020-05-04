<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\ACLRole as Role;
use App\Models\ACLPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class FiturAkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = uuid();
        DB::beginTransaction();

        try {
            User::create([
                'id'        => $user_id,
                'name'      => 'Dandi Fermeko',
                'email'     => 'dandi@gandengtangan.org',
                'password'  => Hash::make('12345678')
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning( get_class($this).' '.$e->getMessage() .' '.__LINE__);
            throw $e;
        }

        try {
            Admin::create([
                'user_id'   => $user_id,
                'fullname'  => 'Dandi Fermeko',
                'phone'     => '081219344136'
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning( get_class($this).' '.$e->getMessage() .' '.__LINE__);
            throw $e;
        }

        $super_admin = uuid();
        // $data_role = [
        //     [
        //         'id'            => $super_admin,
        //         'name'          => 'Super-Admin',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Admin',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Donatur',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Fundraiser',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Finance',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ]
        // ];

        // ACLRole::insert($data_role);
        Role::create([
            'id'            => $super_admin,
            'name'          => 'Super-Admin',
            'guard_name'    => 'web'
        ]);
        Role::create([
            'id'            => uuid(),
            'name'          => 'Admin',
            'guard_name'    => 'web'
        ]);
        Role::create([
            'id'            => uuid(),
            'name'          => 'Donatur',
            'guard_name'    => 'web',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s")
        ]);
        Role::create([
            'id'            => uuid(),
            'name'          => 'Fundraiser',
            'guard_name'    => 'web',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s")
        ]);
        Role::create([
            'id'            => uuid(),
            'name'          => 'Finance',
            'guard_name'    => 'web',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s")
        ]);
        
        // $data_permission = [
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Read-Akun',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],

        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Full-Manage-Akun',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],

        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Donatur-Read',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Donatur-Create',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Donatur-Update',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Donatur-Delete',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],

        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Fundraiser-Read',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Fundraiser-Create',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Fundraiser-Update',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Fundraiser-Delete',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],

        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Finance-Read',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Finance-Create',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Finance-Update',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Finance-Delete',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'id'            => uuid(),
        //         'name'          => 'Report-Monitoring',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s"),
        //         'updated_at'    => date("Y-m-d H:i:s")
        //     ],
        // ];
        // ACLPermission::insert($data_permission);

        // $data_permission = [
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Read-Akun',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);

            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Full-Manage-Akun',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);

            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Donatur-Read',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Donatur-Create',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Donatur-Update',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Donatur-Delete',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);

            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Fundraiser-Read',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Fundraiser-Create',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Fundraiser-Update',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Fundraiser-Delete',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);

            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Finance-Read',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Finance-Create',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Finance-Update',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Finance-Delete',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
            ACLPermission::create([
                'id'            => uuid(),
                'name'          => 'Report-Monitoring',
                'guard_name'    => 'web',
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s")
            ]);
        
       
        DB::commit();

        User::find($user_id)->assignRole('Super-Admin');
    }
}
