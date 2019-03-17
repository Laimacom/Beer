<?php
function form(){?>
    <form method="post">
        <label>Latitude</label><input type="text" name="lat1" required><br>
        <label>Longitude</label><input type="text" name="lon1" required><br>
        <br>
        <input type="submit" value="Find breweries">
    </form>
    <?php
}