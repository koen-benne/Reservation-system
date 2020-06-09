let modals = document.getElementsByClassName("modal");
let infoModal = document.getElementById("infoModal");
let reservationModal = document.getElementById("reservationModal");
let editModal = document.getElementById("editModal");
let close = document.getElementsByClassName("modalClose");
let blockId = document.getElementById("blockId");
let weekId = document.getElementById("weekId");

let fieldSelectors = [
    document.getElementById("fieldOne"),
    document.getElementById("fieldTwo"),
    document.getElementById("fieldThree")
];

function closeModals() {
    for (let i=0; i < modals.length; i++) {
        modals[i].style.display = "none";
    }
}

function openInfoModal() {
    infoModal.style.display = "block";
}

function openReservationModal(freeFields, id, time, day) {
    freeFields = freeFields.split("");


    for (let i=0; i < fieldSelectors.length; i++) {
        if (freeFields[i] === "0") {
            fieldSelectors[i].disabled = true;
            fieldSelectors[i].checked = false;
        } else {
            fieldSelectors[i].disabled = false;
        }
    }

    blockId.value = id;

    reservationModal.style.display = "block";
}

function openEditModal() {
    editModal.style.display = "block";
}

for (let i=0; i < close.length; i++) {
    close[i].addEventListener("click", closeModals);
}

window.addEventListener("click", function(event) {
    if (event.target === infoModal || event.target === reservationModal || event.target === editModal) {
        closeModals();
    }
});