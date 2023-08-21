<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class Store extends FormRequest
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
    public function rules()
    {
        return [
            'personal_title' => ['required'],
            'personal_surname' => ['required'],
            'personal_first_name' => ['required'],
            'personal_sa_citizen' => ['required', 'boolean'],
            'personal_id_number' => [
                'required',
                'unique:applicants,personal_id_number',
            ],
            'personal_dob' => ['required', 'date'],
            'personal_marital_status' => ['required', 'boolean'],
            'personal_gender' => ['required', 'boolean'],
            'personal_disability_status' => ['required', 'boolean'],
            'personal_disability_description' => [
                'required_if:personal_disability_status,1',
            ],
            'personal_room_preference' => ['required', 'in:0,1,2,3,4'],
            'personal_application_year' => ['required', 'date_format:Y'],
            'personal_semester_year' => ['required', 'in:0,1,2'],
            'personal_kovacs_arrival_date' => ['required', 'date'],
            'personal_home_street_address' => ['required'],
            'personal_home_province' => ['required'],
            'personal_home_postal_code' => ['required'],
            'personal_home_city' => ['required'],
            'personal_home_country' => ['required'],
            'personal_current_street_choice' => ['required', 'boolean'],
            'personal_current_street_address' => [
                'required_if:personal_current_street_choice,1',
            ],
            'personal_current_province' => [
                'required_if:personal_current_street_choice,1',
            ],
            'personal_current_postal_code' => [
                'required_if:personal_current_street_choice,1',
            ],
            'personal_current_city' => [
                'required_if:personal_current_street_choice,1',
            ],
            'personal_current_country' => [
                'required_if:personal_current_street_choice,1',
            ],
            'personal_legal_address_choice' => ['required', 'in:0,1,2'],
            'personal_legal_street_address' => [
                'required_if:personal_legal_address_choice,2',
            ],
            'personal_legal_province' => [
                'required_if:personal_legal_address_choice,2',
            ],
            'personal_legal_postal_code' => [
                'required_if:personal_legal_address_choice,2',
            ],
            'personal_legal_city' => [
                'required_if:personal_legal_address_choice,2',
            ],
            'personal_legal_country' => [
                'required_if:personal_legal_address_choice,2',
            ],
            'personal_applicant_telephone' => ['required'],
            'personal_applicant_mobile' => ['required'],
            'personal_applicant_email' => ['required', 'email'],
            'personal_parent_telephone' => ['required'],
            'personal_parent_mobile' => ['required'],
            'personal_parent_email' => ['required', 'email'],
            'personal_kovacs_before' => ['required', 'boolean'],
            'academic_uwc_student_number' => ['required'],
            'confirm_kovacs_credit_eva' => ['required', 'boolean'],
            'confirm_info_correct' => ['required', 'boolean'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'message' => 'Validation errors',
                    'data' => $errors,
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
