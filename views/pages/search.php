<h3><div style="float:left;-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-o-transform: rotate(45deg); transform: rotate(45 deg); margin-right:5px;">&#9906;</div> SEARCH</h3>
<form class="loginform" action="" method="post" style="width:60%;">
    <fieldset>
        <input name="query" id="query" type="text" value="" placeholder="Search" style="width:100%; margin-bottom:20px;"/>
        <div style="margin-bottom:10px;">
            <input name="filter" type="radio" value="user" id="users" checked />User&nbsp;&nbsp;
            <input name="filter" type="radio" value="song" id="songs"/>Song&nbsp;&nbsp;
            <input name="filter" type="radio" value="album" id="albums"/>Album<br />
        </div>
        <input name="submit" type="submit" value="submit"/>
    </fieldset>
</form>
<?php echo isset($results) ? $results: ""; ?>