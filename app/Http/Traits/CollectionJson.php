<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait CollectionJson
{
    /**
     * Format response sebagai Collection+JSON untuk collection
     */
    protected function collectionResponse($items, $collectionUrl, $options = [])
    {
        $collection = [
            'version' => '1.0',
            'href' => url($collectionUrl),
        ];

        // Items
        if ($items instanceof Collection || is_array($items)) {
            $collection['items'] = $this->formatItems($items, $collectionUrl);
        }

        // Links (pagination, related resources)
        if (isset($options['links'])) {
            $collection['links'] = $options['links'];
        }

        // Queries (search templates)
        if (isset($options['queries'])) {
            $collection['queries'] = $options['queries'];
        }

        // Template (untuk POST request)
        if (isset($options['template'])) {
            $collection['template'] = $options['template'];
        }

        return response()->json([
            'collection' => $collection
        ], $options['status_code'] ?? 200);
    }

    /**
     * Format response sebagai Collection+JSON untuk single item
     */
    protected function itemResponse($item, $itemUrl, $options = [])
    {
        $collection = [
            'version' => '1.0',
            'href' => url($itemUrl),
            'items' => [$this->formatSingleItem($item, $itemUrl)]
        ];

        // Links
        if (isset($options['links'])) {
            $collection['links'] = $options['links'];
        }

        return response()->json([
            'collection' => $collection
        ], $options['status_code'] ?? 200);
    }

    /**
     * Format items menjadi array Collection+JSON items
     */
    private function formatItems($items, $baseUrl)
    {
        $formatted = [];
        
        foreach ($items as $item) {
            $itemId = $item->id ?? null;
            $itemUrl = $itemId ? "$baseUrl/$itemId" : $baseUrl;
            
            $formatted[] = $this->formatSingleItem($item, $itemUrl);
        }

        return $formatted;
    }

    /**
     * Format single item menjadi Collection+JSON item
     */
    private function formatSingleItem($item, $itemUrl)
    {
        $formatted = [
            'href' => url($itemUrl),
            'data' => []
        ];

        // Convert model/array ke data array
        $attributes = $item instanceof Model ? $item->toArray() : (array) $item;

        foreach ($attributes as $key => $value) {
            // Skip relasi yang sudah di-load (nested objects)
            if (is_array($value) || is_object($value)) {
                continue;
            }

            $formatted['data'][] = [
                'name' => $key,
                'value' => $value,
                'prompt' => $this->generatePrompt($key)
            ];
        }

        // Add links untuk setiap item (self, edit, delete)
        if (isset($attributes['id'])) {
            $formatted['links'] = [
                [
                    'href' => url($itemUrl),
                    'rel' => 'self',
                    'prompt' => 'View Details'
                ],
                [
                    'href' => url($itemUrl),
                    'rel' => 'edit',
                    'prompt' => 'Edit'
                ],
                [
                    'href' => url($itemUrl),
                    'rel' => 'delete',
                    'prompt' => 'Delete'
                ]
            ];
        }

        return $formatted;
    }

    /**
     * Generate human-readable prompt dari field name
     */
    private function generatePrompt($fieldName)
    {
        // Convert snake_case ke Title Case
        $prompt = str_replace('_', ' ', $fieldName);
        return ucwords($prompt);
    }

    /**
     * Create template untuk POST request
     */
    protected function createTemplate($fields)
    {
        $data = [];
        
        foreach ($fields as $field => $config) {
            $item = [
                'name' => $field,
                'value' => '',
                'prompt' => $config['prompt'] ?? $this->generatePrompt($field)
            ];

            if (isset($config['required'])) {
                $item['required'] = $config['required'];
            }

            if (isset($config['type'])) {
                $item['type'] = $config['type'];
            }

            $data[] = $item;
        }

        return ['data' => $data];
    }

    /**
     * Create search query template
     */
    protected function createQuery($name, $href, $fields, $prompt = null)
    {
        $data = [];
        
        foreach ($fields as $field => $config) {
            $data[] = [
                'name' => $field,
                'value' => '',
                'prompt' => $config['prompt'] ?? $this->generatePrompt($field)
            ];
        }

        return [
            'href' => url($href),
            'rel' => 'search',
            'name' => $name,
            'prompt' => $prompt ?? "Search $name",
            'data' => $data
        ];
    }

    /**
     * Create pagination links
     */
    protected function createPaginationLinks($currentPage, $lastPage, $baseUrl)
    {
        $links = [];

        // First page
        if ($currentPage > 1) {
            $links[] = [
                'href' => url("$baseUrl?page=1"),
                'rel' => 'first',
                'prompt' => 'First Page'
            ];
        }

        // Previous page
        if ($currentPage > 1) {
            $links[] = [
                'href' => url("$baseUrl?page=" . ($currentPage - 1)),
                'rel' => 'prev',
                'prompt' => 'Previous Page'
            ];
        }

        // Next page
        if ($currentPage < $lastPage) {
            $links[] = [
                'href' => url("$baseUrl?page=" . ($currentPage + 1)),
                'rel' => 'next',
                'prompt' => 'Next Page'
            ];
        }

        // Last page
        if ($currentPage < $lastPage) {
            $links[] = [
                'href' => url("$baseUrl?page=$lastPage"),
                'rel' => 'last',
                'prompt' => 'Last Page'
            ];
        }

        return $links;
    }

    /**
     * Format error response dalam Collection+JSON
     */
    protected function collectionError($message, $statusCode = 400, $collectionUrl = null)
    {
        $error = [
            'title' => 'Error',
            'code' => $statusCode,
            'message' => $message
        ];

        $response = [
            'collection' => [
                'version' => '1.0',
                'error' => $error
            ]
        ];

        if ($collectionUrl) {
            $response['collection']['href'] = url($collectionUrl);
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Create standard CRUD links
     */
    protected function createCrudLinks($resourceUrl, $itemId = null)
    {
        $links = [
            [
                'href' => url($resourceUrl),
                'rel' => 'collection',
                'prompt' => 'View All'
            ]
        ];

        if ($itemId) {
            $itemUrl = "$resourceUrl/$itemId";
            $links[] = [
                'href' => url($itemUrl),
                'rel' => 'self',
                'prompt' => 'View Details'
            ];
            $links[] = [
                'href' => url($itemUrl),
                'rel' => 'edit',
                'prompt' => 'Edit This Item'
            ];
            $links[] = [
                'href' => url($itemUrl),
                'rel' => 'delete',
                'prompt' => 'Delete This Item'
            ];
        } else {
            $links[] = [
                'href' => url($resourceUrl),
                'rel' => 'create',
                'prompt' => 'Create New Item'
            ];
        }

        return $links;
    }

    /**
     * Add related resource link
     */
    protected function addRelatedLink($relatedUrl, $prompt)
    {
        return [
            'href' => url($relatedUrl),
            'rel' => 'related',
            'prompt' => $prompt
        ];
    }
}
