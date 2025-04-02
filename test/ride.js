document.addEventListener("DOMContentLoaded", function () {
    // ✅ Flexible Time Handling
    const wheneverCheckbox = document.getElementById("whenever");
    const rideTimeInput = document.getElementById("ride_time");

    wheneverCheckbox.addEventListener("change", function () {
        rideTimeInput.disabled = this.checked;
        if (this.checked) {
            rideTimeInput.value = ""; // Clear the field if unchecked
        }
    });

    if (wheneverCheckbox.checked) {
        rideTimeInput.disabled = true;
    }

    // ✅ Real-time validation for contact & WhatsApp numbers
    const contactInput = document.getElementById("contact");
    const whatsappInput = document.getElementById("whatsapp");
    const contactError = document.getElementById("contact-error");
    const whatsappError = document.getElementById("whatsapp-error");

    function showTemporaryError(errorElement, message) {
        errorElement.textContent = message;
        errorElement.classList.remove("d-none");

        setTimeout(() => {
            errorElement.classList.add("d-none");
        }, 1000); // Hide after 1 second
    }


    
    function validatePhoneInput(input, errorElement, minLen, maxLen, onlyNumbers = false) {
        let value = input.value.trim();
        let originalValue = value;

        if (onlyNumbers) {
            value = value.replace(/\D/g, ""); // Remove non-numeric characters for WhatsApp
        } else {
            value = value.replace(/[^0-9()+\s-]/g, ""); // Remove everything except numbers, (), +, -
        }

        if (originalValue !== value) {
            showTemporaryError(errorElement, "Invalid character removed!");
        }

        input.value = value;

        if (value.length > 0 && (value.length < minLen || value.length > maxLen)) {
            errorElement.classList.remove("d-none");
            input.classList.add("is-invalid");
        } else {
            errorElement.classList.add("d-none");
            input.classList.remove("is-invalid");
        }
    }

    contactInput.addEventListener("input", function () {
        validatePhoneInput(contactInput, contactError, 10, 20);
    });

    whatsappInput.addEventListener("input", function () {
        validatePhoneInput(whatsappInput, whatsappError, 10, 11, true); // WhatsApp should be numbers only
    });

    // ✅ Form validation before submission
    document.querySelector("form").addEventListener("submit", function (event) {
        validatePhoneInput(contactInput, contactError, 10, 20);
        validatePhoneInput(whatsappInput, whatsappError, 10, 11, true);

        if (
            contactInput.classList.contains("is-invalid") ||
            whatsappInput.classList.contains("is-invalid")
        ) {
            event.preventDefault();
            alert("Please enter valid phone numbers before submitting.");
        }
    });
});
