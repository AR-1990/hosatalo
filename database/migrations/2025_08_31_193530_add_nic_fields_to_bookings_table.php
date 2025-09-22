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
            $table->string('nic_number')->nullable()->after('customer_details');
            $table->string('nic_image_path')->nullable()->after('nic_number');
            $table->text('nic_verification_notes')->nullable()->after('nic_image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['nic_number', 'nic_image_path', 'nic_verification_notes']);
        });
    }
};
