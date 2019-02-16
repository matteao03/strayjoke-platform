<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

class ArticleLikeDataToSql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'strayjoke:article-like-data-to-sql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '文章点赞数据同步到数据库';

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
    public function handle(User $user)
    {
        // 在命令行打印一行信息
        $this->info("开始计算...");

        $user->ArticleLikestoSql();

        $this->info("成功生成！");
    }
}
