<?php


namespace AlwaysOpen\MigrationSnapshot\Tests\Mysql;

use AlwaysOpen\MigrationSnapshot\Tests\TestCase;

class MigrateLoadTest extends TestCase
{
    public function test_handle()
    {
        // Make the dump file.
        // CONSIDER: Instead using fixture copy of file from SCM.
        $this->createTestTablesWithoutMigrate();
        $result = \Artisan::call('migrate:dump');
        $this->assertEquals(0, $result);
        \Schema::dropAllTables();

        $result = \Artisan::call('migrate:load');
        $this->assertEquals(0, $result);

        $this->assertEquals(
            '0000_00_00_000000_create_test_tables',
            \DB::table('migrations')->value('migration')
        );

        $this->assertEquals(0, \DB::table('test_ms')->count());

        $table_name = \DB::table(\DB::raw('information_schema.tables'))
            ->where('table_schema', \DB::getDatabaseName())
            ->whereNotIn('table_name', ["{$this->dbPrefix}migrations"])
            ->value('table_name');

        $this->assertEquals("{$this->dbPrefix}test_ms", $table_name);
    }

    // TODO: Test no-drop and prompt-when-production.
}
