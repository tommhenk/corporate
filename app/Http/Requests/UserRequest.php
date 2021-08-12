<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
class UserRequest extends FormRequest
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

    public function getValidatorInstance() {
        $validator = parent::getValidatorInstance();
        $validator->sometimes('password', 'required|min:8|confirmed', function($input){
            if (!empty($input->password) || (empty($input->password) && $this->route()->getName() !== 'admin_users_update')) {
                return true;
            }
            return false;
        });
        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = (isset($this->route()->parameter('user')->id)) ? $this->route()->parameter('user')->id : '';
        return [
            'name'=>'required|max:255',
            'email'=>'required|max:255|email|unique:users,email,'.$id,
            'login'=>'required|max:255|unique:users,login,'.$id,
            'role_id'=>'required|integer'
        ];
    }
}
