<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'application_id';
    public $timestamps = false;

    protected $fillable = [
        'application_name',
        'application_surname',
        'application_student_number',
        'application_gender',
        'application_uwc_study_programme',
        'application_study_year',
        'application_occupation_period',
        'application_payment_type',
        'application_kovacs_before',
        'application_time_period',
        'application_overall_status',
        'application_student_phone',
        'application_student_email',
        'application_payer_phone',
        'application_payer_fax',
        'application_payer_email',
        'application_uwc_accepted',
        'application_bursary_value',
        'application_bursary_status',
        'application_bursary_docs_provided',
        'application_bursary_letter_provided',
        'application_bank_statement_provided',
        'application_proof_income_provided',
        'application_statement_account_provided',
        'application_letter_previous_landlord_provided',
        'application_visa_letter_provided',
        'application_medical_insurance_letter_provided',
        'application_lease_agreement_signed',
        'application_room_inventory_signed_received',
        'application_room_type',
        'application_room_number',
        'application_room_checkin_time',
        'application_documentation_upload_path',
        'application_workflow_status',
        'application_invoice_sent',
        'applicant_id',
        'room_id',
        'application_room_checkout_time',
        'application_room_checkout_form_provided',
        'application_history_notes',
    ];
}
