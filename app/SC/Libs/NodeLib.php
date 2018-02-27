<?php

namespace App\SC\Libs;

use DB;
use Auth;
use Mail;

use Exception;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Dwij\Laraadmin\Helpers\LAHelper;

use App\Role;
use App\SC\Models\Node;
use App\SC\Models\NodeField;

use SCUserLib;
use SCHelper;

class NodeLib 
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

  /**
   * Get Node object
   *
   * @param integer $object_id
   * @param string $node_type
   * @return Node
   */
  public function getNode($object_id, $node_type)
  {
    $node = Node::where('object_id', $object_id)
                ->where('type', $node_type)
                ->first();
    return $node;
  }

  /**
   * Get Node Field - Value
   */
  public function getNodeField($node_id, $field, $default_value='')
  {
    $node_field = NodeField::where('node_id', $node_id)
                    ->where('field', $field)
                    ->first();
    if ($node_field) {
      return $node_field->value;
    }
    return $default_value;
  }

  /**
   * Save Node Field - Value
   */
  public function saveNodeField($node_id, $field, $value)
  {
    $node_field = NodeField::where('node_id', $node_id)
                    ->where('field', $field)
                    ->first();

    if ($node_field) {
      $node_field->value = $value;
      $node_field->save();
      return true;
    } else {
      $node_field = NodeField::create([
        'node_id' => $node_id, 
        'field'   => $field, 
        'value'   => $value,
      ]);
      if ($node_field) {
        return true;
      }
    }

    return false;
  }

  /**
   * Cover Photo Image of Node
   *
   * @param Node $node
   * @param integer $size
   * @param string $classes: html class attributes
   */
  public function coverPhotoImage($node, $classes="") 
  {
    $bg_style = '';
    if ($node) {
      $path = $node->coverPhotoPath(200);    
      if ($path) {
        $bg_style = "background-image: url('$path')";
      }
    }
    
    $html = sprintf('<div style="%s" class="%s img cover-photo-thumb-image">&nbsp;</div>', 
                     $bg_style, $classes);
    return $html;
  }
}

?>
