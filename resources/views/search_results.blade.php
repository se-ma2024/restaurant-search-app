<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
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
                <option value="3" selected>1000m</option>
                <option value="4">2000m</option>
                <option value="5">3000m</option>
            </select>
            <label for="keyword">お探しのキーワード：</label>
            <input type="text" id="keyword" name="keyword" value="{{ $keyword }}" required>
            <button type="submit">検索</button>
        </form>
    </header>
    <h1>「{{ $keyword }}」で見つかったお店</h1>
    <p>{{ count($restaurants) }}件のお店が見つかりました</p>

    @if($restaurants)
    <ul>
        @foreach($restaurants as $restaurant)
            <li>
                <a href="{{ route('restaurant_detail', ['id' => $restaurant['id'], 'keyword' => $keyword]) }}" style="text-decoration: none; color: inherit;">
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
    @elseif($error)
        <p>{{ $error }}</p>
    @else
        <p>お店が見つかりませんでした。</p>
    @endif

    <footer>
        &copy; 2024 Delicious Restaurants | Powered by <a href="http://webservice.recruit.co.jp/">ホットペッパーグルメ Webサービス</a>
    </footer>
</body>
</html>