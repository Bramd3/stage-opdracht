document.getElementById("searchButton").addEventListener("click", function() {
    let query = document.getElementById("searchInput").value.trim();
    if (query === "") {
        alert("Voer een naam of KVK-nummer in.");
        return;
    }

    fetch(`http://localhost:8080/kvk/fetchData?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            console.log("API Response:", data);

            let resultsDiv = document.getElementById("results");
            resultsDiv.innerHTML = "";

            if (data.status === "success" && data.results.length > 0) {
                data.results.forEach(item => {
                    resultsDiv.innerHTML += `
                        <div class="card mt-2 p-3">
                            <h5>${item.naam || "Geen naam beschikbaar"}</h5>
                            <p><strong>KVK-nummer:</strong> ${item.kvkNummer || "Onbekend"}</p>
                        </div>
                    `;
                });
            } else {
                resultsDiv.innerHTML = `<p class="text-danger">Geen resultaten gevonden.</p>`;
            }
        })
        .catch(error => {
            console.error("Fout bij het ophalen van gegevens:", error);
            document.getElementById("results").innerHTML = `<p class="text-danger">Er is een fout opgetreden.</p>`;
        });
});
