<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Tests\TestCase as TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function it_has_a_path()
    {
        $post = Post::factory()->create();

        $this->assertEquals('/posts/'.$post->id, $post->path());
    }

    /** @test */
    public function it_is_hot_when_over_10_comments_in_the_last_day()
    {
        $user = User::factory()->create();

        $post = Post::factory()->create();

        // 15 older comments
        Comment::factory(15)->create([
            'body' => 'this is the comment body',
            'post_id' => $post->id,
            'user_id' => $user->id,
            'created_at' => now()->subDays(1),
        ]);

        $this->assertNotTrue($post->isHot());

        // over 10 "new" comments to make it hot
        Comment::factory(11)->create([
            'body' => 'this is the comment body',
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $this->assertTrue($post->isHot());
    }
}
