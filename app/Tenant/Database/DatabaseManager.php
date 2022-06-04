<?php

namespace App\Tenant\Database;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class DatabaseManager
{
    public function createDatabase(Company $company)
    {
        return DB::statement("
            CREATE DATABASE {$company->db_database} CHARSET utf8 COLLATE utf8_unicode_ci;
        ");
    }
}
