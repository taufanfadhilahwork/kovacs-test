<script setup>
import { onUnmounted, reactive } from "vue";

import { validateForm } from '@/Utils/form-validation'

const emit = defineEmits(['handleOnChange']);
const props = defineProps({
    existingAnswers: {
        type: Object,
        default: {},
    },
});

const answers = reactive(props.existingAnswers)
const questions = {
    "UWC student number:": {
        type: "text",
        name: "academic_uwc_student_number",
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
                    <input :id="questions[question].name" :name="questions[question].name" v-model="answers[questions[question].name]"
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
