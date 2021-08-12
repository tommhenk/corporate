<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
class PortfolioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = isset($this->route()->parameter('portfolio')->id) ? $this->route()->parameter('portfolio')->id : '';
        // dd($id);
        return [
            'title'=>'required',
            'alias'=>'required|unique:portfolios,alias,'.$id,
            'text'=>'required',
            'customer'=>'required|max:255',
            'filter_id'=>'required'
        ];
    }
}
