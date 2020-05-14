<?php
$ip = "fd74:ca9b:3a09:868c:0010:0009:0109:0014";
$cidr = "55";
echo "orig: " . $ip . "<br />";
echo "cidr: " . $cidr . "<br />";

function get_network($ip, $cidr) {
  //goal: given ip address and cidr, find network address
  $cell = explode(":", $ip);
  //number of 1's in a subnet mask
  $num_ones = intval($cidr);
  $cell_num = 0;
  $network = '';

  //cells where all bits are 1's in subnet mask remain unchanged in network address
  while ($num_ones >= 16)
  {
    $network = $network . $cell[$cell_num] . ':';
    $cell_num++;
    $num_ones -= 16;
  }

  //if num_ones not 0, will have a cell that changes
  //in cell with change - if mix of 1's and 0's, num_ones is number of 1's
  //in this cell, bits with 1 in netmask stay turned on, turn off all bits wtih
  //value of 0 in netmask
  if ($num_ones > 0)
  {
    $changed_cell = hexdec($cell[$cell_num]);
    $cell_num++;
    //to turn off bits, shift changed_cell to the right for each value in $num_ones
    //then, shift it back to the left
    //this will replace the bits which are 0 in the netmask with 0s, turning them off
    //while leaving all the bits that are 1s in the netmask as they were
    $changed_cell = $changed_cell >> (16 - $num_ones);
    $changed_cell = $changed_cell << (16 - $num_ones);
    //convert cell to hex and then to strings. pad with 0's as needed
    $changed_cell = dechex($changed_cell);
    $changed_cell = strval($changed_cell);
    $changed_cell = str_repeat("0", 4 - strlen($changed_cell)).$changed_cell;
    //add new cell to rest of network string
    $network = $network . $changed_cell;
    if ($cell_num < 8)
      $network = $network . ":";
  }

  //all remaining cells will be "0000"

  while ($cell_num < 8)
  {
    $network = $network . "0000";
    $cell_num++;
    if ($cell_num < 8)
      $network = $network . ":";
  }
  return $network;
}


?>
