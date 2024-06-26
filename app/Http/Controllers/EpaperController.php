<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Schema;
use Illuminate\Support\Facades\Response;
use Image;

class EpaperController extends Controller
{
    /**
     * Show the application home.
     *
     * @return \Illuminate\Http\Response
     */

    // public function download(Request $request)
    // {
    //     $savePath = public_path('uploads/temp/'); // Change 'team/' to your desired folder name
    //     // Normalize the source file path to use only forward slashes
    //     $sourcePath = public_path($request->image_gp_link . 'images/' . $request->image);
    //     // Load the logo image and resize it to 150x80 pixels
    //     $logo = Image::make(public_path('logo/' . setting()->logo))->resize(250, 60);

    //     if(!empty($request->related_image)){
    //         $related_image_sourcePath = public_path($request->image_gp_link . 'images/' . $request->related_image);
    //         $related_image = Image::make($related_image_sourcePath);
    //         $new_related_image = Image::canvas($related_image->width(), $related_image->height() + 80, '#ffffff');
    //         // Insert the main image into the new image, below the white space
    //         $new_related_image->insert($related_image, 'bottom');
    //         // Insert the logo at the top of the new image
    //         $new_related_image->insert($logo, 'top', 1, 1);
    //         // Save the modified image to the specified directory
    //         $new_related_image->save($savePath . $request->related_image);
    //         $new_related_image_savedImagePath = $savePath . $request->related_image;
    //     }

    //     $image = Image::make($sourcePath);
    //     // Create a new image with white space at the top (100 pixels)
    //     $newImage = Image::canvas($image->width(), $image->height() + 80, '#ffffff');
    //     // Insert the main image into the new image, below the white space
    //     $newImage->insert($image, 'bottom');
    //     // Insert the logo at the top of the new image
    //     $newImage->insert($logo, 'top', 1, 1);
    //     // Save the modified image to the specified directory
    //     $newImage->save($savePath . $request->image);
    //     $savedImagePath = $savePath . $request->image;

    //     $imgArr = [];
    //     if(!empty($new_related_image_savedImagePath)){
    //         $imgArr = [$savedImagePath,$new_related_image_savedImagePath];
    //     }else{
    //         $imgArr = [$savedImagePath]; 
    //     }

    //     $existingFiles = [];
    //     foreach ($imgArr as $filePath) {
    //         if (File::exists($filePath)) {
    //             $existingFiles[] = $filePath;
    //         }
    //     }
    //     dd($existingFiles);
    //     if (!empty($existingFiles)) {
    //         return response()->download($existingFiles);
    //     } else {
    //         abort(404, 'File not found');
    //     }
    // }

    public function download(Request $request)
    {
        $savePath = public_path('uploads/temp/');
        $sourcePath = public_path($request->input('image_gp_link') . 'images/' . $request->input('image'));

        $logo = Image::make(public_path('logo/' . setting()->logo))->resize(250, 60);

        if (!empty($request->input('related_image'))) {
            $related_image_sourcePath = public_path($request->input('image_gp_link') . 'images/' . $request->input('related_image'));
            $related_image = Image::make($related_image_sourcePath);
            $new_related_image = Image::canvas($related_image->width(), $related_image->height() + 80, '#ffffff');
            $new_related_image->insert($related_image, 'bottom');
            $new_related_image->insert($logo, 'top', 1, 1);
            $new_related_image->save($savePath . $request->input('related_image'));
            $new_related_image_savedImagePath = $savePath . $request->input('related_image');
        }

        $image = Image::make($sourcePath);
        $newImage = Image::canvas($image->width(), $image->height() + 80, '#ffffff');
        $newImage->insert($image, 'bottom');
        $newImage->insert($logo, 'top', 1, 1);
        $newImage->save($savePath . $request->input('image'));
        $savedImagePath = $savePath . $request->input('image');

        $imgArr = [];
        $imgArr = [$savedImagePath];
        if (File::exists($imgArr[0])) {
            return response()->download($imgArr[0]);
        }else {
            abort(404, 'File not found');
        }
    }

