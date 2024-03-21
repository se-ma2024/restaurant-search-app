<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レストラン検索</title>
</head>
<body>
    <header>
        <a href="{{ route('index') }}" style="text-decoration: none; color: inherit;">
            <h1>レストラン検索</h1>
        </a>
    </header>
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
        <input type="text" id="keyword" name="keyword" placeholder="例）ラーメン" required>
        <button type="submit">検索</button>
    </form>
    <footer>
        &copy; 2024 Delicious Restaurants | Powered by <a href="http://webservice.recruit.co.jp/">ホットペッパーグルメ Webサービス</a>
    </footer>
    <script src="{{ asset('../resources/js/geolocation.js') }}"></script>
</body>
</html>
