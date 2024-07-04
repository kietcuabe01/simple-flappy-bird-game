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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->float('probability');
            $table->string('item');
        });

        \App\Models\Reward::insert([
            ['probability' => 10, 'item' => 'Iphone'],
            ['probability' => 30, 'item' => 'Voucher'],
        ]);

        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('reward_id')->nullable()->index();
            $table->integer('score')->default(0);
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
        Schema::dropIfExists('games');
    }
};