    public function next_download(Request $request)
    {
        $savePath = public_path('uploads/temp/');
        $sourcePath = public_path($request->input('image_gp_link') . 'images/' . $request->input('image'));

        $logo = Image::make(public_path('logo/' . setting()->logo))->resize(250, 60);

        if (!empty($request->input('related_image'))) {
            $related_image_sourcePath = public_path($request->input('image_gp_link') . 'images/' . $request->input('related_image'));
            $related_image = Image::make($related_image_sourcePath);
            $new_related_image = Image::canvas($related_image->width(), $related_image->height() + 80, '#ffffff');
            $new_related_image->insert($related_image, 'bottom');
            $new_related_image->insert($logo, 'top', 1, 1);
            $new_related_image->save($savePath . $request->input('related_image'));
            $new_related_image_savedImagePath = $savePath . $request->input('related_image');
        }

        if (File::exists($new_related_image_savedImagePath)) {
            return response()->download($new_related_image_savedImagePath);
        }else {
            abort(404, 'File not found');
        }
    }

    public function copyImagePath(Request $request)
    {
        $savePath = public_path('uploads/temp/'); // Change 'team/' to your desired folder name

        // Normalize the source file path to use only forward slashes
        $sourcePath = public_path($request->image_gp_link . 'images/' . $request->image);

        // Load the logo image and resize it to 150x80 pixels
        $logo = Image::make(public_path('logo/' . setting()->logo))->resize(250, 50);
        $image = Image::make($sourcePath);

        // Create a new image with white space at the top (100 pixels)
        $newImage = Image::canvas($image->width(), $image->height() + 80, '#ffffff');

        // Insert the main image into the new image, below the white space
        $newImage->insert($image, 'bottom');

        // Insert the logo at the top of the new image
        $newImage->insert($logo, 'top', 1, 1);

        // Save the modified image to the specified directory
        $newImage->save($savePath . $request->image);

        $savedImagePath = $savePath . $request->image;

        if (File::exists($savedImagePath)) {
            $copyImagePath = '/uploads/temp/' . $request->image;
            return response()->json(['copyImagePath' => $copyImagePath]);
        } else {
            // Handle the case where the file does not exist
            abort(404, 'File not found');
        }
    }

