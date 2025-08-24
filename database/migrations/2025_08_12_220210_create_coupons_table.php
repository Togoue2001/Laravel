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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Code promo
            $table->unsignedBigInteger('user_id')->nullable(); // Client spécifique
            $table->decimal('discount', 8, 2); // Montant ou pourcentage
            $table->boolean('is_percentage')->default(true); // % ou montant fixe
            $table->dateTime('expires_at')->nullable(); // Expiration
            $table->boolean('is_active')->default(true); // Activé ou non
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon');
    }
};
