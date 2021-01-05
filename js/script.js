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
})

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
        $("result-counter").innerText = data.length+" résultat";
        if (data.length > 1)
        $("result-counter").innerText +='s';
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
  return new google.maps.Marker({
    map,
    animation: google.maps.Animation.DROP,
    position: {
      lat: parseFloat(params.latitude),
      lng: parseFloat(params.longitude),
    },
    title: params.nom,
  })
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
  $("result-counter").innerText = "Aucun résultat";
}