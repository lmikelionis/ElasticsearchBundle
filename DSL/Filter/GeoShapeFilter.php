<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Filter;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Elasticsearch geo-shape filter.
 */
class GeoShapeFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var array
     */
    private $fields = [];

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'geo_shape';
    }

    /**
     * Add geo-shape provided filter.
     *
     * @param string $field       Field name.
     * @param string $type        Shape type.
     * @param array  $coordinates Shape coordinates.
     * @param array  $parameters  Additional parameters.
     */
    public function addShape($field, $type, array $coordinates, array $parameters = [])
    {
        $filter = array_merge(
            $parameters,
            [
                'type' => $type,
                'coordinates' => $coordinates,
            ]
        );

        $this->fields[$field]['shape'] = $filter;
    }

    /**
     * Add geo-shape pre-indexed filter.
     *
     * @param string $field      Field name.
     * @param string $id         The ID of the document that containing the pre-indexed shape.
     * @param string $type       Name of the index where the pre-indexed shape is.
     * @param string $index      Index type where the pre-indexed shape is.
     * @param string $path       The field specified as path containing the pre-indexed shape.
     * @param array  $parameters Additional parameters.
     */
    public function addPreIndexedShape($field, $id, $type, $index, $path, array $parameters = [])
    {
        $filter = array_merge(
            $parameters,
            [
                'id' => $id,
                'type' => $type,
                'index' => $index,
                'path' => $path,
            ]
        );

        $this->fields[$field]['indexed_shape'] = $filter;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = $this->processArray($this->fields);

        return $output;
    }
}
