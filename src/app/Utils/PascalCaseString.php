<?php

function toPascalCase (string $rawString): string {
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $rawString))));
}
