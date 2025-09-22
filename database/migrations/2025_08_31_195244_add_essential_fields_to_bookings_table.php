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
        Schema::table('bookings', function (Blueprint $table) {
            // Add only essential fields that are missing
            if (!Schema::hasColumn('bookings', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'advance', 'partial', 'full'])->default('pending')->after('status');
            }
            
            if (!Schema::hasColumn('bookings', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('special_requests');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            
            if (Schema::hasColumn('bookings', 'admin_notes')) {
                $table->dropColumn('admin_notes');
            }
        });
    }
};
