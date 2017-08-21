<?php

namespace App\SC\Libs;

use DB;
use Auth;
use Mail;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Upload;

use App\Role;
use App\SC\Models\User;
use App\SC\Models\UserProfile;
use App\SC\Models\Photo;

use SCHelper;

class PhotoLib 
{
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
    public function uploadPhoto($file, $folder, $group) {
        $filename = $file->getClientOriginalName();
        $date_append = date("Y-m-d-His-");
        $upload_success = $file->move($folder, $date_append.$filename);

        if( $upload_success ) {
            $public = true;
            $upload = Upload::create([
            "name" => $filename,
            "path" => $folder.DIRECTORY_SEPARATOR.$date_append.$filename,
            "extension" => pathinfo($filename, PATHINFO_EXTENSION),
            "caption" => "",
            "hash" => "",
            "public" => $public,
            "user_id" => Auth::user()->id
            ]);

            /** Rotate Image */
            if (function_exists('exif_imagetype')) {
                if(exif_imagetype($upload->path) == 2)//2 IMAGETYPE_JPEG
                {
                  $exif = @exif_read_data($upload->path);
                  if(!empty($exif['Orientation']))
                  {
                      $image = imagecreatefromjpeg($upload->path);

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
                          imagejpeg($image, $upload->path);
                  }
                }
            }

            // apply unique random hash to file
            while(true) {
                $hash = strtolower(str_random(20));
                if(!Upload::where("hash", $hash)->count()) {
                  $upload->hash = $hash;
                  break;
                }
            }
            $upload->save();

            $photo = Photo::create([
                'file_id'   => $upload->id, 
                'group_nid' => $group->id
            ]);
            return $photo;

        } else {
          return false;
        }
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
