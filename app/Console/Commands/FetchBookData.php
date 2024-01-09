<?php

namespace App\Console\Commands;

use App\Services\GoogleBookService;
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
        // まずはserviceクラスをインスタンス化
        $googleBookService = new GoogleBookService();
        // serviceクラスのsearchBooksメソッドを実行
        $books = $googleBookService->searchBooks($publisher, $genre);

        // 今のところ、取得した書籍情報をコンソールに表示するだけ
        // TODO: 万が一のエラーハンドリングを実装する
        // TODO: Slackへの例外発生通知の実装のタイミングで、エラーハンドリングを実装する
        dd($books);

        // TODO: 取得した書籍情報をDBに保存する
        // TODO: DBに保存するために、まずはBookモデルを作成する
    }
}
