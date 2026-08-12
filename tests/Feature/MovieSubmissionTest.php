<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieSubmission;
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
        $this->assertDatabaseHas('movie_submissions', [
            'user_id' => $user->id,
            'title' => 'A New Film',
            'slug' => 'a-new-film',
            'status' => MovieSubmission::STATUS_PENDING,
        ]);
    }

    public function test_user_can_only_resubmit_their_rejected_submission(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $genre = Genre::create(['name' => 'Drama', 'slug' => 'drama']);
        $submission = MovieSubmission::create([
            'user_id' => $user->id,
            'title' => 'Rejected Film',
            'slug' => 'rejected-film',
            'status' => MovieSubmission::STATUS_REJECTED,
            'rejection_reason' => 'Please add more detail.',
        ]);
        $submission->genres()->attach($genre);

        $this->actingAs($otherUser)
            ->get(route('submissions.edit', $submission))
            ->assertForbidden();

        $this->actingAs($user)
            ->put(route('submissions.update', $submission), [
                'title' => 'Improved Film',
                'genres' => [$genre->id],
                'rating' => 4.5,
            ])
            ->assertRedirect(route('submissions.index'));

        $this->assertDatabaseHas('movie_submissions', [
            'id' => $submission->id,
            'title' => 'Improved Film',
            'status' => MovieSubmission::STATUS_PENDING,
            'rejection_reason' => null,
        ]);
    }

    public function test_admin_can_reject_and_approve_a_submission(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $genre = Genre::create(['name' => 'Drama', 'slug' => 'drama']);
        $submission = MovieSubmission::create([
            'user_id' => $user->id,
            'title' => 'Approved Film',
            'slug' => 'approved-film',
            'status' => MovieSubmission::STATUS_PENDING,
        ]);
        $submission->genres()->attach($genre);

        $this->actingAs($admin)
            ->post(route('admin.movie-submissions.reject', $submission), [])
            ->assertSessionHasErrors('rejection_reason');

        $this->actingAs($admin)
            ->post(route('admin.movie-submissions.approve', $submission))
            ->assertRedirect(route('admin.movie-submissions.index'));

        $this->assertDatabaseHas('movies', [
            'title' => 'Approved Film',
            'user_id' => $user->id,
            'slug' => 'approved-film',
        ]);
        $this->assertDatabaseHas('movie_submissions', [
            'id' => $submission->id,
            'status' => MovieSubmission::STATUS_APPROVED,
        ]);
        $this->assertDatabaseHas('movie_genre', ['genre_id' => $genre->id]);
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
        ]);
        $submission = MovieSubmission::create([
            'user_id' => $user->id,
            'title' => 'Published Film',
            'slug' => 'published-film',
            'status' => MovieSubmission::STATUS_APPROVED,
            'approved_movie_id' => $movie->id,
        ]);
        $submission->genres()->attach($genre);
        $movie->genres()->attach($genre);

        $this->actingAs($user)
            ->delete(route('movies.destroy', $movie))
            ->assertRedirect(route('submissions.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id,
        ]);
        $this->assertDatabaseMissing('movie_submissions', [
            'id' => $submission->id,
        ]);
    }

    public function test_slug_conflict_keeps_submission_pending(): void
    {
        $user = User::factory()->create();
        Movie::create(['title' => 'Existing Film', 'slug' => 'conflicting-film']);
        $submission = MovieSubmission::create([
            'user_id' => $user->id,
            'title' => 'Conflicting Film',
            'slug' => 'conflicting-film',
            'status' => MovieSubmission::STATUS_PENDING,
        ]);

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->post(route('admin.movie-submissions.approve', $submission))
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('movie_submissions', [
            'id' => $submission->id,
            'status' => MovieSubmission::STATUS_PENDING,
        ]);
    }
}
