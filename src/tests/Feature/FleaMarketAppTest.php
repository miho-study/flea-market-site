<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Nice;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Purchase;

class FleaMarketAppTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 会員登録のバリデーションと登録成功()
    {
        $this->from('/register')->followingRedirects()
            ->post('/register', [
                'name' => '',
                'email' => 'a@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertSee('お名前を入力してください');

        $this->from('/register')->followingRedirects()
            ->post('/register', [
                'name' => 'テスト',
                'email' => '',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertSee('メールアドレスを入力してください');

        $this->from('/register')->followingRedirects()
            ->post('/register', [
                'name' => 'テスト',
                'email' => 'b@example.com',
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertSee('パスワードを入力してください');

        $this->from('/register')->followingRedirects()
            ->post('/register', [
                'name' => 'テスト',
                'email' => 'c@example.com',
                'password' => 'short7',
                'password_confirmation' => 'short7',
            ])
            ->assertSee('パスワードは8文字以上で入力してください。');

        $this->from('/register')->followingRedirects()
            ->post('/register', [
                'name' => 'テスト',
                'email' => 'd@example.com',
                'password' => 'password123',
                'password_confirmation' => 'different',
            ])
            ->assertSee('パスワードと一致しません。');

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $response->assertRedirect('/mypage/profile');
    }

    /** @test */
    public function ログインのバリデーションと成功()
    {
        $this->from('/login')->followingRedirects()
            ->post('/login', ['email' => '', 'password' => 'password'])
            ->assertSee('メールアドレスを入力してください');

        $this->from('/login')->followingRedirects()
            ->post('/login', ['email' => 'no@example.com', 'password' => ''])
            ->assertSee('パスワードを入力してください');

        $this->from('/login')->followingRedirects()
            ->post('/login', ['email' => 'noone@example.com', 'password' => 'password'])
            ->assertSee('認証情報と一致するレコードがありません。');

        $user = User::factory()->create(['password' => bcrypt('password123')]);
        $this->post('/login', ['email' => $user->email, 'password' => 'password123']);
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function ログアウトができる()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test */
    public function 商品一覧と表示条件()
    {
        $product = Product::factory()->create();
        $this->get('/')->assertStatus(200)->assertSee($product->product_name);

        $sold = Product::factory()->create(['is_sold' => true]);
        $this->get('/')->assertSee('Sold');

        $user = User::factory()->create();
        $own = Product::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user)->get('/')->assertDontSee($own->product_name);
    }

    /** @test */
    public function マイリスト表示と認証条件()
    {
        $user = User::factory()->create();
        $liked = Product::factory()->create(['is_sold' => true]);
        $notLiked = Product::factory()->create();

        $this->actingAs($user)->post(route('nice.store', $liked->id));

        $this->actingAs($user)->get('/?tab=mylist')
            ->assertSee($liked->product_name)
            ->assertSee('Sold')
            ->assertDontSee($notLiked->product_name);

        $this->post('/logout');
        $this->assertGuest();

        $this->get('/?tab=mylist')
            ->assertDontSee($liked->product_name);
    }

    /** @test */
    public function 検索が部分一致で機能しマイリストでも保持される()
    {
        Product::factory()->create(['product_name' => 'UniqueKeywordProduct']);

        $this->get('/search?keyword=UniqueKeyword')
            ->assertSee('UniqueKeywordProduct');

        $this->get('/?tab=mylist&keyword=UniqueKeyword')
            ->assertSee('value="UniqueKeyword"', false);
    }

    /** @test */
    public function 商品詳細に必要な情報とカテゴリが表示される()
    {
        $product = Product::factory()->create([
            'product_name' => 'DetailName',
            'brand_name' => 'BrandX',
            'price' => 1234,
            'product_description' => '説明テキスト',
            'product_condition' => '新品',
        ]);

        $cat1 = Category::create(['category_name' => 'カテゴリーA']);
        $cat2 = Category::create(['category_name' => 'カテゴリーB']);
        $product->categories()->attach([$cat1->id, $cat2->id]);

        $commentUser = User::factory()->create(['name' => 'コメントユーザー']);
        Comment::create([
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
            'comment' => 'コメント内容',
        ]);

        $this->get(route('item.show', $product->id))
            ->assertStatus(200)
            ->assertSee('DetailName')
            ->assertSee('BrandX')
            ->assertSee('¥1,234')
            ->assertSee('説明テキスト')
            ->assertSee('新品')
            ->assertSee('カテゴリーA')
            ->assertSee('カテゴリーB')
            ->assertSee('コメント(1)')
            ->assertSee('コメントユーザー')
            ->assertSee('コメント内容');
    }

    /** @test */
    public function いいねと解除とアイコン状態()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)->post(route('nice.store', $product->id));
        $this->assertDatabaseHas('nices', ['user_id' => $user->id, 'product_id' => $product->id]);

        $this->actingAs($user)->get(route('item.show', $product->id))
            ->assertSee('liked');

        $this->actingAs($user)->post(route('nice.store', $product->id));
        $this->assertDatabaseMissing('nices', ['user_id' => $user->id, 'product_id' => $product->id]);
    }

    /** @test */
    public function コメント送信の認証とバリデーション()
    {
        $product = Product::factory()->create();

        $this->post(route('comments.store', $product->id), ['comment' => 'hello'])
            ->assertRedirect('/login');

        $user = User::factory()->create();
        $this->actingAs($user)->post(route('comments.store', $product->id), ['comment' => 'テストコメント']);
        $this->assertDatabaseHas('comments', ['comment' => 'テストコメント']);

        $this->actingAs($user)
            ->from(route('item.show', $product->id))
            ->followingRedirects()
            ->post(route('comments.store', $product->id), ['comment' => ''])
            ->assertSee('コメントを入力してください');

        $long = str_repeat('a', 256);
        $this->actingAs($user)
            ->from(route('item.show', $product->id))
            ->followingRedirects()
            ->post(route('comments.store', $product->id), ['comment' => $long])
            ->assertSee('コメントは255文字以内で入力してください');
    }

    /** @test */
    public function 購入処理と購入後の表示()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)->post(route('purchase.store', $product->id), [
            'payment_method' => 'コンビニ払い',
            'shipping_address' => '東京都新宿区',
        ]);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'is_sold' => true]);

        if (Schema::hasTable('purchases')) {
            $this->assertDatabaseHas('purchases', [
                'product_id' => $product->id,
                'user_id' => $user->id,
            ]);
        }

        $this->actingAs($user)->get('/')->assertSee('Sold');
        $this->actingAs($user)->get('/mypage?page=buy')->assertSee($product->product_name);
    }

    /** @test */
    public function 支払い方法表示と配送先変更反映と住所紐付け()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Comment::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => '購入前コメント',
        ]);

        $this->actingAs($user)
            ->get(route('purchase.confirm', $product->id))
            ->assertSee('支払い方法')
            ->assertSee('paymentMethod')
            ->assertSee('paymentMethodDisplay');

        $this->actingAs($user)
            ->from(route('purchase.address.edit', $product->id))
            ->post(route('purchase.address.update', $product->id), [
                'post_code' => '123-4567',
                'address' => '東京都港区',
                'building_name' => 'テストビル',
            ])
            ->assertRedirect(route('purchase.confirm', $product->id));

        $this->actingAs($user)
            ->get(route('purchase.confirm', $product->id))
            ->assertSee('〒 123-4567')
            ->assertSee('東京都港区')
            ->assertSee('テストビル');

        $this->actingAs($user)->post(route('purchase.store', $product->id), [
            'payment_method' => 'コンビニ払い',
            'shipping_address' => '東京都港区',
        ]);

        if (Schema::hasTable('purchases')) {
            $this->assertDatabaseHas('purchases', [
                'product_id' => $product->id,
                'user_id' => $user->id,
                'shipping_postcode' => '123-4567',
            ]);
        }
    }

    /** @test */
    public function プロフィール表示と編集初期値()
    {
        $user = User::factory()->create([
            'name' => 'プロフィール名',
            'post_code' => '111-2222',
            'address' => '東京都渋谷区',
            'building_name' => 'テストマンション',
        ]);

        $selling = Product::factory()->create(['user_id' => $user->id, 'product_name' => '出品商品A']);
        $otherSeller = User::factory()->create();
        $purchasedProduct = Product::factory()->create(['user_id' => $otherSeller->id, 'product_name' => '購入商品A']);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $purchasedProduct->id,
            'payment_method' => 'コンビニ払い',
            'shipping_address' => '東京都渋谷区',
            'shipping_postcode' => '111-2222',
            'shipping_building' => 'テストマンション',
        ]);

        $this->actingAs($user)
            ->get('/mypage')
            ->assertSee('プロフィール名')
            ->assertSee('出品商品A')
            ->assertSee('購入商品A')
            ->assertSee('default.jpeg');

        $this->actingAs($user)
            ->get('/mypage/profile')
            ->assertSee('value="プロフィール名"', false)
            ->assertSee('value="111-2222"', false)
            ->assertSee('value="東京都渋谷区"', false)
            ->assertSee('value="テストマンション"', false);
    }

    /** @test */
    public function 出品商品情報登録ができる()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $category = Category::create(['category_name' => 'テストカテゴリ']);
        $imagePath = base_path('public/default.jpeg');
        $uploadedImage = new UploadedFile(
            $imagePath,
            'default.jpeg',
            'image/jpeg',
            null,
            true
        );

        $response = $this->actingAs($user)->post('/sell', [
            'product_name' => 'テスト商品',
            'brand_name' => 'ブランド名',
            'product_description' => '説明テキスト',
            'product_image' => $uploadedImage,
            'category_ids' => [$category->id],
            'product_condition' => '良好',
            'price' => 1000,
        ]);

        $response->assertRedirect(route('search'));

        $product = Product::where('product_name', 'テスト商品')->first();
        $this->assertNotNull($product);
        $this->assertDatabaseHas('products', [
            'product_name' => 'テスト商品',
            'brand_name' => 'ブランド名',
            'price' => 1000,
        ]);
        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);
    }
}

