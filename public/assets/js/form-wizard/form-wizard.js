var form = document.getElementById("msform");
var fieldsets = form.querySelectorAll("article");
var currentStep = 0;
var numSteps = 5;

for (var i = 1; i < fieldsets.length; i++) {
    fieldsets[i].style.display = "none";
}
function nextStep() {
    document.getElementById("backbtn").disabled = false;
    currentStep++;
    if (currentStep > numSteps) {
        currentStep = 1;
    }
    var stepper = document.getElementById("stepper1");
    var steps = stepper.getElementsByClassName("step");
    Array.from(steps).forEach((step, index) => {
        let stepNum = index + 1;
        let stepLength = steps.length;
        if (stepNum === currentStep && currentStep < stepLength) {
            addClass(step, "editing");
            fieldsets[currentStep].style.display = "flex";
        } else {
            removeClass(step, "editing");
        }
        if (stepNum <= currentStep && currentStep < stepLength) {
            addClass(step, "done");
            addClass(step, "active");
            removeClass(step, "editing");
            fieldsets[currentStep - 1].style.display = "none";
        } else {
            removeClass(step, "done");
        }
        if (currentStep == stepLength - 1) {
            document.getElementById("nextbtn").classList.add("d-none");
            document.getElementById("submitButton").classList.remove("d-none");
            if (
                !document
                    .getElementById("submitButton")
                    .querySelector("button[type=submit]")
            ) {
                //! Create and append the submit button
                let button = document.createElement("button");
                button.classList.add("btn", "btn-primary", "w-100", "text-center");
                button.id = "submitButton";
                button.type = "submit";
                button.textContent = "تأكيد";
                document.getElementById("submitButton").appendChild(button);
            }
        }
    });
}
function backStep() {
    if (currentStep > 0) {
        currentStep--;
        var stepper = document.getElementById("stepper1");
        var steps = stepper.getElementsByClassName("step");
        let stepLength = steps.length;
        let submitButton = document.getElementById("submitButton");
        let backbtn = document.getElementById("backbtn");
        let nextbtn = document.getElementById("nextbtn");
        nextbtn.textContent = "التالي";
        nextbtn.disabled = false;
        if (currentStep < stepLength - 1) {
            backbtn.disabled = false;
            submitButton.classList.add("d-none");
            nextbtn.classList.remove("d-none");
            fieldsets[currentStep + 1].style.display = "none";
            fieldsets[currentStep].style.display = "flex";
            removeClass(steps[currentStep], "done");
            removeClass(steps[currentStep], "active");
            if (currentStep === 0) {
                backbtn.disabled = true;
            }
        } else {
            removeClass(steps[currentStep], "done");
            removeClass(steps[currentStep], "active");
        }
    }
}
function hasClass(elem, className) {
    return new RegExp(" " + className + " ").test(" " + elem.className + " ");
}
function addClass(elem, className) {
    if (!hasClass(elem, className)) {
        elem.className += " " + className;
    }
}
function removeClass(elem, className) {
    var newClass = " " + elem.className.replace(/[\t\r\n]/g, " ") + " ";
    if (hasClass(elem, className)) {
        while (newClass.indexOf(" " + className + " ") >= 0) {
            newClass = newClass.replace(" " + className + " ", " ");
        }
        elem.className = newClass.replace(/^\s+|\s+$/g, "");
    }
}
