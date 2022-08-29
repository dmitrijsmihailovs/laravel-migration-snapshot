<?php


namespace AlwaysOpen\MigrationSnapshot\Tests;

class MigrateLoadAfterClosureTest extends TestCase
{
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
