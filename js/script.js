function $(id) {
  return document.getElementById(id);
}

let map;
let markers = [];

function initMap() {
  map = new google.maps.Map($("map"), {
    center: { lat: 47.242249900590146, lng: 6.016386412890068 },
    zoom: 8,
  });
}

document.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    research();
  }
});

function research() {
  resetMarkers();
  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText === "") {
        $("result-counter").innerText = "Aucun résultat";
      } else {
        var dataTemp = this.responseText.split("}");
        var data = parseJSON(dataTemp);
        data.forEach((e) => {
          markers.push(createMarker(e));
        });
        $("result-counter").innerText = data.length + " résultat";
        if (data.length > 1) $("result-counter").innerText += "s";
        map.setCenter({
          lat: parseFloat(data[0].latitude),
          lng: parseFloat(data[0].longitude),
        });
        map.setZoom(13);
      }
    }
  };
  request.open(
    "GET",
    "treatment.php?selection=" +
      $("selection").value +
      "&research=" +
      $("research").value,
    true
  );
  request.send();
}

function createMarker(params) {
  var infos;
  if (params.hasOwnProperty("courriel")) {
    infos = `
    <p>Adresse : ${params.adresse},${params.commune}</p>
    <p>Téléphone : ${params.telephone}</p>
    <p>E-mail : ${params.courriel}</p>
    <p>Site web : ${params.siteinternet}</p>
    `;
  } else {
    infos = `
    <p>Propriétaire : ${params.proprietaire}</p>
    <p>Siècle : ${params.siecle}</p>
    <p>Auteur : ${params.auteur}</p>
    `;
  }
  var contentStr = `
  <div id="content">
    <div id="siteNotice">
    </div>
    <h2 id="firstHeading" class="firstHeading">${params.nom}</h2>
    <div id="bodyContent">
      <p>
          ${params.descriptiflong}
      </p>
      <hr>
      <div>
          ${infos}
      </div>
    </div>
  </div>
  `;

  var infoWin = new google.maps.InfoWindow({
    content: contentStr,
  });
  var marker = new google.maps.Marker({
    map,
    animation: google.maps.Animation.DROP,
    position: {
      lat: parseFloat(params.latitude),
      lng: parseFloat(params.longitude),
    },
    title: params.nom,
    icon: "icons/" + params.categorie + ".png",
  });
  marker.addListener("click", () => {
    infoWin.open(map, marker);
  });
}

function parseJSON(params) {
  var res = [];
  params.forEach((e) => {
    if (e !== "") {
      e = e + "}";
      res.push(JSON.parse(e));
    }
  });
  return res;
}

function resetMarkers() {
  markers.forEach((e) => {
    e.setMap(null);
    e = null;
  });
}

function clearMap() {
  $("research").value = "";
  resetMarkers();
  $("result-counter").innerText = "";
}
