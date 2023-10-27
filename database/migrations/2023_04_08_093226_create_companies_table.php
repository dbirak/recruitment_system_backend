<?php

use App\Models\Province;
use App\Models\User;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('street');
            $table->string('post_code');
            $table->string('city');
            $table->string('krs')->nullable();
            $table->string('regon');
            $table->string('nip');
            $table->string('phone_number');
            $table->mediumText('description');
            $table->json('localization');
            $table->string("avatar")->nullable();
            $table->string("background_image")->nullable();
            $table->string("contact_email")->nullable();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Province::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
