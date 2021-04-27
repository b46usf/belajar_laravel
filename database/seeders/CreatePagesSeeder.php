<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pages;

class CreatePagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = Pages::create(
            [
                'name'  => 'Customers', 
                'url'   => '/customers/',
            ],
            [
                'name'  => 'Users', 
                'url'   => '/users/',
            ],
            [
                'name'  => 'Roles', 
                'url'   => '/roles/',
            ],
        );
    }
}
