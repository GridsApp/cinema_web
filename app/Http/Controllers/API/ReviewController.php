<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\MovieRepositoryInterface;
use App\Interfaces\MovieReviewRepositoryInterface;
use App\Models\MovieReview;
use Illuminate\Support\Facades\Validator;
use twa\cmsv2\Traits\APITrait;

class ReviewController extends Controller
{

    use APITrait;

    // private MovieReviewRepositoryInterface $movieReviewRepository;

    // public function __construct(MovieReviewRepositoryInterface $movieReviewRepository)
    // {
    //     $this->movieReviewRepository = $movieReviewRepository;
    // }


    private MovieRepositoryInterface $movieRepository;
    private MovieReviewRepositoryInterface $movieReviewRepository;
  

    public function __construct(MovieRepositoryInterface $movieRepository,MovieReviewRepositoryInterface $movieReviewRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->movieReviewRepository = $movieReviewRepository;
      
    }

    public function review()
    {

        $form_data = clean_request([]);

        $validator = Validator::make($form_data, [
            'rate' => 'required|integer|min:1|max:5',
            'movie_id' => 'required|exists:movies,id'
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }


        $user_id = request()->user->id;
        $user_type = request()->user_type;

        $movie_id = $form_data['movie_id'];



        // $movie= $this->movieRepository->getMovie($movie_id);

        // dd($movie);

        try {
            $last_review = $this->movieReviewRepository->getLastReviewByUserAndMovie($user_id, $movie_id);
            return $this->response(notification()->error('You have already rated this movie!', 'You have already rated this movie'));
        } catch (\Exception $e) {
        }
        $review = new MovieReview();
        $review->rate = $form_data['rate'];
        $review->comment = $form_data['comment'];
        $review->movie_id = $form_data['movie_id'];
        $review->user_id = $user_id;
        $review->save();

        return $this->response(notification()->success('Successfully rated', 'Your rating has been successfully submitted!'));
    }
}
