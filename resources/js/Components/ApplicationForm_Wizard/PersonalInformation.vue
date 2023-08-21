<script setup>
import { onUnmounted, reactive } from "vue";
import { validateForm } from '@/Utils/form-validation'

const emit = defineEmits(['handleOnChange']);
const props = defineProps({
    existingAnswers: {
        type: Object,
        default: {
            personal_disability_status: false,
            personal_disability_description: "",
            personal_current_street_choice: false,
            personal_current_street_address: "",
            personal_current_province: "",
            personal_current_postal_code: "",
            personal_current_city: "",
            personal_current_country: "",
            personal_legal_street_address: "",
            personal_legal_province: "",
            personal_legal_postal_code: "",
            personal_legal_city: "",
            personal_legal_country: "",
            personal_kovacs_before: false,
        },
    },
});

const answers = reactive(props.existingAnswers)
const today = new Date()
const questions = {
    "Title:": {
        type: "select",
        name: "personal_title",
        options: [
            { id: 0, label: "Mr" },
            { id: 1, label: "Mrs" },
            { id: 2, label: "Ms" }],
    },
    "Surname:": { type: "text", name: "personal_surname", options: [], },
    "Firstname:": { type: "text", name: "personal_first_name", options: [], },
    "I am a:": {
        type: "radio",
        name: "personal_sa_citizen",
        options: [
            { id: 0, label: 'South African citizen' },
            { id: 1, label: 'Non South African citizen' },
        ],
    },
    "SA ID Number:": {
        type: "text",
        name: "personal_id_number",
    },
    "Date of Birth:": {
        type: "date",
        name: "personal_dob",
    },
    "Marital Status:": {
        type: "radio",
        name: "personal_marital_status",
        options: [
            { id: 0, label: 'Single' },
            { id: 1, label: 'Married' }
        ],
    },
    "Gender:": {
        type: "radio",
        name: "personal_gender",
        options: [
            { id: 0, label: 'Male' },
            { id: 1, label: 'Female' }
        ],
    },
    "Are You Disabled?": {
        type: "checkbox",
        name: "personal_disability_status",
    },
    "Disability description:": {
        type: "textarea",
        name: "personal_disability_description",
        hideWhen: () => !answers?.personal_disability_status,
    },
    "Room Preference:": {
        type: "select",
        name: "personal_room_preference",
        options: [
            { id: 0, label: 'Single room shared en suite' },
            { id: 1, label: 'Single room communal bathroom' },
            { id: 2, label: 'Double room shared en suite' },
            { id: 3, label: 'Disable room en suite' },
            { id: 4, label: 'Corner room shared en suite' },
        ],
    },
    "Which year are you applying for?": {
        type: "select",
        name: "personal_application_year",
        options: [
            { id: 0, label: today.getFullYear() },
            { id: 1, label: today.getFullYear() + 1 },
        ],
    },
    "Which semester are you applying for?": {
        type: "select",
        name: "personal_semester_year",
        options: [
            { id: 0, label: "Full Year" },
            { id: 1, label: "1st Semester" },
            { id: 2, label: "2nd Semester" },
        ],
    },
    "Expected date of arrival at Kovacs Residence": {
        type: "date",
        name: "personal_kovacs_arrival_date",
    },
    "Home address": {
        type: "textarea",
        name: "personal_home_street_address",
    },
    "Province": {
        type: "text",
        name: "personal_home_province",
    },
    "Postal code": {
        type: "text",
        name: "personal_home_postal_code",
    },
    "City": {
        type: "text",
        name: "personal_home_city",
    },
    "Country": {
        type: "text",
        name: "personal_home_country",
    },
    "Current residential address is the same as home address above": {
        type: "checkbox",
        name: "personal_current_street_choice",
    },
    "Current residential address (Street Name and Number/Unit/Complex) if differs from above": {
        type: "textarea",
        name: "personal_current_street_address",
        optional: true,
        hideWhen: () => answers?.personal_current_street_choice,
    },
    "Province-2": {
        type: "text",
        name: "personal_current_province",
        optional: true,
        hideWhen: () => answers?.personal_current_street_choice,
    },
    "Postal code-2": {
        type: "text",
        name: "personal_current_postal_code",
        optional: true,
        hideWhen: () => answers?.personal_current_street_choice,
    },
    "City-2": {
        type: "text",
        name: "personal_current_city",
        optional: true,
        hideWhen: () => answers?.personal_current_street_choice,
    },
    "Country-2": {
        type: "text",
        name: "personal_current_country",
        optional: true,
        hideWhen: () => answers?.personal_current_street_choice,
    },
    "Please indicate which address will be used for legal purposes on the lease agreement": {
        type: "select",
        name: "personal_legal_address_choice",
        options: [
            { id: 0, label: "Home address" },
            { id: 1, label: "Current residential address" },
            { id: 2, label: 'Other' },
        ],
    },
    "Legal Home address": {
        type: "text",
        name: "personal_legal_street_address",
        hideWhen: () => answers?.personal_legal_address_choice != 2,
    },
    "Province-3": {
        type: "text",
        name: "personal_legal_province",
        hideWhen: () => answers?.personal_legal_address_choice != 2,
    },
    "Postal code-3": {
        type: "text",
        name: "personal_legal_postal_code",
        hideWhen: () => answers?.personal_legal_address_choice != 2,
    },
    "City-3": {
        type: "text",
        name: "personal_legal_city",
        hideWhen: () => answers?.personal_legal_address_choice != 2,
    },
    "Country-3": {
        type: "text",
        name: "personal_legal_country",
        hideWhen: () => answers?.personal_legal_address_choice != 2,
    },
    "Applicant landline": {
        type: "text",
        name: "personal_applicant_telephone",
    },
    "Applicant mobile": {
        type: "text",
        name: "personal_applicant_mobile",
    },
    "Applicant Email address": {
        type: "email",
        name: "personal_applicant_email",
    },
    "Parent or Guardian landline": {
        type: "text",
        name: "personal_parent_telephone",
    },
    "Parent or Guardian mobile": {
        type: "text",
        name: "personal_parent_mobile",
    },
    "Parent or Guardian Email address": {
        type: "email",
        name: "personal_parent_email",
    },
    "Previously resided at Kovacs": {
        type: "checkbox",
        name: "personal_kovacs_before",
    },
}

