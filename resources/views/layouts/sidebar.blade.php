<header class="header-nav">
    <div class="logo">Kambing Super Pak Nova</div>

    <nav>
        <ul class="nav-links" id="mainNav">
    <li><a href="/dashboard" onclick="moveActive(this)">Dashboard</a></li>
    <li><a href="/katalog" onclick="moveActive(this)">Monitoring Kambing</a></li>
    <li><a href="#" onclick="moveActive(this)">Penggemukan</a></li>
    <li id="adminMenu" style="display:none;"><a href="/admin/medis" onclick="moveActive(this)">Medical Schedule</a></li>
    <div class="nav-indicator"></div>
</ul>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const user = localStorage.getItem('user');
        if(user) {
            const userObj = JSON.parse(user);
            if(userObj.role === 'Admin') {
                document.getElementById('adminMenu').style.display = '';
            }
        }
    });
</script>
    </nav>

    <div class="header-right">
        <button class="search-btn">search</button>
    </div>
</header>