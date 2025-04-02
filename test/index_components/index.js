
function contactWhatsApp(number) {
    window.open(`https://wa.me/${number}`, '_blank');
}
function contactDev(){
    window.open(`https://wa.me/8452441202`, '_blank');
}
        function confirmDelete(event, id) {
            event.preventDefault(); // Prevent the default link behavior

            if (confirm("Are you sure you want to delete this ride?")) {
                fetch("delete.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `id=${id}`,
                })
                .then(response => {
                    if (response.ok) {
                        return response.json(); // Parse the JSON response
                    } else {
                        throw new Error("Failed to delete ride.");
                    }
                })
                .then(data => {
                    alert(data.message); // Show success message
                    location.reload(); // Reload the page to reflect changes
                })
                .catch(error => {
                    alert(error.message); // Show error message
                });
            }
        }

        function contactWhatsApp(number) {
            window.open(`https://wa.me/${number}`, '_blank');
        }

        document.addEventListener("DOMContentLoaded", function () {
            const searchBar = document.getElementById("search-bar");
            const filterSelect = document.getElementById("filter-select");
            const lookingRidesDiv = document.getElementById("looking-rides");
            const offeringRidesDiv = document.getElementById("offering-rides");
            const noResultsMessage = document.getElementById("no-results");

            // Load stored values
            // filterSelect.value = localStorage.getItem("rideFilter") || "";
            // searchBar.value = localStorage.getItem("searchQuery") || "";
            filterSelect.value = "";
            searchBar.value = "";
            function updateRideDisplay() {
                lookingRidesDiv.style.display = filterSelect.value === "offering" ? "none" : "block";
                offeringRidesDiv.style.display = filterSelect.value === "looking" ? "none" : "block";
            }

            filterSelect.addEventListener("change", function () {
                localStorage.setItem("rideFilter", this.value);
                updateRideDisplay();
                applyFilters();
            });

            searchBar.addEventListener("input", function () {
                const searchValue = this.value.trim();
                if (searchValue.length >= 2 || searchValue.length === 0) {
                    localStorage.setItem("searchQuery", searchValue);
                    applyFilters();
                }
            });

            function applyFilters() {
                const search = searchBar.value.toLowerCase();
                const filter = filterSelect.value.toLowerCase();
                let hasResults = false;

                document.querySelectorAll(".card").forEach(card => {
                    const details = card.textContent.toLowerCase();
                    let cardTitleElement =  card.querySelector(".card-title");
                    let type = '';
                    if(cardTitleElement){
                            type = cardTitleElement.textContent.toLowerCase();
                    }
                    

                    const matchesFilter = filter === "" || type.includes(filter);
                    const matchesSearch = search.length < 2 || details.includes(search);

                    if (matchesFilter && matchesSearch) {
                        card.closest(".col-md-4").style.display = "block";
                        hasResults = true;
                    } else {
                        card.closest(".col-md-4").style.display = "none";
                    }
                });

                noResultsMessage.style.display = (search.length >= 2 && !hasResults) ? "block" : "none";
            }

            updateRideDisplay();
            applyFilters();
        });