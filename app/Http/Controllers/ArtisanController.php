<?php

namespace App\Http\Controllers;

use App\Models\Backend\Artisan;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * 文章前台-控制器
 * Class ArtisanController
 * @package App\Http\Controllers
 */
class ArtisanController extends Controller
{
    use \App\Traits\Category;

    /**
     * 文章列表
     * @param Model $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $artisan = Artisan::with('comments','category')
            ->orderBy('created_at','desc')
            ->paginate();

        $category = $this->all();

        return view('index',['artisans' => $artisan,'categorys'=>$category,'session'=>SessionName()]);
    }

    /**
     * 文章详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $id = base64_decode($id);
        $artisan = Artisan::with('comments.user')->findOrFail($id);
        $num = $artisan['read_num'];

        $read_num = $num+1;
        $artisan->read_num = $read_num;
        $artisan->save();

        $category = $this->all();

        return view('detail',['artisan' => $artisan,'categorys'=>$category,'session'=>SessionName()]);
    }

    /**
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search($name)
    {
        $category_id = Category::where('category_name',$name)->first()['id'];

        $artisans = Artisan::with('category')->paginate();

        foreach ($artisans as $key => $artisan) {
            if ($artisan['category']['id'] != $category_id){
                unset($artisans[$key]);
            }
        }

        $category = $this->all();

        $data = [
            'artisans' => $artisans,
            'categorys' => $category,
            'session'=>SessionName()
        ];

        return view('index',$data);
    }
}
