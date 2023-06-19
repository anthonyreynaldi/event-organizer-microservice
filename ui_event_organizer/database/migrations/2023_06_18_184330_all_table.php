<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('CREATE DATABASE IF NOT EXISTS soa_client');
        DB::statement('CREATE DATABASE IF NOT EXISTS soa_staff');
        DB::statement('CREATE DATABASE IF NOT EXISTS soa_login');
        DB::statement('CREATE DATABASE IF NOT EXISTS soa_order');
        DB::statement('CREATE DATABASE IF NOT EXISTS soa_event');
        //
        $clientTable = [
            'table_name' => 'clients',
            'column' => function(Blueprint $table) {
                $table->id('client_id');
                $table->string('name');
                $table->string('phone_num');
                $table->string('username')->unique();
                $table->string('password');
                $table->timestamps();
            }
        ];
        
        $staffTable = [
            'table_name' => 'staffs',
            'column' => function(Blueprint $table) {
                $table->id('staff_id');
                $table->string('name');
                $table->string('phone_num');
                $table->string('username')->unique();
                $table->string('password');
                $table->timestamps();
            }
        ];
        
        $staffTable = [
            'table_name' => 'staffs',
            'column' => function(Blueprint $table) {
                $table->id('staff_id');
                $table->string('name');
                $table->string('phone_num');
                $table->string('username')->unique();
                $table->string('password');
                $table->timestamps();
            }
        ];
        
        $packageTable = [
            'table_name' => 'packages',
            'column' => function(Blueprint $table) {
                $table->id('package_id');
                $table->string('name');
                $table->integer('price');
                $table->timestamps();
            }
        ];

        $orderTable = [
            'table_name' => 'orders',
            'column' => function(Blueprint $table) {
                $table->id('order_id');
                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->text('note');
                $table->bigInteger('package_id');
                $table->bigInteger('client_id');
                $table->bigInteger('staff_id')->nullable();
                $table->timestamps();
            }
        ];
        
        $eventTable = [
            'table_name' => 'events',
            'column' => function(Blueprint $table) {
                $table->id('event_id');
                $table->dateTime('start');
                $table->dateTime('end');
                $table->text('description');
                $table->bigInteger('order_id');
                $table->bigInteger('staff_id')->nullable();
                $table->timestamps();
            }
        ];
        

        //client service db
        Schema::connection('mysql_client')->create($clientTable['table_name'],  $clientTable['column']);

        //staff service db
        Schema::connection('mysql_staff')->create($staffTable['table_name'],  $staffTable['column']);
        
        //login service db
        Schema::connection('mysql_login')->create($clientTable['table_name'],  $clientTable['column']);
        Schema::connection('mysql_login')->create($staffTable['table_name'],  $staffTable['column']);
        
        //order service db
        Schema::connection('mysql_order')->create($clientTable['table_name'],  $clientTable['column']);
        Schema::connection('mysql_order')->create($staffTable['table_name'],  $staffTable['column']);
        Schema::connection('mysql_order')->create($packageTable['table_name'],  $packageTable['column']);
        Schema::connection('mysql_order')->create($orderTable['table_name'],  $orderTable['column']);
        
        //event service db
        Schema::connection('mysql_event')->create($staffTable['table_name'],  $staffTable['column']);
        Schema::connection('mysql_event')->create($orderTable['table_name'],  $orderTable['column']);
        Schema::connection('mysql_event')->create($eventTable['table_name'],  $eventTable['column']);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        DB::statement('DROP DATABASE IF EXISTS soa_client');
        DB::statement('DROP DATABASE IF EXISTS soa_staff');
        DB::statement('DROP DATABASE IF EXISTS soa_login');
        DB::statement('DROP DATABASE IF EXISTS soa_order');
        DB::statement('DROP DATABASE IF EXISTS soa_event');
    }
};
