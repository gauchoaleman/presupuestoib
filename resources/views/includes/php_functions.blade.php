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


?>
