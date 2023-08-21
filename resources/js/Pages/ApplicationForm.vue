<script setup>
import { Head } from "@inertiajs/vue3";
import { computed, reactive, ref } from "vue";

import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

import Introduction from "@/Components/ApplicationForm_Wizard/Introduction.vue";
import PersonalInformation from "@/Components/ApplicationForm_Wizard/PersonalInformation.vue";
import AcademicDetails from "@/Components/ApplicationForm_Wizard/AcademicDetails.vue";
import ApplicationSubmission from "@/Components/ApplicationForm_Wizard/ApplicationSubmission.vue";

const title = {
    2: "Personal Information",
    3: "Academic Details",
    4: "Application Submission",
};
const contentWrapper = ref();

const formData = reactive({});
const state = reactive({
    step: 1,
    isSubmitting: false,
    isShowModal: false,
    modalType: "",
    backendMessages: [],
});

const personalInformationForm = ref();
const academicDetailsForm = ref();
const applicationSubmissionForm = ref();
const validateForm = computed(() => {
    if (state.step === 2) return personalInformationForm.value?.validate?.();
    if (state.step === 3) return academicDetailsForm.value?.validate?.();
    if (state.step === 4) return applicationSubmissionForm.value?.validate?.();
    return { status: true };
});
const errorMessages = computed(() => {
    const validation = validateForm?.value || { status: true };

    if (validation?.status) return [];
    return validation?.validated
        ?.map((item) => item.message)
        .filter((item) => item);
});

const submitForm = () => {
    state.isSubmitting = true;

    const body = {
        ...formData["Personal Information"],
        ...formData["Academic Details"],
        ...formData["Application Submission"],
    };

    return axios
        .post("/api/application-form", body)
        .then((response) => {
            state.isSubmitting = false;

            if (response.data?.success) {
                state.modalType = "submissionSuccess";
                state.isShowModal = true;

                setTimeout(() => window.location.reload(), 2000);
            }
        })
        .catch((error) => {
            state.isSubmitting = false;
            state.modalType = "submissionFailed";
            state.isShowModal = true;

            if (error.response?.data?.data) {
                const data = error.response?.data?.data;
                const messages = Object.keys(data).map((key) => data[key][0]);
                state.backendMessages = messages;
            }
        });
};

const confirmSubmission = () => {
    state.modalType = "submitConfirmation";
    state.isShowModal = true;
};
const handleCloseModal = () => (state.isShowModal = false);

const handleNext = () => {
    state.step = state.step + 1
    contentWrapper.value?.scrollTo?.({
        top: 0,
        behavior: 'smooth'
    });
}

const handlePrev = () => {
    state.step = state.step - 1
    contentWrapper.value?.scrollTo?.({
        top: 0,
        behavior: 'smooth'
    });
}
</script>

