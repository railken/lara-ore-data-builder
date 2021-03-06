<?php

namespace Amethyst\Console\Commands;

use Amethyst\DataBuilders\CommonDataBuilder;
use Amethyst\Managers\DataBuilderManager;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class DataBuilderSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amethyst:data-builder:seed';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dataBuilderManager = new DataBuilderManager();

        $managers = app('amethyst')->getData();

        foreach ($managers as $manager) {
            $dataBuilderRecord = $dataBuilderManager->updateOrCreateOrFail([
                'name' => $manager->getName().' by dates',
            ], [
                'class_name'      => CommonDataBuilder::class,
                'class_arguments' => get_class($manager),
                'description'     => 'Retrieve data between dates',
                'filter'          => 'created_at gte "{{ from|date("Y-m-d 00:00:00") }}" and created_at lte "{{ to|date("Y-m-d 23:59:59") }}"',
                'input'           => Yaml::dump([
                    'from' => [
                        'validation' => 'date',
                        'type'       => 'date',
                    ],
                    'to' => [
                        'validation' => 'date',
                        'type'       => 'date',
                    ],
                ]),
                'mock_data' => Yaml::dump([
                    'from' => '2018-09-01T22:00:00.000Z',
                    'to'   => '2018-09-08T22:00:00.000Z',
                ]),
            ])->getResource();

            $dataBuilderRecord = $dataBuilderManager->updateOrCreateOrFail([
                'name' => $manager->getName().' by id',
            ], [
                'class_name'      => CommonDataBuilder::class,
                'class_arguments' => get_class($manager),
                'description'     => 'Retrieve data by id',
                'filter'          => 'id eq "{{ id }}"',
                'input'           => Yaml::dump([
                    'id' => [
                        'validation' => 'integer',
                        'type'       => 'text',
                    ],
                ]),
                'mock_data' => Yaml::dump([
                    'id' => 1,
                ]),
            ])->getResource();
        }
    }
}
