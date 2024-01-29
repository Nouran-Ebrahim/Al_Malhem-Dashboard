<?php


namespace Modules\Common\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'phone' => 'required',
            'message' => 'required',
        ];
    }

    public function messages()
    {

        return [
            'phone.required' => 'الهاتف  مطلوب',
            'message.required' => 'الرسالة مطلوبة',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => null,

            ])
        );
    }
}
