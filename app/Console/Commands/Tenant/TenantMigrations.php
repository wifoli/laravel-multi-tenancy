<?php

namespace App\Console\Commands\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrations {id?} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Migrations Tenants';

    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();
        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        if ($id = $this->argument('id')) {
            $company = Company::find($id);

            if (!$company) {
                $this->error('Company not found');
                return 1;
            }

            $this->execCommend($command, $company);

            return;
        }

        $companies = Company::all();

        foreach ($companies as $company)
            $this->execCommend($command, $company);
    }

    public function execCommend($command, $company)
    {
        $this->tenant->setConection($company);

        $this->info("Connecting Company {$company->name}");

        Artisan::call($command, [
            '--force' => true,
            '--path' => 'database/migrations/tenant',
        ]);

        $this->info("End Connecting Company {$company->name}");
        $this->info("-----------------------------------------");
    }
}
