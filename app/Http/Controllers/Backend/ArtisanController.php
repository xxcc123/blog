<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Artisan;
use App\Models\Category;
use App\Models\User\User;
use App\Traits\Label;
use Barryvdh\Snappy\Facades\SnappyPdf as pdf;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Box\Spout\Common\Type;
use phpseclib\Crypt\Hash;

//use Knp\Snappy\Pdf;
use Barryvdh\Snappy\Facades\SnappyImage;

//use Barryvdh\DomPDF\Facade as PDF;

/**
 * 文章后台-控制器
 * Class ArtisanController
 * @package App\Http\Controllers\Backend
 */
class ArtisanController extends Controller
{
    use \App\Traits\Category;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artisans =  admin_user()->artisans()->paginate();

        $data = [
            'artisans' => $artisans,
        ];

        return view('backend.artisan-list',$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keyword = trim($request->input('search'));

        $artisans = admin_user()->artisans()->where('title','like',"%{$keyword}%")->paginate();

        $data = [
            'artisans' => $artisans,
            'default_search' => $keyword
        ];

        return view('backend.artisan-list',$data);
    }

    /**
     * excel导入
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function excel_import(Request $request)
    {
        $filePath = $request->file('file');

        //第一种导入方式
        $reader = ReaderFactory::create(Type::XLSX);
        //如果注释掉，单元格内的日期类型将会是DateTime，不注释的话Spout自动帮你将日期转化成string
        //$reader->setShouldFormatDates(true);
        $reader->open($filePath);
        $iterator = $reader->getSheetIterator();
        foreach ($iterator as $sheet) {
            foreach ($sheet->getRowIterator() as $value) {

                if($value[0] == 'Title' && $value[1] == 'Label' && $value[2] == 'Content') {
                    continue;
                }

                $artisan_data = [
                    'user_id' => user_id(),
                    'title' => $value[0],
                    'label' => $value[1],
                    'content' => $value[2]
                ];

                Artisan::create($artisan_data);

            }
        }

        $reader->close();

        //第二种导入方式
//        Excel::load($filePath, function($reader) {
////            $reader = $reader->getSheet(0);
//
//            $artisan = ['Title','Label','Content'];
//
//            $data = $reader->all()->toArray();
//            dd($data);
//
//            if (count($data) == 1) {
//                foreach ($data as $datum) {
//                    self::import_create($datum);
//                }
//            }else{
//                foreach ($data as $datum) {
//                    foreach ($datum as $value) {
//                        self::import_create($value);
//                    }
//                }
//            }
//
//        });

        return redirect()->route('artisan.index');

    }

    /**
     * excel 导入创建
     * @param $datum
     */
    public function import_create($datum)
    {
        $artisan_data = [
            'user_id' => user_id(),
            'title' => array_get($datum, 'title'),
            'label' => array_get($datum, 'label'),
            'content' => array_get($datum, 'content')
        ];
        $artisan = Artisan::where('title', array_get($datum, 'title'))->first();
        if (empty($artisan) && array_get($datum, 'title') !== null) {
            Artisan::create($artisan_data);
        }
    }

    /**
     * excel 导出
     */
    public function excel_export()
    {
        $artisan = Artisan::all()->toArray();

        //第一种方法
        $header = [];
        foreach ($artisan as $value) {
            $header[] = $value;
        }

        $writer = WriterFactory::create(Type::XLSX);
        $target = 'TMP'. '.xlsx';
        $writer->openToFile($target);
        $writer->addRow(array_keys($header[0]));
        $writer->addRows($header);
        $writer->close();
        return response()->download($target);

        //第二种方法
//        // 设置超时
//        set_time_limit(180);
//
//        /*设置内存*/
//        ini_set('memory_limit','100M');
//
//        $filename = 'Artisan'.'-'.date('Ymd',time());
//
//        $artisans = Artisan::all();
//        Excel::create($filename, function ($excel) use($artisans,$filename){
//            $excel->sheet($filename, function ($sheet) use($artisans) {
//                $data = ['Title','Label','Content'];
//
//                $sheet->fromArray([$data],null,'A1',false,false);
//
//                $export_data = [];
//
//                foreach ($artisans as $artisan) {
//                    $data = [
//                        'title' => $artisan['title'],
//                        'label' => $artisan['label'],
//                        'content' => $artisan['content']
//                    ];
//                    array_push($export_data,$data);
//                }
//
//                $sheet->fromArray($export_data, null,'A1',false,false);
//
//                $sheet->freezeFirstRow();
//
//                $column_width = [
//                    'A'     =>  16,
//                    'B'     =>  16,
//                    'C'     =>  40,
//                ];
//
//                $sheet->setWidth($column_width);
//
//                $sheet->row(1, function($row) {
//
//                    $row->setBackground('#3c8dbc');
//                    $row->setFontWeight(true);
//
//                });
//            });
//        })->export('xlsx');
    }

    /**
     * 发布文章页面
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = $this->all();

        return view('backend.artisan-add',['categorys'=>$category]);
    }

    /**
     * 发布文章
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'label' => 'required',
        ]);

        $category_id = Category::where('category_name',$request->input('category'))->first()['id'];

        $all_data = [
            'title' => $request->input('title'),
            'label' => $request->input('label'),
            'content' => $request->input('editorValue'),
            'category_id' => $category_id,
        ];

        $artisan = admin_user()->artisans()->create($all_data);

        if (isset($artisan)) {
            return redirect()->route('artisan.index');
        } else {
            return redirect()->route('artisan_create');
        }


    }

    /**
     * 文章详情
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artisan = admin_user()->artisans()->with('category')->findOrFail($id);

        $categorys = $this->all();

        $data = [
            'artisan' => $artisan,
            'categorys' => $categorys,
        ];

        return view('backend.artisan-detail',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $data = $request->except(['_token']);

        $artisan = admin_user()->artisans()->findOrFail($id);
        $artisan->fill($data);
        $artisan->save();

        return redirect()->route('artisan.index');
    }

    /**
     * 删除文章
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $artisan = admin_user()->artisans()->findOrFail($id);

        $data = $artisan->delete();

        if ($data == true) {
            return redirect()->route('artisan.index');
        }else{
            return redirect()->route('artisan.index');
        }
    }


    public function pdf()
    {
        $artisans =admin_user()->artisnas()->orderBy('created_at','desc')->paginate();

        $data = [
            'artisans' => $artisans,
        ];

        $pdf = pdf::loadView('backend/pdf');
        return $pdf->download('artisan.pdf ');
    }


    /**
     * 图片上传
     * @param Request $request
     * @return string
     */
    public function image(Request $request)
    {
        $img= $request->file('file');
        if ($img) {

            //获取文件的原文件名 包括扩展名
            $yuanname= $img->getClientOriginalName();

            //获取文件的扩展名
            $kuoname=$img->getClientOriginalExtension();

            //获取文件的类型
            $type=$img->getClientMimeType();

            //获取文件的绝对路径，但是获取到的在本地不能打开
            $path=$img->getRealPath();

            //要保存的文件名 时间+扩展名
            $filename=uniqid() .'.'.$kuoname;
            //保存文件          配置文件存放文件的名字  ，文件名，路径
            $bool= Storage::disk('upload')->put($filename,file_get_contents($path));

            $user = auth()->user();
            $user->img = 'img/'.$filename;
            $user->save();

            return json_encode(['status'=>1,'filepath'=>$filename]);
        }else{
            $idCardFrontImg = '';
            return json_encode($idCardFrontImg);
        }
    }
}
