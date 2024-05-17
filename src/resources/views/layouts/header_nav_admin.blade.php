<div class="header__inner">
    <h1 class="header__heading">Atte -管理者menu-</h1>
    <nav>
        <ul class="header-nav">
            <li class="header-nav__item">
            <a class="header-nav__link" href="{{ route('admin_index') }}">ホーム</a>
            </li>
            <li class="header-nav__item">
                <form class="form" action="{{ route('admin_logout') }}" method="get">
                <button class="header-nav__button">ログアウト</button>
            </form>
            </li>
        </ul>
    </nav>
</div>
