<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('email');
            $table->string('google_id')->nullable()->after('phone_number');
        });

        Schema::table('bookings', function (Blueprint $table) {
            // Drop legacy columns
            $table->dropColumn(['customer_name', 'customer_email']);

            // Add user_id foreign key
            $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'google_id']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->string('customer_name', 150)->nullable();
            $table->string('customer_email', 150)->nullable();
        });
    }
};
