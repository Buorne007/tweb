<?php include("top.html"); ?>
<form action="matches-submit.php" method="get">
    <fieldset>
        <legend>Returning User:</legend>
        <ul>
            <li class="item">
                <label class="left"><strong>Name:</strong></label> <input type="text" name="name" maxlength="16">
            </li>
            <li>
                <input type="submit" value="View My Matches">
            </li>
        </ul>
    </fieldset>
</form>

<?php include("bottom.html"); ?>
