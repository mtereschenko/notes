<?php

use App\Models\SharedNote;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_notes', function (Blueprint $table) {
            $table->id();
            $table->string(SharedNote::EMAIL_ATTRIBUTE)->index();
            $table->string(SharedNote::SLUG_ATTRIBUTE)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_notes');
    }
}
