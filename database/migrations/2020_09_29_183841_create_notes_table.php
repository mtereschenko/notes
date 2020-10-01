<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Note;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string(Note::TITLE_ATTRIBUTE, 250);
            $table->string(Note::SLUG_ATTRIBUTE, 250)->index();
            $table->text(Note::PREVIEW_BODY_ATTRIBUTE);
            $table->longText(Note::BODY_ATTRIBUTE);
            $table->integer(Note::PRIVACY_STATUS_ATTRIBUTE)->default(Note::PRIVATE);
            $table->integer(Note::USER_ID_ATTRIBUTE);
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
        Schema::dropIfExists('notes');
    }
}
