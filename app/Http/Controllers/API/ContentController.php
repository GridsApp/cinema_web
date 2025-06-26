<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Faq;
use App\Models\InformativePages;
use App\Models\Slideshow;
use twa\cmsv2\Traits\APITrait;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{

    use APITrait;


    public function responses($type)
    {
        switch ($type) {
            case "success":
                return $this->response(notification()->success("Title", "Message"));
                break;

            case "error":
                return $this->response(notification()->error("Title", "Message"));
                break;

            case "validation":
                $validator = Validator::make(request()->all(), [
                    'name' => 'required'
                ]);

                if ($validator->errors()->count() > 0) {
                    return  $this->responseValidation($validator);
                }

                return $this->responseData([]);
                break;


            case "data":
                return $this->responseData([]);
                break;

            case "data-success":

                return $this->responseData([], notification()->success('Title', "Message"));

                break;

            case "data-error":

                return $this->responseData([], notification()->error('Title', "Message"));
                break;
        }
    }
    public function getSlideshows()
    {
        $slideshows = Slideshow::whereNull('deleted_at')
            ->orderBy('orders', 'ASC')
            ->get()
            ->map(function ($slideshow) {
                return [
                    'id' => $slideshow->id,
                    'label' => $slideshow->label,
                    'text' => $slideshow->text,
                    'image' => get_image($slideshow->image),
                    'cta_label' => $slideshow->cta_label,
                    'cta_link' => $slideshow->cta_link,
                ];
            });
    
        return $this->responseData($slideshows);
    }
    

    public function getFaqs()
    {

        $faqs = Faq::whereNull('deleted_at')->get()
            ->map(function ($faq) {
                return [
                    'id' => $faq->id,
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                ];
            });

        return $this->responseData($faqs);
    }

    public function getPage($slug)
    {
        $page = InformativePages::where('slug', $slug)->where('deleted_at')->get()->map(function ($page) {
            return [

                'label' => $page->label,
                'content' => $page->content,
            ];
        });


        return $this->responseData($page);
    }

    public function getSetting()
    {
        $locale = app()->getLocale();
        $settings = collect(config('settings'))->map(function ($setting) use ($locale) {

            $info = config('fields.' . $setting['field']);

            if (!$info) {
                return null;
            }

            $info['name'] = $setting['translatable'] ?? false ? 'value_' . $locale : 'value';
            $value = (new $info['type']($info))->display($setting);

            return [
                'key' => $setting['field'] ?? null,
                'value' => $value,
            ];
        })->filter()->values()->toArray();


        if(request()->input('type') == 'object'){
            $settings = collect($settings)->pluck('value' , 'key')->toArray();
        }


        return $this->responseData($settings);
    }
}
