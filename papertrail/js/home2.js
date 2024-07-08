const modal = document.getElementById("modal");
const modalTrigger = document.getElementById("add-button");
const modalClose = document.getElementById("modal-close");

modalTrigger.addEventListener("click", () => {
    modal.style.display = "block";
});

modalClose.addEventListener("click", () => {
    modal.style.display = "none";
});

window.addEventListener("click", (event) => {
    if (event.target === modal) {
modal.style.display = "none";
    }
});

const logoutPopupButton = document.getElementById("logout-popup-button");
const logoutPopup = document.getElementById("logout-popup");
const logoutClose = document.getElementById("logout-close");

logoutPopupButton.addEventListener("click", function () {
    logoutPopup.style.display = "block";
});

logoutClose.addEventListener("click", function () {
    logoutPopup.style.display = "none";
});

window.addEventListener("click", function (event) {
    if (event.target === logoutPopup) {
        logoutPopup.style.display = "none";
    }
});

