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
            select.value === "الحرفة" ||
            select.value === "السنة"
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
        imgSizeMsg.classList.remove("d-none");
        return false;
    } else {
        invoice_img.classList.remove("error");
        invoice_img.classList.add("good");
        imgSizeMsg.classList.add("d-none");
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
    //! Validation Subscriber Name
    const nameSub = document.getElementById("name");
    const nameSubMsg = document.getElementById("nameMsg");
    const nameReq = document.getElementById("nameMsgRequired");
    nameSub.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{3,}$/;
        if (this.value.trim() === "") {
            nameReq.classList.remove("d-none");
            nameSubMsg.classList.add("d-none");
            nameSub.classList.remove("good");
            nameSub.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                nameSub.classList.add("good");
                nameSub.classList.remove("error");
                nameSubMsg.classList.add("d-none");
                nameReq.classList.add("d-none");
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
                nameReq.classList.add("d-none");
                f3 = 0;
                document.getElementById("nextbtn").disabled = true;
            }
        }
    });
    //! Validation Subscriber NICKNAME
    const nickname = document.getElementById("nickname");
    const nicknameReq = document.getElementById("nickReq");
    const nicknameMsg = document.getElementById("nickMsg");
    nickname.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]{5,}$/;
        if (this.value.trim() === "") {
            nicknameReq.classList.remove("d-none");
            nicknameMsg.classList.add("d-none");
            nickname.classList.remove("good");
            nickname.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                nickname.classList.add("good");
                nickname.classList.remove("error");
                nicknameMsg.classList.add("d-none");
                nicknameReq.classList.add("d-none");
            } else {
                nickname.classList.remove("good");
                nickname.classList.add("error");
                nicknameMsg.classList.remove("d-none");
                nicknameReq.classList.add("d-none");
            }
        }
    });
    //! Validation Subscriber SSN
    const ssn = document.getElementById("ssn");
    const ssnMsg = document.getElementById("ssnMsg");
    const ssnReq = document.getElementById("ssnMsgRequired");
    ssn.addEventListener("input", function () {
        let letters = /(?=.{14,})/;
        if (this.value.trim() === "") {
            ssnReq.classList.remove("d-none");
            ssnMsg.classList.add("d-none");
            ssn.classList.remove("good");
            ssn.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                ssn.classList.add("good");
                ssn.classList.remove("error");
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
                ssnReq.classList.add("d-none");
                f1 = 0;
                document.getElementById("nextbtn").disabled = true;
            }
        }
    });
    //! Validation Subscriber Mobile
    const mobile = document.getElementById("mobile_no");
    const mobileMsg = document.getElementById("mobileMsg");
    const mobReq = document.getElementById("mobileMsgRequired");
    mobile.addEventListener("input", function () {
        let letters = /(?=.{11,})/;
        if (mobile.value.trim() === "") {
            mobReq.classList.remove("d-none");
            mobileMsg.classList.add("d-none");
            mobile.classList.remove("good");
            mobile.classList.add("error");
        } else {
            if (letters.test(mobile.value)) {
                mobile.classList.add("good");
                mobile.classList.remove("error");
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
                mobReq.classList.add("d-none");
                f2 = 0;
                document.getElementById("nextbtn").disabled = true;
            }
        }
    });
    //! Validation Subscriber Birthdate
    const birthday = document.getElementById("birthdate");
    const birthdayMsg = document.getElementById("birthdateMsg");
    const birthReq = document.getElementById("birthdateMsgRequired");
    birthday.addEventListener("blur", function () {
        if (this.value.trim() === "") {
            birthReq.classList.remove("d-none");
            birthdayMsg.classList.add("d-none");
            birthday.classList.remove("good");
            birthday.classList.add("error");
            document.getElementById("nextbtn").disabled = true;
        } else {
            birthday.classList.remove("error");
            birthdayMsg.classList.add("d-none");
            birthReq.classList.add("d-none");
            birthday.classList.add("good");
            f4 = 1;
            if (f1 === 1 && f2 === 1 && f3 === 1 && f4 === 1) {
                document.getElementById("nextbtn").disabled = false;
            } else {
                document.getElementById("nextbtn").disabled = true;
            }
        }
    });
    //! Validation on Subscriber Address
    const address = document.getElementById("address");
    const addressReq = document.getElementById("addressReq");
    const addressMsg = document.getElementById("addressMsg");
    address.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s]+$/;
        if (this.value.trim() === "") {
            addressReq.classList.remove("d-none");
            addressMsg.classList.add("d-none");
            address.classList.remove("good");
            address.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                address.classList.add("good");
                address.classList.remove("error");
                addressMsg.classList.add("d-none");
                addressReq.classList.add("d-none");
            } else {
                address.classList.remove("good");
                address.classList.add("error");
                addressMsg.classList.remove("d-none");
                addressReq.classList.add("d-none");
            }
        }
    });
    //! Validation on Subscriber Avatar Image
    const AvatarImg = document.getElementById("personalImg");
    const SubimgReq = document.getElementById("personalimgReq");
    const SubimgSize = document.getElementById("personalimgSize");
    const SubimgExt = document.getElementById("personalimgExt");
    AvatarImg.addEventListener("change", function () {
        const img = AvatarImg.files[0];
        if (img) {
            validateImage(img, SubimgReq, SubimgExt, AvatarImg, SubimgSize);
        } else {
            AvatarImg.classList.add("error");
            AvatarImg.classList.remove("good");
            SubimgReq.classList.remove("d-none");
            SubimgSize.classList.add("d-none");
            SubimgExt.classList.add("d-none");
        }
    });
    //! Validation on Subscriber Id Image
    const IdImg = document.getElementById("idImg");
    const IdimgReq = document.getElementById("idimgReq");
    const IdimgSize = document.getElementById("idimgSize");
    const IdimgExt = document.getElementById("idimgExt");
    IdImg.addEventListener("change", function () {
        const img = IdImg.files[0];
        if (img) {
            validateImage(img, IdimgReq, IdimgExt, IdImg, IdimgSize);
        } else {
            IdImg.classList.add("error");
            IdImg.classList.remove("good");
            IdimgReq.classList.remove("d-none");
            IdimgSize.classList.add("d-none");
            IdimgExt.classList.add("d-none");
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
        let letters = /^[\u0600-\u06FF\s!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`]{7,}$/;
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
    const newsDetailsReq = document.getElementById("detailsReq");
    details.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`]{7,}$/;
        if (this.value.trim() === "") {
            newsDetailsReq.classList.remove("d-none");
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
    //! Validation For Year Cost
    const year = document.getElementById("year");
    const yearMsg = document.getElementById("yearMsg");
    const yearReq = document.getElementById("yearReq");
    year.addEventListener("input", function () {
        let letters = /^\d{4}$/;
        if (this.value.trim() === "") {
            yearReq.classList.remove("d-none");
            yearMsg.classList.add("d-none");
            year.classList.remove("good");
            year.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                year.classList.add("good");
                year.classList.remove("error");
                yearMsg.classList.add("d-none");
                yearReq.classList.add("d-none");
            } else {
                year.classList.remove("good");
                year.classList.add("error");
                yearMsg.classList.remove("d-none");
                yearReq.classList.add("d-none");
            }
        }
    });
    //! Validation For Year Cost
    const cost = document.getElementById("cost");
    const amountMsg = document.getElementById("amountMsg");
    const amountReq = document.getElementById("amountReq");
    cost.addEventListener("input", function () {
        let letters = /^(?!-)(?!0+$)\d{2,10}$/;
        if (this.value.trim() === "") {
            amountReq.classList.remove("d-none");
            amountMsg.classList.add("d-none");
            cost.classList.remove("good");
            cost.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                cost.classList.add("good");
                cost.classList.remove("error");
                amountMsg.classList.add("d-none");
                amountReq.classList.add("d-none");
            } else {
                cost.classList.remove("good");
                cost.classList.add("error");
                amountMsg.classList.remove("d-none");
                amountReq.classList.add("d-none");
            }
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
    //! Validation For Tomb Name
    const tombName = document.getElementById("tombName");
    const tombReq = document.getElementById("tombReq");
    const tombMsg = document.getElementById("tombMsg");
    tombName.addEventListener("input", function () {
        let letters = /^[\u0600-\u06FF\s\d\/\-\.\,]{3,}$/;
        if (this.value.trim() === "") {
            tombReq.classList.remove("d-none");
            tombMsg.classList.add("d-none");
            tombName.classList.remove("good");
            tombName.classList.add("error");
        } else {
            if (letters.test(this.value)) {
                tombName.classList.add("good");
                tombName.classList.remove("error");
                tombMsg.classList.add("d-none");
                tombReq.classList.add("d-none");
            } else {
                tombName.classList.remove("good");
                tombName.classList.add("error");
                tombMsg.classList.remove("d-none");
                tombReq.classList.add("d-none");
            }
        }
    });
    //! Validation For Region
    const tombRegion = document.getElementById("regionSelect");
    const regionMsg = document.getElementById("regionMsg");
    tombRegion.addEventListener("change", function () {
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
    //! Validation For Tomb Guard Mobile Number
    const tombGuardMobileNumber = document.getElementById("tomb_guard_number");
    const guardMsg = document.getElementById("guardMob");
    tombGuardMobileNumber.addEventListener("input", function () {
        let guardMob = /(?=.{11,})/;
        if (this.value.trim() === "") {
            guardMsg.classList.remove("d-none");
            tombGuardMobileNumber.classList.remove("good");
            tombGuardMobileNumber.classList.add("error");
        } else {
            if (guardMob.test(this.value)) {
                tombGuardMobileNumber.classList.add("good");
                tombGuardMobileNumber.classList.remove("error");
                guardMsg.classList.add("d-none");
            } else {
                tombGuardMobileNumber.classList.remove("good");
                tombGuardMobileNumber.classList.add("error");
                guardMsg.classList.add("d-none");
            }
        }
    });
    //! Validation For Location
    const tombLocation = document.getElementById("location");
    const locationReq = document.getElementById("locationReq");
    tombLocation.addEventListener("input", function () {
        let urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
        if (this.value.trim() === "") {
            locationReq.classList.remove("d-none");
            tombLocation.classList.remove("good");
            tombLocation.classList.add("error");
        } else {
            if (urlRegex.test(this.value)) {
                tombLocation.classList.add("good");
                tombLocation.classList.remove("error");
                locationReq.classList.add("d-none");
            } else {
                tombLocation.classList.remove("good");
                tombLocation.classList.add("error");
                locationReq.classList.add("d-none");
            }
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
    //! Validation Other Category
    const otherCat = document.getElementById("other_category");
    const otherReq = document.getElementById("otherReq");
    const otherMsg = document.getElementById("otherMsg");
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
//! Adding Debt Validation
const debtForm = document.getElementById("debtForm");
if (debtForm) {
    //! Validation For Choosen Year
    const yearSelect = document.getElementById("costYear");
    const costYearMsg = document.getElementById("costYearMsg");
    yearSelect.addEventListener("change", function () {
        if (this.options[this.selectedIndex].value === "السنة") {
            yearSelect.classList.add("error");
            yearSelect.classList.remove("good");
            costYearMsg.classList.remove("d-none");
        } else {
            yearSelect.classList.remove("error");
            yearSelect.classList.add("good");
            costYearMsg.classList.add("d-none");
        }
    });
    //! Validation For Year Cost
    const yearSub = document.getElementById("yearly_cost");
    const costMsg = document.getElementById("costMsg");
    const costReq = document.getElementById("costReq");
    yearSub.addEventListener("input", function () {
        let regCost = /(?=.{2,4})/;
        if (this.value.trim() === "") {
            costReq.classList.remove("d-none");
            costMsg.classList.add("d-none");
            yearSub.classList.remove("good");
            yearSub.classList.add("error");
        } else {
            if (regCost.test(this.value)) {
                yearSub.classList.add("good");
                yearSub.classList.remove("error");
                costReq.classList.add("d-none");
                costMsg.classList.add("d-none");
            } else {
                yearSub.classList.remove("good");
                yearSub.classList.add("error");
                costReq.classList.add("d-none");
                costMsg.classList.remove("d-none");
            }
        }
    });
    //! Validation For Submit Button
    const debtSubmit = document.getElementById("debtSubmit");
    if (debtSubmit) {
        debtSubmit.addEventListener("click", function (event) {
            event.preventDefault();
            if (validateForm(debtForm)) {
                debtForm.submit();
            }
        });
    }
}
//! Pay Debts Validation
const DelaysForm = document.querySelectorAll("[data-payDelay-id]");
if (DelaysForm) {
    const invoices = document.querySelectorAll("[data-invoice-id]");
    const AllDebts = document.querySelectorAll("[data-delay-id]");
    DelaysForm.forEach((form) => {
        //! Invoices Number Validation
        invoices.forEach((inv) => {
            let invoiceNo = form.querySelector(`input[name="invoice_no"][data-invoice-id="${inv.dataset.invoiceId}"]`);
            let invReq = form.querySelector(`p.invReq[data-invoice-id="${inv.dataset.invoiceId}"]`);
            let invMsg = form.querySelector(`p.invMsg[data-invoice-id="${inv.dataset.invoiceId}"]`);
            if (invoiceNo) {
                inv.addEventListener("input", function () {
                    let invoiceReg = /^\d{5}$/;
                    if (this.value.trim() === "") {
                        invReq.classList.remove("d-none");
                        invMsg.classList.add("d-none");
                        inv.classList.remove("good");
                        inv.classList.add("error");
                    } else {
                        if (invoiceReg.test(this.value)) {
                            inv.classList.add("good");
                            inv.classList.remove("error");
                            invReq.classList.add("d-none");
                            invMsg.classList.add("d-none");
                        } else {
                            inv.classList.remove("good");
                            inv.classList.add("error");
                            invReq.classList.add("d-none");
                            invMsg.classList.remove("d-none");
                        }
                    }
                });
            }
        });
        //! Debt Amount Validation
        AllDebts.forEach((debt) => {
            let debtAmount = form.querySelector(
                `input[name="paied"][data-delay-id="${debt.dataset.delayId}"]`
            );
            let debtReq = form.querySelector(
                `p.payReq[data-delay-id="${debt.dataset.delayId}"]`
            );
            let debtMsg = form.querySelector(
                `p.payMsg[data-delay-id="${debt.dataset.delayId}"]`
            );
            if (debtAmount) {
                debt.addEventListener("input", function () {
                    let debtReg = /(?=.{2,5})/;
                    if (this.value.trim() === "") {
                        debtReq.classList.remove("d-none");
                        debtMsg.classList.add("d-none");
                        debt.classList.remove("good");
                        debt.classList.add("error");
                    } else {
                        if (debtReg.test(this.value)) {
                            debt.classList.add("good");
                            debt.classList.remove("error");
                            debtReq.classList.add("d-none");
                            debtMsg.classList.add("d-none");
                        } else {
                            debt.classList.remove("good");
                            debt.classList.add("error");
                            debtReq.classList.add("d-none");
                            debtMsg.classList.remove("d-none");
                        }
                    }
                });
            }
        });
        //! Validation For Submit Button
        const AllDelaySubmit = form.querySelectorAll("[data-DelaysForm-id]");
        if (AllDelaySubmit) {
            AllDelaySubmit.forEach((delay) => {
                delay.addEventListener("click", function (event) {
                    event.preventDefault();
                    if (validateForm(form)) {
                        form.submit();
                    }
                });
            });
        }
    });
}
//! Pay Old Payment Validation
const OldPaymentForm = document.querySelectorAll("[data-paymentForm-id]");
if (OldPaymentForm) {
    const paymentInvs = document.querySelectorAll("[data-inv-id]");
    const paymentAmount = document.querySelectorAll("[data-pay-id]");
    OldPaymentForm.forEach((payment) => {
        //! Invoices Number Validation
        paymentInvs.forEach((inv) => {
            let payInput = payment.querySelector(`input[name="invoice_no"][data-inv-id="${inv.dataset.invId}"]`);
            let payReq = payment.querySelector(`p.paymentInvReq[data-inv-id="${inv.dataset.invId}"]`);
            let payMsg = payment.querySelector(`p.paymentInvMsg[data-inv-id="${inv.dataset.invId}"]`);
            if (payInput) {
                inv.addEventListener("input", function () {
                    let invoiceReg = /^\d{5}$/;
                    if (this.value.trim() === "") {
                        payReq.classList.remove("d-none");
                        payMsg.classList.add("d-none");
                        inv.classList.remove("good");
                        inv.classList.add("error");
                    } else {
                        if (invoiceReg.test(this.value)) {
                            inv.classList.add("good");
                            inv.classList.remove("error");
                            payReq.classList.add("d-none");
                            payMsg.classList.add("d-none");
                        } else {
                            inv.classList.remove("good");
                            inv.classList.add("error");
                            payReq.classList.add("d-none");
                            payMsg.classList.remove("d-none");
                        }
                    }
                })
            }
        });
        //! Payment Amount Validation
        paymentAmount.forEach((pay) => {
            let amountInput = payment.querySelector(`input[name="olddelay"][data-pay-id="${pay.dataset.payId}"]`);
            let amountReq = payment.querySelector(`p.paymentAmountReq[data-pay-id="${pay.dataset.payId}"]`);
            let amountMsg = payment.querySelector(`p.paymentAmountMsg[data-pay-id="${pay.dataset.payId}"]`);
            if (amountInput) {
                pay.addEventListener("input", function () {
                    const amountReg = /(?=.{2,5})/;
                    if (this.value.trim() === "") {
                        amountReq.classList.remove("d-none");
                        amountMsg.classList.add("d-none");
                        pay.classList.remove("good");
                        pay.classList.add("error");
                    } else {
                        if (amountReg.test(this.value)) {
                            pay.classList.add("good");
                            pay.classList.remove("error");
                            amountReq.classList.add("d-none");
                            amountMsg.classList.add("d-none");
                        } else {
                            pay.classList.remove("good");
                            pay.classList.add("error");
                            amountReq.classList.add("d-none");
                            amountMsg.classList.remove("d-none");
                        }
                    }
                })
            }
        })
        //! Validation For Submit Button
        const PaymentSubmit = payment.querySelectorAll("[data-PaymentSubmit-id]");
        if (PaymentSubmit) {
            PaymentSubmit.forEach((pay) => {
                pay.addEventListener("click", function (event) {
                    event.preventDefault();
                    if (validateForm(payment)) {
                        payment.submit();
                    }
                });
            });
        }
    });
}
//! Safe Validation
const safeDataForm = document.getElementById("safeForm");
if (safeDataForm) {
    //! Validation For Safe Amount
    const withdrawnAmount = document.getElementById("withdrawn_amount");
    const withdrawReq = document.getElementById("withdrawReq");
    const withdrawMsg = document.getElementById("withdrawMsg");
    withdrawnAmount.addEventListener("input", function () {
        const withdrawReg = /(?=.{2,})/;
        if (this.value.trim() === "") {
            withdrawReq.classList.remove("d-none");
            withdrawMsg.classList.add("d-none");
            withdrawnAmount.classList.remove("good");
            withdrawnAmount.classList.add("error");
        } else {
            if (withdrawReg.test(this.value)) {
                withdrawnAmount.classList.add("good");
                withdrawnAmount.classList.remove("error");
                withdrawReq.classList.add("d-none");
                withdrawMsg.classList.add("d-none");
            } else {
                withdrawnAmount.classList.remove("good");
                withdrawnAmount.classList.add("error");
                withdrawReq.classList.add("d-none");
                withdrawMsg.classList.remove("d-none");
            }
        }
    });
    //! Validation For Safe Image
    const proofImg = document.getElementById("proof_withdraw");
    const ProofimgReq = document.getElementById("withdrawimgReq");
    const ProofimgSize = document.getElementById("withdrawimgSize");
    const ProofimgExt = document.getElementById("withdrawimgExt");
    proofImg.addEventListener("change", function () {
        const img = proofImg.files[0];
        if (img) {
            validateImage(img,ProofimgReq,ProofimgExt,proofImg,ProofimgSize);
        } else {
            proofImg.classList.add("error");
            proofImg.classList.remove("good");
            ProofimgReq.classList.remove("d-none");
            ProofimgSize.classList.add("d-none");
            ProofimgExt.classList.add("d-none");
        }
    })
    //! Validation For Safe Submit Button
    const withdrawFormSubmit = document.getElementById("withdrawSubmit");
    if (withdrawFormSubmit) {
        withdrawFormSubmit.addEventListener("click", function (event) {
            event.preventDefault();
            if (validateForm(safeDataForm)) {
                safeDataForm.submit();
            }
        });
    }
}
//! Bank Validation
const BankForm = document.getElementById("BankForm");
if (BankForm) {
    //! Validation For Bank Amount
    const bankAmount = document.getElementById("withdrawn_bank");
    const bankReq = document.getElementById("bankReq");
    const bankMsg = document.getElementById("bankMsg");
    bankAmount.addEventListener("input", function () {
        const bankReg = /(?=.{2,})/;
        if (this.value.trim() === "") {
            bankReq.classList.remove("d-none");
            bankMsg.classList.add("d-none");
            bankAmount.classList.remove("good");
            bankAmount.classList.add("error");
        } else {
            if (bankReg.test(this.value)) {
                bankAmount.classList.add("good");
                bankAmount.classList.remove("error");
                bankReq.classList.add("d-none");
                bankMsg.classList.add("d-none");
            } else {
                bankAmount.classList.remove("good");
                bankAmount.classList.add("error");
                bankReq.classList.add("d-none");
                bankMsg.classList.remove("d-none");
            }
        }
    })
    //! Validation For Bank Image
    const proofBankImg = document.getElementById("proof_bank");
    const ProofBankimgReq = document.getElementById("bankImgReq");
    const ProofBankimgSize = document.getElementById("bankImgSize");
    const ProofBankimgExt = document.getElementById("bankImgExt");
    proofBankImg.addEventListener("change", function () {
        const img = proofBankImg.files[0];
        if (img) {
            validateImage(img,ProofBankimgReq,ProofBankimgExt,proofBankImg,ProofBankimgSize);
        } else {
            proofBankImg.classList.add("error");
            proofBankImg.classList.remove("good");
            ProofBankimgReq.classList.remove("d-none");
            ProofBankimgSize.classList.add("d-none");
            ProofBankimgExt.classList.add("d-none");
        }
    })
    //! Validation For Bank Submit Button
    const BankSubmit = document.getElementById("BankSubmit");
    if (BankSubmit) {
        BankSubmit.addEventListener("click", function (event) {
            event.preventDefault();
            if (validateForm(BankForm)) {
                BankForm.submit();
            }
        });
    }
}
//! Donation Debt
const DonationDebtForm = document.getElementById("DonationDebtForm");
if (DonationDebtForm) {
    //! Validation For Reason Field
    const delayReason = document.getElementById("delay_reason");
    const reasonReq = document.getElementById("reasonReq");
    delayReason.addEventListener("input", function () {
        let reasonReg = /^[\u0600-\u06FF\s]+$/;
        if (this.value.trim() === "") {
            reasonReq.classList.remove("d-none");
            delayReason.classList.remove("good");
            delayReason.classList.add("error");
        } else {
            if (reasonReg.test(this.value)) {
                delayReason.classList.add("good");
                delayReason.classList.remove("error");
                reasonReq.classList.add("d-none");
            } else {
                delayReason.classList.remove("good");
                delayReason.classList.add("error");
                reasonReq.classList.add("d-none");
            }
        }
    });
    //! Validation For Donation Debt Amount
    const DelayAmount = document.getElementById("delay_amount");
    const DelayAmountReq = document.getElementById("DelayAmountReq");
    const DelayAmountMsg = document.getElementById("DelayAmountMsg");
    DelayAmount.addEventListener("input", function () {
        let DelayAmountReg = /(?=.{2,})/;
        if (this.value.trim() === "") {
            DelayAmountReq.classList.remove("d-none");
            DelayAmountMsg.classList.add("d-none");
            DelayAmount.classList.remove("good");
            DelayAmount.classList.add("error");
        } else {
            if (DelayAmountReg.test(this.value)) {
                DelayAmount.classList.add("good");
                DelayAmount.classList.remove("error");
                DelayAmountReq.classList.add("d-none");
                DelayAmountMsg.classList.add("d-none");
            } else {
                DelayAmount.classList.remove("good");
                DelayAmount.classList.add("error");
                DelayAmountReq.classList.add("d-none");
                DelayAmountMsg.classList.remove("d-none");
            }
        }
    });
    //! Validation For Donation Debt Submit
    const DonationDebtSubmit = document.getElementById("DonationDebtSubmit");
    if (DonationDebtSubmit) {
        DonationDebtSubmit.addEventListener("click", function (event) {
            event.preventDefault();
            if (validateForm(DonationDebtForm)) {
                DonationDebtForm.submit();
            }
        });
    }
}
//! Validation For Paying Donation Debt
const PayDonationDebtForm = document.querySelectorAll("[data-paydonation-id]");
if (PayDonationDebtForm) {
    const donationAmount = document.querySelectorAll("[data-donationamount-id]");
    const donationInvoice = document.querySelectorAll("[data-donationinv-id]");
    PayDonationDebtForm.forEach((paydon) => {
        //! Donation Invoice
        donationInvoice.forEach((inv) => {
            let invInput = paydon.querySelector(`input[name="invoice_no"][data-donationinv-id="${inv.dataset.donationinvId}"]`);
            let donationInvReq = paydon.querySelector(`p.donationInvReq[data-donationinv-id="${inv.dataset.donationinvId}"]`);
            let donationInvMsg = paydon.querySelector(`p.donationInvMsg[data-donationinv-id="${inv.dataset.donationinvId}"]`);
            if (invInput) {
                inv.addEventListener("input", function () {
                    let invoiceReg = /^\d{5}$/;
                    if (this.value.trim() === "") {
                        donationInvReq.classList.remove("d-none");
                        donationInvMsg.classList.add("d-none");
                        inv.classList.remove("good");
                        inv.classList.add("error");
                    } else {
                        if (invoiceReg.test(this.value)) {
                            inv.classList.add("good");
                            inv.classList.remove("error");
                            donationInvReq.classList.add("d-none");
                            donationInvMsg.classList.add("d-none");
                        } else {
                            inv.classList.remove("good");
                            inv.classList.add("error");
                            donationInvReq.classList.add("d-none");
                            donationInvMsg.classList.remove("d-none");
                        }
                    }
                });
            }
        });
        //! Donation Amount
        donationAmount.forEach((amount) => {
            let amountInput = paydon.querySelector(`input[name="amount"][data-donationamount-id="${amount.dataset.donationamountId}"]`);
            let donationAmountReq = paydon.querySelector(`p.donationAmountReq[data-donationamount-id="${amount.dataset.donationamountId}"]`);
            let donationAmountMsg = paydon.querySelector(`p.donationAmountMsg[data-donationamount-id="${amount.dataset.donationamountId}"]`);
            if (amountInput) {
                amount.addEventListener("input", function () {
                    let amountReg = /(?=.{2,5})/;
                    if (this.value.trim() === "") {
                        donationAmountReq.classList.remove("d-none");
                        donationAmountMsg.classList.add("d-none");
                        amount.classList.remove("good");
                        amount.classList.add("error");
                    } else {
                        if (amountReg.test(this.value)) {
                            amount.classList.add("good");
                            amount.classList.remove("error");
                            donationAmountReq.classList.add("d-none");
                            donationAmountMsg.classList.add("d-none");
                        } else {
                            amount.classList.remove("good");
                            amount.classList.add("error");
                            donationAmountReq.classList.add("d-none");
                            donationAmountMsg.classList.remove("d-none");
                        }
                    }
                });
            }
        });
        //! Validation For Donation Debt Payment Submit Form
        const DonationDebtSubmit = paydon.querySelectorAll("[data-donationSubmitForm-id]");
        if(DonationDebtSubmit){
            DonationDebtSubmit.forEach((debt)=>{
                debt.addEventListener("click",function(event){
                    event.preventDefault();
                    if (validateForm(paydon)) {
                        paydon.submit();
                    }
                })
            })
        }
    })
}
//! Validation For Paying Old Donation
const PayOldDonationDebt = document.querySelectorAll("[data-payolddonation-id]");
if (PayOldDonationDebt) {
    const oldDonationInvoice = document.querySelectorAll("[data-oldinv-id]");
    const oldDonationAmount = document.querySelectorAll("[data-oldamount-id]");
    PayOldDonationDebt.forEach((olddon) => {
        //! Old Donation Invoice
        oldDonationInvoice.forEach((inv) => {
            let invInput = olddon.querySelector(`input[name="invoice_no"][data-oldinv-id="${inv.dataset.oldinvId}"]`);
            let oldDonationInvReq = olddon.querySelector(`p.oldDonationInvReq[data-oldinv-id="${inv.dataset.oldinvId}"]`);
            let oldDonationInvMsg = olddon.querySelector(`p.oldDonationInvMsg[data-oldinv-id="${inv.dataset.oldinvId}"]`);
            if (invInput) {
                inv.addEventListener("input", function () {
                    let invoiceReg = /^\d{5}$/;
                    if (this.value.trim() === "") {
                        oldDonationInvReq.classList.remove("d-none");
                        oldDonationInvMsg.classList.add("d-none");
                        inv.classList.remove("good");
                        inv.classList.add("error");
                    } else {
                        if (invoiceReg.test(this.value)) {
                            inv.classList.add("good");
                            inv.classList.remove("error");
                            oldDonationInvReq.classList.add("d-none");
                            oldDonationInvMsg.classList.add("d-none");
                        } else {
                            inv.classList.remove("good");
                            inv.classList.add("error");
                            oldDonationInvReq.classList.add("d-none");
                            oldDonationInvMsg.classList.remove("d-none");
                        }
                    }
                })
            }
        });
        //! Old Donation Amount
        oldDonationAmount.forEach((oldamount) => {
            let oldAmountInput = olddon.querySelector(`input[name="amount"][data-oldamount-id="${oldamount.dataset.oldamountId}"]`);
            let oldDonationAmountReq = olddon.querySelector(`p.oldDonationAmountReq[data-oldamount-id="${oldamount.dataset.oldamountId}"]`);
            let oldDonationAmountMsg = olddon.querySelector(`p.oldDonationAmountMsg[data-oldamount-id="${oldamount.dataset.oldamountId}"]`);
            if (oldAmountInput) {
                oldamount.addEventListener("input", function () {
                    let amountReg = /(?=.{2,5})/;
                    if (this.value.trim() === "") {
                        oldDonationAmountReq.classList.remove("d-none");
                        oldDonationAmountMsg.classList.add("d-none");
                        oldamount.classList.remove("good");
                        oldamount.classList.add("error");
                    } else {
                        if (amountReg.test(this.value)) {
                            oldamount.classList.add("good");
                            oldamount.classList.remove("error");
                            oldDonationAmountReq.classList.add("d-none");
                            oldDonationAmountMsg.classList.add("d-none");
                        } else {
                            oldamount.classList.remove("good");
                            oldamount.classList.add("error");
                            oldDonationAmountReq.classList.add("d-none");
                            oldDonationAmountMsg.classList.remove("d-none");
                        }
                    }
                });
            }
        });
        //! Old Donation Submit Button
        const OldDonationSubmit = olddon.querySelectorAll("[data-oldDonationSubmit-id]");
        if (OldDonationSubmit) {
            OldDonationSubmit.forEach((oldsubmit) => {
                oldsubmit.addEventListener("click", function (event) {
                    event.preventDefault();
                    if (validateForm(olddon)) {
                        olddon.submit();
                    }
                })
            })
        }
    })
}
//! craftSelect
let SelectedOption = document.getElementById("craftSelect");
if (SelectedOption) {
    SelectedOption.addEventListener("change", function () {
        let selectedOption = this.options[this.selectedIndex].value;
        let otherCraftInput = document.getElementsByName("other_craft")[0];
        otherCraftInput.value = "";
        otherCraftInput.disabled = selectedOption !== "أخرى";
    });
}
//! category News Select
const categorySelect = document.getElementById("categorySelect");
const inputsDiv = document.getElementById("inputs");
const img = document.getElementById("img");
const thumbs = document.getElementById("thumbs");
if (categorySelect) {
    categorySelect.addEventListener("change", function () {
        if (this.value === "عزاء") {
            inputsDiv.classList.add("hidden");
            img.classList.add("hidden");
            thumbs.classList.add("hidden");
            inputsDiv.querySelectorAll("input").forEach(function (input) {
                input.disabled = true;
            });
        } else {
            inputsDiv.classList.remove("hidden");
            img.classList.remove("hidden");
            thumbs.classList.remove("hidden");
            inputsDiv.querySelectorAll("input").forEach(function (input) {
                input.disabled = false;
            });
        }
    });
}
//! updateCraft Worker Page
let selectElements = document.querySelectorAll("[data-worker-id]");
if (selectElements) {
    selectElements.forEach((selectElement) => {
        let otherCraftInput = document.querySelector(`input[name="other_craft"][data-worker-id="${selectElement.dataset.workerId}"]`);
        function handleUpdateCraft() {
            let selectedOption = selectElement.options[selectElement.selectedIndex].value;
            if (selectedOption === "أخرى") {
                otherCraftInput.disabled = false;
            } else {
                otherCraftInput.value = "";
                otherCraftInput.disabled = true;
                otherCraftInput.removeAttribute("value");
            }
        }
        selectElement.addEventListener("change", function () {
            handleUpdateCraft();
        });
    });
}
//! Insert Donation
let allDonations = document.querySelectorAll("[data-donation-id]");
if (allDonations) {
    allDonations.forEach((donation) => {
        let otherDonation = document.querySelector(`input[name="other_donation"][data-donation-id="${donation.dataset.donationId}"]`);
        let categoryType = document.querySelector(`select[name="donation_category"][data-donation-id="${donation.dataset.donationId}"]`);
        let Amount = document.querySelector(`input[name="amount"][data-donation-id="${donation.dataset.donationId}"]`);
        function donationUpdate() {
            let donationValue = donation.options[donation.selectedIndex].value;
            if (donationValue == "أخرى") {
                Amount.classList.remove("d-none");
                Amount.disabled = false;
                categoryType.classList.add("d-none");
                categoryType.disabled = true;
                otherDonation.classList.remove("d-none");
                otherDonation.disabled = false;
            } else if (donationValue == "مادي") {
                Amount.classList.remove("d-none");
                Amount.disabled = false;
                categoryType.classList.remove("d-none");
                categoryType.disabled = false;
                otherDonation.classList.add("d-none");
                otherDonation.disabled = true;
            }
        }
        donation.addEventListener("change", function () {
            donationUpdate();
        });
    });
}
//! Outer Donators Period
let donationSelect = document.getElementById("donator_type");
if (donationSelect) {
    donationSelect.addEventListener("change", function () {
        let donationValue = this.options[this.selectedIndex].value;
        let donationName = document.getElementById("duration");
        if (donationValue == "منتظم") {
            donationName.classList.remove("d-none");
        } else {
            donationName.value = "";
            donationName.classList.add("d-none");
        }
    });
}
//! miscellaneous Insertion
let category = document.getElementById("category");
if (category) {
    category.addEventListener("change", function () {
        let selectedOption = this.options[this.selectedIndex].value;
        let otherCategory = document.getElementById("other_category");
        if (selectedOption === "أخرى") {
            otherCategory.classList.remove("d-none");
        } else {
            otherCategory.value = "";
            otherCategory.classList.add("d-none");
        }
    });
}
//! Update miscellaneous
let selectMiscs = document.querySelectorAll("[data-misc-id]");
if (selectMiscs) {
    selectMiscs.forEach((misc) => {
        let otherCategory = document.querySelector(
            `input[name="other_category"][data-misc-id="${misc.dataset.miscId}"]`
        );
        function handleUpdateCraft() {
            let selectedOption = misc.options[misc.selectedIndex].value;
            if (selectedOption === "أخرى") {
                otherCategory.disabled = false;
            } else {
                otherCategory.value = "";
                otherCategory.disabled = true;
                otherCategory.removeAttribute("value");
            }
        }
        misc.addEventListener("change", function () {
            handleUpdateCraft();
        });
    });
}
//! Pay Subscription or Old Delays
let paymentTypes = document.querySelectorAll("[data-payment-id]");
if (paymentTypes) {
    paymentTypes.forEach((payment) => {
        let subscriptionCost = document.querySelector(`input[name="subscription_cost"][data-payment-id="${payment.dataset.paymentId}"]`);
        let subscriptionPeriod = document.querySelector(`input[name="period"][data-payment-id="${payment.dataset.paymentId}"]`);
        let delayAmount = document.querySelector(`input[name="delays"][data-payment-id="${payment.dataset.paymentId}"]`);
        let delayPeriod = document.querySelector(`input[name="delays_period"][data-payment-id="${payment.dataset.paymentId}"]`);
        function handleDelay() {
            let selectedPayment = payment.options[payment.selectedIndex].value;
            if (selectedPayment === "إشتراك") {
                subscriptionCost.classList.remove("d-none");
                subscriptionPeriod.classList.remove("d-none");
                delayAmount.classList.add("d-none");
                delayPeriod.classList.add("d-none");
            } else if (selectedPayment === "متأخرات") {
                subscriptionCost.classList.add("d-none");
                subscriptionPeriod.classList.add("d-none");
                delayAmount.classList.remove("d-none");
                delayPeriod.classList.remove("d-none");
            } else {
                subscriptionCost.classList.add("d-none");
                subscriptionPeriod.classList.add("d-none");
                delayAmount.classList.add("d-none");
                delayPeriod.classList.add("d-none");
            }
        }
        payment.addEventListener("change", function () {
            handleDelay();
        });
    });
}
//!
//!
//!
//!
//!
//!
//!
//!
//!
//!






