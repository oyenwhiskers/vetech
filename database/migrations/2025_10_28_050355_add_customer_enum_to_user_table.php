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
        // Modify the existing role enum to include 'customer'
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin', 'collaborator', 'customer') NOT NULL DEFAULT 'customer'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values (without 'customer')
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin', 'collaborator') NOT NULL DEFAULT 'admin'");
    }
};
