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
            // Add missing fields if they don't exist
            if (!Schema::hasColumn('bookings', 'booking_type')) {
                $table->enum('booking_type', ['per_night', 'weekly', 'monthly'])->default('per_night')->after('room_id');
            }
            
            if (!Schema::hasColumn('bookings', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->after('status');
            }
            
            if (!Schema::hasColumn('bookings', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'advance', 'partial', 'full'])->default('pending')->after('status');
            }
            
            if (!Schema::hasColumn('bookings', 'outstanding_balance')) {
                $table->decimal('outstanding_balance', 10, 2)->default(0)->after('total_amount');
            }
            
            if (!Schema::hasColumn('bookings', 'advance_amount')) {
                $table->decimal('advance_amount', 10, 2)->default(0)->after('outstanding_balance');
            }
            
            if (!Schema::hasColumn('bookings', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('advance_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'booking_type',
                'created_by',
                'payment_status',
                'outstanding_balance',
                'advance_amount',
                'admin_notes'
            ]);
        });
    }
};
