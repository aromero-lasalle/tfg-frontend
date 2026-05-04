<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🔹 Añadir rol a usuarios
        Schema::table('users', function (Blueprint $table) {
            $table->string('rol')->default('usuario'); 
            // admin | tecnico | usuario
        });

        // 🔹 Añadir campos a tickets
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['assigned_by']);

            $table->dropColumn(['created_by', 'assigned_by']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol');
        });
    }
};