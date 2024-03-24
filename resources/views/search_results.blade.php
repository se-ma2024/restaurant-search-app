<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
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
        .main-body {
            margin: 80px 20px 80px 20px;
        }
        .search-info {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .search-info h2 {
            font: inherit;
            margin: 16px 16px 0px 16px;
        }
        .search-results {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px;
        }
        .restaurant-card {
            position: relative;
            width: 250px;
            height: 350px;
            margin: 0 15px 30px 15px;
            padding: 20px;
            border-radius: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeInUp 0.5s ease;
            transition: transform 0.3s ease;
        }
        .restaurant-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background-color: #fff;
            border-radius: 30px 30px 0 0;
            z-index: -1;
        }
        .restaurant-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background-color: #ffde59;
            border-radius: 0 0 30px 30px;
            z-index: -1;
        }
        .restaurant-card:hover {
            transform: scale(1.05);
        }
        .restaurant-card img {
            width: 100%;
            height: 50%;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
            position: relative;
        }
        .restaurant-card h2 {
            margin-top: 10px;
            font-size: 18px;
            text-align: center;
        }
        .restaurant-card p {
            margin: 5px 0;
            font-size: 14px;
            text-align: center;
        }
        .pagination {
            
            text-align: center;
            font-size: 18px;
        }
        .pagination li {
            display: inline-block;
            margin-right: 5px;
        }
        .pagination a {
            display: inline-block;
            padding: 8px 12px;
            background-color: #ff914d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }
        .pagination a:hover {
            background-color: #ff7243;
        }
        footer {
            text-align: center;
            background-color: #ffde59;
            padding: 10px 0;
            position: absolute;
            width: 100%;
            bottom: 0;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
        }
        footer a {
            color: #007bff;
            text-decoration: none;
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
    <div class="main-body">
        <div class="search-info">
            <h2>「{{ $keyword }}」で見つかったお店</h2>
            <h2>{{ $count }}件</h2>
        </div>
        <div class="search-results">
            @if($restaurants)
                @foreach($restaurants as $restaurant)
                    <article class="restaurant-card">
                        <a href="{{ route('restaurant_detail', ['id' => $restaurant['id'], 'keyword' => $keyword, 'range' => $range]) }}" style="text-decoration: none; color: inherit;">
                            <img src="{{ $restaurant['photo']['pc']['l'] }}" alt="{{ $restaurant['name'] }} Image">
                            <h2>{{ $restaurant['name'] }}</h2>
                            <p class="access">{{ $restaurant['mobile_access'] }}</p>
                            <p class="genre"><strong>ジャンル:</strong> {{ ($restaurant['genre']['name']) ? $restaurant['genre']['name'] : 'データがありません' }}</p>
                            <p class="budget"><strong>予算:</strong> {{ ($restaurant['budget']['name']) ? $restaurant['budget']['name'] : 'データがありません' }}</p>
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
    <script src="{{ asset('../resources/js/geolocation.js') }}"></script>
</body>
</html>
