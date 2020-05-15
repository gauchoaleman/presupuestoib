<?php

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

function get_paper_types()
{
  $paper_types = DB::table('paper_prices')->
  join('paper_types', 'paper_types.id', '=', 'paper_prices.paper_type_id')->
  select('paper_types.id', 'paper_types.name')->
  where('paper_prices.paper_prices_set_id','=', get_latest_paper_price_set_id())->
  distinct('paper_types.id')->get();
  return $paper_types;
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
?>
