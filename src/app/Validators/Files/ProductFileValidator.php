<?php

namespace App\Validators\Files;

use App\Contracts\Abstracts\AbstractFileValidator;
use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileReaderInterface;

class ProductFileValidator extends AbstractFileValidator
{
    protected array $rules = [
        'product_name' => 'string|required|max:255',
        'product_handle' => 'string|nullable|max:255',
        'product_desc' => 'string',
        'product_sku' => 'string|nullable|max:255',
        'display_name' => 'string|nullable|max:255',
        'product_image' => 'string|nullable|max:255',
        'barcode' => 'string|nullable|max:255',
        'is_loose' => 'numeric|nullable|max:1|gte:0',
        'is_open_price_product' => 'numeric|nullable|max:1|gte:0',
        'product_label' => 'string|nullable|max:255',
        'weight' => 'numeric|nullable|max:11|gte:0',
        'delivery_code' => 'string|nullable|max:255',
        'purchase_price' => 'numeric|nullable|check_decimal:8,3',
        'supplier_purchase_price' => 'numeric|nullable|check_decimal:8,3',
        'supplier_unit' => 'string|nullable|max:255',
        'store_to_supplier_unit_conversion' => 'numeric|nullable|check_decimal:8,3',
        'selling_price' => 'numeric|nullable|check_decimal:8,3',
        'takeaway_no_vat' => 'numeric|nullable|max:1|gte:0',
        'takeaway_override_price' => 'numeric|nullable|max:1|gte:0',
        'takeaway_selling_price' => 'numeric|nullable|check_decimal:8,3',
        'takeaway_vat_code' => 'string|nullable|max:36',
        'oc_disabled' => 'numeric|nullable|digits_between:1,4',
        'oc_no_vat' => 'numeric|nullable|digits_between:1,4',
        'oc_override_price' => 'numeric|nullable|digits_between:1,4',
        'oc_selling_price' => 'numeric|nullable|check_decimal:8,3',
        'oc_collection_vat_code' => 'string|nullable|max:36',
        'oc_delivery_vat_code' => 'string|nullable|max:36',
        'oc_dropoff_vat_code' => 'string|nullable|max:36',
        'oc_collection_selling_price' => 'numeric|nullable|check_decimal:8,3',
        'oc_delivery_selling_price' => 'numeric|nullable|check_decimal:8,3',
        'oc_dropoff_selling_price' => 'numeric|nullable|check_decimal:8,3',
        'track_inventory' => 'numeric|nullable|max:1|gte:0',
        'inventory' => 'numeric|nullable|check_decimal:10,3',
        'min_stock' => 'numeric|nullable|check_decimal:10,3',
        'stock_level_1' => 'numeric|nullable|check_decimal:10,3',
        'stock_level_2' => 'numeric|nullable|check_decimal:10,3',
        'alert_on' => 'numeric|nullable|max:1|gte:0',
        'alert_below' => 'numeric|nullable|check_decimal:10,3',
        'delivery_reorder_on' => 'numeric|nullable|max:1|gte:0',
        'delivery_reorder_point' => 'numeric|nullable|check_decimal:10,3',
        'has_variant' => 'numeric|nullable|max:1|gte:0',
        'has_attributes' => 'numeric|nullable|max:1|gte:0',
        'display_attr_pos' => 'numeric|nullable|max:1|gte:0',
        'take_stock_from_parent' => 'numeric|nullable|max:1|gte:0',
        'stock_quantifier' => 'numeric|nullable|check_decimal:7,3',
        'has_ingredient_stock' => 'numeric|nullable|max:1|gte:0',
        'cost_from_ingredient' => 'numeric|nullable|max:1|gte:0',
        'label_as_main' => 'numeric|nullable|max:1|gte:0',
        'course_no' => 'numeric|nullable|digits_between:0,4',
        'print_on_receipt' => 'numeric|nullable|max:1|gte:0',
        'print_on_kitchen' => 'numeric|nullable|max:1|gte:0',
        'print_on_drink' => 'numeric|nullable|max:1|gte:0',
        'print_on_other' => 'numeric|nullable|max:1|gte:0',
        'ticket_printer_1' => 'numeric|nullable|max:1|gte:0',
        'ticket_printer_2' => 'numeric|nullable|max:1|gte:0',
        'ticket_printer_3' => 'numeric|nullable|max:1|gte:0',
        'ticket_printer_4' => 'numeric|nullable|max:1|gte:0',
        'display_order' => 'numeric|nullable|max:1|gte:0',
        'account_code' => 'string|nullable|max:255',
        'active' => 'numeric|nullable|max:1|gte:0',
        'is_deleted' => 'numeric|nullable|max:1|gte:0',
        'deleted_at' => 'date_format:Y-m-d H:i:s', // ??
        'shareable' => 'numeric|nullable|max:1|gte:0',
        'lock_price' => 'numeric|nullable|max:1|gte:0',
        'has_modifier' => 'numeric|nullable|max:1|gte:0',
        'display_colour' => 'string',
        'custom_field_1' => 'string',
        'custom_field_2' => 'string',
        'custom_field_3' => 'string',
        'custom_field_4' => 'string',
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
