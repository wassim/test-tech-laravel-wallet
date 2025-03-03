<?php

declare(strict_types=1);

use App\Enums\RecurringTransferStatus;
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
        Schema::create('recurring_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('recipient_email');
            $table->string('reason')->nullable();
            $table->integer('amount');
            $table->integer('frequency')->unsigned();
            $table->dateTime('next_execution')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default(RecurringTransferStatus::ACTIVE);
            $table->text('last_error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_transfers');
    }
};
