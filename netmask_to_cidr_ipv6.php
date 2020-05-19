<?php
    $netmask = "FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFE";

    function netmask_to_cidr_ipv6($netmask)
    {
        //plan: break netmask into cells. while the cell is "FFFF", add 16 to the netmask
        $cell = explode(':', $netmask);
        $cidr = 0;
        $cell_num = 0;

        while  ($cell_num < 8 && strcmp($cell[$cell_num], "FFFF") == 0)
        {
            $cell_num++;
            $cidr += 16;
        }

        //at the cell not equal to FFFF, know that there will be a mix of 1's and 0's
        //need to get the hex value at this cell, then, if val > 0, convert string to binary
        $cell_dec = hexdec($cell[$cell_num]);
        if ($cell_dec > 0)
        {
            $cell_binary = decbin($cell_dec);
            //if greater than 0 and less than FFFF, know at least one value in the binary string is 0
            //get its index and add this value to the cird
            //ex-> 1111 1111  1111 0000, index of 0 is 12, so there are 12 1's in this cell
            //     0123 4567  891011 12
            $cidr += strpos($cell_binary, '0');
        }
        return $cidr;
    }

    echo netmask_to_cidr_ipv6($netmask) . "\n";
?>