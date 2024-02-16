<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use function Safe\fclose;
use function Safe\fopen;
use function Safe\fputcsv;

<<<<<<< HEAD
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
/**
 * Class ArrayService.
 */
class ArrayService
{
    private static ?self $instance = null;

    public array $array;

    public ?string $filename = null;
<<<<<<< HEAD

    private int $export_processor = 1;
=======
    protected int $export_processor = 1;
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a

    public function __construct()
    {
        // ---
        include_once __DIR__.'/vendor/autoload.php';
    }

    public static function getInstance(): self
    {
        if (! self::$instance instanceof \Modules\Xot\Services\ArrayService) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function make(): self
    {
        return static::getInstance();
    }

    public static function save(array $params): void
    {
        extract($params);
        if (! isset($data)) {
            dddx(['err' => 'data is missing']);

            return;
        }
<<<<<<< HEAD

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        if (! isset($filename)) {
            dddx(['filename' => 'filename is missing']);

            return;
        }
<<<<<<< HEAD

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        $content = var_export($data, true);

        // HHVM fails at __set_state, so just use object cast for now
        $content = str_replace('stdClass::__set_state', '(object)', $content);

        $content = '<?php '.\chr(13).'return '.$content.';'.\chr(13);
        // $content = str_replace('stdClass::__set_state', '(object)', $content);
<<<<<<< HEAD
        File::makeDirectory(\dirname((string) $filename), 0775, true, true);
=======
        File::makeDirectory(\dirname($filename), 0775, true, true);
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        File::put($filename, $content);
    }

    /**
     * Undocumented function.
     *
     * @param array|object $arrObjData
     * @param array        $arrSkipIndices
<<<<<<< HEAD
     */
    public static function fromObjects($arrObjData, $arrSkipIndices = []): array
=======
     *
     * @return array
     */
    public static function fromObjects($arrObjData, $arrSkipIndices = [])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        $arrData = [];

        // if input is object, convert into array
        if (\is_object($arrObjData)) {
            $arrObjData = get_object_vars($arrObjData);
        }

        if (\is_array($arrObjData)) {
            foreach ($arrObjData as $index => $value) {
                if (\is_object($value) || \is_array($value)) {
                    $value = self::fromObjects($value, $arrSkipIndices); // recursive call
                }
<<<<<<< HEAD

                if (\in_array($index, $arrSkipIndices, true)) {
                    continue;
                }

=======
                if (\in_array($index, $arrSkipIndices, true)) {
                    continue;
                }
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
                $arrData[$index] = $value;
            }
        }

        return $arrData;
    }

    /**
     * Undocumented function.
     *
     * @param int $a0
     * @param int $b0
     * @param int $a1
     * @param int $b1
<<<<<<< HEAD
     */
    public static function rangeIntersect($a0, $b0, $a1, $b1): array|bool
=======
     *
     * @return array|bool
     */
    public static function rangeIntersect($a0, $b0, $a1, $b1)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        if ($a1 >= $a0 && $a1 <= $b0 && $b0 <= $b1) {
            return [$a1, $b0];
        }
<<<<<<< HEAD

        if ($a0 >= $a1 && $a0 <= $b0 && $b0 <= $b1) {
            return [$a0, $b0];
        }

        if ($a1 >= $a0 && $a1 <= $b1 && $b1 <= $b0) {
            return [$a1, $b1];
        }

        if ($a0 < $a1) {
            return false;
        }
        if ($a0 > $b1) {
            return false;
        }
        if ($b1 > $b0) {
            return false;
        }

        return [$a0, $b1];
=======
        if ($a0 >= $a1 && $a0 <= $b0 && $b0 <= $b1) {
            return [$a0, $b0];
        }
        if ($a1 >= $a0 && $a1 <= $b1 && $b1 <= $b0) {
            return [$a1, $b1];
        }
        if ($a0 >= $a1 && $a0 <= $b1 && $b1 <= $b0) {
            return [$a0, $b1];
        }

