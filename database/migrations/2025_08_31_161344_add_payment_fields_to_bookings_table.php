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
            $table->enum('payment_status', ['pending', 'advance', 'partial', 'full'])->default('pending')->after('status');
            $table->decimal('outstanding_balance', 10, 2)->default(0.00)->after('total_amount');
            $table->decimal('advance_amount', 10, 2)->default(0.00)->after('outstanding_balance');
            $table->text('customer_details')->nullable()->after('admin_notes'); // Store contact details when converted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'outstanding_balance', 'advance_amount', 'customer_details']);
        });
    }
};
