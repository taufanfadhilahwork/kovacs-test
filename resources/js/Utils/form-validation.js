const validateEmail = (email) => {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};

export const validateForm = (questions, answers) => {
    const validated = []
    Object.keys(questions).map(question => {
        if (question.optional) return

        const questionDetails = questions[question]
        if (typeof questionDetails?.hideWhen === 'function' && questionDetails.hideWhen()) return

        const questionName = questionDetails.name
        const answer = answers[questionName]

        if (["", undefined, null].includes(answer)) {
            validated.push({ name: questionDetails.name, message: `` }); return
        }

        if (questionDetails?.type === 'email' && !validateEmail(answer)) {
            validated.push({ name: questionDetails.name, message: `Please enter valid email address on ${question}` }); return
        }

        if (questionDetails.agreement && !answers[questionName]) {
            validated.push({ name: questionDetails.name, message: `` }); return
        }
    })

    return { status: !validated.length, validated }
}