<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\CompanyCreated;
use App\Events\Tenant\DatabaseCreated;
use App\Tenant\Database\DatabaseManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateCompanyDatabase
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Tenant\CompanyCreated  $event
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        $company = $event->company();

        if (!$this->databaseManager->createDatabase($company))
            throw new \Exception("Could not create database for company {$company->name}");

        event(new DatabaseCreated($company));
    }
}
