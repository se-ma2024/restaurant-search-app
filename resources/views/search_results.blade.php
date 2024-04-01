<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
    <link rel="stylesheet" href="{{ asset('../resources/css/search_restaurant.css') }}">
</head>
<body>
    <header>
        <a href="{{ route('index') }}" style="text-decoration: none; color: inherit;">
            <h1>グルポンッ!!</h1>
        </a>
        <form action="{{ route('keyword_search') }}" method="get" class="search-area">
            @csrf
            <div class="input-keyword">
                <input type="text" id="keyword" name="keyword" value="{{ $keyword }}" required>
            </div>                
            <button type="submit" class="search-button">キーワード検索</button>
        </form>
        <form action="{{ route('search') }}" method="get" id="search-form" class="search-area">
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
    <div class="main-body">
        <div class="search-info">
            <h2>「{{ ($keyword) ? $keyword : "近く" }}」で見つかったお店</h2>
            <h2>{{ $count }}件</h2>
        </div>
        <div class="search-results">
            @if($restaurants)
                @foreach($restaurants as $restaurant)
                    <article class="restaurant-card">
                        <a href="{{ route('restaurant_detail', ['restaurantId' => $restaurant['id'], 'keyword' => $keyword, 'range' => $range]) }}" style="text-decoration: none; color: inherit;">
                            <img src="{{ $restaurant['photo']['pc']['l'] }}" alt="{{ $restaurant['name'] }} Image">
                            <h2>{{ $restaurant['name'] }}</h2>
                            <div class="detail-area">
                                <p class="access">{{ $restaurant['mobile_access'] }}</p>
                                <div class="detail-group">
                                    <p class="detail-title"><strong>ジャンル</strong></p>
                                    <p class="detail">{{ ($restaurant['genre']['name']) ? $restaurant['genre']['name'] : 'データがありません' }}</p>
                                </div>
                                <div class="detail-group">
                                    <p class="detail-title"><strong>予算</strong></p>
                                    <p class="detail">{{ ($restaurant['budget']['name']) ? $restaurant['budget']['name'] : 'データがありません' }}</p>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            @elseif($error)
                <p>{{ $error }}</p>
            @else
                <p>お店が見つかりませんでした。</p>
            @endif
        </div>
        <div class="pagination">
            {{ $restaurants->withPath('/restaurant-search-app/public/search')->withQueryString()->links() }}
        </div>
    </div>
    <footer>
        &copy; 2024 Delicious Restaurants | Powered by <a href="http://webservice.recruit.co.jp/">ホットペッパーグルメ Webサービス</a>
    </footer>
    <script>
        const initialRange = "{{ $range }}";
        window.onload = function() {
            const rangeSelect = document.getElementById('range');
            rangeSelect.value = initialRange;
        };
    </script>
    <script src="{{ asset('../resources/js/toggleAccount.js') }}"></script>
    <script src="{{ asset('../resources/js/geolocationHeader.js') }}"></script>
</body>
</html>
