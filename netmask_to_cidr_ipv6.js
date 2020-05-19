/* Given a subnet mask, return the cidr (number of 1's in the mask)*/

let netmask = "FFFF:FFFF:FFFF:FFFC:0000:0000:0000:0000";

var netmask_to_cidr_ipv6 = function(netmask)
{
//plan: break netmask into cells. while the cell is "FFFF", add 16 to the netmask
  let cell = netmask.split(':');
  let cidr = 0;
  let cell_num = 0;

  while  (cell_num < 8 && cell[cell_num] == "FFFF")
  {
    cell_num++;
    cidr += 16;
  }

  //at the cell not equal to FFFF, know that there will be a mix of 1's and 0's
  //need to get the hex value at this cell, then, if val > 0, get string in binary
  let cell_dec = parseInt(cell[cell_num], 16);
  if (cell_dec > 0)
  {
    console.log(cell_dec);
    let cell_binary = cell_dec.toString(2);
    //if greater than 0 and less than FFFF, know at least one value in the binary string is 0
    //get its index and add this value to the cird
    //ex-> 1111 1111  1111 0000, index of 0 is 12, so there are 12 1's in this cell
    //     0123 4567  891011 12
    cidr += cell_binary.indexOf('0');
  }
  return cidr;
}

console.log(netmask_to_cidr_ipv6(netmask));
