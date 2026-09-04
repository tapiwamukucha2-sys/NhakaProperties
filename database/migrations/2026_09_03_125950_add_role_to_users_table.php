<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['renter', 'landlord', 'agent', 'admin'])->default('renter')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->boolean('is_verified')->default(false)->after('phone');
            $table->timestamp('verified_at')->nullable()->after('is_verified');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'is_verified', 'verified_at']);
        });
    }
};
