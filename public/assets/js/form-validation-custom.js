let f1 = 0;
let f2 = 0;
let f3 = 0;
let f4 = 0;

// ! Validation Function Stamp
function validateForm(form) {
    let inputs = form.querySelectorAll("input[required]");
    let reqs = form.querySelectorAll("p.required");
    let isValid = true;
    inputs.forEach(function (input) {
        if (!input.value.trim()) {
            input.classList.add("error");
            isValid = false;
            reqs.forEach(function (req) {
                req.classList.remove("d-none");
            });
        } else {
            input.classList.remove("error");
            input.classList.add("good");
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
}
//! Validation Subscriber SSN
const ssn = document.getElementById("ssn");
const ssnMsg = document.getElementById("ssnMsg");
const ssnReq = document.getElementById("ssnMsgRequired");
ssn.addEventListener("keyup", function () {
    const regSSN = /(?=.{14,})/;
    if (regSSN.test(ssn.value)) {
        ssn.classList.add("good");
        ssnMsg.classList.add("d-none");
        ssnReq.classList.add("d-none");
        f1 = 1;
        if (f1 === 1 && f2 === 1 && f3 === 1 && f4 === 1) {
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
ssn.addEventListener("input", function () {
    if (this.value.trim() === "") {
        ssnReq.classList.remove("d-none");
        ssnMsg.classList.add("d-none");
    } else {
        ssnReq.classList.add("d-none");
        ssnMsg.classList.remove("d-none");
    }
});

ssn.addEventListener("blur", function () {
    if (this.value.trim() === "") {
        ssnReq.classList.remove("d-none");
    } else {
        ssnReq.classList.add("d-none");
    }
});
//! Validation Subscriber Mobile
const mobile = document.getElementById("mobile_no");
const mobileMsg = document.getElementById("mobileMsg");
const mobReq = document.getElementById("mobileMsgRequired");
mobile.addEventListener("keyup", function () {
    const regMOB = /(?=.{11,})/;
    if (regMOB.test(mobile.value)) {
        mobile.classList.add("good");
        mobileMsg.classList.add("d-none");
        mobReq.classList.add("d-none");
        f2 = 1;
        if (f1 === 1 && f2 === 1 && f3 === 1 && f4 === 1) {
            document.getElementById("nextbtn").disabled = false;
        } else {
            document.getElementById("nextbtn").disabled = true;
        }
    } else {
        mobile.classList.remove("good");
        mobile.classList.add("error");
        mobileMsg.classList.remove("d-none");
        if (isEmpty(mobile)) {
            mobReq.classList.remove("d-none");
        } else {
            mobReq.classList.add("d-none");
        }
        f2 = 0;
        document.getElementById("nextbtn").disabled = true;
    }
});
mobile.addEventListener("input", function () {
    if (this.value.trim() === "") {
        mobReq.classList.remove("d-none");
        mobileMsg.classList.add("d-none");
    } else {
        mobReq.classList.add("d-none");
        mobileMsg.classList.remove("d-none");
    }
});
mobile.addEventListener("blur", function () {
    if (this.value.trim() === "") {
        mobReq.classList.remove("d-none");
    } else {
        mobReq.classList.add("d-none");
    }
});
//! Validation Subscriber Name
const nameSub = document.getElementById("name");
const nameSubMsg = document.getElementById("nameMsg");
const nameReq = document.getElementById("nameMsgRequired");
nameSub.addEventListener("keyup", function () {
    let letters = /^[\u0600-\u06FF\s]{3,}$/;
    if (letters.test(nameSub.value)) {
        nameSub.classList.add("good");
        nameSubMsg.classList.add("d-none");
        f3 = 1;
        if (f1 === 1 && f2 === 1 && f3 === 1 && f4 === 1) {
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
nameSub.addEventListener("input", function () {
    if (this.value.trim() === "") {
        nameReq.classList.remove("d-none");
        nameSubMsg.classList.add("d-none");
    } else {
        nameReq.classList.add("d-none");
        nameSubMsg.classList.remove("d-none");
    }
});
nameSub.addEventListener("blur", function () {
    if (this.value.trim() === "") {
        nameReq.classList.remove("d-none");
    } else {
        nameReq.classList.add("d-none");
    }
});
//! Validation Subscriber Birthdate
const birthday = document.getElementById("birthdate");
const birthdayMsg = document.getElementById("birthdateMsg");
const birthReq = document.getElementById("birthdateMsgRequired");
birthday.addEventListener("blur", function () {
    if (this.value) {
        birthday.classList.add("good");
        birthdayMsg.classList.add("d-none");
        f4 = 1;
        if (f1 === 1 && f2 === 1 && f3 === 1 && f4 === 1) {
            document.getElementById("nextbtn").disabled = false;
        } else {
            document.getElementById("nextbtn").disabled = true;
        }
    } else {
        birthday.classList.remove("good");
        birthday.classList.add("error");
        birthdayMsg.classList.remove("d-none");
        f4 = 0;
        document.getElementById("nextbtn").disabled = true;
    }
});
birthday.addEventListener("input", function () {
    if (this.value.trim() === "") {
        birthReq.classList.remove("d-none");
        birthdayMsg.classList.add("d-none");
    } else {
        birthReq.classList.add("d-none");
        birthdayMsg.classList.remove("d-none");
    }
});
birthday.addEventListener("blur", function () {
    if (this.value.trim() === "") {
        birthReq.classList.remove("d-none");
    } else {
        birthReq.classList.add("d-none");
    }
});
