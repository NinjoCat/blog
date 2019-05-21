<?php

namespace App\Console\Commands;

use App\Revision;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class CleanRevisions extends Command
{
    const MAX_REVISIONS_COUNT = 5;
    const MAX_DAYS_COUNT = 30;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revisions:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean revisions';

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
     * @return mixed
     */
    public function handle()
    {
        DB::table('revisions')
        ->select(DB::raw('post_id, count(id) as revisions_count'))
        ->groupBy('post_id')
        ->orderBy('post_id')
        ->havingRaw('COUNT(id) > ?', [self::MAX_REVISIONS_COUNT])
        ->chunk(100, function ($revisionsData) {
            foreach ($revisionsData->toArray() as $rev) {
                DB::table('revisions')
                ->where('post_id', $rev->post_id)
                ->where('status', '<>', Revision::STATUS['ACTIVE'])
                ->whereRaw('created_at < FROM_UNIXTIME(UNIX_TIMESTAMP() - ?*24*60*60)', [self::MAX_DAYS_COUNT])
                ->orderBy('id', 'asc')
                ->limit($rev->revisions_count - self::MAX_REVISIONS_COUNT)
                ->delete();
            }
        });
    }
}
