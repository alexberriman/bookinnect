<?php
$colors = ['d01f3c'];

$edges = '';
foreach ($book->getConnections() as $character)
{
    foreach ($character['connections'] as $id => $connection) 
    {
        $edges .= '
        {
            "id": "e' . $character['name'] . $id . '",
            "source": "n' . $character['name'] . '",
            "target": "n' . $connection['name'] . '"
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
            "x": <?php print $character['spring_coordinates'][0] ?>,
            "y": <?php print $character['spring_coordinates'][1] ?>,
            <?php print isset($colors[$id - 1]) ? '"color": "#' . $colors[$id - 1] . '",' . "\n" : '' ?>
            "size" : <?php print (int) $character['occurrences'] ?>
        }<?php if ($id < sizeof($book->getConnections())): ?>,<?php endif; ?>

    <?php endforeach; ?>
  ],
  "edges": [
    <?php print $edges; ?>
  ]
}
