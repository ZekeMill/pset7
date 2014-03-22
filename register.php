<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO
        if (empty($_POST["username"]))
        {
            apologize("We still need your name.");
        }
        else if(empty($_POST["password"]))
        {
            apologize("We still need your password.");
        }
        else if($_POST["password"] != $_POST["confirmation"])
        {
            apologize("The passwords don't match.");
        }
        $rows = query("SELECT * FROM users WHERE username = ?", $_POST["username"]);
        if (count($rows) == 1)
        {
            apologize("That username already exists, dude!");
        }
        else
        {
            query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.00)", $_POST["username"], crypt($_POST["password"]));
            if ($query === false)
            {
               apologize("Nice try, moron!");
            }
            else
            {
                $rows = query("SELECT LAST_INSERT_ID() AS id");
                $id = $rows[0]["id"];
                $_SESSION["id"] = $id;
                redirect("/");
            }
        }
    }
    else
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

?>
