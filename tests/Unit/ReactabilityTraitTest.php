<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReactabilityTraitTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function it_can_be_reacted_to_with_a_value()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $post->react($user, 5);

        $this->assertDatabaseHas('reactions', [
            'user_id' => $user->id,
            'reactable_id' => $post->id,
            'reactable_type' => get_class($post),
            'value' => 5,
        ]);
    }

    /** @test */
    public function it_can_have_a_reaction_reversed()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $post->react($user, 5);

        $this->assertDatabaseHas('reactions', [
            'user_id' => $user->id,
            'reactable_id' => $post->id,
            'reactable_type' => get_class($post),
            'value' => 5,
        ]);

        $post->unreact($user);

        $this->assertDatabaseMissing('reactions', [
            'user_id' => $user->id,
            'reactable_id' => $post->id,
            'reactable_type' => get_class($post),
            'value' => 5,
        ]);
    }

    /** @test */
    public function it_can_check_if_a_user_has_a_reaction_on_the_model()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $post->react($user, 1);

        $this->assertTrue($post->hasReactionFrom($user));
    }

    /** @test */
    public function it_can_toggle_a_user_reaction()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        // on
        $post->toggleReaction($user, 5);

        $this->assertDatabaseHas('reactions', [
            'user_id' => $user->id,
            'reactable_id' => $post->id,
            'reactable_type' => get_class($post),
            'value' => 5,
        ]);

        // off
        $post->toggleReaction($user, 5);

        $this->assertDatabaseMissing('reactions', [
            'user_id' => $user->id,
            'reactable_id' => $post->id,
            'reactable_type' => get_class($post),
            'value' => 5,
        ]);

        // on again
        $post->toggleReaction($user, 5);

        $this->assertDatabaseHas('reactions', [
            'user_id' => $user->id,
            'reactable_id' => $post->id,
            'reactable_type' => get_class($post),
            'value' => 5,
        ]);
    }

    /** @test */
    public function it_can_get_a_reaction_by_user()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $this->assertNull($post->getReaction($user));

        $reaction = $post->react($user, 1);

        $this->assertEquals($reaction->reactable_id, $post->getReaction($user)->reactable_id);
    }

    /** @test */
    public function it_can_get_its_total_score()
    {
        $post = Post::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();
        $user4 = User::factory()->create();

        $post->upvote($user1);
        $post->downvote($user2);
        $post->upvote($user3);
        $post->react($user4, 5);

        $this->assertEquals(6, $post->score());
    }
}
