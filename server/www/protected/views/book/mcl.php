---8<------8<------8<------8<------8<---
<?php
foreach ($book->getConnections() as $character)
{
    if (isset($character['connections']))
    {
        foreach ($character['connections'] as $connection)
        {
            printf("%s %s %s\n", str_replace(' ', '/', $character['name']), str_replace(' ', '/', $connection['name']), $connection['strength']);
        }
    }
}
?>
---8<------8<------8<------8<------8<---