    public function index()
    {
        $edition = 'nogor-edition';
        $page_no = 1;
        $page_info = \App\Models\Epaper::GetPageInfo();

        if (!empty($page_info->publish_date)) {

            ## get required tables ##
            $date = $page_info->publish_date;
            $pages_table = 'pages_' . date('Y_m', strtotime($date));
            $edition_pages_table = 'edition_pages_' . date('Y_m', strtotime($date));
            $images_table = 'images_' . date('Y_m', strtotime($date));

            if (!Schema::hasTable($pages_table) || !Schema::hasTable($edition_pages_table) || !Schema::hasTable($images_table)) {
                return view('errors.404');
            }

            $by_edition = \DB::table('editions')->where('title', $edition)->select('editions.id', 'editions.name', 'editions.title')->first();

            // $get_categories = \DB::table($pages_table)->where($pages_table . '.publish_date', $date)->where($pages_table . '.status', 1)
            //     ->leftjoin('categories', 'categories.id', '=', $pages_table . '.category_id')
            //     ->select([\DB::RAW('DISTINCT(category_id)'), $pages_table . '.publish_date', $pages_table . '.page_number', $pages_table . '.image', 'categories.name'])->get();
            // $data['get_categories'] = $get_categories;

            $get_categories = \DB::table($pages_table)->where($pages_table . '.publish_date', $date)->where($pages_table . '.status', 1)
                ->leftjoin($edition_pages_table, $edition_pages_table . '.page_id', '=', $pages_table . '.id')->where($edition_pages_table . '.edition_id', $by_edition->id)
                ->leftjoin('categories', 'categories.id', '=', $pages_table . '.category_id')
                ->select([\DB::RAW('DISTINCT(category_id)'), $pages_table . '.publish_date', $pages_table . '.page_number', $pages_table . '.image', 'categories.name'])->get();

            // $get_page = \DB::table($pages_table)->where($pages_table . '.publish_date', $date)->where($pages_table . '.page_number', 1)->where($pages_table . '.status', 1)
            //     ->leftjoin($edition_pages_table, $edition_pages_table . '.page_id', '=', $pages_table . '.id')->where($edition_pages_table . '.edition_id', $by_edition->id)
            //     ->select($pages_table . '.*', $edition_pages_table . '.page_id', $edition_pages_table . '.edition_id')->first();
            // $data['home_page'] = $get_page;

            $get_page = \DB::table($pages_table)->where($pages_table . '.publish_date', $date)->where($pages_table . '.page_number', 1)->where($pages_table . '.status', 1)
                ->leftjoin($edition_pages_table, $edition_pages_table . '.page_id', '=', $pages_table . '.id')->where($edition_pages_table . '.edition_id', $by_edition->id)
                ->select($pages_table . '.*', $edition_pages_table . '.page_id', $edition_pages_table . '.edition_id')->first();

            $pagination_pages = \DB::table($pages_table)->where($pages_table . '.publish_date', $date)->where($pages_table . '.status', 1)
                ->leftjoin($edition_pages_table, $edition_pages_table . '.page_id', '=', $pages_table . '.id')
                ->leftjoin('editions', 'editions.id', '=', $edition_pages_table . '.edition_id')->where('editions.title', $edition)->get();
            
            if (!empty($get_page->id)) {
                $epaper_articles = \DB::table($images_table)->where('page_id', $get_page->id)->get();
                $data['epaper_articles'] = $epaper_articles;
                $data['home_page'] = $get_page;
                $data['page_edition'] = $by_edition->title;
                $data['date'] = $date;
                $data['page_next'] = $page_no + 1;
                $data['page_last'] = $page_no - 1;
                $data['current_page'] = $page_no;
                $data['get_categories'] = $get_categories;
                $data['pagination_pages'] = $pagination_pages;
            }

            // $pagination_pages = \DB::table($pages_table)->where($pages_table . '.publish_date', $date)->where($pages_table . '.status', 1)
            //     ->leftjoin($edition_pages_table, $edition_pages_table . '.page_id', '=', $pages_table . '.id')
            //     ->leftjoin('editions', 'editions.id', '=', $edition_pages_table . '.edition_id')->where('editions.title', $edition)->get();
            // $data['pagination_pages'] = $pagination_pages;
            
            return \View::make('epaper.index', $data);
        } else {
            return view('errors.404');
        }
    }

    /**
     * Show the application allPages.
     *
     * @return \Illuminate\Http\Response
     */
    public function allPages($edition, $date)
    {
        try {
            ## get required tables ##
            if (date('Y-m-d', strtotime($date)) != $date) {
                return view('errors.404');
            }
            $pages_table = 'pages_' . date('Y_m', strtotime($date));
            $edition_pages_table = 'edition_pages_' . date('Y_m', strtotime($date));
            if (!Schema::hasTable($pages_table) || !Schema::hasTable($edition_pages_table)) {
                return view('errors.404');
            }

            $by_edition = \DB::table('editions')->where('title', $edition)->select('editions.title', 'editions.name', 'editions.id')->first();

            $get_categories = \DB::table($pages_table)->where($pages_table . '.publish_date', $date)->where($pages_table . '.status', 1)
                ->leftjoin($edition_pages_table, $edition_pages_table . '.page_id', '=', $pages_table . '.id')->where($edition_pages_table . '.edition_id', $by_edition->id)
                ->leftjoin('categories', 'categories.id', '=', $pages_table . '.category_id')
                ->select([\DB::RAW('DISTINCT(category_id)'), $pages_table . '.publish_date', $pages_table . '.page_number', $pages_table . '.image', 'categories.name'])->get();
            $data['get_categories'] = $get_categories;

            $data['page_edition'] = $edition;
            $data['date'] = $date;
            $data['page_name'] = 'all_page';

            return \View::make('epaper.all-page', $data);
        } catch (\Exception $e) {

            return view('errors.404');
        }
    }

