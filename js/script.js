console.log("File loaded");

function $(id) {
  return document.getElementById(id);
}

let map;

  function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 47.242249900590146 , lng: 6.016386412890068 },
      zoom: 8,
    });
}

document.getElementById("search")
    .onsubmit= function (event) {
      event.preventDefault();
      console.log("Button triggered");
      var request = new XMLHttpRequest();
      console.log(request.readyState);
      request.onreadystatechange = function () {
        
        if (this.readyState == 4 && this.status == 200) {

          alert(this.responseText)
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
