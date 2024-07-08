document.addEventListener("DOMContentLoaded", function () {
    var logoutBtn = document.getElementById("logout-btn");
    logoutBtn.addEventListener("click", function () {
        document.getElementById("logout-popup").style.display = "block";
    });

    var logoutClose = document.getElementById("logout-close");
    logoutClose.addEventListener("click", function () {
        document.getElementById("logout-popup").style.display = "none";
    });

    function toggleDropdown(button) {
        // Close all other dropdowns before opening this one
        closeDropdowns();

        // Find the dropdown content associated with this button
        var dropdownContent = button.nextElementSibling;

        // Toggle the display of the dropdown content
        dropdownContent.style.display = (dropdownContent.style.display === 'block') ? 'none' : 'block';
    }

    function closeDropdowns() {
        var dropdowns = document.getElementsByClassName('dropdown-content');
        for (var i = 0; i < dropdowns.length; i++) {
            dropdowns[i].style.display = 'none';
        }
    }
});
