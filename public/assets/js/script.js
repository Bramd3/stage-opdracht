document.getElementById("searchButton").addEventListener("click", function() {
    const query = document.getElementById("searchInput").value.trim();

    if (!query) {
        alert("Vul een bedrijfsnaam of KVK-nummer in!");
        return;
    }

    // API request uitvoeren
    fetch(`/api/search?query=${encodeURIComponent(query)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Fout bij ophalen: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            displayResults(data);
        })
        .catch(error => {
            console.error("Error:", error);
            document.getElementById("results").innerHTML = `<p class="text-danger">Er is een fout opgetreden. Probeer het later opnieuw.</p>`;
        });
});

function displayResults(data) {
    const resultsDiv = document.getElementById("results");
    resultsDiv.innerHTML = "";

    if (!data || !data.items || data.items.length === 0) {
        resultsDiv.innerHTML = "<p class='text-warning'>Geen resultaten gevonden.</p>";
        return;
    }

    let list = "<ul class='list-group'>";
    data.items.forEach(company => {
        list += `
            <li class="list-group-item">
                <strong>${company.handelsnaam}</strong> (KVK: ${company.kvkNummer})
                <button class="btn btn-sm btn-info float-end" onclick="getDetails('${company.kvkNummer}')">Meer info</button>
            </li>
        `;
    });
    list += "</ul>";
    resultsDiv.innerHTML = list;
}

function getDetails(kvkNummer) {
    fetch(`/api/company/${kvkNummer}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Fout bij ophalen: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (!data.bedrijfsnaam) {
                alert("Geen details beschikbaar voor dit bedrijf.");
                return;
            }
            alert(`Bedrijfsnaam: ${data.bedrijfsnaam}\nAdres: ${data.adres}`);
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Er is een fout opgetreden bij het ophalen van bedrijfsgegevens.");
        });
}
