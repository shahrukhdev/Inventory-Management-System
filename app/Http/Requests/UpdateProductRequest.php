<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if (request()->type == 'fixed' || request()->type == null) {

            return [
                'title' => 'required',
                'brand' => 'required',
                'type' => 'required',
                'asset_type' => 'required',
                'price' => 'required_if:type,fixed',
            ];

        } else {

            $variations = request()->variation;
            $variations_count = count($variations);

            if ($variations_count == 1) {                                         // For Variation Count 1

                return [
                    'title' => 'required',
                    'brand' => 'required',
                    'type' => 'required',
                    'asset_type' => 'required',
                    'variation.0.title' => 'required',
                    'variation.0.price' => 'required_with:variation.0.title'
                ];
            } else {

//                $empty_variations = request()->variation;
//                $check = false;
//                foreach ($empty_variations as $key => $empty_variation) {
//
//                    if ($empty_variation['title'] == null && $empty_variation['price'] == null) {
//                        $check = true;
//
//
//                    }
//                }
//
//                if($check){
//                    $k = $key;
//

//                }

//                if ($check) {
//                    $k = $key;
//
//                    if (!request()->variation[$k]) {
//
//                        return [
//                            'title' => 'required',
//                            'brand' => 'required',
//                            'type' => 'required',
//                            'asset_type' => 'required',
//                            'price' => 'required_if:type,fixed',
//                            'variation.*.title' => 'required_if:type,variable',
//                            'variation.*.price' => 'required_with:variation.*.title'
//                        ];
//                    }
//                } else {
//
                    return [
                        'title' => 'required',
                        'brand' => 'required',
                        'type' => 'required',
                        'asset_type' => 'required',
                        'variation.*.title' => 'required_if:type,variable',
                        'variation.*.price' => 'required_with:variation.*.title'
                    ];
//
//                }


            }


        }

    }


    public function messages()
    {
        return [
            'variation.*.title.required_if' => 'The variation field is required',
            'variation.*.price.required_with' => 'The price field is required',
//            'variation_title.required' => 'The variation field is required',             // For Variation Count 1
//            'variation_price.required_with' => 'The price field is required'                // For Variation Count 1
//            'variation_price.required' => 'The price field is required'                // For Variation Count 1
            'variation.0.title' => 'The variation field is required',             // For Variation Count 1
            'variation.0.price' => 'The price field is required',             // For Variation Count 1


        ];
    }


}
