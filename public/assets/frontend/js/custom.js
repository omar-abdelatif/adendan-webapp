//! Current Year
// const currentYear = new Date().getFullYear();
// document.getElementById("year").innerHTML = currentYear;
//! Fixed Navbar
window.addEventListener("scroll", () => {
    if (window.scrollY > 150) {
        document.querySelector(".navbar").classList.add("fixed");
    } else {
        document.querySelector(".navbar").classList.remove("fixed");
    }
});
//! Play Music On Page Load
// document.addEventListener("DOMContentLoaded", function () {
//     var audio = document.getElementById("audio-player");
//     function playAudioAfterDelay() {
//         setTimeout(function () {
//             audio.play();
//         }, 3000);
//     }
//     window.addEventListener("scroll", function () {
//         if (window.scrollY > 10) {
//             playAudioAfterDelay();
//         }
//     });
// });
//! Arabic Direction To The News Bar
$(document).ready(function () {
    $("#newsTicker2").breakingNews({
        direction: "rtl",
    });
});
//! Copy To Clipboard
function copyToClipboard() {
    var tempInput = document.createElement("input");
    tempInput.value = window.location.href;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    alert("Copied the URL: " + tempInput.value);
}

