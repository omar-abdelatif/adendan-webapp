let f1 = 0;
let f2 = 0;
let f3 = 0;
let f4 = 0;
// ! Validation Function Stamp
function validateForm(form) {
    let isValid = true;
    let inputs = form.querySelectorAll(
        "input[type='number'][required],input[type='text'][required]"
    );
    inputs.forEach(function (input) {
        let inputError = input.nextElementSibling;
        if (input.value.trim() === "") {
            input.classList.add("error");
            inputError.classList.remove("d-none");
            isValid = false;
        } else {
            input.classList.remove("error");
            input.classList.add("good");
            inputError.classList.add("d-none");
        }
    });
    const categorySelects = form.querySelectorAll("select[required]");
    categorySelects.forEach(function (select) {
        let categoryErrorMsg = select.nextElementSibling;
        if (
            select.value === "التصنيف" ||
            select.value === "المنطقة" ||
            select.value === "الحرفة"
        ) {
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
    const inputImg = form.querySelectorAll('input[type="file"][required]');
    inputImg.forEach((img) => {
        let imgError = img.nextElementSibling;
        if (img.files.length === 0) {
            img.classList.add("error");
            imgError.classList.remove("d-none");
            isValid = false;
        }
    });
    const textareas = form.querySelectorAll("textarea[required]");
    textareas.forEach(function (text) {
        let textareaErrorMsg = text.nextElementSibling;
        if (text.value.trim() === "") {
            text.classList.add("error");
            textareaErrorMsg.classList.remove("d-none");
            isValid = false;
        } else {
            text.classList.remove("error");
            text.classList.add("good");
            textareaErrorMsg.classList.add("d-none");
        }
    });
    return isValid;
}
function validateImage(img, imgReq, imgExt, invoice_img, imgSizeMsg) {
    const allowedExtensions = [
        "image/jpeg",
        "image/jpg",
        "image/png",
        "image/webp",
    ];
    imgReq.classList.add("d-none");
    imgExt.classList.add("d-none");
    imgSizeMsg.classList.add("d-none");
    if (!img) {
        invoice_img.classList.remove("good");
        invoice_img.classList.add("error");
        imgReq.classList.remove("d-none");
        return false;
    } else {
        invoice_img.classList.add("good");
        invoice_img.classList.remove("error");
        imgReq.classList.add("d-none");
    }
    if (!allowedExtensions.includes(img.type)) {
        invoice_img.classList.add("error");
        invoice_img.classList.remove("good");
        imgExt.classList.remove("d-none");
        return false;
    } else {
        invoice_img.classList.remove("error");
        invoice_img.classList.add("good");
        imgExt.classList.add("d-none");
    }
    const sizeLimit = 2048;
    if (img.size / 1024 > sizeLimit) {
        invoice_img.classList.add("error");
        invoice_img.classList.remove("good");
        imgSize.classList.remove("d-none");
        return false;
    } else {
        invoice_img.classList.remove("error");
        invoice_img.classList.add("good");
        imgSize.classList.add("d-none");
    }
}
//! Store Subscriber Form
const storeSub = document.getElementById("storeSubscriber");
if (storeSub) {
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
    //! Validation on Submit Button
    const subSubmit = document.getElementById("submitButton");
    subSubmit.addEventListener("click", function (e) {
        e.preventDefault();
        if (validateForm(storeSub)) {
            storeSub.submit();
        }
    });
}
//! Validation Store News
const newsform = document.getElementById("newsForm");
if (newsform) {
    //! Validation For Input News Title
    const newsMsg = document.getElementById("newsMsg");
    const title = document.getElementById("newsTitle");
    const newsReq = document.getElementById("newsReq");
    title.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{7,}$/;
        if (this.value.trim() === "") {
            newsReq.classList.remove("d-none");
            newsMsg.classList.add("d-none");
            title.classList.remove("good");
            title.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                title.classList.add("good");
                title.classList.remove("error");
                newsMsg.classList.add("d-none");
                newsReq.classList.add("d-none");
            } else {
                title.classList.remove("good");
                title.classList.add("error");
                newsMsg.classList.remove("d-none");
                newsReq.classList.add("d-none");
            }
        }
    });
    //! Validation For Input News TextArea
    const details = document.getElementById("details");
    const newsDetailsMsg = document.getElementById("detailsMsg");
    const newsDetailsReq = document.getElementById("detailsReq");
    details.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{7,}$/;
        if (this.value.trim() === "") {
            newsDetailsReq.classList.remove("d-none");
            newsDetailsMsg.classList.add("d-none");
            details.classList.remove("good");
            details.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                details.classList.add("good");
                newsDetailsReq.classList.add("d-none");
            } else {
                details.classList.remove("good");
                details.classList.add("error");
                newsDetailsReq.classList.remove("d-none");
            }
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
    //! Validation For News Image
    const newsImg = document.getElementById("newsImg");
    const NewsimgReq = document.getElementById("imgReq");
    const NewsimgSize = document.getElementById("imgSize");
    const NewsimgExt = document.getElementById("imgExt");
    newsImg.addEventListener("change", function () {
        const img = newsImg.files[0];
        if (img) {
            validateImage(img, NewsimgReq, NewsimgExt, newsImg, NewsimgSize);
        } else {
            newsImg.classList.add("error");
            newsImg.classList.remove("good");
            NewsimgReq.classList.remove("d-none");
            NewsimgSize.classList.add("d-none");
            NewsimgExt.classList.add("d-none");
        }
    });
    //! Validation ON Submit
    const submit = document.getElementById("newsSubmit");
    submit.addEventListener("click", function (event) {
        event.preventDefault();
        if (validateForm(newsform)) {
            newsform.submit();
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
            costYears.submit();
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
            tomb.submit();
        }
    });
}
//! Validation For Store Workers
const workers = document.getElementById("workers");
if (workers) {
    //! Validation For Worker Name
    const workerName = document.getElementById("worker_name");
    const nameMsg = document.getElementById("nameMsg");
    const nameReq = document.getElementById("nameReq");
    workerName.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{3,}$/;
        if (this.value.trim() === "") {
            nameReq.classList.remove("d-none");
            nameMsg.classList.add("d-none");
            workerName.classList.remove("good");
            workerName.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                workerName.classList.add("good");
                workerName.classList.remove("error");
                nameMsg.classList.add("d-none");
                nameReq.classList.add("d-none");
            } else {
                workerName.classList.remove("good");
                workerName.classList.add("error");
                nameMsg.classList.remove("d-none");
                nameReq.classList.add("d-none");
            }
        }
    });
    //! Validation For Worker Mobile
    const workerMob = document.getElementById("worker_mob");
    const mobReq = document.getElementById("mobReq");
    const mobCount = document.getElementById("mobCount");
    workerMob.addEventListener("input", function () {
        const regMOB = /(?=.{11,})/;
        if (this.value.trim() === "") {
            mobReq.classList.remove("d-none");
            mobCount.classList.add("d-none");
            workerMob.classList.remove("good");
            workerMob.classList.add("error");
        } else {
            if (regMOB.test(this.value)) {
                workerMob.classList.add("good");
                workerMob.classList.remove("error");
                mobReq.classList.add("d-none");
                mobCount.classList.add("d-none");
            } else {
                workerMob.classList.remove("good");
                workerMob.classList.add("error");
                mobReq.classList.add("d-none");
                mobCount.classList.remove("d-none");
            }
        }
    });
    //! Validation For Worker Category
    const craft = document.getElementById("craftSelect");
    const craftReq = document.getElementById("craftReq");
    craft.addEventListener("change", function () {
        if (this.options[this.selectedIndex].value === "الحرفة") {
            craft.classList.add("error");
            craft.classList.remove("good");
            craftReq.classList.remove("d-none");
        } else {
            craft.classList.remove("error");
            craft.classList.add("good");
            craftReq.classList.add("d-none");
        }
        if (this.options[this.selectedIndex].value === "أخرى") {
            otherCraft.disabled = false;
            if (otherCraft.value.trim() === "") {
                otherReq.classList.remove("d-none");
                otherCraft.classList.remove("good");
                otherCraft.classList.add("error");
            }
        } else {
            otherCraft.disabled = true;
            otherCraft.classList.remove("good");
            otherCraft.classList.remove("error");
            otherReq.classList.add("d-none");
        }
    });
    //! Validation For Worker Other Category
    const otherCraft = document.getElementById("otherCategory");
    const otherReq = document.getElementById("otherReq");
    otherCraft.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{3,}$/;
        if (this.value.trim() === "") {
            otherReq.classList.remove("d-none");
            otherMsg.classList.remove("d-none");
            otherCraft.classList.remove("good");
            otherCraft.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                otherCraft.classList.add("good");
                otherCraft.classList.remove("error");
                otherReq.classList.add("d-none");
                otherMsg.classList.add("d-none");
            } else {
                otherCraft.classList.remove("good");
                otherCraft.classList.add("error");
                otherReq.classList.add("d-none");
                otherMsg.classList.remove("d-none");
            }
        }
    });
    //! Validation For Worker Location
    const worker_loc = document.getElementById("worker_location");
    const locReq = document.getElementById("locReq");
    const locMsg = document.getElementById("locMsg");
    worker_loc.addEventListener("input", function () {
        const regLOC = /^[\u0600-\u06FF\s]{5,}$/;
        if (this.value.trim() === "") {
            locReq.classList.remove("d-none");
            locMsg.classList.add("d-none");
            worker_loc.classList.remove("good");
            worker_loc.classList.add("error");
        } else {
            if (regLOC.test(this.value)) {
                worker_loc.classList.add("good");
                worker_loc.classList.remove("error");
                locMsg.classList.add("d-none");
                locReq.classList.add("d-none");
            } else {
                worker_loc.classList.remove("good");
                worker_loc.classList.add("error");
                locMsg.classList.remove("d-none");
                locReq.classList.add("d-none");
            }
        }
    });
    //! Validation For Submit Form
    const submit = document.getElementById("workerSubmit");
    submit.addEventListener("click", function (event) {
        event.preventDefault();
        if (validateForm(workers)) {
            workers.submit();
        }
    });
}
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
            associate.submit();
        }
    });
}
//! Validation For Store Miscellaneous
const miscForm = document.getElementById("miscForm");
if (miscForm) {
    //! Validation Select Category And Other Category
    const categorySelect = document.getElementById("category");
    const catReq = document.getElementById("catReq");
    const otherCat = document.getElementById("other_category");
    const otherReq = document.getElementById("otherReq");
    const otherMsg = document.getElementById("otherMsg");
    categorySelect.addEventListener("change", function () {
        if (this.options[this.selectedIndex].value === "التصنيف") {
            categorySelect.classList.add("error");
            categorySelect.classList.remove("good");
            catReq.classList.remove("d-none");
        } else {
            categorySelect.classList.remove("error");
            categorySelect.classList.add("good");
            catReq.classList.add("d-none");
        }
        if (this.options[this.selectedIndex].value === "أخرى") {
            otherCat.classList.remove("d-none");
            otherCat.disabled = false;
            otherCat.setAttribute("required", true);
            if (otherCat.value.trim() === "") {
                otherReq.classList.remove("d-none");
                otherCat.classList.remove("good");
                otherCat.classList.add("error");
            }
        } else {
            otherCat.disabled = true;
            otherCat.classList.remove("good");
            otherCat.classList.remove("error");
            otherCat.removeAttribute("required");
            otherReq.classList.add("d-none");
        }
    });
    otherCat.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{3,}$/;
        if (this.value.trim() === "") {
            otherReq.classList.remove("d-none");
            otherMsg.classList.remove("d-none");
            otherCat.classList.remove("good");
            otherCat.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                otherCat.classList.add("good");
                otherCat.classList.remove("error");
                otherReq.classList.add("d-none");
                otherMsg.classList.add("d-none");
            } else {
                otherCat.classList.remove("good");
                otherCat.classList.add("error");
                otherReq.classList.add("d-none");
                otherMsg.classList.remove("d-none");
            }
        }
    });
    //! Validation Amount Number
    const amount = document.getElementById("amount");
    const amountReq = document.getElementById("amountReq");
    const amountMsg = document.getElementById("amountMsg");
    amount.addEventListener("input", function () {
        const regAmount = /^.{2,}$/;
        if (this.value.trim() === "") {
            amountReq.classList.remove("d-none");
            amountMsg.classList.add("d-none");
            amount.classList.remove("good");
            amount.classList.add("error");
        } else {
            if (regAmount.test(this.value)) {
                amount.classList.add("good");
                amount.classList.remove("error");
                amountReq.classList.add("d-none");
                amountMsg.classList.add("d-none");
            } else {
                amount.classList.remove("good");
                amount.classList.add("error");
                amountReq.classList.add("d-none");
                amountMsg.classList.remove("d-none");
            }
        }
    });
    //! Validation Image Upload
    const invoice_img = document.getElementById("invoice_img");
    const imgReq = document.getElementById("imgReq");
    const imgSize = document.getElementById("imgSize");
    const imgExt = document.getElementById("imgExt");
    invoice_img.addEventListener("change", function () {
        const img = invoice_img.files[0];
        if (img) {
            validateImage(img, imgReq, imgExt, invoice_img, imgSize);
        } else {
            invoice_img.classList.add("error");
            invoice_img.classList.remove("good");
            imgReq.classList.remove("d-none");
            imgSize.classList.add("d-none");
            imgExt.classList.add("d-none");
        }
    });
    //! Validation Submit Form
    const miscSubmit = document.getElementById("miscSubmit");
    if (miscSubmit) {
        miscSubmit.addEventListener("click", function (event) {
            event.preventDefault();
            // const img = invoice_img.files[0];
            if (validateForm(miscForm)) {
                miscForm.submit();
            }
        });
    }
}
//! Validation For Store Board Members
const boardForm = document.getElementById("boardForm");
if (boardForm) {
    //! Validation For Board Name
    const boardName = document.getElementById("boardName");
    const BoardMsg = document.getElementById("NameMsg");
    const BoardReq = document.getElementById("NameReq");
    boardName.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{3,}$/;
        if (this.value.trim() === "") {
            BoardReq.classList.remove("d-none");
            BoardMsg.classList.add("d-none");
            boardName.classList.remove("good");
            boardName.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                boardName.classList.add("good");
                boardName.classList.remove("error");
                BoardMsg.classList.add("d-none");
                BoardReq.classList.add("d-none");
            } else {
                boardName.classList.remove("good");
                boardName.classList.add("error");
                BoardMsg.classList.remove("d-none");
                BoardReq.classList.add("d-none");
            }
        }
    });
    //! Validation For Board Position
    const BoardPosition = document.getElementById("boardPos");
    const PosMsg = document.getElementById("PosMsg");
    const PosReq = document.getElementById("PosReq");
    BoardPosition.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{5,}$/;
        if (this.value.trim() === "") {
            PosReq.classList.remove("d-none");
            PosMsg.classList.add("d-none");
            BoardPosition.classList.remove("good");
            BoardPosition.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                BoardPosition.classList.add("good");
                BoardPosition.classList.remove("error");
                PosMsg.classList.add("d-none");
                PosReq.classList.add("d-none");
            } else {
                BoardPosition.classList.remove("good");
                BoardPosition.classList.add("error");
                PosMsg.classList.remove("d-none");
                PosReq.classList.add("d-none");
            }
        }
    });
    //! Validation For Board Mob
    const BoardMob = document.getElementById("boardMob");
    const MobMsg = document.getElementById("MobMsg");
    const MobReq = document.getElementById("MobReq");
    BoardMob.addEventListener("input", function () {
        const regMOB = /(?=.{11,})/;
        if (this.value.trim() === "") {
            MobReq.classList.remove("d-none");
            MobMsg.classList.add("d-none");
            BoardMob.classList.remove("good");
            BoardMob.classList.add("error");
        } else {
            if (regMOB.test(this.value)) {
                BoardMob.classList.add("good");
                BoardMob.classList.remove("error");
                MobReq.classList.add("d-none");
                MobMsg.classList.add("d-none");
            } else {
                BoardMob.classList.remove("good");
                BoardMob.classList.add("error");
                MobReq.classList.add("d-none");
                MobMsg.classList.remove("d-none");
            }
        }
    });
    //! Validation For Board Image
    const BoardImg = document.getElementById("boardImg");
    const BoardimgReq = document.getElementById("imgReq");
    const BoardimgSize = document.getElementById("imgSize");
    const BoardimgExt = document.getElementById("imgExt");
    BoardImg.addEventListener("change", function () {
        const img = BoardImg.files[0];
        if (img) {
            validateImage(
                img,
                BoardimgReq,
                BoardimgExt,
                BoardImg,
                BoardimgSize
            );
        } else {
            BoardImg.classList.add("error");
            BoardImg.classList.remove("good");
            BoardimgReq.classList.remove("d-none");
            BoardimgSize.classList.add("d-none");
            BoardimgExt.classList.add("d-none");
        }
    });
    //! Validation For Submit Button
    const boardSubmit = document.getElementById("boardSubmit");
    if (boardSubmit) {
        boardSubmit.addEventListener("click", function (event) {
            event.preventDefault();
            if (validateForm(boardForm)) {
                boardForm.submit();
            }
        });
    }
}
