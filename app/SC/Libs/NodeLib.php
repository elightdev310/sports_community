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
}

?>