<template>

    <Head title="Application Form" />

    <Modal class="m-6" :show="state.isShowModal" @close="handleCloseModal()">
        <div v-if="state.modalType === 'submissionSuccess'" class="px-6 py-8 w-full flex flex-col items-center gap-8">
            <h2 class="text-lg font-medium text-gray-900 text-center">
                Application Form Submitted Succesfully
            </h2>
            <p class="px-8 text-center text-gray-600">
                Thank you for submitting your application, you will be
                redirected automatically...
            </p>
        </div>
        <div v-if="state.modalType === 'submissionFailed'" class="px-6 py-8 w-full flex flex-col items-center gap-8">
            <h2 class="text-lg font-medium text-gray-900 text-center">
                Failed to Submit Application Form
            </h2>
            <div v-if="state.backendMessages?.length" class="flex flex-col">
                <p class="px-8 pb-4 text-center text-gray-600">
                    Please check these conditions:
                </p>
                <ul class="list-disc w-auto">
                    <li v-for="message in state.backendMessages" class="pl-2 text-left text-gray-600">
                        {{ message }}
                    </li>
                </ul>
            </div>
            <div v-else class="flex flex-col">
                <p class="px-8 pb-4 text-center text-gray-600">
                    Something went wrong, please contact administrators.
                </p>
            </div>

            <div class="flex gap-4">
                <SecondaryButton @click="handleCloseModal()">Ok</SecondaryButton>
            </div>
        </div>
        <div v-if="state.modalType === 'submitConfirmation'" class="px-6 py-8 w-full flex flex-col items-center gap-8">
            <h2 class="text-lg font-medium text-gray-900 text-center">
                Are you sure to submit?
            </h2>
            <p class="md:px-8 px-2 text-center text-gray-600">
                Please review your entries before confirming. Once submitted,
                the information cannot be altered. Double-check for accuracy and
                completeness to ensure a successful submission.
            </p>
            <div class="flex gap-4">
                <SecondaryButton @click="handleCloseModal()">Cancel</SecondaryButton>
                <PrimaryButton :disabled="state.isSubmitting"
                    :buttonClass="state.isSubmitting ? 'bg-gray-300' : 'bg-teasel'" @click="submitForm()">
                    Ok
                    <img v-if="state.isSubmitting" src="/loading-gif.gif" class="w-4 h-4 ml-2" />
                </PrimaryButton>
            </div>
        </div>
    </Modal>

    <div class="w-extra flex flex-col h-extra items-center bg-white">
        <div class="md:w-content w-[100%] absolute z-10 p-4">
            <div
                class="w-[100%] rounded-t-lg rounded-tl-lg p-4 bg-teasel flex flex-col sm:flex-row justify-between sm:items-center transition-all ease-in duration-200drop-shadow-md">
                <span class="text-white font-bold text-xl">APPLICATION FORM</span>
                <span class="text-white font-bold text-xl">{{
                        title[state.step]
                }}</span>
            </div>
        </div>
        <div class="md:w-content w-[100%] absolute z-10 p-4 bottom-0">
            <div v-if="errorMessages.length" class="bg-red-300 p-2 text-sm text-white">
                <div v-for="message in errorMessages">
                    {{ message }}
                </div>
            </div>
            <div
                class="w-[100%] rounded-bl-lg rounded-br-lg p-4 bg-white border border-illusion flex justify-between items-center">
                <div class="flex-1">
                    <button v-if="state.step > 1" @click="handlePrev()" :type="type"
                        class="inline-flex items-center px-4 py-2 bg-lavender border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-illusion active:bg-illusion focus:outline-none focus:ring-2 focus:ring-illusion focus:ring-offset-2 transition ease-in-out duration-150">
                        Prev
                    </button>
                </div>
                <div class="flex-1 flex justify-center">
                    <span class="text-teasel font-bold text-base">Step {{ state.step }} / 4</span>
                </div>
                <div class="flex-1 flex justify-end">
                    <button v-if="state.step < 4" @click="handleNext()" :type="type" :disabled="!validateForm?.status"
                        :class="`${validateForm?.status
                        ? 'bg-lavender hover:bg-illusion active:bg-illusion focus:outline-none focus:ring-2 focus:ring-illusion focus:ring-offset-2'
                        : 'bg-gray-300'
                        } inline-flex items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150`">
                        Next
                    </button>
                    <button v-else-if="state.step === 4" @click="confirmSubmission()" :type="type"
                        :disabled="!validateForm?.status || state.isSubmitting"
                        :class="`${validateForm?.status && !state.isSubmitting
                        ? 'bg-lavender hover:bg-illusion active:bg-illusion focus:outline-none focus:ring-2 focus:ring-illusion focus:ring-offset-2'
                        : 'bg-gray-300'
                        } inline-flex items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150`">
                        {{ state.isSubmitting ? "Submitting" : "Submit" }}
                        <img v-if="state.isSubmitting" src="/loading-gif.gif" class="w-4 h-4 ml-2" />
                    </button>
                </div>
            </div>
        </div>
        <div :class="`md:w-content w-[100%] h-[100%] p-4 ${errorMessages.length ? 'pb-10' : ''}`">
            <div ref="contentWrapper"
                class="w-full h-[100%] bg-lavender border border-illusion rounded-lg bg-white overflow-y-scroll relative">
                <Introduction v-if="(state.step === 1)" />
                <PersonalInformation ref="personalInformationForm" :existingAnswers="formData?.[title[2]]"
                    v-else-if="(state.step === 2)" @handleOnChange="(answers) => {
                        formData[title[2]] = answers;
                    }" />
                <AcademicDetails ref="academicDetailsForm" :existingAnswers="formData?.[title[3]]"
                    v-else-if="(state.step === 3)" @handleOnChange="(answers) => {
                        formData[title[3]] = answers;
                    }" />
                <ApplicationSubmission ref="applicationSubmissionForm" :existingAnswers="formData?.[title[4]]"
                    v-else-if="(state.step === 4)" @handleOnChange="(answers) => {
                        formData[title[4]] = answers;
                    }" />
            </div>
        </div>
    </div>
</template>

<style>
table {
    border-collapse: collapse;
}

th,
td {
    border: 1px solid thistle;
}

.h-extra {
    height: 100vh;
    max-height: -webkit-fill-available;
    -webkit-overflow-scrolling: touch
}
</style>
