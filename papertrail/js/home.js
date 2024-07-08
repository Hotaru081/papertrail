$(document).ready(function() {
    // Click event for a particular
    $('.stats-row').click(function() {
        var particular = $(this).find('a').text(); // Get the particular text
        openModal();

        // Load data based on the particular via an AJAX request
        $.ajax({
            type: "POST",
            url: "get_data.php", // Replace with the actual URL for fetching data
            data: { particular: particular },
            success: function(data) {
                // Update the modal content with the data received
                $("#data-container").html(data);
            }
        });
    });
});

// Other functions (openModal, closeModal, etc.) remain the same
