<?php
use Illuminate\Support;
use LSS\Array2Xml;
use Tightenco\Collect\Support\Collection;

class Exporter 
{
    protected $exportable;

    public function __construct(Exportable $exportable)
    {
        $this->exportable = $exportable;
    }

    public function export()
    {
        switch($this->exportable->getFormat()) {
            case 'xml':
                return $this->exportXml();
            case 'json':
                return $this->exportJson();
            case 'csv':
                return $this->exportCsv();
            default: 
                return $this->exportHtml();
        }
    }

    private function exportXml()
    {
        header('Content-type: text/xml');
        // fix any keys starting with numbers
        $keyMap = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        $xmlData = [];
        foreach ($this->exportable->getData()->all() as $row) {
            $xmlRow = [];
            foreach ($row as $key => $value) {
                $key = preg_replace_callback('(\d)', function($matches) use ($keyMap) {
                    return $keyMap[$matches[0]] . '_';
                }, $key);
                $xmlRow[$key] = $value;
            }
            $xmlData[] = $xmlRow;
        }
        $xml = Array2XML::createXML('data', [
            'entry' => $xmlData
        ]);

        return $xml->saveXML();
    }

    private function exportJson()
    {
        header('Content-type: application/json');

        return json_encode($this->exportable->getData()->all());
    }

    private function exportCsv()
    {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv";');
        $csv = [];
        $data = $this->exportable->getData();
        
        // extract headings
        // replace underscores with space & ucfirst each word for a decent headings
        $headings = collect($data->get(0))->keys();
        $headings = $headings->map(function($item, $key) {
            return collect(explode('_', $item))
                ->map(function($item, $key) {
                    return ucfirst($item);
                })
                ->join(' ');
        });
        $csv[] = $headings->join(',');

        // format data
        foreach ($data as $dataRow) {
            $csv[] = implode(',', array_values($dataRow));
        }
        return implode("\n", $csv);
    }

    private function exportHtml()
    {
        $data = $this->exportable->getData();

        if (!$data->count()) {
            return $this->htmlTemplate('Sorry, no matching data was found');
        }

        // extract headings
        // replace underscores with space & ucfirst each word for a decent heading
        $headings = collect($data->get(0))->keys();
        $headings = $headings->map(function($item, $key) {
            return collect(explode('_', $item))
                ->map(function($item, $key) {
                    return ucfirst($item);
                })
                ->join(' ');
        });
        $headings = '<tr><th>' . $headings->join('</th><th>') . '</th></tr>';

        // output data
        $rows = [];
        foreach ($data as $dataRow) {
            $row = '<tr>';
            foreach ($dataRow as $key => $value) {
                $row .= '<td>' . $value . '</td>';
            }
            $row .= '</tr>';
            $rows[] = $row;
        }
        $rows = implode('', $rows);
        return $this->htmlTemplate('<table>' . $headings . $rows . '</table>');
    }

    private function htmlTemplate($html) {
        return '
            <html>
            <head>
            <style type="text/css">
                body {
                    font: 16px Roboto, Arial, Helvetica, Sans-serif;
                }
                td, th {
                    padding: 4px 8px;
                }
                th {
                    background: #eee;
                    font-weight: 500;
                }
                tr:nth-child(odd) {
                    background: #f4f4f4;
                }
            </style>
            </head>
            <body>
                ' . $html . '
            </body>
            </html>
        ';
    }
}