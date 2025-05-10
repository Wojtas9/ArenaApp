<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\MySqlGrammar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Fix for older MySQL versions that don't have generation_expression column
        if (DB::connection()->getDriverName() === 'mysql') {
            $version = DB::select('select version() as version')[0]->version;
            
            if (version_compare($version, '5.7.0', '<')) {
                $this->fixMySqlSchemaBuilder();
            }
        }
    }

    protected function fixMySqlSchemaBuilder()
    {
        // Override the column listing method to be compatible with older MySQL versions
        DB::connection()->setSchemaGrammar(new class extends MySqlGrammar {
            protected function compileColumnListing()
            {
                return 'select column_name as `name`, data_type as `type_name`, column_type as `type`, ' .
                    'collation_name as `collation`, is_nullable as `nullable`, ' .
                    'column_default as `default`, column_comment as `comment`, ' .
                    'extra as `extra` ' .
                    'from information_schema.columns ' .
                    'where table_schema = ? and table_name = ? ' .
                    'order by ordinal_position asc';
            }
        });
    }

    public function register()
    {
        //
    }
}