const checkVisibility = (questionDetails) => {
    if (typeof questionDetails.hideWhen === 'function') {
        return !questionDetails.hideWhen()
    }
    return true
}

const validate = () => {
    emit('handleOnChange', answers)
    const validation = validateForm(questions, answers)

    return validation
}

defineExpose({ validate });
</script>


<template>
    <div class="p-4 items-center flex flex-col w-full sm:my-16 my-24 bg-white">
        <div class="w-[100%]" v-for="(question, index) in Object.keys(questions)" :key="question">
            <div v-if="checkVisibility(questions[question])"
                :class="`flex md:flex-row flex-col w-[100%] justify-between md:items-center ${index && 'pt-4'} relative`">

                <label :for="questions[question].name"
                    :class="`md:basis-[200px] md:flex-grow-0 flex-1 ${questions[question].type === 'checkbox' && 'pl-8 md:pl-0'}`">
                    {{ question.split?.("-")?.[0] }}
                </label>

                <input v-model="answers[questions[question].name]" :name="questions[question].name"
                    v-if="(['text', 'email', 'date'].includes(questions[question].type))"
                    :type="questions[question].type"
                    class="flex-1 w-[100%] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

                <select v-model="answers[questions[question].name]" v-else-if="(questions[question].type === 'select')"
                    :id="questions[question].name" :name="questions[question].name"
                    class="flex-1 w-[100%] bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option v-for="option in questions[question].options" :value="option.id">{{ option.label }}
                    </option>
                </select>

                <div v-else-if="(questions[question].type === 'radio')" class="flex-1 flex items-center w-[100%]">
                    <div class="flex-1 flex md:flex-row flex-col md:gap-6 md:items-center items-start">
                        <div v-for="option in questions[question].options" class="md:mt-0 mt-2">
                            <input :id="`${questions[question].name}_${option.label}`" type="radio" :value="option.id"
                                :name="questions[question].name" v-model="answers[questions[question].name]"
                                class="w-4 h-4 text-blue-600 bg-white border-gray-300 checked:bg-teasel hover:checked:bg-teasel focus:checked:bg-teasel focus:ring-teasel focus:border-teasel">
                            <label :for="`${questions[question].name}_${option.label}`"
                                class="ml-2 text-sm font-medium text-gray-900">
                                {{ option.label }}
                            </label>
                        </div>
                    </div>
                </div>

                <div v-else-if="(questions[question].type === 'checkbox')" class="flex-1 absolute md:static">
                    <input :id="questions[question].name" :name="questions[question].name"
                        v-model="answers[questions[question].name]"
                        class="border-gray-300 rounded-lg hover:opacity-80 block w-full p-2.5 checked:bg-teasel hover:checked:bg-teasel focus:checked:bg-teasel focus:ring-teasel focus:border-teasel"
                        type="checkbox" />
                </div>

                <textarea v-else-if="(questions[question].type === 'textarea')" id="message" rows="2"
                    :name="questions[question].name" v-model="answers[questions[question].name]"
                    class="flex-1 w-[100%] block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                    placeholder=""></textarea>
            </div>
        </div>
    </div>
</template>
