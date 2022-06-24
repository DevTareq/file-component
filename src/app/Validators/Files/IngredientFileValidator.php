<?php

namespace App\Validators\Files;

use App\Contracts\Abstracts\AbstractFileValidator;
use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileReaderInterface;

class IngredientFileValidator extends AbstractFileValidator
{
    protected array $rules = [
        'ingredient_name' => 'string|required|max:255',
        'is_preparation_item' => 'string|nullable|max:255',
        'ingredient_unit' => 'numeric|required|check_decimal:8,3',
        'supplier_pack_size' => 'string|nullable|max:255',
        'purchase_price' => 'numeric|nullable|check_decimal:8,3',
        'supplier_purchase_price' => 'numeric|nullable|check_decimal:8,3',
        'retail_value_store_unit' => 'numeric|nullable|check_decimal:8,3',
        'delivery_code' => 'string|nullable|max:255',
        'ingredient_sku' => 'string|nullable|max:255',
        'barcode' => 'string|nullable|max:50',
        'default_unit' => 'string|nullable|max:255',
        'store_to_supplier_unit_conversion' => 'numeric|nullable|check_decimal:8,3',
        'supplier_qty_quantifier' => 'numeric|nullable|check_decimal:8,3',
        'inventory' => 'numeric|nullable|check_decimal:8,3',
        'stock_level_1' => 'numeric|nullable|check_decimal:8,3',
        'stock_level_2' => 'numeric|nullable|check_decimal:8,3',
        'alert_on' => 'numeric|nullable|max:1|gte:0',
        'alert_below' => 'numeric|nullable|digits_between:0,10',
        'delivery_reorder_on' => 'numeric|nullable|max:1|gte:0',
        'delivery_reorder_point' => 'numeric|nullable|digits_between:0,10',
        'active' => 'numeric|nullable|max:1|gte:0',
        'is_deleted' => 'numeric|nullable|max:1|gte:0',
        'instructions' => 'string',
    ];

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @param FileReaderInterface $fileReader
     * @return array|null
     * @throws \Throwable
     */
    public function validate(DataTransferObjectInterface $dataTransferObject, FileReaderInterface $fileReader): ?array
    {
        $fileRecords = $fileReader->fetchAll($dataTransferObject->getFileInput());

        return $this->validateMultiple($fileRecords);
    }
}
