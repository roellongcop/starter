<?php

namespace app\models\form\export;

class ExportForm extends \yii\base\Model
{
    public $exportColumnsName = 'exportColumns';
    public $excelIgnoreAttributesName = 'excelIgnoreAttributes';
    public $tableColumnsName = 'tableColumns';

    const EXPORT_ACTIONS = [
        'print',
        'export-pdf',
        'export-csv',
        'export-xls',
        'export-xlsx'
    ];

    const IGNORE_ATTRIBUTES = [
        'checkbox',
        'actions'
    ];

    const FORMATS = [
        'raw' => [
            'photo',
            'icon'
        ],
        'fulldate' => [
            'created_at',
            'updated_at'
        ],
        'ago' => [
            'last_updated'
        ]
    ];

    public $filename;
    public $content;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['filename'], 'required'],
            [['filename'], 'string'],
            [['filename'], 'trim'],
            [['content',], 'safe'],
        ];
    }

    public function getExportColumns($searchModel, $type = 'excel')
    {
        if ($searchModel->{$this->exportColumnsName}) {
            $columns = $searchModel->{$this->exportColumnsName};
            $newColumns = [];

            foreach ($columns as $key => $column) {
                if (is_array($column)) {
                    $newColumns[$key] = $column;
                    $newColumns['enableSorting'] = false;
                }
                else {
                    if (str_contains($column, ':')) {
                        list($column_name, $format) = explode(':', $column);
                    }
                    else {
                        $column_name = $column;
                        $format = 'raw';
                    }
                    
                    $newColumns[$column_name] = [
                        'attribute' => $column_name,
                        'format' => $format,
                        'enableSorting' => false
                    ];
                }
            }

            return $newColumns;
        }

        $ignoreAttributes = self::IGNORE_ATTRIBUTES;

        if ($type == 'excel' && (($excelIgnoreAttributes = $searchModel->excelIgnoreAttributes) != null)) {
            $ignoreAttributes = array_merge($ignoreAttributes, $excelIgnoreAttributes);
        }

        $tableColumns = array_filter(
            $searchModel->tableColumns,
            function ($column, $key) use ($ignoreAttributes) {
                if (!in_array($key, $ignoreAttributes)) {
                    return $column;
                }
            },
            ARRAY_FILTER_USE_BOTH
        );

        foreach ($tableColumns as $column => &$attribute) {
            if (in_array($column, $ignoreAttributes)) {
                continue;
            }

            if ($column == 'serial') {
                continue;
            }

            $attribute['header'] = strtoupper(str_replace('_', ' ', $column));
            $attribute['format'] = 'stripTags';
            $attribute['enableSorting'] = false;

            foreach (self::FORMATS as $format => $columns) {
                if (in_array($column, $columns)) {
                    $attribute['format'] = $format;
                }
            }
        }

        return $tableColumns;
    }
}