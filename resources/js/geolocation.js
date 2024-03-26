function addLocationToForm(formElement) {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            var hiddenLatitude = document.createElement("input");
            hiddenLatitude.type = "hidden";
            hiddenLatitude.name = "latitude";
            hiddenLatitude.value = latitude;
            formElement.appendChild(hiddenLatitude);

            var hiddenLongitude = document.createElement("input");
            hiddenLongitude.type = "hidden";
            hiddenLongitude.name = "longitude";
            hiddenLongitude.value = longitude;
            formElement.appendChild(hiddenLongitude);

            formElement.submit();
        }, function(error) {
            console.error("位置情報の取得に失敗しました:", error.message);
            alert("位置情報の取得に失敗しました。");
        });
    } else {
        console.error("このブラウザは位置情報の取得に対応していません。");
        alert("このブラウザは位置情報の取得に対応していません。");
    }
}

document.getElementById('search-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var formElement = event.target;
    addLocationToForm(formElement);
});

document.getElementById('pickUp-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var formElement = event.target;
    addLocationToForm(formElement);
});