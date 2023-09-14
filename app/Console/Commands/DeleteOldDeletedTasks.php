<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Tasks;
use App\Models\SubTasks;

class DeleteOldDeletedTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete the deleted old records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now()->subMonth();

        SubTasks::onlyTrashed()
            ->where('deleted_at', '<', $date)
            ->forceDelete();

        Tasks::onlyTrashed()
            ->where('deleted_at', '<', $date)
            ->forceDelete();

    }
}
