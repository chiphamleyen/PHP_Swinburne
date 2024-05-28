<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Chi Pham" />
    <title>Web Programming - Lab08</title>
</head>

<body>
    <h1>Add VIP Member</h1>
    <form action="member_add.php" method="POST">
        <fieldset>
            <legend>Enter your details to sign vip member</legend>
            <p>
                <label for="fname">First Name: </label>
                <input type="text" id="fname" name="fname">
            </p>
            <p>
                <label for="lname">Last Name: </label>
                <input type="text" id="lname" name="lname">
            </p>
            <p>
                <label for="gender">Gender: </label>
                <input type="text" id="gender" name="gender">
            </p>
            <p>
                <label for="email">Email: </label>
                <input type="text" id="email" name="email">
            </p>
            <p>
                <label for="phone">Phone: </label>
                <input type="text" id="phone" name="phone">
            </p>
            <button type="submit" name="submit">Submit</button>
            <button type="reset">Reset</button>
        </fieldset>

        <p><a href="vip_member.php">Home</a></p>
        <p><a href="member_display.php">Display All Members Page</a></p>
        <p><a href="member_search.php">Search Member Page</a></p>
    </form>
</body>

</html>