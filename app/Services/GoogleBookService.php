<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Google Book Apiにアクセスするサービスクラス
 */
class GoogleBookService
{
    protected $url = 'https://www.googleapis.com/books/v1/volumes?q=';

    protected $search_publisher = 'inpublisher:';

    protected $search_genre = 'subject:';

    protected $search_limit = '&maxResults=';

    protected $order = '&orderBy=newest';

    protected $limit = 10;

    protected $api_key;

    /**
     * 初期化時にGoogle Books APIのAPIキーを取得する
     */
    public function __construct()
    {
        $this->api_key = "&key=" . config('services.google_books.api_key');
    }

    /**
     * Google Book Apiにアクセスして書籍情報を取得する
     * 基本的に出版社とジャンルを指定して検索する
     * 検索して取得した情報を配列で返す
     *
     * @param string $publisher
     * @param string $genre
     * @return array
     */
    public function searchBooks(string $publisher, string $genre): array
    {
        $response = Http::get($this->url .
            $this->search_publisher . $publisher . '+' .
            $this->search_genre . $genre .
            $this->search_limit . $this->limit .
            $this->order .
            $this->api_key
        );

        // responseが200ならばレコードの整形を行う
        if ($response->successful()) {

            $res = $response->json();

            // 万が一成功だったとしても レスポンスにitemsがなければ空の配列を返す
            if (empty($res['items'])) {
                return [];
            }

            $items = $response->json()['items'];

            $books = [];
            foreach ($items as $item) {
                $book = [
                    'title' => $item['volumeInfo']['title'],
                    'authors' => $item['volumeInfo']['authors'],
                    'publisher' => $item['volumeInfo']['publisher'],
                    'publishedDate' => $item['volumeInfo']['publishedDate'],
                    'description' => $item['volumeInfo']['description'],
                    'thumbnail' => $item['volumeInfo']['imageLinks']['thumbnail'],
                    'previewLink' => $item['volumeInfo']['previewLink'],
                    'genre' => $item['volumeInfo']['categories'][0],
                ];
                $books[] = $book;
            }
            return $books;
        } else {
            // エラーハンドリング
            // responseが200以外ならば例外を投げる
            // 参考のために responseの内容を表示
            throw new \Exception('Google Book Api との通信に失敗しました'. $response->body() . ' ' . $response->status());
        }

    }
}
