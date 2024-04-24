<div class="header__inner">
    <h1 class="header__heading">Atte</h1>
    <nav>
        <ul class="header-nav">
            <li class="header-nav__item">
            <a class="header-nav__link" href="{{ route('index') }}">ホーム</a>
            </li>
            <li class="header-nav__item">
                <a class="header-nav__link" href="{{ route('attendance') }}">日付一覧</a>
                </li>
            <li class="header-nav__item">
                <form class="form" action="{{ route('logout') }}" method="post">
                    @csrf
                <button class="header-nav__button">ログアウト</button>
            </form>
            </li>
        </ul>
    </nav>
</div>
