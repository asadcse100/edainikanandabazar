<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    /**
     * Show the application manage-images.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date, $page_id)
    {   

        ## get db table ##
        $pages_table='pages_'.date('Y_m', strtotime($date));
        $edition_pages_table='edition_pages_'.date('Y_m', strtotime($date));
        $images_table='images_'.date('Y_m', strtotime($date));

        $page_info=\DB::table($pages_table)->where($pages_table.'.id',$page_id)->leftjoin($edition_pages_table, $edition_pages_table.'.page_id', '=', $pages_table.'.id')->select($pages_table.'.*', $edition_pages_table.'.*', $pages_table.'.id as page_id')->first();

        $data['page_info']=$page_info;

        if (!empty($page_info)) {
            $page_list=\DB::table($pages_table)->where($pages_table.'.publish_date',$page_info->publish_date)->get();
            $data['page_list']=$page_list;

            $image_list = \DB::table($images_table)->where($images_table.'.page_id',$page_id)->get();
            $data['image_list']=$image_list;

        }

        $data['image_date']=$date;

        return \View::make('admin.manage-images.index',$data);
    }


    /**
     * Show the application cropImage.
     *
     * @return \Illuminate\Http\Response
     */

    public function cropImage($page_id)
    {   

        $now = date('Y-m-d H:i:s');

        try{

            $coords=\Request::input('coords');
            $page_publish_date=\Request::input('page_publish_date');
            $page_image=\Request::input('page_image');

            if (!empty($coords) && (!empty($page_publish_date)) && (!empty($page_image))) {

                $explode=explode(',', $coords);

                (int)$x1=$explode[0];
                (int)$y1=$explode[1];
                (int)$x2=$explode[2];
                (int)$y2=$explode[3];

                (int)$width=$x2-$x1;
                (int)$height=$y2-$y1;

                $main_page='uploads/temp/'.date('Y',strtotime($page_publish_date)).'/'.date('m',strtotime($page_publish_date)).'/'.date('d',strtotime($page_publish_date)).'/original-pages/'.$page_image;


                if (!file_exists($main_page)) {

                    $main_page='uploads/epaper/'.date('Y',strtotime($page_publish_date)).'/'.date('m',strtotime($page_publish_date)).'/'.date('d',strtotime($page_publish_date)).'/pages/'.$page_image;

                }


                $src = $main_page;
                $img_r = imagecreatefromjpeg($src);
                
                if($width > 0 && $height > 0){
                    $dst_r = ImageCreateTrueColor($width, $height);
                }

                imagecopyresampled($dst_r,$img_r,0,0,$x1,$y1,
                    $width,$height,$width,$height);
                header('Content-type: image/jpeg');

                $explode=explode('.jpg', $page_image);
                $name=implode('', $explode);
                $image_name=$name.'-'.uniqid().'.jpg';

                $dest_directiory='uploads/epaper/'.date('Y',strtotime($page_publish_date)).'/'.date('m',strtotime($page_publish_date)).'/'.date('d',strtotime($page_publish_date)).'/images/';

                if (!file_exists($dest_directiory)) {
                    mkdir($dest_directiory, 0777, true);
                }
                $cropped_image=$dest_directiory.$image_name;
                imagejpeg($dst_r, $cropped_image);

                list($org_width, $org_height, $type, $attr) = getimagesize($main_page);
                (int)$final_coords=(($x1*700)/$org_width).','.(($y1*910)/$org_height).','.(($x2*700)/$org_width).','.(($y2*910)/$org_height);

                $image_data=array(
                    'page_id' => $page_id,
                    'image' => $image_name,
                    'coords' => $final_coords,
                    'relation' => \Request::input('relation'),
                    'related_page_no' => \Request::input('related_page_no'),
                    'created_by' => \Auth::user()->id,
                    'created_at' => $now,
                    );

                $images_table='images_'.date('Y_m', strtotime($page_publish_date));
                
                $image_save_id=\DB::table($images_table)->insertGetId($image_data);


                $related_image_id =\Request('related_image_id');
                if(!empty($related_image_id)){
                    $image_relation_previous_data=array(
                    'related_image_id' => $related_image_id,
                    'image_status' => 1,
                    );

                    $image_relation_next_data=array(
                    'related_image_id' => $image_save_id,
                    'image_status' => 1,
                    );

                $image_relation_previous_save=\DB::table($images_table)->where('id',$image_save_id)->update($image_relation_previous_data);

                $image_relation_next_save=\DB::table($images_table)->where('id',$related_image_id)->update($image_relation_next_data);
                }
                


            }else return \Redirect::back()->with('errormessage', "Please select coordinates to crop image !");

        }catch(\Exception $e){

            return \Redirect::back()->with('errormessage', "Problem mapping coordinates.please try again");
        }

        return \Redirect::back()->with('message', "Image coordinate uploaded successfully !");

    }



    /**
     * Show the application AjaxImageRelationModal.
     *
     * @return \Illuminate\Http\Response
     */

    public function AjaxSelectImageRelationModal($edition_id, $image_date, $related_page)
    {   

        ## Find Table ##
        $pages_table='pages_'.date('Y_m', strtotime($image_date));
        $edition_pages_table='edition_pages_'.date('Y_m', strtotime($image_date));
        $images_table='images_'.date('Y_m', strtotime($image_date));

        $related_page_id = \DB::table($pages_table)
        ->where($pages_table.'.page_number',$related_page)
        ->where($pages_table.'.publish_date',$image_date)
        ->leftjoin($edition_pages_table, $edition_pages_table.'.page_id', '=', $pages_table.'.id')
        ->where($edition_pages_table.'.edition_id', $edition_id)
        ->select($pages_table.'.*', $edition_pages_table.'.*', $pages_table.'.id as p_id')
        ->first();

        if(!empty($related_page_id)){
            $related_images=\DB::table($images_table)
            ->where($images_table.'.page_id',$related_page_id->p_id)
            ->where($images_table.'.relation','next')
            ->get();
            
            $data['related_images']=$related_images;
            $data['image_date']=$image_date;

        }else{
            $data['related_images']=Null;
        }

        return \View::make('admin.manage-images.ajax-image-relation',$data);

    }



    /**
     * Show the application AjaxImageRelationModal.
     *
     * @return \Illuminate\Http\Response
     */

    public function AjaxImageRelationUpdateModal($edition_id, $image_id, $related_image, $image_date, $related_page, $relation_type)
    {   

        ## Find Table ##
        $pages_table='pages_'.date('Y_m', strtotime($image_date));
        $edition_pages_table = 'edition_pages_'.date('Y_m', strtotime($image_date));
        $images_table='images_'.date('Y_m', strtotime($image_date));

        $related_page_id = \DB::table($pages_table)
        ->where($pages_table.'.page_number',$related_page)
        ->where($pages_table.'.publish_date',$image_date)
        ->leftjoin($edition_pages_table, $edition_pages_table.'.page_id', '=', $pages_table.'.id')
        ->where($edition_pages_table.'.edition_id', $edition_id)
        ->select($pages_table.'.*', $edition_pages_table.'.*', $pages_table.'.id as p_id')
        ->first();
        if(!empty($related_page_id)){
            $related_images=\DB::table($images_table)
            ->where($images_table.'.page_id',$related_page_id->p_id)
            ->where($images_table.'.relation', '!=' ,'no')
            ->where($images_table.'.relation', '!=' ,$relation_type)
            ->get();

            $main_image=\DB::table($images_table)
            ->where($images_table.'.id', $image_id)
            ->first();
            $data['main_image']=$main_image;

            $data['related_images']=$related_images;
            $data['image_id']=$image_id;
            $data['image_date']=$image_date;
            $data['related_image_id']=$related_image;
        }

        return \View::make('admin.manage-images.ajax-image-relation-update',$data);

    }



    /**
     * Show the application imageRelationsSave.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageRelationsSave($image_date, $image_id)
    {   

        $now = date('Y-m-d H:i:s');
        $images_table='images_'.date('Y_m', strtotime($image_date));

        if (!empty(\Request::input('related_image_id'))) {

            try{

                $related_image_id=\Request::input('related_image_id');
                $image_1_data=array(
                    'related_image_id' => $related_image_id,
                    'image_status' => 1,
                    'updated_by' => \Auth::user()->id,
                    'updated_at' => $now,
                    );

                $image_2_data=array(
                    'related_image_id' => $image_id,
                    'image_status' => 1,
                    'updated_by' => \Auth::user()->id,
                    'updated_at' => $now,
                    );


                $image_1_save=\DB::table($images_table)->where('id',$image_id)->update($image_1_data);

                $image_2_save=\DB::table($images_table)->where('id',$related_image_id)->update($image_2_data);

            }catch(\Exception $e){

                return \Redirect::back()->with('errormessage', "Problem linking image.please try again");
            }
            return \Redirect::back()->with('message', "Image has been linked successfully !");

        }else return \Redirect::back()->with('errormessage', "No image selected.please try again");

    }



    /**
     * Show the application delete Image.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id,$image_name,$publish_date)
    {
        $images_table='images_'.date('Y_m', strtotime($publish_date));

        try{

            $image_delete = \DB::table($images_table)->where('id',$id)->delete();
            if($image_delete){
                unlink('uploads/epaper/'.date('Y',strtotime($publish_date)).'/'.date('m',strtotime($publish_date)).'/'.date('d',strtotime($publish_date)).'/images/'.$image_name);
            }
            
            return \Redirect::back()->with('message',"Image has been deleted successfully !");

        }catch(\Exception $e){

            return \Redirect::back()->with('errormessage',"Problem deleting image.please try again");
        }
    }




    #------------------ End --------------------#
}
