<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\DNSValidation;
use App\Rules\HashValidation;

class VerificationRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'data.id' => 'required',
            'data.recipient.name' => 'required',
            'data.recipient.email' => 'required',
            'data.issuer.name' => 'required',
            'data.issuer.identityProof' => ['required', new DNSValidation() ],
            'signature.targetHash' => 'required',
            'data' => [ new HashValidation($this->input('signature.targetHash')) ],
            
        ];
    }
    /**
     * Message for each validation
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function messages(): array {
        return [
            'data.id' => 'invalid_request',
            'data.recipient.name.required' => 'invalid_recipient',
            'data.recipient.email.required' => 'invalid_recipient',
            'data.issuer.name.required' => 'invalid_issuer',
            'data.issuer.identityProof.required' => 'invalid_issuer',
            'signature.targetHash' => 'invalid_signature',
        ];
    }
    /**
     * Message for each validation
     *
     * 
     */
    public function failedValidation(Validator $validator): Void
    {
        $this->merge(['errors' => $validator->errors()]);
    }
}
