<?php


namespace AlwaysOpen\MigrationSnapshot\Tests\Postgresql;

use AlwaysOpen\MigrationSnapshot\Tests\TestCase;

class MigrateLoadTest extends TestCase
{
    protected $dbDefault = 'pgsql';

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set(
            'migration-snapshot.after-load',
            function ($schema_sql_path, $data_sql_path) {
                throw new \RuntimeException("AfterLoadTest,{$schema_sql_path},{$data_sql_path}");
            }
        );
    }

    public function test_handle()
    {
        // Make the dump file.
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
            ->where('table_catalog', \DB::getDatabaseName())
            ->where('table_schema', 'public')
            ->whereNotIn('table_name', ["{$this->dbPrefix}migrations"])
            ->where('table_name', 'NOT LIKE', 'pg_%')
            ->value('table_name');

        $this->assertEquals("{$this->dbPrefix}test_ms", $table_name);
    }

    // TODO: Test no-drop and prompt-when-production.

    public function test_load_callsAfterLoadClosure()
    {
        $this->createTestTablesWithoutMigrate();
        $result = \Artisan::call('migrate:dump');
        $this->assertSame(0, $result);
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("AfterLoadTest,");
        \Artisan::call('migrate:load');
    }
}
