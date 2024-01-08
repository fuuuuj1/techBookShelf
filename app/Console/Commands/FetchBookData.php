<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchBookData extends Command
{
    /**
     * 出版社、ジャンルを引数にとり、Google Books APIから書籍情報を取得する
     *
     * @var string
     */
    protected $signature = 'fetch:book {publisher} {genre}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get book data from Google Books API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 出版社、ジャンルを取得
        $publisher = $this->argument('publisher');
        $genre = $this->argument('genre');

        // Google Books APIから書籍情報を取得
    }
}
