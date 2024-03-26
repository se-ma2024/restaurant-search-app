<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レストラン検索</title>
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
            width: 100%;
            top: 0;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            margin: 0;
            margin-left: 100px;
        }
        .form-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 800px;
            height: 400px;
            background-color: #ffde59;
            border-radius: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .search-area {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .input-item {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .input-item label {
            margin-top: 30px;
            margin-bottom: 10px;
        }
        .input-range,
        .input-keyword {
            display: flex;
            flex-direction: column;
            margin: 0 10px;
        }
        #range,
        #keyword {
            border: none;
            width: 300px;
            height: 40px;
            padding: 0px 8px;
            margin-bottom: 10px;
            font-size: 16px;
            border-radius: 10px;
        }
        .search-button {
            width: 300px;
            border: none;
            background-color: #ff914d;
            padding: 10px 20px;
            color: #fff;
            cursor: pointer;
            font-size: 20px;
            border-radius: 10px;
            margin: 30px 0px 20px 0px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .search-button:hover {
            background-color: #ff7243;
        }
        hr {
            width: 90%;
            height: 2px;
            margin: 0;
            background-color: #ffbd59;
            border: none;
        }
        .tippy-box[data-theme='my-custom-theme'] {
            background-color: #fff;
            color: #000;
        }
        .tippy-box[data-theme='my-custom-theme'] .tippy-arrow {
            color: #fff;
        }
        footer {
            text-align: center;
            background-color: #ffde59;
            padding: 10px 0;
            position: absolute;
            width: 100%;
            bottom: 0;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
</head>
<body>
    <header>
        <a href="{{ route('index') }}" style="text-decoration: none; color: inherit;">
            <h1>レストラン検索</h1>
        </a>
    </header>
    <div class="form-area">
        <form action="{{ route('search') }}" method="get" id="search-form" class="search-area">
            @csrf
            <div class="input-item">
                <div class="input-range">
                    <label for="range">検索範囲</label>
                    <select id="range" name="range">
                        <option value="1">300m</option>
                        <option value="2">500m</option>
                        <option value="3" selected>1000m</option>
                        <option value="4">2000m</option>
                        <option value="5">3000m</option>
                    </select>
                </div>
                <div class="input-keyword">
                    <label for="keyword">お探しのキーワード</label>
                    <input type="text" id="keyword" name="keyword" placeholder="例）ラーメン">
                </div>
            </div>
            <button type="submit" class="search-button">検索</button>
        </form>
        <hr>
        <form action="{{ route('pickUp') }}" method="get" id="pickUp-form" class="search-area">
            @csrf
            <button type="submit" class="search-button" id="pickUp-button">ピックアップ</button>
        </form>
    </div>
    <footer>
        &copy; 2024 Delicious Restaurants | Powered by <a href="http://webservice.recruit.co.jp/">ホットペッパーグルメ Webサービス</a>
    </footer>
    <script src="{{ asset('../resources/js/tippy.js') }}"></script>
    <script src="{{ asset('../resources/js/geolocation.js') }}"></script>
</body>
</html>
