<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Applicant;
use App\Models\Application;
use App\Http\Requests\Application\Store as StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Mail\Application\Confirmation as ConfirmationMail;
use Inertia\Inertia;
use Mail;
class ApplicationFormController extends Controller
{
    public function index()
    {
        return Inertia::render('ApplicationForm');
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->all();

        // NOTE: uncomment line 26-34 for dev stage
        // return response()->json(
        //     [
        //         'success' => true,
        //         'message' => 'Application form submitted successfully',
        //         'data' => $data,
        //     ],
        //     200
        // );

        // user creation
        $user = User::create([
            'user_type' => 0,
            'user_login' => $data['personal_applicant_email'],
            'user_password' => '1234567890',
            'contact_name' => $data['personal_first_name'],
            'contact_surname' => $data['personal_surname'],
            'contact_number' => $data['personal_applicant_mobile'],
            'contact_email' => $data['personal_applicant_email'],
        ]);

        // applicant creation
        $applicant = Applicant::create([
            'personal_title' => $data['personal_title'],
            'personal_surname' => $data['personal_surname'],
            'personal_first_name' => $data['personal_first_name'],
            'personal_sa_citizen' => $data['personal_sa_citizen'],
            'personal_id_number' => $data['personal_id_number'],
            'personal_dob' => $data['personal_dob'],
            'personal_marital_status' => $data['personal_marital_status'],
            'personal_disablity_status' => $data['personal_disability_status'],
            'personal_disability_description' =>
                $data['personal_disability_description'] ?: '',
            'personal_gender' => $data['personal_gender'],
            'personal_room_preference' => $data['personal_room_preference'],
            'personal_application_year' => $data['personal_application_year'],
            'personal_semester_year' => $data['personal_semester_year'],
            'personal_kovacs_arrival_date' =>
                $data['personal_kovacs_arrival_date'],
            'personal_home_street_address' =>
                $data['personal_home_street_address'],
            'personal_home_province' => $data['personal_home_province'],
            'personal_home_postal_code' => $data['personal_home_postal_code'],
            'personal_home_city' => $data['personal_home_city'],
            'personal_home_country' => $data['personal_home_country'],
            'personal_current_street_address' =>
                $data['personal_current_street_address'] ?: '',
            'personal_current_province' =>
                $data['personal_current_province'] ?: '',
            'personal_current_postal_code' =>
                $data['personal_current_postal_code'] ?: '',
            'personal_current_city' => $data['personal_current_city'] ?: '',
            'personal_current_country' =>
                $data['personal_current_country'] ?: '',
            'personal_legal_address_choice' =>
                $data['personal_legal_address_choice'] ?: 0,
            'personal_legal_street_address' =>
                $data['personal_legal_street_address'] ?: '',
            'personal_legal_province' => $data['personal_legal_province'] ?: '',
            'personal_legal_postal_code' =>
                $data['personal_legal_postal_code'] ?: '',
            'personal_legal_city' => $data['personal_legal_city'] ?: '',
            'personal_legal_country' => $data['personal_legal_country'] ?: '',
            'personal_applicant_telephone' =>
                $data['personal_applicant_telephone'],
            'personal_applicant_mobile' => $data['personal_applicant_mobile'],
            'personal_applicant_email' => $data['personal_applicant_email'],
            'personal_parent_telephone' => $data['personal_parent_telephone'],
            'personal_parent_mobile' => $data['personal_parent_mobile'],
            'personal_parent_email' => $data['personal_parent_email'],
            'personal_kovacs_before' => $data['personal_kovacs_before'],
            'academic_uwc_student_number' =>
                $data['academic_uwc_student_number'],
            'confirm_kovacs_credit_eva' => $data['confirm_kovacs_credit_eva'],
            'confirm_info_correct' => $data['confirm_info_correct'],
            'user_id' => $user['user_id'],
            /**
             * NOTE:
             * manually set the default value to avoid breaking changes with the dashboard web
             * should be set the null value on db schema while normalize the DB.
             */
            'personal_room_with_fridge' => 0,
            'personal_applicant_telephone_country_code' => '',
            'personal_applicant_telephone_area_code' => '',
            'personal_applicant_mobile_country_code' => '',
            'personal_applicant_mobile_area_code' => '',
            'personal_applicant_fax' => '',
            'personal_applicant_fax_country_code' => '',
            'personal_applicant_fax_area_code' => '',
            'personal_parent_telephone_country_code' => '',
            'personal_parent_telephone_area_code' => '',
            'personal_parent_mobile_country_code' => '',
            'personal_parent_mobile_area_code' => '',
            'personal_parent_fax' => '',
            'personal_parent_fax_country_code' => '',
            'personal_parent_fax_area_code' => '',
            'personal_medical_aid' => 0,
            'personal_medical_aid_number' => '',
            'personal_medical_aid_name' => '',
            'personal_medical_aid_member_name' => '',
            'personal_medical_aid_member_surname' => '',
            'personal_illness_allergy' => '',
            'personal_kovacs_legal_address_accept' => 0,
            'academic_highest_qualification' => '',
            'academic_uwc_study_programme' => '',
            'academic_study_year' => 0,
            'academic_remaining_years' => 0,
            'academic_pg_start_date' => date('Y-m-d'),
            'academic_pg_end_date' => date('Y-m-d'),
            'academic_application_status' => 0,
            'academic_uwc_residence_application' => 0,
            'academic_study_application_elsewhere' => 0,
            'fees_parent_responsible_payment' => 0,
            'fees_student_responsible_payment' => 0,
            'fees_partly_bursary_responsible_payment' => 0,
            'fees_party_responsible_payment' => 0,
            'fees_nsfas_bursary' => 0,
            'fees_bursary_covers_payment' => 0,
            'fees_government_employee_payment' => 0,
            'fees_title' => '',
            'fees_surname' => '',
            'fees_first_name' => '',
            'fees_burser_name' => '',
            'fees_telephone' => '',
            'fees_telephone_country_code' => '',
            'fees_telephone_area_code' => '',
            'fees_mobile' => '',
            'fees_mobile_country_code' => '',
            'fees_mobile_area_code' => '',
            'fees_fax' => '',
            'fees_fax_country_code' => '',
            'fees_fax_area_code' => '',
            'fees_email' => '',
            'credit_prepaid_fees' => 0,
            'credit_current_residence' => 0,
            'credit_current_residence_rental_amount' => 0,
            ' credit_current_residence_reference_letter' => 0,
            'credit_employed' => 0,
            'credit_occupation' => '',
            'credit_mother_occupation' => '',
            'credit_father_occupation' => '',
            'credit_guardian_occupation' => '',
            'credit_company_credit_1' => '',
            'credit_company_credit_1_account' => '',
            'credit_company_credit_2' => '',
            'credit_company_credit_2_account' => '',
            'credit_bank_statement_provided' => 0,
            'credit_proof_income_provided' => 0,
            'bursary_annual_value' => 0,
            'bursary_accommodation_value' => 0,
            'bursary_confirm_letter_provided' => 0,
            'bursary_approval_status' => 0,
            'bursary_residence_payment_date' => date('Y-m-d'),
            'bursary_residence_fees_recipient' => 0,
            'confirm_application_date' => date('Y-m-d'),
            'confirm_name' => '',
            'confirm_signature' => 0,
            'room_id' => 0,
        ]);

        // application creation
        $application = Application::create([
            'application_name' => $applicant['personal_first_name'],
            'application_surname' => $applicant['personal_surname'],
            'application_student_number' =>
                $applicant['academic_uwc_student_number'],
            'application_gender' => $applicant['personal_gender'],
            'application_uwc_study_programme' =>
                $applicant['academic_uwc_study_programme'],
            'application_study_year' => $applicant['academic_study_year'],
            'application_occupation_period' =>
                $applicant['academic_remaining_years'],
            'application_payment_type' => 0,
            'application_kovacs_before' => $applicant['personal_kovacs_before'],
            'application_time_period' => $applicant['academic_remaining_years'],
            'application_overall_status' => 0,
            'application_student_phone' =>
                $applicant['personal_applicant_mobile'],
            'application_student_email' =>
                $applicant['personal_applicant_email'],
            'application_payer_phone' => $applicant['fees_mobile'],
            'application_payer_fax' => $applicant['fees_fax'],
            'application_payer_email' => $applicant['fees_email'],
            'application_uwc_accepted' =>
                $applicant['academic_application_status'],
            'application_bursary_value' => $applicant['bursary_annual_value'],
            'application_bursary_status' =>
                $applicant['bursary_approval_status'],
            'application_bursary_docs_provided' => 0,
            'application_bursary_letter_provided' => 0,
            'application_bank_statement_provided' => 0,
            'application_proof_income_provided' => 0,
            'application_statement_account_provided' => 0,
            'application_letter_previous_landlord_provided' => 0,
            'application_visa_letter_provided' => 0,
            'application_medical_insurance_letter_provided' => 0,
            'application_lease_agreement_signed' => 0,
            'application_room_inventory_signed_received' => 0,
            'application_room_type' => 0,
            'application_room_number' => 0,
            'application_room_checkin_time' =>
                $applicant['personal_kovacs_arrival_date'],
            'application_documentation_upload_path' => '',
            'application_workflow_status' => 0,
            'application_invoice_sent' => 0,
            'applicant_id' => $applicant['applicant_id'],
            'room_id' => 0,
            'application_room_checkout_time' => date('Y-m-d'),
            'application_room_checkout_form_provided' => 0,
            'application_history_notes' => '',
        ]);

        Mail::to($user['user_login'])->send(
            new ConfirmationMail($user['personal_first_name'], $application->application_id)
        );

        return response()->json(
            [
                'success' => true,
                'message' => 'Application form submitted successfully',
                'data' => $application,
            ],
            200
        );
    }
}
