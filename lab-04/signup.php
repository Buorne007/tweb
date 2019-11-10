<?php include("top.html"); ?>

<form action="signup-submit.php" method="post">
    <fieldset>
        <legend>New User Signup:</legend>
        <ul>
            <li class="item">
                <label class="left"><strong>Name:</strong></label> <input type="text" name="name" size="16" maxlength="16">
            </li>
            <li class="item">
                <label class="left"><strong>Gender:</strong></label>
                <input type="radio" name="gender" value="M">Male
                <input type="radio" name="gender" value="F" checked="checked">Female
            </li>
            <li class="item">
                <label class="left"><strong>Age:</strong></label> <input type="text" name="age" size="6" maxlength="2">
            </li>
            <li class="item">
                <label class="left"><strong>Personality type:</strong></label>
                <input type="text" name="personality" size="6" maxlength="4"> (<a href="http://www.humanmetrics.com/cgi-win/JTypes2.asp">Don't know your type?</a>)
            </li>
            <li class="item">
                <label class="left"><strong>Favorite OS:</strong></label>
                <select name="os">
                    <option value="Linux" selected="selected">Linux</option>
                    <option value="Windows">Windows</option>
                    <option value="Mac OS X">Mac OS X</option>
                </select>
            </li>
            <li class="item">
                <label class="left"><strong>Seeking age:</strong></label>
                <input type="text" name="min" size="6" maxlength="2" placeholder="min"> to
                <input type="text" name="max" size="6" maxlength="2" placeholder="max">
            </li>
            <li class="item">
                <input type="submit" value="Sign Up">
            </li>
        </ul>
     </fieldset>
</form>

<?php include("bottom.html"); ?>