<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAssistanceFields extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('seekingAssistance', 10)->nullable()->after('phoneVerified');
            $table->string('offeringAssistance', 10)->nullable()->after('phoneVerified');
            $table->dateTime('updatedAt')->nullable()->after('registeredAt');
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
            $table->dropColumn('seekingAssistance');
            $table->dropColumn('offeringAssistance');
            $table->dropColumn('updatedAt');
        });
    }

}
