<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class all_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seeder clients
        $clients = [
            [
                'client_id' => 1,
                'name' => 'Tipen',
                'phone_num' => '08123456789',
                'username' => 'tipen',
                'password' => 'budak1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => 2,
                'name' => 'Susin',
                'phone_num' => '08123456789',
                'username' => 'susin',
                'password' => 'budak2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => 3,
                'name' => 'Tuny',
                'phone_num' => '08123456789',
                'username' => 'tuny',
                'password' => 'budak3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        
        DB::connection('mysql_client')->table('clients')->insert($clients);
        DB::connection('mysql_login')->table('clients')->insert($clients);
        DB::connection('mysql_order')->table('clients')->insert($clients);
        
        //staff seeder
        $staffs = [
            [
                'staff_id' => 1,
                'name' => 'Staff Tipen',
                'phone_num' => '08123456789',
                'username' => 'tipen-stafff',
                'password' => 'budak1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id' => 2,
                'name' => 'Staff Susin',
                'phone_num' => '08123456789',
                'username' => 'susin-stafff',
                'password' => 'budak2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id' => 3,
                'name' => 'Staff Tuny',
                'phone_num' => '08123456789',
                'username' => 'tuny-stafff',
                'password' => 'budak3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::connection('mysql_staff')->table('staffs')->insert($staffs);
        DB::connection('mysql_login')->table('staffs')->insert($staffs);
        DB::connection('mysql_order')->table('staffs')->insert($staffs);
        DB::connection('mysql_event')->table('staffs')->insert($staffs);
        
        //packages seeder
        $packages = [
            [
                'package_id' => 1,
                'name' => 'Pernikahan',
                'price' => 100000000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
            [
                'package_id' => 2,
                'name' => "Sweet Seventeen",
                'price' => 50000000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'package_id' => 3,
                'name' => 'Lamaran',
                'price' => 30000000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'package_id' => 4,
                'name' => 'Graduation',
                'price' => 25000000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        
        DB::connection('mysql_order')->table('packages')->insert($packages);
        
        //order seeder
        $orders = [
            [
                'order_id' => 1,
                'start_date' => Carbon::createFromDate(2023, 6, 19),
                'end_date' => Carbon::createFromDate(2023, 6, 20),
                'note' => 'Minta yang mewah ya mas',
                'package_id' => 1,
                'client_id' => 1,
                'staff_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => 2,
                'start_date' => Carbon::createFromDate(2023, 9, 30),
                'end_date' => Carbon::createFromDate(2023, 9, 30),
                'note' => 'nuansa perjuangan ya mas :)',
                'package_id' => 2,
                'client_id' => 2,
                'staff_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => 3,
                'start_date' => Carbon::createFromDate(2023, 10, 10),
                'end_date' => Carbon::createFromDate(2023, 10, 10),
                'note' => 'Mau lamaran yang Chinese banget, keluarga saya totok soalnya (✿◡‿◡)',
                'package_id' => 3,
                'client_id' => 3,
                'staff_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];
            
        DB::connection('mysql_order')->table('orders')->insert($orders);
        DB::connection('mysql_event')->table('orders')->insert($orders);
        
        //event seeder
        $events = [
            [
                'event_id' => 1,
                'start' => Carbon::create(2023, 6, 19, 9, 0, 0),
                'end' => Carbon::create(2023, 6, 19, 11, 0, 0),
                'description' => 'Pemberkatan pernikahan oleh Romo Aloysius di Gereja Katedral',
                'order_id' => 1,
                'staff_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 2,
                'start' => Carbon::create(2023, 6, 19, 11, 30, 0),
                'end' => Carbon::create(2023, 6, 19, 13, 30, 0),
                'description' => 'Sesi Foto bersama keluarga besar di gereja',
                'order_id' => 1,
                'staff_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 3,
                'start' => Carbon::create(2023, 6, 20, 17, 0, 0),
                'end' => Carbon::create(2023, 6, 20, 21, 0, 0),
                'description' => 'Wedding Party di depan rumah (sewa terop)',
                'order_id' => 1,
                'staff_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 4,
                'start' => Carbon::create(2023, 9, 30, 15, 0, 0),
                'end' => Carbon::create(2023, 9, 30, 17, 0, 0),
                'description' => 'Make up',
                'order_id' => 2,
                'staff_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'event_id' => 5,
                'start' => Carbon::create(2023, 9, 30, 18, 0, 0),
                'end' => Carbon::create(2023, 9, 30, 21, 0, 0),
                'description' => 'Sweet 17 di aula SMA Katolik WijayaKusuma',
                'order_id' => 2,
                'staff_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::connection('mysql_event')->table('events')->insert($events);
    }
}
