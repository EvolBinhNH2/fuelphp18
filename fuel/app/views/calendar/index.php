<ul>
    <?php foreach($calList['items'] as $calendar): ?>
        <li><?php echo $calendar['summary']; ?></li>
    <?php endforeach; ?>
</ul>