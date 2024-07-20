<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
//            // First, convert existing values
//        DB::statement("UPDATE users SET role = CASE
//            WHEN role = 'admins' THEN 'admin'
//            WHEN role = 'editors' THEN 'editor'
//            WHEN role = 'supervisors' THEN 'supervisor'
//            ELSE role END");

        // Then, alter the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'editor', 'supervisor')");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            //    // If you need to roll back, you can revert to the original enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admins', 'editors', 'supervisors')");
    //
    //    // And convert the values back
    //    DB::statement("UPDATE users SET role = CASE
    //            WHEN role = 'admin' THEN 'admins'
    //            WHEN role = 'editor' THEN 'editors'
    //            WHEN role = 'supervisor' THEN 'supervisors'
    //            ELSE role END");

    }
};
