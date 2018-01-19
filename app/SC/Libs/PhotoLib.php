<?php

namespace App\SC\Libs;

use DB;
use Auth;
use Mail;
use File; 

use Exception;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Dwij\Laraadmin\Helpers\LAHelper;

use App\Models\Upload;

use App\Role;
use App\SC\Models\User;
use App\SC\Models\Photo;

use SCHelper;
use App\SC\Libs\PhotoLib_UI;

class PhotoLib 
{
    use PhotoLib_UI;
    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Create a new confide instance.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    // Upload Photo
    // public function uploadPhoto($file, $folder, $group) {
    //     $filename = $file->getClientOriginalName();
    //     $date_append = date("Y-m-d-His-");
    //     $upload_success = $file->move($folder, $date_append.$filename);

    //     if( $upload_success ) {
    //         $public = true;
    //         $upload = Upload::create([
    //         "name" => $filename,
    //         "path" => $folder.DIRECTORY_SEPARATOR.$date_append.$filename,
    //         "extension" => pathinfo($filename, PATHINFO_EXTENSION),
    //         "caption" => "",
    //         "hash" => "",
    //         "public" => $public,
    //         "user_id" => Auth::user()->id
    //         ]);

    //         /** Rotate Image */
    //         if (function_exists('exif_imagetype')) {
    //             if(exif_imagetype($upload->path) == 2)//2 IMAGETYPE_JPEG
    //             {
    //               $exif = @exif_read_data($upload->path);
    //               if(!empty($exif['Orientation']))
    //               {
    //                   $image = imagecreatefromjpeg($upload->path);

    //                   switch($exif['Orientation']) 
    //                           {
    //                   case 8:
    //                       $image = imagerotate($image,90,0);
    //                       break;
    //                   case 3:
    //                       $image = imagerotate($image,180,0);
    //                       break;
    //                   case 6:
    //                       $image = imagerotate($image,-90,0);
    //                       break;
    //                   }
    //                       imagejpeg($image, $upload->path);
    //               }
    //             }
    //         }

    //         // apply unique random hash to file
    //         while(true) {
    //             $hash = strtolower(str_random(20));
    //             if(!Upload::where("hash", $hash)->count()) {
    //               $upload->hash = $hash;
    //               break;
    //             }
    //         }
    //         $upload->save();

    //         $info = getimagesize($upload->path);
    //         $photo = Photo::create([
    //             'file_id'   => $upload->id, 
    //             'group_nid' => $group->id, 
    //             'width'     => $info[0], 
    //             'height'    => $info[1]
    //         ]);
    //         return $photo;

    //     } else {
    //       return false;
    //     }
    // }

    public function uploadPhoto($file, $path, $group) {
        $filename = $file->getClientOriginalName();
        $date_append = date("Y-m-d-His-");
        $file_path = public_path($path).DIRECTORY_SEPARATOR.$date_append.$filename;
        $upload_success = $file->move(public_path($path), $date_append.$filename);

        if( $upload_success ) {
            /** Rotate Image */
            if (function_exists('exif_imagetype')) {
                if(exif_imagetype($file_path) == 2)//2 IMAGETYPE_JPEG
                {
                  $exif = @exif_read_data($file_path);
                  if(!empty($exif['Orientation']))
                  {
                      $image = imagecreatefromjpeg($file_path);

                      switch($exif['Orientation']) 
                              {
                      case 8:
                          $image = imagerotate($image,90,0);
                          break;
                      case 3:
                          $image = imagerotate($image,180,0);
                          break;
                      case 6:
                          $image = imagerotate($image,-90,0);
                          break;
                      }
                          imagejpeg($image, $file_path);
                  }
                }
            }

            $info = getimagesize($file_path);
            $photo = Photo::create([
                'name'      => $date_append.$filename, 
                'path'      => $path, 
                "extension" => pathinfo($filename, PATHINFO_EXTENSION),
                "user_id"   => Auth::user()->id, 
                'group_nid' => $group->id, 
                'width'     => $info[0], 
                'height'    => $info[1]
            ]);
            return $photo;
        } else {
          return false;
        }
    }


    /**
     * Get Photo URL
     */
    public function getThumbPhotoUrl($photo, $size) {
      if ($size == 0) {
        $file_path = str_replace(DIRECTORY_SEPARATOR, "/", $photo->path);
        return url($file_path.'/'.$photo->name);
      }

      try {
        $thumb_url = $photo->path.DIRECTORY_SEPARATOR.$size."x".$size.DIRECTORY_SEPARATOR.$photo->name;

        $thumbpath = public_path($thumb_url);
        $filepath = public_path($photo->path.DIRECTORY_SEPARATOR.$photo->name);
        if(File::exists($thumbpath)) {
          
        } else {
            // check & create Folder
            $thumb_folder = dirname($thumbpath);
            if(!File::exists($thumb_folder)) {
              File::makeDirectory($thumb_folder, 0777, true);
            }
            // Create Thumbnail
            self::createThumbnail($filepath, $thumbpath, $size, $size, "transparent");
        }

        $photo_url = str_replace(DIRECTORY_SEPARATOR, "/", $thumb_url);
        return url($photo_url);
      } catch (Exception $e) {
        return "#";
      }
    }

    public static function createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height, $background=false) {
      list($original_width, $original_height, $original_type) = getimagesize($filepath);
      if ($original_width < $original_height) {
          $new_width = $thumbnail_width;
          $new_height = intval($original_height * $new_width / $original_width);
      } else {
          $new_height = $thumbnail_height;
          $new_width = intval($original_width * $new_height / $original_height);
      }
      $dest_x = intval(($thumbnail_width - $new_width) / 2);
      $dest_y = intval(($thumbnail_height - $new_height) / 2);
      if ($original_type === 1) {
          $imgt = "ImageGIF";
          $imgcreatefrom = "ImageCreateFromGIF";
      } else if ($original_type === 2) {
          $imgt = "ImageJPEG";
          $imgcreatefrom = "ImageCreateFromJPEG";
      } else if ($original_type === 3) {
          $imgt = "ImagePNG";
          $imgcreatefrom = "ImageCreateFromPNG";
      } else {
          return false;
      }
      $old_image = $imgcreatefrom($filepath);
      $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height); // creates new image, but with a black background
      // figuring out the color for the background
      if(is_array($background) && count($background) === 3) {
        list($red, $green, $blue) = $background;
        $color = imagecolorallocate($new_image, $red, $green, $blue);
        imagefill($new_image, 0, 0, $color);
      // apply transparent background only if is a png image
      } else if($background === 'transparent' && $original_type === 3) {
        imagesavealpha($new_image, TRUE);
        $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
        imagefill($new_image, 0, 0, $color);
      }
      imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
      $imgt($new_image, $thumbpath);
      return file_exists($thumbpath);
    }

    public function removePhoto($photo_id) 
    {
        $photo = Photo::find($photo_id);
        if ($photo) {
            $photo->remove();
            return true;
        }
        return false;
    }

    /**
     * Get Photos related to Group (Node)
     */
    public function getPhotos($group)
    {
        return Photo::where('group_nid', '=', $group->id)
                    ->where('used', '=', 1)
                    ->orderBy('id', 'DESC')
                    ->get();
    }
}
