<?php

namespace Tests\Feature;

use App\Http\Controllers\User\MovieController;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class MovieYearFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_movies_can_be_filtered_by_year_range(): void
    {
        Movie::factory()->create([
            'title' => 'Movie Inside Range',
            'slug' => 'movie-inside-range',
            'release_date' => '2020-06-01',
            'status' => Movie::STATUS_APPROVED,
        ]);
        Movie::factory()->create([
            'title' => 'Movie Outside Range',
            'slug' => 'movie-outside-range',
            'release_date' => '2018-06-01',
            'status' => Movie::STATUS_APPROVED,
        ]);

        $request = Request::create('/movies', 'GET', ['year_from' => 2020, 'year_to' => 2021]);
        $response = app(MovieController::class)->index($request);
        $movies = $response->getData()['movies'];

        $this->assertSame(['Movie Inside Range'], $movies->pluck('title')->all());
    }

    public function test_starting_year_cannot_be_later_than_ending_year(): void
    {
        $this->from(route('movies.index'))
            ->get(route('movies.index', ['year_from' => 2021, 'year_to' => 2020]))
            ->assertRedirect(route('movies.index'))
            ->assertSessionHasErrors('year_from');
    }
}
