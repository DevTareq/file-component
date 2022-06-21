<?php

namespace App\Validators\Files;

use App\Contracts\FileReaderInterface;
use App\Contracts\FileValidatorInterface;
use Illuminate\Support\Facades\Validator;

class CsvFileValidator implements FileValidatorInterface
{
    /** @var array $errors */
    protected array $errors = [];

    /**
     * @param FileReaderInterface $fileParser
     */
    public function __construct(
        protected FileReaderInterface $fileParser
    ) {}

    private array $rules = [
        'product_name' => 'string|required|max:255',
        'product_handle' => 'string|nullable|max:255',
        'product_desc' => 'string',
        'product_sku' => 'string|nullable|max:255',
        'display_name' => 'string|nullable|max:255',
        'product_image' => 'string|nullable|max:255',
        'barcode' => 'string|nullable|max:255',
        'is_loose' => 'required|integer|max:1',
        'is_open_price_product' => 'integer|required',
        'product_label' => 'string|nullable|max:255',
        'weight' => 'integer|required|max:11',
        'delivery_code' => 'string|nullable|max:255',
        'purchase_price' => 'required|check_decimal:8,3',
        'supplier_purchase_price' => 'nullable|check_decimal:8,3',
        'supplier_unit' => 'string|nullable|max:255',
        'store_to_supplier_unit_conversion' => 'check_decimal:8,3',
        'selling_price' => 'nullable|check_decimal:8,3',
        'takeaway_no_vat' => 'integer|max:1',
        'takeaway_override_price' => 'integer|max:1',
        'takeaway_selling_price' => 'check_decimal:8,3',
        'takeaway_vat_code' => 'string|nullable|max:36',
        'oc_disabled' => 'integer|max:4',
        'oc_no_vat' => 'integer|max:4',
        'oc_override_price' => 'integer|max:4',
        'oc_selling_price' => 'check_decimal:8,3',
        'oc_collection_vat_code' => 'string|nullable|max:36',
        'oc_delivery_vat_code' => 'string|nullable|max:36',
        'oc_dropoff_vat_code' => 'string|nullable|max:36',
        'oc_collection_selling_price' => 'nullable|check_decimal:8,3',
        'oc_delivery_selling_price' => 'nullable|check_decimal:8,3',
        'oc_dropoff_selling_price' => 'nullable|check_decimal:8,3',
        'track_inventory' => 'required|integer|max:1',
        'inventory' => 'nullable|check_decimal:10,3',
        'min_stock' => 'required|check_decimal:10,3',
        'stock_level_1' => 'nullable|check_decimal:10,3',
        'stock_level_2' => 'nullable|check_decimal:10,3',
        'alert_on' => 'integer|required|max:1',
        'alert_below' => 'nullable|check_decimal:10,3',
        'delivery_reorder_on' => 'integer|required|max:1',
        'delivery_reorder_point' => 'nullable|check_decimal:10,3',
        'has_variant' => 'integer|required|max:1',
        'has_attributes' => 'integer|required|max:1',
        'display_attr_pos' => 'integer|max:1',
        'take_stock_from_parent' => 'integer|required|max:1',
        'stock_quantifier' => 'required|check_decimal:7,3',
        'has_ingredient_stock' => 'integer|required|max:1',
        'cost_from_ingredient' => 'integer|required|max:1',
        'label_as_main' => 'integer|required|max:1',
        'course_no' => 'integer|max:4',
        'print_on_receipt' => 'integer|required|max:1',
        'print_on_kitchen' => 'integer|required|max:1',
        'print_on_drink' => 'integer|required|max:1',
        'print_on_other' => 'integer|required|max:1',
        'ticket_printer_1' => 'integer|max:1',
        'ticket_printer_2' => 'integer|max:1',
        'ticket_printer_3' => 'integer|max:1',
        'ticket_printer_4' => 'integer|max:1',
        'display_order' => 'integer|required|max:11',
        'account_code' => 'string|nullable|max:255',
        'active' => 'integer|required|max:1',
        'is_deleted' => 'integer|max:1',
        'deleted_at' => 'date_format:Y-m-d H:i:s', // ??
        'shareable' => 'integer|required|max:1',
        'lock_price' => 'integer|required|max:1',
        'has_modifier' => 'integer|max:1',
        'display_colour' => 'string',
        'custom_field_1' => 'string',
        'custom_field_2' => 'string',
        'custom_field_3' => 'string',
        'custom_field_4' => 'string',
        'created_at' => 'integer|min:1',
        'updated_at' => 'integer|min:1',
    ];

    /**
     * @param array $array
     * @return void
     */
    public function setRules(array $array): void
    {
        $this->rules = $array;
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param string $filePath
     * @return mixed
     * @throws \League\Csv\Exception
     */
    public function validate(string $filePath): mixed
    {
        $fileRecords = $this->fileParser->fetchAll($filePath);

        return $this->validateMultiple($fileRecords);
    }

    /**
     * @param $fileRecords
     * @return array|null
     */
    private function validateMultiple($fileRecords): ?array
    {
        foreach ($fileRecords as $offset => $record) {
            $validator = Validator::make($record, $this->getRules());

            if (!$validator->fails()) {
                continue;
            }

            $this->errors[] = [
                'record' => $offset,
                'errors' => $validator->errors()->all(),
            ];
        }

        return $this->errors ?? [];
    }

    /**
     * @param $fileRecords
     * @return array|null
     */
    private function validateOnce($fileRecords): ?array
    {
        foreach ($fileRecords as $offset => $record) {
            $validator = Validator::make($record, $this->getRules());

            if ($validator->fails()) {
                $this->errors[] = [
                    'record' => $offset,
                    'errors' => $validator->errors()->all(),
                ];

                return $this->errors;
            }
        }

        return [];
    }
}
