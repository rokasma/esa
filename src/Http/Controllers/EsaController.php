<?php

namespace Rokasma\Esa\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Rokasma\Esa\Column;

class EsaController extends Controller
{
    protected $base_url = 'https://api.smartsheet.com/2.0/';
    protected $sheet_id;
    protected $columns = [];
    protected $formdata = [];

    public function init(Request $request)
    {
        if (empty($request->input('sheet-id'))) {
            return response()->json(['error' => 'Sheet ID is not defined!']);
        } else {
            $this->sheet_id = $request->input('sheet-id');

            $this->formatFormData($request->except('sheet-id'));

            $res = $this->getColumns();

            return $res;
        }
    }

    public function getColumns()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('esa.api_key')
        ])->get($this->base_url . 'sheets/' . $this->sheet_id);

        if ($response->ok()) {

            $content = (object) $response->json();
    
            foreach ($content->columns as $column) {
                if ($column['type'] === 'TEXT_NUMBER') {
                    array_push($this->columns, $column['id']);
                }
            }

            $validateFields = $this->compareFieldLength();

            if ($validateFields) {
                $postdata = $this->postToSmartsheet();
                return response()->json($postdata);
            }

        } else {
            $response->throw();
        }
    }

    public function createColumn($howmany)
    {
        $created = [];

        for ($c=0; $c < $howmany; $c++) {

            $column = new Column('Column' . $c, 'TEXT_NUMBER', count($this->formdata));
    
            $response = Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . config('esa.api_key')])->post($this->base_url . 'sheets/' . $this->sheet_id . '/columns', [
                'title' => $column->title,
                'type' => $column->type,
                'index' => $column->index
            ]);
    
            if ($response->ok()) {
                $createdColumn = (object) $response->json();

                $columnid = $createdColumn->result['id'];
                array_push($created, $columnid);
            } else {
                $response->throw();
            }
        }

        return $created;
    }

    public function postToSmartsheet()
    {
        $cells = [];

        for ($i=0; $i < count($this->formdata); $i++) {

            $columnid = $this->columns[$i];
            $value = $this->formdata[$i];

            $cell = [
                'columnId' => $columnid,
                'value' => $value
            ];

            array_push($cells, $cell);
            
        }

        $response = Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . config('esa.api_key')])->post($this->base_url . 'sheets/' . $this->sheet_id . '/rows', [
            'toTop' => true,
            'cells' => $cells
        ]);

        if ($response->ok()) {

            return (object) $response->json();
            
        } else {
            $response->throw();
        }

    }

    public function formatFormData($data)
    {
        foreach ($data as $dt => $value) {
            array_push($this->formdata, $value);
        }

        return true;
    }

    public function compareFieldLength()
    {
        if (count($this->columns) < count($this->formdata)) {

            $dif = count($this->formdata) - count($this->columns);
            $createdcolumn = $this->createColumn($dif);

            if (empty($createdcolumn)) {
                return response()->json(['error' => 'Created columns array is empty!']);
            } else {
                foreach ($createdcolumn as $col) {
                    array_push($this->columns, $col);
                }
            }
        }

        return true;
    }
}