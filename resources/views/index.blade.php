<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レストラン検索</title>
    <link rel="stylesheet" href="{{ asset('../resources/css/index.css') }}">
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #ffbd59;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .capsuleBoxHead {
            width: 290px;
            height: 30px;
            border: 2px solid #000000;
            background-color: #ff914d;
            border-radius: 10px;
        }
        .capsuleBoxBody {
            width: 280px;
            height: 300px;
            border: 2px solid #000000;
            background-color: #ffffff;
            border-radius: 10px;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .capsuleBoxBody span {
            width: 220px;
            height: 250px;
            background-color: #eeeeee;
            padding: 5px;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .gacha-machine {
            position: relative;
            width: 300px;
            height: 200px;
            background-color: #ff914d;
            border: 2px solid #000000;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            overflow: hidden;
        }
        .handle-container {
            position: absolute;
            top: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .handle {
            width: 100px;
            height: 20px;
            background-color: #eeeeee;
            border: 2px solid #000000;
            border-radius: 5px;
            position: absolute;
            cursor: pointer;
            transition: transform 1s ease-in-out;
            transform: rotate(0deg);
            z-index: 2;
        }
        .handle::after {
            content: "";
            width: 100px;
            height: 100px;
            background-image: url("handle.png");
            background-size: cover;
            background-repeat: no-repeat;
            position: absolute;
            top: -40px;
            left: -40px;
            transform: rotate(-90deg);
            z-index: 1;
        }
        .circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #333;
            position: absolute;
            background-color: #ffffff;
        }
        .exit {
            width: 80px;
            height: 150px;
            background-color: #1d1d1d;
            position: absolute;
            top: calc(100% - 75px);
            left: calc(50% - 40px);
            z-index: 2;
            border-radius: 10px;
        }
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 189, 89, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('index') }}" style="text-decoration: none; color: inherit;">
            <h1>グルポンッ!!</h1>
        </a>
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
    <div class="form-area">
        <form action="{{ route('keyword_search') }}" method="get" class="search-area">
            @csrf
            <div class="input-keyword">
                <label for="keyword">お探しのキーワード</label>
                <input type="text" id="keyword" name="keyword" placeholder="例）ラーメン" required>
            </div>                
            <button type="submit" class="search-button" id="keyword-button" onclick="searchLoading()">キーワード検索</button>
        </form>
        <hr>
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
            <button type="submit" class="search-button" id="search-button" onclick="searchLoading()">近くを検索</button>
        </form>
        <hr>
        <form action="{{ route('pickUp') }}" method="get" id="pickUp-form" class="search-area">
            @csrf
            <button type="submit" class="search-button" id="pickUp-button" onclick="searchLoading()">ピックアップ</button>
        </form>
    </div>
    <footer>
        &copy; 2024 Delicious Restaurants | Powered by <a href="http://webservice.recruit.co.jp/">ホットペッパーグルメ Webサービス</a>
    </footer>

    <div class="loading-overlay" id="loading-overlay">
        <div class="gatyaContainer">
            <div class="capsuleBoxHead"></div>
            <div class="capsuleBoxBody"><span></span></div>
            <div class="gacha-machine">
                <div class="handle-container">
                    <div class="handle"></div>
                    <div class="circle"></div>
                </div>
                <div class="exit"></div>
            </div>
        </div>
    </div>

    <script src="{{ asset('../resources/js/toggleAccount.js') }}"></script>
    <script src="{{ asset('../resources/js/indexTippy.js') }}"></script>
    <script src="{{ asset('../resources/js/geolocation.js') }}"></script>
    <script src="{{ asset('../resources/js/searchLoading.js') }}"></script>
</body>
</html>
