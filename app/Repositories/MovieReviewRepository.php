<?php

namespace App\Repositories;

use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\MovieReviewRepositoryInterface;
use App\Models\Branch;
use App\Models\MovieReview;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MovieReviewRepository implements MovieReviewRepositoryInterface
{

    public function getLastReviewByUserAndMovie($user_id, $movie_id)
    {
        try {
            return MovieReview::where('user_id', $user_id)->where('movie_id', $movie_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
      
    }

}