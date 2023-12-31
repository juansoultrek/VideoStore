<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class MovieService
{
    public const KEY_MOVIE_NUMBER  = 'movieNumber_';
    public const KEY_MOVIE_COUNTER = 'movieCounter';

    // Public Methods
    public function addMovie($movieTitle): void
    {
        $this->incrementMovieCounter();
        $newMovieKey   = self::KEY_MOVIE_NUMBER . $this->getMovieCounter();
        $newMovieValue = [
            'id'    => $this->getMovieCounter(),
            'title' => $movieTitle,
            'likes' => 0
        ];
        Cache::add($newMovieKey, $newMovieValue);
    }


    public function addMovieLikes($movieKeyId): void
    {
        $movieKey = self::KEY_MOVIE_NUMBER . $movieKeyId;
        $movie    = $this->getMovie($movieKey);
        $movie['likes'] += 1;
        $this->updateMovie($movieKey, $movie);
    }

    public function deleteMovies(): void
    {
        for ($i = 1; $i <= $this->getMovieCounter(); $i++) {
            $movieKey = self::KEY_MOVIE_NUMBER . $i;
            $this->deleteMovie($movieKey);
        }
        $this->deleteMovieCounter();
    }

    public function getAllMovies(): array
    {
        $movieCounter = $this->getMovieCounter();
        if ($movieCounter === 0) {
            return [];
        }
        $movieArray   = range(0, $movieCounter - 1);
        foreach ($movieArray as $movieNumber) {
            $movieKey                  = self::KEY_MOVIE_NUMBER . $movieNumber + 1;
            $movie                     =  $this->getMovie($movieKey);
            $movieArray [$movieNumber] = $movie;
        }

        return $movieArray;
    }

    public function getMovie($movieKey): array | int
    {
        return Cache::get($movieKey, 0);
    }


    // Private Methods
    private function deleteMovieCounter(): void
    {
        Cache::delete(self::KEY_MOVIE_COUNTER);
    }
    private function deleteMovie($movieKey): void
    {
        Cache::delete($movieKey);
    }

    private function getMovieCounter(): int
    {
        return Cache::get(self::KEY_MOVIE_COUNTER, 0);
    }

    private function incrementMovieCounter(): void
    {
        Cache::increment(self::KEY_MOVIE_COUNTER);
    }

    private function updateMovie($movieKey, $movie): void
    {
        Cache::put($movieKey, $movie);
    }
}