    /**
     * Show the application byEdition.
     *
     * @return \Illuminate\Http\Response
     */
    public function byEdition($edition, $date, $page_no)
    {
        try {
            ## get required tables ##
            if (date('Y-m-d', strtotime($date)) != $date) {
                return view('errors.404');
            }
            $pages_table = 'pages_' . date('Y_m', strtotime($date));
            $edition_pages_table = 'edition_pages_' . date('Y_m', strtotime($date));
            $images_table = 'images_' . date('Y_m', strtotime($date));

            if (!Schema::hasTable($pages_table) || !Schema::hasTable($edition_pages_table) || !Schema::hasTable($images_table)) {
                return view('errors.404');
            }

            $by_edition = \DB::table('editions')->where('title', $edition)->select('editions.title', 'editions.name', 'editions.id')->first();

            $get_categories = \DB::table($pages_table)->where($pages_table . '.publish_date', $date)->where($pages_table . '.status', 1)
                ->leftjoin($edition_pages_table, $edition_pages_table . '.page_id', '=', $pages_table . '.id')->where($edition_pages_table . '.edition_id', $by_edition->id)
                ->leftjoin('categories', 'categories.id', '=', $pages_table . '.category_id')
                ->select([\DB::RAW('DISTINCT(category_id)'), $pages_table . '.publish_date', $pages_table . '.page_number', $pages_table . '.image', 'categories.name'])->get();


            $get_page = \DB::table($pages_table)->where($pages_table . '.publish_date', $date)->where($pages_table . '.page_number', $page_no)->where($pages_table . '.status', 1)
                ->leftjoin($edition_pages_table, $edition_pages_table . '.page_id', '=', $pages_table . '.id')->where($edition_pages_table . '.edition_id', $by_edition->id)
                ->select($pages_table . '.*', $edition_pages_table . '.page_id', $edition_pages_table . '.edition_id')->first();

            $pagination_pages = \DB::table($pages_table)->where($pages_table . '.publish_date', $date)->where($pages_table . '.status', 1)
                ->leftjoin($edition_pages_table, $edition_pages_table . '.page_id', '=', $pages_table . '.id')
                ->leftjoin('editions', 'editions.id', '=', $edition_pages_table . '.edition_id')->where('editions.title', $edition)->get();
            $data['pagination_pages'] = $pagination_pages;
            $data['page_edition'] = $by_edition->title;

            if ($get_page != Null) {
                $epaper_articles = \DB::table($images_table)->where('page_id', $get_page->id)->get();
                $data['epaper_articles'] = $epaper_articles;

                $data['home_page'] = $get_page;
                $data['page_edition'] = $edition;
                $data['date'] = $date;
                $data['page_next'] = $page_no + 1;
                $data['page_last'] = $page_no - 1;
                $data['current_page'] = $page_no;
                $data['get_categories'] = $get_categories;
                $data['current_edition'] = $by_edition->name;
                return \View::make('epaper.by-edition', $data);
            } else {

                return view('errors.404');
            }
        } catch (\Exception $e) {

            return view('errors.404');
        }
    }


    /**
     * Show the application SharedItem.
     *
     * @return \Illuminate\Http\Response
     */
    public function SharedItem($year_month, $month, $day, $mainImg, $reatedImg = Null)
    {
        if (!empty($mainImg)) {
            $data['main_image_name'] = $mainImg;
            $data['main_image'] = $year_month . '/' . $month . '/' . $day . '/images/' . $mainImg;
            $data['main_image_location'] = $year_month . '/' . $month . '/' . $day . '/images/';
        } else {
            $data['main_image_name'] = Null;
            $data['main_image'] = Null;
            $data['main_image_location'] = Null;
        }


        if (!empty($reatedImg)) {
            $data['related_image_name'] = $reatedImg;
            $data['related_image'] = $year_month . '/' . $month . '/' . $day . '/images/' . $reatedImg;
            $data['related_image_location'] = $year_month . '/' . $month . '/' . $day . '/images/';
        } else {
            $data['related_image_name'] = Null;
            $data['related_image'] = Null;
            $data['related_image_location'] = Null;
        }


        $date = $year_month . '-' . $day;
        $data['date_show'] = \App\Models\Epaper::GetBanglaDate($date);

        return \View::make('epaper.shared-item', $data);
    }
    #----------------End---------------#
}
