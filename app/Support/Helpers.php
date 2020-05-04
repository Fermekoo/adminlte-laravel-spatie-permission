<?php

use Ramsey\Uuid\Uuid;

function uuid()
{
    return str_replace("-","",Uuid::uuid4()->toString());
}