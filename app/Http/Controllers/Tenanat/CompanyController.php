<?php

namespace App\Http\Controllers\Tenanat;

use App\Events\Tenant\CompanyCreated;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function store(Request $request)
    {
        $random = Str::random(5);
        $company = $this->company->create([
            'name' => "Empresa {$random}",
            'domain' => "{$random}empresa.com",
            'db_database' => "multi_tenant_{$random}",
            'db_hostname' => 'mysql',
            'db_username' => 'root',
            'db_password' => 'root'
        ]);

        event(new CompanyCreated($company));

        dd($company);
    }
}
