<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_pending_movie_submission(): void
    {
        $user = User::factory()->create();
        $genre = Genre::create(['name' => 'Drama', 'slug' => 'drama']);

        $response = $this->actingAs($user)->post(route('submissions.store'), [
            'title' => 'A New Film',
            'genres' => [$genre->id],
            'rating' => 4.2,
        ]);

        $response->assertRedirect(route('submissions.index'));
        $this->assertDatabaseHas('movies', [
            'user_id' => $user->id,
            'title' => 'A New Film',
            'slug' => 'a-new-film',
            'status' => Movie::STATUS_PENDING,
        ]);
    }

    public function test_user_submission_sanitizes_rich_text_content(): void
    {
        $user = User::factory()->create();
        $genre = Genre::create(['name' => 'Drama', 'slug' => 'drama']);

        $this->actingAs($user)->post(route('submissions.store'), [
            'title' => 'Safe Rich Text Film',
            'genres' => [$genre->id],
            'synopsis' => '<h2>Synopsis</h2><script>alert(1)</script><p><strong>Bold text</strong></p>',
            'review' => '<p><a href="javascript:alert(1)">Unsafe link</a></p>',
        ])->assertRedirect(route('submissions.index'));

        $movie = Movie::where('slug', 'safe-rich-text-film')->firstOrFail();

        $this->assertStringContainsString('<h2>Synopsis</h2>', $movie->synopsis);
        $this->assertStringContainsString('<strong>Bold text</strong>', $movie->synopsis);
        $this->assertStringNotContainsString('<script>', $movie->synopsis);
        $this->assertStringNotContainsString('alert(1)', $movie->synopsis);
        $this->assertStringNotContainsString('javascript:', $movie->review);
    }

    public function test_user_can_only_resubmit_their_rejected_submission(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $genre = Genre::create(['name' => 'Drama', 'slug' => 'drama']);
        $movie = Movie::create([
            'user_id' => $user->id,
            'title' => 'Rejected Film',
            'slug' => 'rejected-film',
            'status' => Movie::STATUS_REJECTED,
            'note' => 'Please add more detail.',
        ]);
        $movie->genres()->attach($genre);

        $this->actingAs($otherUser)
            ->get(route('submissions.edit', $movie))
            ->assertForbidden();

        $this->actingAs($user)
            ->put(route('submissions.update', $movie), [
                'title' => 'Improved Film',
                'genres' => [$genre->id],
                'rating' => 4.5,
            ])
            ->assertRedirect(route('submissions.index'));

        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => 'Improved Film',
            'status' => Movie::STATUS_PENDING,
            'note' => null,
        ]);
    }

    public function test_admin_can_reject_and_approve_a_submission(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $genre = Genre::create(['name' => 'Drama', 'slug' => 'drama']);
        $movie = Movie::create([
            'user_id' => $user->id,
            'title' => 'Pending Film',
            'slug' => 'pending-film',
            'status' => Movie::STATUS_PENDING,
        ]);
        $movie->genres()->attach($genre);

        $this->actingAs($admin)
            ->post(route('admin.movie-submissions.reject', $movie), [])
            ->assertSessionHasErrors('rejection_reason');

        $this->actingAs($admin)
            ->post(route('admin.movie-submissions.approve', $movie))
            ->assertRedirect(route('admin.movie-submissions.index'));

        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => 'Pending Film',
            'user_id' => $user->id,
            'status' => Movie::STATUS_APPROVED,
        ]);
    }

    public function test_admin_movie_content_is_sanitized_before_storage(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $genre = Genre::create(['name' => 'Drama', 'slug' => 'drama']);

        $this->actingAs($admin)->post(route('admin.movies.store'), [
            'title' => 'Admin Rich Text Film',
            'genres' => [$genre->id],
            'synopsis' => '<p><em>Italic synopsis</em></p><iframe src="bad"></iframe>',
            'review' => '<ul><li>Good point</li></ul><img src="bad">',
        ])->assertRedirect(route('admin.movies.index'));

        $movie = Movie::where('slug', 'admin-rich-text-film')->firstOrFail();

        $this->assertStringContainsString('<em>Italic synopsis</em>', $movie->synopsis);
        $this->assertStringNotContainsString('<iframe', $movie->synopsis);
        $this->assertStringContainsString('<ul><li>Good point</li></ul>', $movie->review);
        $this->assertStringNotContainsString('<img', $movie->review);
    }

    public function test_user_can_delete_their_own_approved_movie_from_submissions(): void
    {
        $user = User::factory()->create();
        $genre = Genre::create(['name' => 'Drama', 'slug' => 'drama']);
        $movie = Movie::create([
            'user_id' => $user->id,
            'title' => 'Published Film',
            'slug' => 'published-film',
            'rating' => 4.5,
            'status' => Movie::STATUS_APPROVED,
        ]);
        $movie->genres()->attach($genre);

        $this->actingAs($user)
            ->delete(route('movies.destroy', $movie))
            ->assertRedirect(route('submissions.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id,
        ]);
    }
}
