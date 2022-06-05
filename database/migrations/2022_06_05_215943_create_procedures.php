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
        $createExampleTree = '
        CREATE OR REPLACE PROCEDURE createExampleTree()
        BEGIN
            INSERT INTO treenodes(id, name, parentId) VALUES
            (1, "Example node 1", 0),
            (2, "Example node 2", 0),
            (3, "Example node 3", 1),
            (4, "Example node 4", 3),
            (5, "Example node 5", 2),
            (6, "Example node 6", 3),
            (7, "Example node 7", 4),
            (8, "Example node 8", 0),
            (9, "Example node 9", 4);
        END';

        $deleteAllNodes = '
        CREATE OR REPLACE PROCEDURE deleteAllNodes()
        BEGIN
            DELETE FROM treenodes WHERE id > 0;
        END';

        DB::unprepared($createExampleTree);
        DB::unprepared($deleteAllNodes);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedures');
    }
};
