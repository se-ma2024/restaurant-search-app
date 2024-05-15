<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レストラン詳細</title>
    <link rel="stylesheet" href="{{ asset('../resources/css/restaurant_detail.css') }}">
</head>
<body>
    <header>
        <a href="{{ route('index') }}" style="text-decoration: none; color: inherit;">
            <h1>グルポンッ!!</h1>
        </a>
        <form action="{{ route('keyword_search') }}" method="get" id="search-form" class="search-area">
            @csrf
            <div class="input-keyword">
                <input type="text" id="keyword" name="keyword" value="{{ $keyword }}" required>
            </div>                
            <button type="submit" class="search-button">キーワード検索</button>
        </form>
        <form action="{{ route('search') }}" method="get" class="search-area">
            @csrf
            <select id="range" name="range">
                <option value="1">300m</option>
                <option value="2">500m</option>
                <option value="3">1000m</option>
                <option value="4">2000m</option>
                <option value="5">3000m</option>
            </select>
            <input type="text" id="keyword" name="keyword" value="{{ $keyword }}">
            <button type="submit" class="search-button">近くを検索</button>
        </form>
        <div class="account">
        @if(Auth::check())
            <div class="dropdown">
                <a class="user" onclick="toggleDropdown('userDropdown')"> {{ Auth::user()->name }} さん</a>
                <ul id="userDropdown" class="dropdown-menu" style="display: none;">
                    <li><a href="{{ route('saved_list') }}">保存済み</a></li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    </li>
                </ul>
            </div>
            @else
                <a class="account-link" href="{{ route('register') }}">会員登録</a>
                <a class="account-link" href="{{ route('login') }}">ログイン</a>
            @endif
        </div>
    </header>
    <div class="main-content">
        <div class="restaurant-content">
            <div class="info">
                <div class="info-top">
                    @if(Auth::check())
                        @php
                            $user_id = Auth::user()->id;
                            $isFavorite = \App\Models\Favorite::where('user_id', $user_id)->where('restaurant_id', $restaurant['id'])->exists();
                        @endphp
                        <form action="{{ route('saved', ['restaurantId' => $restaurant['id'], 'user_id' => Auth::user()->id]) }}" method="POST">
                            @csrf
                            @if($isFavorite)
                                <button type="submit" class="btn-favorite btn-favorite-active">
                                    <span class="star">&#9733;</span>
                                </button>
                            @else
                                <button type="submit" class="btn-favorite">
                                    <span class="star">&#9734;</span>
                                </button>
                            @endif
                        </form>
                    @endif
                    <div class="restaurant_name">
                        <p class="name_kana">{{ $restaurant['name_kana'] }}</p>
                        <h1 class="name">{{ $restaurant['name'] }}</h1>
                    </div>
                </div>
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
        <button id="toggle-button">詳細を表示/非表示</button>
        <div class="toggle-content" id="toggle-content">
            <hr>
            <p class="detail-title"><strong>最大宴会収容人数</strong></p><p class="detail">{{ ($restaurant['party_capacity']) ? $restaurant['party_capacity'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>WiFi 有無</strong></p><p class="detail">{{ ($restaurant['wifi']) ? $restaurant['wifi'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>ウェディング･二次会</strong></p><p class="detail">{{ ($restaurant['wedding']) ? $restaurant['wedding'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>飲み放題</strong></p><p class="detail">{{ ($restaurant['free_drink']) ? $restaurant['free_drink'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>食べ放題</strong></p><p class="detail">{{ ($restaurant['free_food']) ? $restaurant['free_food'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>個室</strong></p><p class="detail">{{ ($restaurant['private_room']) ? $restaurant['private_room'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>掘りごたつ</strong></p><p class="detail">{{ ($restaurant['horigotatsu']) ? $restaurant['horigotatsu'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>座敷</strong></p><p class="detail">{{ ($restaurant['tatami']) ? $restaurant['tatami'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>カード可</strong></p><p class="detail">{{ ($restaurant['card']) ? $restaurant['card'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>禁煙席</strong></p><p class="detail">{{ ($restaurant['non_smoking']) ? $restaurant['non_smoking'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>貸切可</strong></p><p class="detail">{{ ($restaurant['charter']) ? $restaurant['charter'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>駐車場</strong></p><p class="detail">{{ ($restaurant['parking']) ? $restaurant['parking'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>バリアフリー</strong></p><p class="detail">{{ ($restaurant['barrier_free']) ? $restaurant['barrier_free'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>その他設備</strong></p><p class="detail">{{ ($restaurant['other_memo']) ? $restaurant['other_memo'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>ライブ・ショー</strong></p><p class="detail">{{ ($restaurant['show']) ? $restaurant['show'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>カラオケ</strong></p><p class="detail">{{ ($restaurant['karaoke']) ? $restaurant['karaoke'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>バンド演奏可</strong></p><p class="detail">{{ ($restaurant['band']) ? $restaurant['band'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>TV・プロジェクター</strong></p><p class="detail">{{ ($restaurant['tv']) ? $restaurant['tv'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>英語メニュー</strong></p><p class="detail">{{ ($restaurant['english']) ? $restaurant['english'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>ペット可</strong></p><p class="detail">{{ ($restaurant['pet']) ? $restaurant['pet'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>お子様連れ</strong></p><p class="detail">{{ ($restaurant['child']) ? $restaurant['child'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>ランチ</strong></p><p class="detail">{{ ($restaurant['lunch']) ? $restaurant['lunch'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>23時以降も営業</strong></p><p class="detail">{{ ($restaurant['lunch']) ? $restaurant['lunch'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>備考</strong></p><p class="detail">{{ ($restaurant['midnight']) ? $restaurant['midnight'] : 'データがありません' }}</p>
            <p class="detail-title"><strong>TV・プロジェクター</strong></p><p class="detail">{{ ($restaurant['shop_detail_memo']) ? $restaurant['shop_detail_memo'] : 'データがありません' }}</p>
            <a href="#" class="page-link">上へ移動</a>
        </div>
        <h2 class="map-title">地図</h2>
        <hr>
        <div id="map"></div>
    </div>
    <button class="back-button" onclick="goBack()">戻る</button>
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
        function goBack() {
            var currentDirectory = window.location.pathname;
            console.log(currentDirectory);
            if (currentDirectory.startsWith('/restaurant-search-app/public/saved/')) {
                window.location.href = '/restaurant-search-app/public/';
            } else {
                window.history.back();
            }
        }
    </script>
    <script src="{{ asset('../resources/js/toggleAccount.js') }}"></script>
    <script src="{{ asset('../resources/js/toggleDetail.js') }}"></script>
    <script src="{{ asset('../resources/js/rangeDelivery.js') }}"></script>
    <script src="{{ asset('../resources/js/geolocationHeader.js') }}"></script>
    <script async src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemap.api_key') }}&callback=initMap"></script>
</body>
</html>
