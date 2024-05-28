<header>
    <div>
        <img id="header" src="images/jobvacancy.jpg" />
        <img id="logo" src="images/logo.png" />
        <nav id="navbar">
            <a class="<?php echo $currentPage === 'home' ? 'active' : ''; ?>" href="index.php">Home</a>
            <a class="<?php echo $currentPage === 'post' ? 'active' : ''; ?>" href="postjobform.php">Post
                Job</a>
            <a class="<?php echo $currentPage === 'search' ? 'active' : ''; ?>" href="searchjobform.php">Search
                Job</a>
            <a class="<?php echo $currentPage === 'about' ? 'active' : ''; ?>" href="about.php">About</a>
        </nav>
        <h1>Job Vacancy Posting System</h1>
    </div>
</header>