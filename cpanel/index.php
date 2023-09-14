<?php
require_once './auth.php';
require '../lib/Statstics.php';
require_once 'template/header.tpl';
require_once 'template/navbar.tpl';
?>
<div id="content" class="row">
    <h2>Statstics</h2>
    <table class="table-bordered table-striped">
        <tr>
            <th>no of editors</th>
            <td><?php echo Statstics::getNoOfRecords("editor") ?></td>
        </tr>
        <tr>
            <th>no of categories</th>
            <td><?php echo Statstics::getNoOfRecords("category") ?></td>
        </tr>
        <tr>
            <th>no of news</th>
            <td><?php echo Statstics::getNoOfRecords("news") ?></td>
        </tr>
    </table>
</div>
<?php
require_once 'template/footer.tpl';
?>

