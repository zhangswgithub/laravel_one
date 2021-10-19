<?php

namespace App\Console\Commands;

use App\Models\Integral;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:top_ten';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '上一周用户的积分增长的前十个用户';

    const LIMIT = 10;

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
        $this->info('任务开始');
        $date = date('Y-m-d H:i:s',strtotime('-7 day'));
        $data = Integral::selectRaw('uid,sum(integral) as total')->where('updated_at','>=',$date)->groupBy('uid')->limit(self::LIMIT)->get();
        Log::channel('user_log')->info($data);
        $this->info('任务结束');
    }
}
