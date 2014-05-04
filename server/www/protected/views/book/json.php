<?php
$colors = ['d01f3c'];

// Map out the selected characters connections (if viewing graph on a particular character)
if (isset($char['connections']) && sizeof($char['connections']) > 0)
{
    $connection_strings = [$char['name']];
    foreach ($char['connections'] as $connection)
    {
        $connection_strings[] = $connection['name'];
    }
    $char['connections_str'] = $connection_strings;
    $nodeAmount = sizeof($char['connections_str']);
}
else
{
    $nodeAmount = sizeof($book->getConnections());
}

// Calculate edges
$edges = '';
foreach ($book->getConnections() as $character)
{
    // If no character passed through, or character passed through matches current char
    if (! isset($char['name']))
    {
        foreach ($character['connections'] as $id => $connection) 
        {
            if (! isset($connection_strings) || in_array($connection['name'], $connection_strings))
            {
                $edges .= '
                {
                    "id": "e' . $character['name'] . $id . '",
                    "source": "n' . $character['name'] . '",
                    "target": "n' . $connection['name'] . '"
                },';
            }
        }
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
    <?php $id = 0; foreach ($book->getConnections() as $character): ?>
    <?php if (! isset($char['connections_str']) || in_array($character['name'], $char['connections_str'])): $id++; ?>{
            "id": "n<?php print CHtml::encode($character['name']) ?>",
            "label": "<?php print CHtml::encode($character['name']) ?>",
            "x": <?php print $character['spring_coordinates'][0] ?>,
            "y": <?php print $character['spring_coordinates'][1] ?>,
            <?php print isset($colors[$id - 1]) ? '"color": "#' . $colors[$id - 1] . '",' . "\n" : '' ?>"size" : <?php print (int) $character['occurrences'] . "\n" ?>
        }<?php if ($id < $nodeAmount): ?>,<?php endif; ?><?php endif; ?>

    <?php endforeach; ?>
  ],
  "edges": [
    <?php print $edges; ?>
  ]
}
