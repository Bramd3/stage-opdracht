document.getElementById("searchButton").addEventListener("click", function () {
  const query = document.getElementById("searchInput").value;

  if (!query) {
    alert("Vul een bedrijfsnaam of KVK-nummer in!");
    return;
  }
});

function displayResults(data) {
  const resultsDiv = document.getElementById("results");
  resultsDiv.innerHTML = "";

  if (data.length === 0) {
    resultsDiv.innerHTML = "<p>Geen resultaten gevonden.</p>";
    return;
  }

  data.forEach((company) => {
    const companyDiv = document.createElement("div");
    companyDiv.innerHTML = `
            <h3>${company.bedrijfsnaam} (${company.kvknummer})</h3>
            <p>Adres: ${company.adres}</p>
            <button onclick="getDetails('${company.kvknummer}')">Meer info</button>
        `;
    resultsDiv.appendChild(companyDiv);
  });
}

function getDetails(kvknummer) {
  fetch(`http://localhost/api/company/${kvknummer}`)
    .then((response) => response.json())
    .then((data) => {
      alert(
        `Bedrijfsnaam: ${data.bedrijfsnaam}\nAdres: ${data.adres}\nActiviteiten: ${data.activiteiten}`
      );
    })
    .catch((error) => console.error("Error:", error));
}
