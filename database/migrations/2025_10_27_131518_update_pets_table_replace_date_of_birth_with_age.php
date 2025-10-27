<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            // Add age column
            $table->integer('age')->nullable()->after('breed');
            
            // Remove date_of_birth column
            $table->dropColumn('date_of_birth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            // Add back date_of_birth column
            $table->date('date_of_birth')->nullable()->after('breed');
            
            // Remove age column
            $table->dropColumn('age');
        });
    }
};
