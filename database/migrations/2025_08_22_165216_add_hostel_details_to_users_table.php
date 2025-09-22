<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // NIC (National Identity Card) - Required for clients
            $table->string('nic')->nullable()->after('address');
            
            // Hostel Details - Required for clients
            $table->string('hostel_name')->nullable()->after('nic');
            $table->text('hostel_description')->nullable()->after('hostel_name');
            $table->string('hostel_address')->nullable()->after('hostel_description');
            $table->string('hostel_phone')->nullable()->after('hostel_address');
            $table->string('hostel_email')->nullable()->after('hostel_phone');
            $table->string('hostel_website')->nullable()->after('hostel_email');
            
            // Hostel Images
            $table->string('hostel_logo')->nullable()->after('hostel_website');
            $table->string('hostel_banner')->nullable()->after('hostel_logo');
            $table->json('hostel_gallery')->nullable()->after('hostel_banner');
            
            // Business Details
            $table->string('business_license')->nullable()->after('hostel_gallery');
            $table->string('tax_number')->nullable()->after('business_license');
            $table->enum('hostel_type', ['budget', 'mid-range', 'luxury'])->nullable()->after('tax_number');
            $table->integer('total_rooms')->nullable()->after('hostel_type');
            $table->time('check_in_time')->default('14:00:00')->after('total_rooms');
            $table->time('check_out_time')->default('11:00:00')->after('check_in_time');
            
            // Location Details
            $table->decimal('latitude', 10, 8)->nullable()->after('check_out_time');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('city')->nullable()->after('longitude');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
            $table->string('postal_code')->nullable()->after('country');
            
            // Social Media
            $table->string('facebook_url')->nullable()->after('postal_code');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('twitter_url')->nullable()->after('instagram_url');
            
            // Additional Features
            $table->json('amenities')->nullable()->after('twitter_url');
            $table->json('policies')->nullable()->after('amenities');
            $table->text('special_offers')->nullable()->after('policies');
            $table->boolean('is_verified')->default(false)->after('special_offers');
            $table->timestamp('verified_at')->nullable()->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nic', 'hostel_name', 'hostel_description', 'hostel_address',
                'hostel_phone', 'hostel_email', 'hostel_website', 'hostel_logo',
                'hostel_banner', 'hostel_gallery', 'business_license', 'tax_number',
                'hostel_type', 'total_rooms', 'check_in_time', 'check_out_time',
                'latitude', 'longitude', 'city', 'state', 'country', 'postal_code',
                'facebook_url', 'instagram_url', 'twitter_url', 'amenities',
                'policies', 'special_offers', 'is_verified', 'verified_at'
            ]);
        });
    }
};
