<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レストラン検索</title>
    <link rel="stylesheet" href="{{ asset('../resources/css/index.css') }}">
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
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
            <button type="submit" class="search-button">キーワード検索</button>
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
            <button type="submit" class="search-button">近くを検索</button>
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
    <script src="{{ asset('../resources/js/toggleAccount.js') }}"></script>
    <script src="{{ asset('../resources/js/pickUpTippy.js') }}"></script>
    <script src="{{ asset('../resources/js/geolocation.js') }}"></script>
</body>
</html>
