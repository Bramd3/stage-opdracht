document.getElementById("searchButton").addEventListener("click", function() {
    let query = document.getElementById("searchInput").value.trim(); // Haal de invoer op en verwijder extra spaties
    if (query === "") {
        alert("Voer een naam of KVK-nummer in."); // Waarschuwing als het invoerveld leeg is
        return;
    }

    // API-aanroep met de ingevoerde zoekquery
    fetch(`http://localhost:8080/kvk/fetchData?q=${encodeURIComponent(query)}`)
        .then(response => response.json()) // Converteer de response naar JSON
        .then(data => {
            console.log("API Response:", data); // Debugging: log de API-response

            let resultsDiv = document.getElementById("results");
            resultsDiv.innerHTML = ""; // Wis eerdere zoekresultaten

            // Controleer of er resultaten zijn
            if (data.status === "success" && data.results.length > 0) {
                data.results.forEach(item => {
                    resultsDiv.innerHTML += `
                        <div class="card mt-2 p-3">
                            <h5>${item.naam || "Geen naam beschikbaar"}</h5>
                            <p><strong>KVK-nummer:</strong> ${item.kvkNummer || "Onbekend"}</p>
                        </div>
                    `; // Voeg elk resultaat toe aan de weergave
                });
            } else {
                resultsDiv.innerHTML = `<p class="text-danger">Geen resultaten gevonden.</p>`; // Toon een melding als er geen resultaten zijn
            }
        })
        .catch(error => {
            console.error("Fout bij het ophalen van gegevens:", error); // Foutmelding in de console
            document.getElementById("results").innerHTML = `<p class="text-danger">Er is een fout opgetreden.</p>`; // Toon een foutmelding op de pagina
        });
});
