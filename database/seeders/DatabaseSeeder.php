<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Database\Seeders\AdminDatabaseSeeder;
use Modules\Branch\Database\Seeders\BranchDatabaseSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\Client\Database\Seeders\ClientDatabaseSeeder;
use Modules\Common\Database\Seeders\CommonDatabaseSeeder;
use Modules\Employee\Database\Seeders\EmployeeDatabaseSeeder;
use Modules\Order\Database\Seeders\OrderDatabaseSeeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(AdminDatabaseSeeder::class);
//        $this->call(ClientDatabaseSeeder::class);
//        $this->call(BranchDatabaseSeeder::class);
//        $this->call(CategoryDatabaseSeeder::class);
        $this->call(CommonDatabaseSeeder::class);
        // $this->call(EmployeeDatabaseSeeder::class);
    }
}
