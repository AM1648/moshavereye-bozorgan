<?php

$msg_lines = file("messages.txt");
$people_contents = file_get_contents("people.json");
$people_obj = json_decode($people_contents, TRUE);

$question = $_POST["question"];
$is_valid = (mb_substr($question, 0, 3) == "آیا") && (mb_substr($question, -1) == "?" || mb_substr($question, -1) == "؟");

$en_name = $_POST["person"] ? $_POST["person"] : array_rand($people_obj);
$fa_name = $people_obj[$en_name];

$hash_val = intval(hash("crc32b", $en_name . $question), 16);
$msg = $msg_lines[$hash_val % sizeof($msg_lines)];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label"><?php if ($question) echo "پرسش: " ?></span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo (!$question ? "سؤال خود را بپرس!" : (!$is_valid ? "سؤال درستی پرسیده نشده" : $msg)) ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                foreach ($people_obj as $en_name_item => $fa_name_item) {
                    if ($en_name == $en_name_item) {
                        echo "<option value=\"$en_name_item\" selected=\"selected\">$fa_name_item</option>";
                    } else {
                        echo "<option value=\"$en_name_item\">$fa_name_item</option>";
                    }
                }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>
