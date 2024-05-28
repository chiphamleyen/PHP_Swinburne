<header>
    <div>
        <img id="header" src="images/friendsystem.jpg" />
        <img id="logo" src="images/logo.png" />
        <nav id="navbar">
            <a class="<?php echo $currentPage === 'home' ? 'active' : ''; ?>" href="index.php">Home</a>

            <a class="<?php echo $currentPage === 'list' ? 'active' : ''; ?>" href="friendlist.php">Friend List</a>
            <a class="<?php echo $currentPage === 'add' ? 'active' : ''; ?>" href="friendadd.php">Add Friend</a>
            <a class="<?php echo $currentPage === 'about' ? 'active' : ''; ?>" href="about.php">About</a>
        </nav>
        <h1>My Friend System</h1>
        <?php
        if (!isset($_SESSION['login_status']) || $_SESSION['login_status'] === false) {
            // User who logged out or has not logged in
            echo '<a href="login.php" class="horder">Login</a>';
        } else {
            // User who already loggin
            echo '<a href="logout.php" class="horder">Logout</a>';
        }
        ?>
    </div>
</header>