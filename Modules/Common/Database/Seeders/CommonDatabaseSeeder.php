<?php

namespace Modules\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Common\Entities\Setting;

class CommonDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $data = [
            ['key' => 'name', 'display' => 'الاسم', 'value' => 'Shop', 'type' => 'text'],
            ['key' => 'email', 'display' => 'البريد الالكتروني', 'value' => 'loz_moz@gmail.com', 'type' => 'text'],
            ['key' => 'terms', 'display' => 'الشروط والاحكام', 'value' => '', 'type' => 'textarea'],
            ['key' => 'about', 'display' => 'من نحن', 'value' => '', 'type' => 'textarea'],
        ];
        Setting::query()->insert($data);

        // $this->call("OthersTableSeeder");
    }
}
