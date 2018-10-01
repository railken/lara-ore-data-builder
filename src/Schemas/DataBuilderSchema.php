<?php

namespace Railken\Amethyst\Schemas;

use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class DataBuilderSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            Attributes\TextAttribute::make('name')
                ->setRequired(true)
                ->setUnique(true),
            Attributes\LongTextAttribute::make('description'),
            Attributes\TextAttribute::make('filter'),
            Attributes\ClassNameAttribute::make('class_name', [\Railken\Amethyst\Contracts\DataBuilderContract::class])
                ->setRequired(true),
            Attributes\ObjectAttribute::make('mock_data'),
            Attributes\ObjectAttribute::make('input'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}