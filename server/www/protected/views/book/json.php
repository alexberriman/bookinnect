<?php
$edges = '';
foreach ($book->getConnections() as $character)
{
    foreach ($character['connections'] as $id => $connection) 
    {
        $edges .= '
        {
            "id": "e' . $character['name'] . $id . '",
            "source": "n' . $character['name'] . '",
            "target": "n' . $connection . '"
        },';
    }
}

// Get rid of final comma
if (strlen($edges) > 0)
{
    $edges = substr($edges, 0, strlen($edges) - 1);
}
?>
{
  "nodes": [
    <?php $id = 0; foreach ($book->getConnections() as $character): $id++; ?>
        {
            "id": "n<?php print CHtml::encode($character['name']) ?>",
            "label": "<?php print CHtml::encode($character['name']) ?>",
            "x": <?php print rand(1,1000) ?>,
            "y": <?php print rand(1,1000) ?>,
            "size" : <?php print (int) $character['occurrences'] ?>
        }<?php if ($id < sizeof($book->getConnections())): ?>,<?php endif; ?>

    <?php endforeach; ?>
  ],
  "edges": [
    <?php print $edges; ?>
  ]
}