        return false;
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * Undocumented function.
     */
    public static function fixType(array $data): array
    {
        $res = collect($data)
            ->map(
<<<<<<< HEAD
                static function ($item) {
                    if (! is_array($item)) {
                        throw new \Exception('['.__LINE__.']['.__FILE__.']');
                    }

                    return collect($item)
                        ->map(
                            static function ($item0) {
                                if (is_numeric($item0)) {
                                    return $item0 * 1;
=======
                function ($item) {
                    if (! is_array($item)) {
                        throw new \Exception('['.__LINE__.']['.__FILE__.']');
                    }
                    $item = collect($item)
                        ->map(
                            function ($item0) {
                                if (is_numeric($item0)) {
                                    $item0 = $item0 * 1;
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
                                }

                                return $item0;
                            }
                        )->all();
<<<<<<< HEAD
=======

                    return $item;
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
                }
            );

        return $res->all();
    }

    /**
     * Undocumented function.
     */
    public static function diff_assoc_recursive(array $arr_1, array $arr_2): array
    {
        $coll_1 = collect(self::fixType($arr_1));
        $arr_2 = self::fixType($arr_2);

        $ris = $coll_1->filter(
<<<<<<< HEAD
            static function ($value, $key) use ($arr_2) {
                try {
                    return ! \in_array($value, $arr_2, true);
                } catch (\Exception $exception) {
                    dddx(['err' => $exception->getMessage(), 'value' => $value, 'key' => $key, 'arr_2' => $arr_2]);
=======
            function ($value, $key) use ($arr_2) {
                try {
                    return ! \in_array($value, $arr_2, true);
                } catch (\Exception $e) {
                    dddx(['err' => $e->getMessage(), 'value' => $value, 'key' => $key, 'arr_2' => $arr_2]);
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
                }
            }
        );

        return $ris->all();
<<<<<<< HEAD
    }

    public function getArray(): array
    {
        return $this->array;
    }

    public function setArray(array $array): self
    {
        $this->array = $array;

        return $this;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFilename(): string
    {
        $filename = $this->filename;
        if (null !== $filename) {
            return $filename;
        }

        // dddx(debug_backtrace());
        return 'test';
    }

    // ret array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string|\Symfony\Component\HttpFoundation\BinaryFileResponse

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function toXLS(): BinaryFileResponse|Renderable
    {
        if (1 === request('debug', 0) * 1) {
            return self::toHtml();
        }

        // include_once __DIR__.'/vendor/autoload.php';
        $data = $this->array;
        $res = [];
        foreach ($data as $k => $v) {
            foreach ($v as $k0 => $v0) {
                if (! \is_array($v0)) {
                    $res[$k][$k0] = $v0;
                }
            }
        }

        $this->array = $res;
        if (1 == $this->export_processor) {
            return self::toXLS_phpoffice();
        }
        $msg = 'unknown export_processor ['.$this->export_processor.']';
        throw new \Exception($msg.'['.__LINE__.']['.__FILE__.']');
        $msg = 'unknown export_processor ['.$this->export_processor.']';
        throw new \Exception($msg.'['.__LINE__.']['.__FILE__.']');
    }

    public function toHtml(): Renderable
    {
        /*
        $header = $this->getHeader();
        $data = $this->getArray();
        $html = '';
        $html .= '<table border="1">';
        $html .= '<thead>';
        $html .= '<tr>';
        foreach ($header as $k => $v) {
            $html .= '<th>'.$v.'</th>';
        }

        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($data as $k => $v) {
            $html .= '<tr>';
            foreach ($v as $v0) {
                if (\is_string($v0) || is_numeric($v0) || null === $v0) {
                    $html .= '<td><pre>'.$v0.'</pre></td>';
                } elseif (\is_array($v0)) {
                    $html .= '<td><pre>'.print_r($v0, true).'</pre></td>';
                } else {
                    $html .= '<td><pre>NOT STRING</pre></td>';
                }
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
        */

        /**
         * @phpstan-var view-string
         */
        $view = 'xot::services.table';
        $view_params = [
            // 'header'=>$this->getHeader(),
            'rows' => $this->array,
        ];

        return view($view, $view_params);
    }

    public function getHeader(): array
    {
        $data = $this->array;
        $firstrow = collect($data)->first();
        if (! \is_array($firstrow)) {
            $firstrow = [];
        }

        $header = array_keys($firstrow);

        $debug = debug_backtrace();
        if (isset($debug[2]['file'])) {
            $mod_trad = getModTradFilepath($debug[2]['file']);

            return TranslatorService::getArrayTranslated($mod_trad, $header);
        }

        return $header;
    }

    // ret array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string|\Symfony\Component\HttpFoundation\BinaryFileResponse

    public function fixCellsType(Worksheet &$worksheet): void
    {
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            foreach ($cellIterator as $cell) {
                if (filter_var($cell->getValue(), FILTER_VALIDATE_URL)) {
                    $cell_value = $cell->getValue();
                    if (! is_string($cell_value)) {
                        throw new \Exception('['.__LINE__.']['.__FILE__.']');
                    }

                    $worksheet->getCell($cell->getCoordinate())->getHyperlink()->setUrl($cell_value);
                }
            }
        }
    }

    public function toCsv(): StreamedResponse
    {
        $filename = $this->getFilename();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename='.$filename,
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function (): void {
            $file = fopen('php://output', 'w');

            fputcsv($file, $this->array);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Illuminate\Contracts\View\View|string|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function toXLS_phpoffice(?string $out = 'download'): BinaryFileResponse|Renderable
    {
        $spreadsheet = new Spreadsheet();
        // ----
        $ltr = 'A1';
        // ----
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle($ltr)->getAlignment()->setWrapText(true);

        $header = $this->getHeader();
        $data = $this->array;
        $filename = $this->getFilename();

        $sheet->fromArray($header, null, 'A1');

        // $this->setHyperlinks($data, $spreadsheet);
        // $sheet->getCell('B2')->getHyperlink()->setUrl('https://www.google.com/');

        $sheet->fromArray(
            $data,      // The data to set
            null,        // Array values with this value will not be set
            'A2'         // Top left coordinate of the worksheet range where
            //    we want to set these values (default is A1)
        );

        $this->fixCellsType($sheet);

        // $sheet->setCellValue('A1', 'Hello World !');
        $xlsx = new Xlsx($spreadsheet);

        $pathToFile = Storage::disk('local')->path($filename.'.xlsx');
        $xlsx->save($pathToFile); // $writer->save('php://output'); // per out diretto ?

        $view_params = [
            'file' => $pathToFile,
            'ext' => 'xls',
            'text' => '.',
            // 'text'=>$text,
        ];

        return match ($out) {
            'link' => view()->make('ui::download_icon', $view_params),
            'download' => response()->download($pathToFile),
            'link_file' => view()->make('ui::download_icon', $view_params),
            default => throw new \Exception('['.__LINE__.']['.__FILE__.']'),
        };
=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    public function getArray(): array
    {
        return $this->array;
    }

    public function setArray(array $array): self
    {
        $this->array = $array;

        return $this;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFilename(): string
    {
        $filename = $this->filename;
        if (null !== $filename) {
            return $filename;
        }

        // dddx(debug_backtrace());
        return 'test';
    }

    // ret array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string|\Symfony\Component\HttpFoundation\BinaryFileResponse

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string|\Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|Renderable
     */
    public function toXLS()
    {
        if (1 === request('debug', 0) * 1) {
            return self::toHtml();
        }
        // include_once __DIR__.'/vendor/autoload.php';
        $data = $this->array;
        $res = [];
        foreach ($data as $k => $v) {
            foreach ($v as $k0 => $v0) {
                if (! \is_array($v0)) {
                    $res[$k][$k0] = $v0;
                }
            }
        }
        $this->array = $res;

        switch ($this->export_processor) {
            case 1:
                return self::toXLS_phpoffice(); // break;
                // case 2:return self::toXLS_Maatwebsite($params); //break;
                // case 3:return self::toXLS_phpexcel($params); //break;
            default:
                $msg = 'unknown export_processor ['.$this->export_processor.']';
                throw new \Exception($msg.'['.__LINE__.']['.__FILE__.']');
        }
    }

    public function toHtml(): Renderable
    {
        /*
        $header = $this->getHeader();
        $data = $this->getArray();
        $html = '';
        $html .= '<table border="1">';
        $html .= '<thead>';
        $html .= '<tr>';
        foreach ($header as $k => $v) {
            $html .= '<th>'.$v.'</th>';
        }

        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($data as $k => $v) {
            $html .= '<tr>';
            foreach ($v as $v0) {
                if (\is_string($v0) || is_numeric($v0) || null === $v0) {
                    $html .= '<td><pre>'.$v0.'</pre></td>';
                } elseif (\is_array($v0)) {
                    $html .= '<td><pre>'.print_r($v0, true).'</pre></td>';
                } else {
                    $html .= '<td><pre>NOT STRING</pre></td>';
                }
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
        */

        /**
         * @phpstan-var view-string
         */
        $view = 'xot::services.table';
        $view_params = [
            // 'header'=>$this->getHeader(),
            'rows' => $this->getArray(),
        ];

        return view($view, $view_params);
    }

    public function getHeader(): array
    {
        $data = $this->array;
        $firstrow = collect($data)->first();
        if (! \is_array($firstrow)) {
            $firstrow = [];
        }
        $header = array_keys($firstrow);

        $debug = debug_backtrace();
        if (isset($debug[2]['file'])) {
            $mod_trad = getModTradFilepath($debug[2]['file']);

            return TranslatorService::getArrayTranslated($mod_trad, $header);
        }

        return $header;
    }

    // ret array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string|\Symfony\Component\HttpFoundation\BinaryFileResponse

    public function fixCellsType(Worksheet &$sheet): void
    {
        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            foreach ($cellIterator as $cell) {
                if (filter_var($cell->getValue(), FILTER_VALIDATE_URL)) {
                    $cell_value = $cell->getValue();
                    if (! is_string($cell_value)) {
                        throw new \Exception('['.__LINE__.']['.__FILE__.']');
                    }
                    $sheet->getCell($cell->getCoordinate())->getHyperlink()->setUrl($cell_value);
                }
            }
        }
    }

    public function toCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename = $this->getFilename();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['Title', 'Assign', 'Description', 'Start Date', 'Due Date'];

        $callback = function () {
            /**
             * @var resource
             */
            $file = fopen('php://output', 'w');

            fputcsv($file, $this->array);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Illuminate\Contracts\View\View|string|\Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|Renderable
     */
    public function toXLS_phpoffice(?string $out = 'download')
    {
        $spreadsheet = new Spreadsheet();
        // ----
        $ltr = 'A1';
        // ----
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle($ltr)->getAlignment()->setWrapText(true);

        $header = $this->getHeader();
        $data = $this->array;
        $filename = $this->getFilename();

        $sheet->fromArray($header, null, 'A1');

        // $this->setHyperlinks($data, $spreadsheet);
        // $sheet->getCell('B2')->getHyperlink()->setUrl('https://www.google.com/');

        $sheet->fromArray(
            $data,      // The data to set
            null,        // Array values with this value will not be set
            'A2'         // Top left coordinate of the worksheet range where
            //    we want to set these values (default is A1)
        );

        $this->fixCellsType($sheet);

        // $sheet->setCellValue('A1', 'Hello World !');
        $writer = new Xlsx($spreadsheet);

        $pathToFile = Storage::disk('local')->path($filename.'.xlsx');
        $writer->save($pathToFile); // $writer->save('php://output'); // per out diretto ?

        $view_params = [
            'file' => $pathToFile,
            'ext' => 'xls',
            'text' => '.',
            // 'text'=>$text,
        ];

        // if (! isset($out)) {
        //    $out = 'download';
        // }
        // return response()->download($pathToFile);
        // $out='link';
        // exit(response()->download($pathToFile));
        // }
        // Variable $text in isset() is never defined
        // if (! isset($text)) {
        //    $text = 'text';
        // }

        switch ($out) {
            case 'link':
                return view()->make('ui::download_icon', $view_params);
            case 'download':
                return response()->download($pathToFile);
                // case 'file':
                //    return $pathToFile;
            case 'link_file':
                return view()->make('ui::download_icon', $view_params);

                // return [$link, $pathToFile];
        }
        // 231    Unreachable statement - code above always terminates.
        throw new \Exception('['.__LINE__.']['.__FILE__.']');
    }
}
