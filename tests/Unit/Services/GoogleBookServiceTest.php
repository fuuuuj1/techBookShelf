<?php

namespace Tests\Unit\Services;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Services\GoogleBookService;
use Illuminate\Support\Facades\Http;

/**
 * GoogleBookServiceクラスのテスト
 * test 実行コマンド: vendor/bin/phpunit tests/Unit/Services/GoogleBookServiceTest.php
 * sail ver 実行コマンド: sail test tests/Unit/Services/GoogleBookServiceTest.php
 *
 */
class GoogleBookServiceTest extends TestCase
{
    public function test_searchBooks_取得に成功(): void
    {
        // Google Books APIのレスポンスをモック
        Http::fake([
            '*' => Http::response([
                'items' => [
                    [
                        'volumeInfo' => [
                            'title' => 'Book 1',
                            'authors' => ['Author 1'],
                            'publisher' => 'Publisher 1',
                            'publishedDate' => '2022-01-01',
                            'description' => 'Description 1',
                            'imageLinks' => [
                                'thumbnail' => 'thumbnail1.jpg',
                            ],
                            'previewLink' => 'previewlink1',
                            'categories' => ['Genre 1'],
                        ],
                        // 実装で必要になれば項目を追加
                    ],
                ],
            ]),
        ]);

        // GoogleBookServiceクラスのインスタンスを作成
        $google_book_service = new GoogleBookService();

        // GoogleBookServiceクラスのsearchBooksメソッドを実行
        $books = $google_book_service->searchBooks('Publisher', 'Genre');

        // responseが配列であることを確認
        $this->assertIsArray($books);

        // responseの内容を確認
        $this->assertEquals([
            [
                'title' => 'Book 1',
                'authors' => ['Author 1'],
                'publisher' => 'Publisher 1',
                'publishedDate' => '2022-01-01',
                'description' => 'Description 1',
                'thumbnail' => 'thumbnail1.jpg',
                'previewLink' => 'previewlink1',
                'genre' => 'Genre 1',
            ],
        ], $books);
    }

    public function test_searchBooks_対象レコードが見つからなかった場合(): void
    {
        // Google Books APIのレスポンスをモック
        Http::fake([
            '*' => Http::response([
                'items' => [],
            ]),
        ]);

        // GoogleBookServiceクラスのインスタンスを作成
        $google_book_service = new GoogleBookService();

        // GoogleBookServiceクラスのsearchBooksメソッドを実行
        $books = $google_book_service->searchBooks('Publisher', 'Genre');

        // responseが空の配列であることを確認
        $this->assertIsArray($books);
        $this->assertEmpty($books);
    }

    public function test_searchBooks_取得失敗(): void
    {
        // Google Books APIのレスポンスをモック
        Http::fake([
            '*' => Http::response([], 500),
        ]);

        // GoogleBookServiceクラスのインスタンスを作成
        $google_book_service = new GoogleBookService();

        // 例外が投げられることを確認
        $this->expectException(\Exception::class);

        // GoogleBookServiceクラスのsearchBooksメソッドを実行
        $google_book_service->searchBooks('Publisher', 'Genre');
    }
}
