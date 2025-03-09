<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
   /**
    * Run the database seeds.
    */
   public function run(): void {
      $roles = [
         [
            "name" => "Admin",
            "slug" => "admin"
         ],
         [
            "name" => "Contractor",
            "slug" => "contractor"
         ],
         [
            "name" => "Sub Contractor",
            "slug" => "sub-contractor"
         ]
      ];

      foreach ($roles as $role) {
         $rls = new Role();
         $rls->name = $role['name'];
         $rls->slug = $role['slug'];
         $rls->save();
      }

      dd("Role Created Sucessfully!.");
   }
}
