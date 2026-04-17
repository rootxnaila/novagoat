<header class="header-nav">
    <div class="logo-wrapper">
        <img src="{{ asset('images/logo kambiang.png') }}" alt="Goat Logo" class="goat-icon">
        <div class="logo-text-stack">
            <span class="logo-main">Peternakan Kambing</span>
            <span class="logo-main">Pak Tarno</span>
        </div>
    </div>

    <nav>
        <ul class="nav-links" id="mainNav">
            <li><a href="#" onclick="moveActive(this)">Dashboard</a></li>
            <li><a href="#" onclick="moveActive(this)">Monitoring Kambing</a></li>
            <li><a href="#" onclick="moveActive(this)">Penggemukan</a></li>
            <li><a href="#" onclick="moveActive(this)">Medical Schedule</a></li>
            <div class="nav-indicator"></div>
        </ul>
    </nav>

    <div class="header-right">
        <div class="search-wrapper" id="searchWrapper">
            <input type="text" class="search-input" placeholder="Cari data kambing..." id="searchInput">
            
            <button class="search-pill" id="searchPill" onclick="toggleSearch()">search</button>
            
            <span class="close-search" onclick="toggleSearch()" id="closeSearch">&times;</span>
        </div>
    </div>
</header>