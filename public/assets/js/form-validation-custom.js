let f1 = 0;
let f2 = 0;
let f3 = 0;

// ! Validation Function Stamp
function validateForm(form) {
    let inputs = form.querySelectorAll("input[required]");
    let isValid = true;
    inputs.forEach(function (input) {
        if (!input.value.trim()) {
            input.classList.add("error");
            isValid = false;
        } else {
            input.classList.remove("error");
            input.classList.add("good");
            input.removeAttribute("required");
            isValid = true;
        }
    });
    return isValid;
}
//! Store Subscriber Form
const storeSub = document.getElementById("storeSubscriber");
storeSub.addEventListener("submit", function (event) {
    event.preventDefault();
    if (validateForm(storeSub)) {
        this.submit();
    }
});

function nextStepFunction() {
    if (validateForm(storeSub)) {
        nextStep();
    }
}

function backStepFunction() {
    backStep();
    // const currentStep = document.querySelector(".stepper-one");
    // if (currentStep) {
    //     if (!validateForm(storeSub)) {
    //         alert("not validated");
    //     } else {
    //         alert("validated");
    //     }
    // }
}

//! Validation Subscriber SSN
const ssn = document.getElementById("ssn");
const ssnMsg = document.getElementById("ssnMsg");
ssn.addEventListener("keyup", function () {
    const regSSN = /(?=.{14,})/;
    if (regSSN.test(ssn.value)) {
        ssn.classList.add("good");
        ssnMsg.classList.add("d-none");
        f1 = 1;
        if (f1 === 1 && f2 === 1 && f3 === 1) {
            document.getElementById("nextbtn").disabled = false;
        } else {
            document.getElementById("nextbtn").disabled = true;
        }
    } else {
        ssn.classList.remove("good");
        ssn.classList.add("error");
        ssnMsg.classList.remove("d-none");
        f1 = 0;
        document.getElementById("nextbtn").disabled = true;
    }
});
//! Validation Subscriber Mobile
const mobile = document.getElementById("mobile_no");
const mobileMsg = document.getElementById("mobileMsg");
mobile.addEventListener("keyup", function () {
    const regMOB = /(?=.{11,})/;
    if (regMOB.test(mobile.value)) {
        mobile.classList.add("good");
        mobileMsg.classList.add("d-none");
        f2 = 1;
        if (f1 === 1 && f2 === 1 && f3 === 1) {
            document.getElementById("nextbtn").disabled = false;
        } else {
            document.getElementById("nextbtn").disabled = true;
        }
    } else {
        mobile.classList.remove("good");
        mobile.classList.add("error");
        mobileMsg.classList.remove("d-none");
        f2 = 0;
        document.getElementById("nextbtn").disabled = true;
    }
});
//! Validation Subscriber Name
const nameSub = document.getElementById("name");
const nameSubMsg = document.getElementById("nameMsg");
nameSub.addEventListener("keyup", function () {
    let letters = /^[\u0600-\u06FF\s]{3,}$/;
    if (letters.test(nameSub.value)) {
        nameSub.classList.add("good");
        nameSubMsg.classList.add("d-none");
        f3 = 1;
        if (f1 === 1 && f2 === 1 && f3 === 1) {
            document.getElementById("nextbtn").disabled = false;
        } else {
            document.getElementById("nextbtn").disabled = true;
        }
    } else {
        nameSub.classList.remove("good");
        nameSub.classList.add("error");
        nameSubMsg.classList.remove("d-none");
        f3 = 0;
        document.getElementById("nextbtn").disabled = true;
    }
});

//! Validation Subscriber Birthdate
const birthday = document.getElementById("birthday");
const birthdayMsg = document.getElementById("birthdayMsg");
