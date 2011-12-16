<html>
<head>
    <title><?php echo $title; ?></title>
</head>
<body>
    <h1><?php echo $body; ?></h1>
    <p>
        This is a test template page.
    </p>
    <ul>
<?php
    foreach ($list as $value):
        echo '        <li>' . $value . '</li>' . PHP_EOL;
    endforeach;
?>
    </ul>
    <p>
        This is another list.
    </p>
    <ul>
<?php
    foreach ($pages as $page):
        echo '        <li><a href="' . $page->page_url . '">' . $page->page_title . '</a></li>' . PHP_EOL;
    endforeach;
?>
    </ul>
</body>
</html>