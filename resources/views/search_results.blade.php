<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
    <style>
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination li {
            display: inline-block;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('index') }}" style="text-decoration: none; color: inherit;">
            <h1>レストラン検索</h1>
        </a>
        <form action="{{ route('search') }}" method="get" id="search-form">
            @csrf
            <label for="range">検索範囲：</label>
            <select id="range" name="range">
                <option value="1">300m</option>
                <option value="2">500m</option>
                <option value="3">1000m</option>
                <option value="4">2000m</option>
                <option value="5">3000m</option>
            </select>
            <label for="keyword">お探しのキーワード：</label>
            <input type="text" id="keyword" name="keyword" value="{{ $keyword }}" required>
            <button type="submit">検索</button>
        </form>
    </header>
    <h1>「{{ $keyword }}」で見つかったお店</h1>
    <p>{{ $count }}件のお店が見つかりました</p>

    @if($restaurants)
    <ul>
        @foreach($restaurants as $restaurant)
            <li>
                <a href="{{ route('restaurant_detail', ['id' => $restaurant['id'], 'keyword' => $keyword, 'range' => $range]) }}" style="text-decoration: none; color: inherit;">
                    <article class="restaurant-card">
                        <img src="{{ $restaurant['photo']['pc']['l'] }}" alt="{{ $restaurant['name'] }} Image">
                        <div class="info">
                            <h2>{{ $restaurant['name'] }}</h2>
                            <p class="access">{{ $restaurant['mobile_access'] }}</p>
                            <p class="genre"><strong>ジャンル:</strong> {{ $restaurant['genre']['name'] }}</p>
                            <p class="budget"><strong>予算:</strong> {{ $restaurant['budget']['name'] }}</p>
                        </div>
                    </article>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="pagination">
        {{ $restaurants->withPath('/restaurant-search-app/public/search')->withQueryString()->links() }}
    </div>
    @elseif($error)
        <p>{{ $error }}</p>
    @else
        <p>お店が見つかりませんでした。</p>
    @endif

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
    <script src="{{ asset('../resources/js/geolocation.js') }}"></script>
</body>
</html>
