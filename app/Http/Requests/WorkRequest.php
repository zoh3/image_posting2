<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules()
    {
        return [
            'work.title' =>'required|string|max:50',
            'work.body' =>'required|string|max:250',
            // 'work.age' =>'required',
        ];
    }
    
     public function messages()
    {
        return[
            'work.title.required' => 'タイトルを入力してください',
            'work.body.required' => 'コメントを入力してください',
            // 'work.age.required' => 'どちらかを選択してください'
            ];
    }
    protected function prepareForValidation()
    {
        $value = $this->age;
        // 文字列表現のboolを実際のboolに変換
        if($value === 'false'){
            $value = 0;
        }elseif($value === 'true'){
            $value = 1;
        }
        $work['age'] = $value;
        $this->merge($work);
    }
    
   
}
