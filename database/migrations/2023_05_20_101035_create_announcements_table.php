<?php

use App\Models\Category;
use App\Models\Company;
use App\Models\Contract;
use App\Models\EarnTime;
use App\Models\WorkTime;
use App\Models\WorkType;
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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->json('duties');
            $table->json('requirements');
            $table->json('offer');
            $table->date('expiry_date');
            $table->decimal('min_earn', 5, 2)->nullable();
            $table->decimal('max_earn', 5, 2)->nullable();
            $table->foreignIdFor(EarnTime::class)->nullable()->constrained();
            $table->foreignIdFor(Contract::class)->constrained();
            $table->foreignIdFor(Company::class)->constrained();
            $table->foreignIdFor(Category::class)->constrained();
            $table->foreignIdFor(WorkTime::class)->constrained();
            $table->foreignIdFor(WorkType::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
