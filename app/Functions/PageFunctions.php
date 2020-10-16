<?php
session_start();

function show_page_with_menubars($uri,$message = "",$data=array()) {
  $ret = "";
  $ret .= view('includes/head');
  $ret .= view('includes/top_bar');
  if( $message )
    $ret .= $message."<br>";
  $ret .= view($uri,$data);
  $ret .= view('includes/bottom_bar');
  $ret .= view('includes/bottom');
  return $ret;
}

function show_page_without_menubars($uri,$message = "",$data=array()) {
  $ret = "";
  $ret .= view('includes/head');
  if( $message )
    $ret .= $message."<br>";
  $ret .= view($uri,$data);
  $ret .= view('includes/bottom');
  return $ret;
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function transform_result2array($result,$key,$value)
{
  for( $i=0,$obj=$result[0];$i<sizeof($result);$i++){
    $obj=$result[$i];
    $ret[$obj->$key] = $obj->$value;
  }
  return $ret;
}

function week_event()
{
  $events = DB::table('events')->whereRaw('DATEDIFF(date,now())<=7 AND date>=now()')->get();
  if( sizeof($events)==0 )
    return FALSE;
  else
    return TRUE;
}

function get_latest_paper_price_set_id()
{
  $max_id = DB::table('paper_prices_sets')->max('id');
  return $max_id;
}

function get_latest_paper_size_set_id()
{
  $max_id = DB::table('paper_sizes_sets')->max('id');
  return $max_id;
}

function get_paper_types()
{
  $paper_types = DB::table('paper_prices')->
  join('paper_types', 'paper_types.id', '=', 'paper_prices.paper_type_id')->
  select('paper_types.id', 'paper_types.name')->
  where('paper_prices.paper_prices_set_id','=', get_latest_paper_price_set_id())->
  distinct('paper_types.id')->get();
  return $paper_types;
}

function get_clients()
{
  $clients = DB::table('clients')->orderBy('name', 'asc')->select('id','name')->get();
  return $clients;
}

function get_client_name($id)
{
  $client = DB::table('clients')->select('clients.name')->
  where('clients.id','=',$id)->first();

  return $client->name;
}

function get_paper_type($id)
{
  $paper_type = DB::table('paper_types')->select('paper_types.name')->
  where('paper_types.id','=',$id)->first();
  return $paper_type->name;
}

function get_paper_color($id)
{
  $paper_color = DB::table('paper_colors')->select('paper_colors.name')->
  where('paper_colors.id','=',$id)->first();
  return $paper_color->name;
}

function get_paper_colors($paper_type_id)
{
  $paper_colors = DB::table('paper_prices')->
  join('paper_colors', 'paper_colors.id', '=', 'paper_prices.paper_color_id')->
  select('paper_colors.id', 'paper_colors.name')->
  where('paper_prices.paper_type_id','=', $paper_type_id)->
  where('paper_prices.paper_prices_set_id','=', get_latest_paper_price_set_id())->
  distinct('paper_colors.id')->get();

  return $paper_colors;
}

function get_paper_weights($paper_type_id,$paper_color_id)
{
  $paper_weights = DB::table('paper_prices')->
  select('paper_prices.weight')->
  where('paper_prices.paper_type_id','=', $paper_type_id)->
  where('paper_prices.paper_color_id','=', $paper_color_id)->
  where('paper_prices.paper_prices_set_id','=', get_latest_paper_price_set_id())->
  distinct('paper_prices.weight')->get();

  return $paper_weights;
}

function get_dollar_price($id=0) {
  if( $id )
    $dollar_price = DB::table('dollar_prices')->where("id","=",$id)->select('amount')->first();
  else
    $dollar_price = DB::table('dollar_prices')->orderBy('id', 'desc')->select('amount')->first();
  return $dollar_price->amount;
}

function get_actual_dollar_price_id() {
  $max_dollar_price_id = DB::table('dollar_prices')->orderBy('id', 'desc')->select('id')->first();
  return $max_dollar_price_id->id;
}

function pesos_to_dollars($pesos,$dollar_price_id=0) {
  return $pesos?$pesos/get_dollar_price($dollar_price_id):0;
}

function aasort (&$array, $key) {
  $sorter=array();
  $ret=array();
  reset($array);
  foreach ($array as $ii => $va) {
      $sorter[$ii]=$va[$key];
  }
  asort($sorter);
  foreach ($sorter as $ii => $va) {
      $ret[$ii]=$array[$ii];
  }
  $array=$ret;
}

function get_form_value($var_name){
  return request()->get($var_name)?request()->get($var_name):request()->old($var_name);
}

function get_form_sub_array_value($var_name,$index,$sub_index)
{
  if( isset($_POST[$var_name][$index][$sub_index]) )
    return $_POST[$var_name][$index][$sub_index];
}

function swap(&$x, &$y) {
  $tmp=$x;
  $x=$y;
  $y=$tmp;
}

function sizes_compare($s1,$s2)
{
  if( $s1["paper_price_id"] == $s2["paper_price_id"] && $s1["sheet_width"] == $s2["sheet_width"] && $s1["sheet_height"] == $s2["sheet_height"] &&
      $s1["leaf_qty_per_sheet"] == $s2["leaf_qty_per_sheet"] && $s1["leaf_width"] == $s2["leaf_width"] &&
      $s1["leaf_height"] == $s2["leaf_height"] && $s1["pose_width"] == $s2["pose_width"] && $s1["pose_height"] == $s2["pose_height"] &&
      $s1["leaf_width_without_borders"] == $s2["leaf_width_without_borders"] && $s1["leaf_height_without_borders"] == $s2["leaf_height_without_borders"] &&
      $s1["pose_width_qty"] == $s2["pose_width_qty"] && $s1["pose_height_qty"] == $s2["pose_height_qty"] && $s1["rest"] == $s2["rest"] &&
      $s1["position"] == $s2["position"] && $s1["front_back"] == $s2["front_back"] )
      return 0;
  else
    return 1;
}
?>
