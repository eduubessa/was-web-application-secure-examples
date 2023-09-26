<?php

function dd(string|int|float|array $value): void
{
    echo json_encode($value);
    exit(10);
}