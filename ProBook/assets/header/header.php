<div class="top-navbar">
    <ul>
        <li class="navbar-logo">
            <a href="/view/profile"><h1 class="header-logo"><span class="pro-logo">Pro</span>-Book</h1></a>
        </li>
        <li class="top-right-navbar logout">
            <a href="/controller/logout.php" class="logout-button">
                <img src="/assets/images/power.png">
            </a>
        </li>
        <li class="top-right-navbar user-greeting">
            <div><a href="/view/profile">Hi, <?php echo $username ?></a></div>
        </li>
    </ul>
</div>
<div class="bottom-navbar">
    <ul>
        <li
            <?php if ($activeTab === 'browse') {
                echo 'class="active"';
            }?>
        ><a href="/view/search-books">Browse</a></li>
        <li
            <?php if ($activeTab === 'history') {
                echo 'class="active"';
            }?>
        ><a href="/view/history">History</a></li>
        <li <?php if ($activeTab === 'profile') {
                echo 'class="active"';
            }?>
        ><a href="/view/profile">Profile</a></li>
    </ul>
</div>