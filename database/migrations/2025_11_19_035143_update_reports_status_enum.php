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
        // 1️⃣ Update existing rows to lowercase
        DB::table('reports')->where('status', 'Pending')->update(['status' => 'pending']);
        DB::table('reports')->where('status', 'In Progress')->update(['status' => 'in-progress']);
        DB::table('reports')->where('status', 'Resolved')->update(['status' => 'resolved']);

        // 2️⃣ Change the column to ENUM
        Schema::table('reports', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in-progress', 'resolved'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1️⃣ Revert ENUM to string
        Schema::table('reports', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });

        // 2️⃣ Optionally revert data back to original format
        DB::table('reports')->where('status', 'pending')->update(['status' => 'Pending']);
        DB::table('reports')->where('status', 'in-progress')->update(['status' => 'In Progress']);
        DB::table('reports')->where('status', 'resolved')->update(['status' => 'Resolved']);
    }
};
