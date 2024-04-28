let f1 = 0;
let f2 = 0;
let f3 = 0;
let f4 = 0;

// ! Validation Function Stamp
function validateForm(form, event) {
    let inputs = form.querySelectorAll("input[required], textarea[required]");
    let categorySelects = form.querySelectorAll("select[required]");
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
    categorySelects.forEach(function (select) {
        let categoryErrorMsg = select.nextElementSibling;
        if (select.value === "التصنيف" || select.value === "المنطقة") {
            select.classList.add("error");
            select.classList.remove("good");
            categoryErrorMsg.classList.remove("d-none");
            isValid = false;
        } else {
            select.classList.remove("error");
            select.classList.add("good");
            categoryErrorMsg.classList.add("d-none");
        }
    });
    if (!isValid) {
        event.preventDefault();
    }
    return isValid;
}
//! Store Subscriber Form
const storeSub = document.getElementById("storeSubscriber");
if (storeSub) {
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
        if (this.value.trim() === "") {
            birthReq.classList.remove("d-none");
        } else {
            birthReq.classList.add("d-none");
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
}
//! Validation Store News
const newsform = document.getElementById("newsForm");
if (newsform) {
    newsform.addEventListener("submit", function (event) {
        event.preventDefault();
        if (validateForm(newsform)) {
            this.submit();
        }
    });
    //! Validation For Input News Title
    const newsMsg = document.getElementById("newsMsg");
    const title = document.getElementById("newsTitle");
    const newsReq = document.getElementById("newsReq");
    title.addEventListener("keyup", function () {
        let letters = /^[\u0600-\u06FF\s]{7,}$/;
        if (letters.test(title.value)) {
            title.classList.add("good");
            newsMsg.classList.add("d-none");
        } else {
            title.classList.remove("good");
            title.classList.add("error");
            newsMsg.classList.remove("d-none");
        }
    });
    title.addEventListener("input", function () {
        if (this.value.trim() === "") {
            newsReq.classList.remove("d-none");
            newsMsg.classList.add("d-none");
        } else {
            newsReq.classList.add("d-none");
            newsMsg.classList.remove("d-none");
        }
    });
    title.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            newsReq.classList.remove("d-none");
        } else {
            newsReq.classList.add("d-none");
        }
    });
    //! Validation For Input News TextArea
    const details = document.getElementById("details");
    const newsDetailsMsg = document.getElementById("detailsMsg");
    const newsDetailsReq = document.getElementById("detailsReq");
    details.addEventListener("keyup", function () {
        let letters = /^[\u0600-\u06FF\s]+$/;
        if (letters.test(details.value)) {
            details.classList.add("good");
            newsDetailsMsg.classList.add("d-none");
        } else {
            details.classList.remove("good");
            details.classList.add("error");
            newsDetailsMsg.classList.remove("d-none");
        }
    });
    details.addEventListener("input", function () {
        if (this.value.trim() === "") {
            newsDetailsReq.classList.remove("d-none");
        } else {
            newsDetailsReq.classList.add("d-none");
        }
    });
    //! Validation For Category Select
    const categorySelect = document.getElementById("categorySelect");
    const categoryMsg = document.getElementById("categoryMsg");
    categorySelect.addEventListener("change", function () {
        if (this.options[this.selectedIndex].value === "التصنيف") {
            categorySelect.classList.add("error");
            categoryMsg.classList.remove("d-none");
            categorySelect.classList.remove("good");
        } else {
            categorySelect.classList.remove("error");
            categorySelect.classList.add("good");
            categoryMsg.classList.add("d-none");
        }
    });
    //! Validation ON Submit
    const submit = document.getElementById("submit");
    submit.addEventListener("click", function (event) {
        event.preventDefault();
        if (validateForm(newsform)) {
            this.submit();
        }
    });
}
//! Validation For Store Cost Years
const costYears = document.getElementById("costYears");
if (costYears) {
    costYears.addEventListener("submit", function (event) {
        event.preventDefault();
        if (validateForm(costYears)) {
            this.submit();
        }
    });
    //! Validation For Year Cost
    const year = document.getElementById("year");
    const yearMsg = document.getElementById("yearMsg");
    const yearReq = document.getElementById("yearReq");
    year.addEventListener("keyup", function () {
        let letters = /^\d{4}$/;
        if (letters.test(year.value)) {
            year.classList.add("good");
            yearMsg.classList.add("d-none");
        } else {
            year.classList.remove("good");
            year.classList.add("error");
            yearMsg.classList.remove("d-none");
        }
    });
    year.addEventListener("input", function () {
        if (this.value.trim() === "") {
            yearReq.classList.remove("d-none");
            yearMsg.classList.add("d-none");
        } else {
            yearReq.classList.add("d-none");
            yearMsg.classList.remove("d-none");
        }
    });
    year.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            yearReq.classList.remove("d-none");
        } else {
            yearReq.classList.add("d-none");
        }
    });
    //! Validation For Year Cost
    const cost = document.getElementById("cost");
    const amountMsg = document.getElementById("amountMsg");
    const amountReq = document.getElementById("amountReq");
    cost.addEventListener("keyup", function () {
        let letters = /^(?!-)(?!0+$)\d{2,10}$/;
        if (letters.test(cost.value)) {
            cost.classList.add("good");
            amountMsg.classList.add("d-none");
        } else {
            cost.classList.remove("good");
            cost.classList.add("error");
            amountMsg.classList.remove("d-none");
        }
    });
    cost.addEventListener("input", function () {
        if (this.value.trim() === "") {
            amountReq.classList.remove("d-none");
            amountMsg.classList.add("d-none");
        } else {
            amountReq.classList.add("d-none");
            amountMsg.classList.remove("d-none");
        }
    });
    cost.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            amountReq.classList.remove("d-none");
        } else {
            amountReq.classList.add("d-none");
        }
    });
    //! Validation For Submit Cost
    const submit = document.getElementById("submitCost");
    submit.addEventListener("click", function (event) {
        event.preventDefault();
        if (validateForm(costYears)) {
            this.submit();
        }
    });
}
//! Validation For Store Tombs
const tomb = document.getElementById("tombForm");
if (tomb) {
    tomb.addEventListener("submit", function (event) {
        event.preventDefault();
        if (validateForm(tomb)) {
            this.submit();
        }
    });
    //! Validation For Tomb Name
    const tombName = document.getElementById("tombName");
    const tombReq = document.getElementById("tombReq");
    const tombMsg = document.getElementById("tombMsg");
    tombName.addEventListener("keyup", function () {
        let letters = /^[\u0600-\u06FF\s]{3,}$/;
        if (letters.test(tombName.value.trim())) {
            tombName.classList.remove("error");
            tombName.classList.add("good");
            tombMsg.classList.add("d-none");
        } else {
            tombName.classList.remove("good");
            tombName.classList.add("error");
            tombMsg.classList.remove("d-none");
        }
    });
    tombName.addEventListener("input", function () {
        if (this.value.trim() === "") {
            tombReq.classList.remove("d-none");
            tombMsg.classList.add("d-none");
        } else {
            tombReq.classList.add("d-none");
            tombMsg.classList.remove("d-none");
        }
    });
    tombName.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            tombReq.classList.remove("d-none");
        } else {
            tombReq.classList.add("d-none");
        }
    });
    //! Validation For Region
    const tombRegion = document.getElementById("regionSelect");
    const regionMsg = document.getElementById("regionMsg");
    tombRegion.addEventListener("change", function (event) {
        event.preventDefault();
        if (this.options[this.selectedIndex].value === "المنطقة") {
            tombRegion.classList.add("error");
            regionMsg.classList.remove("d-none");
            tombRegion.classList.remove("good");
        } else {
            tombRegion.classList.remove("error");
            tombRegion.classList.add("good");
            regionMsg.classList.add("d-none");
        }
    });
    tombRegion.addEventListener("input", function () {
        if (this.value.trim() === "") {
            regionMsg.classList.add("d-none");
        } else {
            regionMsg.classList.remove("d-none");
        }
    });
    //! Validation For Location
    const tombLocation = document.getElementById("location");
    const locationReq = document.getElementById("locationReq");
    tombLocation.addEventListener("keyup", function () {
        let letters = /^[\u0600-\u06FF\s]{3,}$/;
        if (letters.test(tombLocation.value)) {
            tombLocation.classList.add("good");
            locationReq.classList.add("d-none");
        } else {
            tombLocation.classList.remove("good");
            tombLocation.classList.add("error");
            locationReq.classList.remove("d-none");
        }
    });
    tombLocation.addEventListener("input", function () {
        if (this.value.trim() === "") {
            locationReq.classList.add("d-none");
        } else {
            locationReq.classList.remove("d-none");
        }
    });
    //! Validation For Submit Form
    const submit = document.getElementById("tombSubmit");
    submit.addEventListener("click", function (event) {
        event.preventDefault();
        if (validateForm(tomb)) {
            this.submit();
        }
    });
}
//! Validation For Store Workers
//! Validation For Store Associations Committes
const associate = document.getElementById("associateForm");
if (associate) {
    associate.addEventListener("submit", function (event) {
        event.preventDefault();
        if (validateForm(associate)) {
            this.submit();
        }
    });
    //! Validation For Association Name
    const associateName = document.getElementById("associateName");
    const associateNameReq = document.getElementById("associateNameReq");
    const associateNameMsg = document.getElementById("associateNameMsg");
    associateName.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{10,}$/;
        if (this.value.trim() === "") {
            associateNameReq.classList.remove("d-none");
            associateNameMsg.classList.add("d-none");
            associateName.classList.remove("good");
            associateName.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                associateName.classList.add("good");
                associateName.classList.remove("error");
                associateNameMsg.classList.add("d-none");
                associateNameReq.classList.add("d-none");
            } else {
                associateName.classList.remove("good");
                associateName.classList.add("error");
                associateNameMsg.classList.remove("d-none");
                associateNameReq.classList.add("d-none");
            }
        }
    });
    //! Validation For Association Boss
    const associateBoss = document.getElementById("associateBoss");
    const bossMsg = document.getElementById("bossMsg");
    const bossReq = document.getElementById("bossReq");
    associateBoss.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{3,}$/;
        if (this.value.trim() === "") {
            bossReq.classList.remove("d-none");
            bossMsg.classList.add("d-none");
            associateBoss.classList.remove("good");
            associateBoss.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                associateBoss.classList.add("good");
                associateBoss.classList.remove("error");
                bossMsg.classList.add("d-none");
                bossReq.classList.add("d-none");
            } else {
                associateBoss.classList.remove("good");
                associateBoss.classList.add("error");
                bossMsg.classList.remove("d-none");
                bossReq.classList.add("d-none");
            }
        }
    });
    //! Validation For Submit Form
    const submit = document.getElementById("associateSubmit");
    submit.addEventListener("click", function (event) {
        event.preventDefault();
        if (validateForm(associate)) {
            this.submit();
        }
    });
}
