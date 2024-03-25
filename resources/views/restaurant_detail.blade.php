<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レストラン詳細</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffbd59;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        header {
            padding: 20px 0;
            background-color: #ffde59;
            position: absolute;
            position: fixed;
            width: 100%;
            top: 0;
            display: flex;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }
        header h1 {
            margin: 0;
            margin-left: 100px;
            width: 400px;
        }
        .search-area {
            display: flex;
            justify-content: center;
            height: 100%;
            width: 100%;
            right: 0px;
        }
        #range,
        #keyword {
            border: none;
            width: 300px;
            height: 40px;
            padding: 0px 8px;
            font-size: 16px;
            border-radius: 10px;
        }
        .search-button {
            width: 150px;
            height: 40px;
            border: none;
            background-color: #ff914d;
            color: #fff;
            cursor: pointer;
            font-size: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .search-button:hover {
            background-color: #ff7243;
        }
        .main-content {
            width: 80%;
            padding: 20px;
            margin-top: 100px;
            background-color: #ffde59;
            border-radius: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            
        }
        .restaurant-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }
        .info {
            flex: 2;
            padding-right: 20px;
        }
        .name_kana {
            margin-bottom: 0;
            margin-left: 10px;
        }
        .name {
            margin-top: 0;
            margin-left: 10px;
            margin-bottom: 10px;
        }
        hr {
            border: none;
            border-top: 2px solid #ffbd59;
        }
        .detail-title {
            margin-left: 20px;
            margin-bottom: 5px;

        }
        .detail {
            margin-top: 5px;
            margin-left: 30px;
        }
        img {
            flex: 1;
            border-radius: 10px;
            border: 5px solid #FFF;
            box-shadow: 20px 20px 0 #ffbd59;
            margin-right: 20px;
        }
        .back-button {
            position: fixed;
            bottom: 20px;
            left: 40px;
            padding: 10px 20px;
            border: none;
            background-color: #ff914d;
            color: #fff;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #ff7243;
        }
        #map {
            width: calc(100% - 40px); /* マップの幅を調整 */
            height: 400px;
            margin: 20px; /* 上下左右に余白を追加 */
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .map-title {
            margin-left: 20px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<header>
        <a href="{{ route('index') }}" style="text-decoration: none; color: inherit;">
            <h1>レストラン検索</h1>
        </a>
        <form action="{{ route('search') }}" method="get" id="search-form" class="search-area">
            @csrf
            <select id="range" name="range">
                <option value="1">300m</option>
                <option value="2">500m</option>
                <option value="3">1000m</option>
                <option value="4">2000m</option>
                <option value="5">3000m</option>
            </select>
            <input type="text" id="keyword" name="keyword" value="{{ $keyword }}" required>
            <button type="submit" class="search-button">検索</button>
        </form>
    </header>
    <div class="main-content">
        <div class="restaurant-content">
            <div class="info">
                <p class="name_kana">{{ $restaurant['name_kana'] }}</p>
                <h1 class="name">{{ $restaurant['name'] }}</h1>
                <hr>
                <p class="detail-title"><strong>営業時間</strong></p><p class="detail">{{ ($restaurant['open']) ? $restaurant['open'] : 'データがありません' }}</p>
                <p class="detail-title"><strong>定休日</strong></p><p class="detail">{{ ($restaurant['close']) ? $restaurant['close'] : 'データがありません'}}</p>
                <p class="detail-title"><strong>キャッチコピー</strong></p><p class="detail">{{ ($restaurant['catch']) ? $restaurant['catch'] : 'データがありません' }}</p>
                <p class="detail-title"><strong>ジャンル</strong></p><p class="detail">{{ ($restaurant['genre']['name']) ? $restaurant['genre']['name'] : 'データがありません' }}</p>
                <p class="detail-title"><strong>予算</strong></p><p class="detail">{{ ($restaurant['budget']['average']) ? $restaurant['budget']['average'] : 'データがありません' }}</p>
                <p class="detail-title"><strong>アクセス</strong></p><p class="detail">{{ ($restaurant['access']) ? $restaurant['access'] : 'データがありません' }}</p>
                <p class="detail-title"><strong>住所</strong></p><p class="detail">{{ ($restaurant['address']) ? $restaurant['address'] : 'データがありません' }}</p>
            </div>
            <img src="{{ $restaurant['photo']['pc']['l'] }}" alt="{{ $restaurant['name'] }} Image">
        </div>
        <h2 class="map-title">地図</h2>
        <hr>
        <div id="map"></div>
    </div>
    <button class="back-button" onclick="window.history.back()">戻る</button>
    <script>
        const initialRange = "{{ $range }}";
        window.onload = function() {
            const rangeSelect = document.getElementById('range');
            rangeSelect.value = initialRange;
        };


        async function initMap() {
            const mapElement = document.getElementById("map");
            const restaurantLat = {{ $restaurant['lat'] }};
            const restaurantLng = {{ $restaurant['lng'] }};
            const position = { lat: restaurantLat, lng: restaurantLng };
            const { Map, InfoWindow } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
            const map = new Map(mapElement, {
                zoom: 15,
                center: position,
                mapId: "6cdf255d1c2c205d",
            });
            const markerTitle = "{{ $restaurant['name'] }}"
            const marker = new AdvancedMarkerElement({
                map: map,
                position: position,
                title: markerTitle
            });
            const infoWindow = new InfoWindow();
            marker.addListener("click", () => {
                infoWindow.setContent(marker.getTitle());
                infoWindow.open(map, marker);
            });
        }
    </script>
    <script src="{{ asset('../resources/js/geolocation.js') }}"></script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemap.api_key') }}&callback=initMap">
    </script>
</body>
</html>
